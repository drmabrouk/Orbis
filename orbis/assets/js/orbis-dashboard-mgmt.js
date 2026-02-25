(function($) {
    'use strict';

    $(function() {

        // App Switching Logic (SPA-like)
        function switchApp(appSlug) {
            const $target = (appSlug === 'launchpad') ? $('#orbis-launchpad') : $(`#orbis-app-${appSlug}`);

            $('.orbis-app-view').fadeOut(200, function() {
                $('.orbis-app-view').removeClass('active');
                $('.orbis-sidebar-nav li').removeClass('active');

                if (appSlug === 'launchpad') {
                    $('#orbis-launchpad').fadeIn(300).addClass('active');
                    $('.orbis-sidebar-nav li').first().addClass('active');
                } else {
                    $target.fadeIn(300).addClass('active');
                    $(`.orbis-sidebar-nav a[data-app="${appSlug}"]`).parent().addClass('active');

                    // Show loading state if needed
                    $target.find('.orbis-app-content').append('<div class="orbis-loading-overlay"><div class="orbis-spinner"></div></div>');

                    // Trigger app-specific loading
                    if (appSlug === 'notes') loadNotes();
                    if (appSlug === 'tasks') loadTasks();
                    if (appSlug === 'passwords') loadPasswords();
                    if (appSlug === 'finance') loadFinance();

                    setTimeout(() => $target.find('.orbis-loading-overlay').fadeOut(), 400);
                }
            });

            $('.orbis-master-content').animate({ scrollTop: 0 }, 'fast');
        }

        // Click on Tile
        $('.orbis-app-tile').on('click', function() {
            const app = $(this).data('app');
            switchApp(app);
        });

        // Click on Sidebar Link
        $('.orbis-app-link').on('click', function(e) {
            e.preventDefault();
            const app = $(this).data('app');
            switchApp(app);
        });

        // Back to Launchpad button
        $('.orbis-back-to-launchpad').on('click', function() {
            switchApp('launchpad');
        });

        // Tab Switching for Admin Dashboard
        $('.orbis-admin-sidebar a').on('click', function(e) {
            e.preventDefault();
            const tab = $(this).data('tab');

            $('.orbis-admin-sidebar li').removeClass('active');
            $(this).parent().addClass('active');

            $('.orbis-admin-tab-section').removeClass('active');
            $(`#orbis-tab-${tab}`).addClass('active');
        });

        // Site Settings Saving (AJAX)
        $('#orbis-site-settings-form').on('submit', function(e) {
            e.preventDefault();
            const $msg = $('#orbis-admin-mgmt-msg');
            const data = $(this).serialize() + '&action=orbis_save_site_settings';

            $msg.html('<p style="color:blue;">Saving settings...</p>');

            $.post(orbis_params.ajax_url, data, function(response) {
                if (response.success) {
                    $msg.html('<p style="color:green;">' + response.data.message + '</p>');
                    // Live update title if visible
                    $('.orbis-site-title').text($('input[name="orbis_site_title"]').val());
                } else {
                    $msg.html('<p style="color:red;">' + response.data.message + '</p>');
                }
            });
        });

        // Translation Saving (AJAX)
        $('#orbis-translations-form').on('submit', function(e) {
            e.preventDefault();
            const $msg = $('#orbis-admin-mgmt-msg');
            const data = $(this).serialize() + '&action=orbis_save_translations';

            $msg.html('<p style="color:blue;">Saving translations...</p>');

            $.post(orbis_params.ajax_url, data, function(response) {
                if (response.success) {
                    $msg.html('<p style="color:green;">' + response.data.message + '</p>');
                } else {
                    $msg.html('<p style="color:red;">' + response.data.message + '</p>');
                }
            });
        });

        // Translation Search
        $('#orbis-translation-search').on('keyup', function() {
            const val = $(this).val().toLowerCase();
            $('.orbis-translation-row').each(function() {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.indexOf(val) > -1);
            });
        });

        /* --- Image App Logic --- */
        $('#orbis-upload-image-btn').on('click', function(e) {
            e.preventDefault();
            const frame = wp.media({
                title: 'Upload or Select Images',
                button: { text: 'Add to Orbis Storage' },
                multiple: true
            });

            frame.on('select', function() {
                const selections = frame.state().get('selection');
                selections.map(attachment => {
                    const data = attachment.toJSON();
                    $('#orbis-gallery-grid').prepend(`<div class="orbis-image-tile"><img src="${data.sizes.thumbnail ? data.sizes.thumbnail.url : data.url}"></div>`);
                });
            });

            frame.open();
        });

        // Media Library for Logo
        $('#orbis-select-logo').on('click', function(e) {
            e.preventDefault();
            const frame = wp.media({
                title: 'Select or Upload Site Logo',
                button: { text: 'Use this logo' },
                multiple: false
            });

            frame.on('select', function() {
                const attachment = frame.state().get('selection').first().toJSON();
                $('#orbis_site_logo_val').val(attachment.url);
                $('.orbis-logo-preview').html(`<img src="${attachment.url}" style="max-width: 150px; display: block; margin-bottom: 10px;">`);
                // Live update logo in header
                $('.orbis-site-logo').attr('src', attachment.url);
            });

            frame.open();
        });

        // Live Color Update
        $('input[name="orbis_primary_color"]').on('input', function() {
            const color = $(this).val();
            document.documentElement.style.setProperty('--orbis-primary', color);
            $('.orbis-site-title').css('color', color);
        });

        /* --- Notes App Logic --- */
        function loadNotes() {
            $.post(orbis_params.ajax_url, { action: 'orbis_get_notes' }, function(response) {
                if (response.success) {
                    let html = '';
                    response.data.forEach(note => {
                        html += `
                            <div class="orbis-note-card ${note.pinned ? 'pinned' : ''}" data-id="${note.id}">
                                <h4>${note.title}</h4>
                                <p>${note.content.substring(0, 100)}${note.content.length > 100 ? '...' : ''}</p>
                                <div class="orbis-note-meta">
                                    <div class="orbis-note-actions">
                                        <span class="dashicons ${note.pinned ? 'dashicons-star-filled' : 'dashicons-star-empty'} orbis-pin-note" title="Pin/Unpin"></span>
                                        <span class="dashicons dashicons-edit orbis-edit-note" title="Edit"></span>
                                        <span class="dashicons dashicons-trash orbis-delete-note" title="Delete"></span>
                                    </div>
                                    <small>${note.category.join(', ')}</small>
                                </div>
                            </div>
                        `;
                    });
                    $('#orbis-notes-list').html(html || '<p>No notes found. Create your first note!</p>');
                }
            });
        }

        // Open Modal for New Note
        $('#orbis-new-note-btn').on('click', function() {
            $('#orbis-note-id').val('0');
            $('#orbis-note-title-field').val('');
            $('#orbis-note-editor').html('');
            $('#orbis-note-modal-title').text('Create New Note');
            $('#orbis-note-modal').fadeIn();
        });

        // Close Modal
        $('.orbis-close-modal').on('click', function() {
            $('.orbis-modal').fadeOut();
        });

        // Save Note
        $('#orbis-note-form').on('submit', function(e) {
            e.preventDefault();
            const data = {
                action: 'orbis_save_note',
                note_id: $('#orbis-note-id').val(),
                note_title: $('#orbis-note-title-field').val(),
                note_content: $('#orbis-note-editor').html()
            };

            $.post(orbis_params.ajax_url, data, function(response) {
                if (response.success) {
                    $('#orbis-note-modal').fadeOut();
                    loadNotes();
                }
            });
        });

        // Edit Note
        $(document).on('click', '.orbis-edit-note', function() {
            const $card = $(this).closest('.orbis-note-card');
            const id = $card.data('id');
            const title = $card.find('h4').text();

            // We'd ideally fetch full content via AJAX if snippet isn't enough
            // For now, let's just use what's in the card or fetch
            $.post(orbis_params.ajax_url, { action: 'orbis_get_notes' }, function(response) {
                const note = response.data.find(n => n.id == id);
                if (note) {
                    $('#orbis-note-id').val(note.id);
                    $('#orbis-note-title-field').val(note.title);
                    $('#orbis-note-editor').html(note.content);
                    $('#orbis-note-modal-title').text('Edit Note');
                    $('#orbis-note-modal').fadeIn();
                }
            });
        });

        // Pin Note
        $(document).on('click', '.orbis-pin-note', function() {
            const id = $(this).closest('.orbis-note-card').data('id');
            $.post(orbis_params.ajax_url, { action: 'orbis_toggle_pin_note', note_id: id }, function() {
                loadNotes();
            });
        });

        // Delete Note
        $(document).on('click', '.orbis-delete-note', function() {
            if (!confirm('Are you sure you want to delete this note?')) return;
            const id = $(this).closest('.orbis-note-card').data('id');
            $.post(orbis_params.ajax_url, { action: 'orbis_delete_note', note_id: id }, function() {
                loadNotes();
            });
        });

        /* --- Tasks App Logic --- */
        let taskFilter = 'all';

        function loadTasks() {
            $.post(orbis_params.ajax_url, { action: 'orbis_get_tasks' }, function(response) {
                if (response.success) {
                    let html = '';
                    response.data.forEach(task => {
                        if (taskFilter !== 'all' && task.status !== taskFilter) return;

                        html += `
                            <div class="orbis-task-item ${task.status === 'completed' ? 'completed' : ''}" data-id="${task.id}">
                                <input type="checkbox" class="orbis-toggle-task" ${task.status === 'completed' ? 'checked' : ''}>
                                <div class="orbis-task-details">
                                    <span class="orbis-task-title">${task.title}</span>
                                    <div class="orbis-task-meta">
                                        <span class="priority-badge priority-${task.priority}">${task.priority}</span>
                                        ${task.deadline ? `<span>Due: ${task.deadline}</span>` : ''}
                                        <span class="dashicons dashicons-trash orbis-delete-task" style="cursor:pointer; font-size:16px;"></span>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#orbis-tasks-list').html(html || '<p>No tasks found. Time to relax!</p>');
                }
            });
        }

        $('#orbis-add-task-btn').on('click', function() {
            $('#orbis-task-id').val('0');
            $('#orbis-task-title-field').val('');
            $('#orbis-task-deadline-field').val('');
            $('#orbis-task-modal-title').text('New Task');
            $('#orbis-task-modal').fadeIn();
        });

        $('#orbis-task-form').on('submit', function(e) {
            e.preventDefault();
            const data = {
                action: 'orbis_save_task',
                task_id: $('#orbis-task-id').val(),
                task_title: $('#orbis-task-title-field').val(),
                task_deadline: $('#orbis-task-deadline-field').val(),
                task_priority: $('#orbis-task-priority-field').val()
            };

            $.post(orbis_params.ajax_url, data, function(response) {
                if (response.success) {
                    $('#orbis-task-modal').fadeOut();
                    loadTasks();
                }
            });
        });

        $(document).on('change', '.orbis-toggle-task', function() {
            const id = $(this).closest('.orbis-task-item').data('id');
            $.post(orbis_params.ajax_url, { action: 'orbis_toggle_task', task_id: id }, function() {
                loadTasks();
            });
        });

        $(document).on('click', '.orbis-delete-task', function() {
            if (!confirm('Delete this task?')) return;
            const id = $(this).closest('.orbis-task-item').data('id');
            $.post(orbis_params.ajax_url, { action: 'orbis_delete_task', task_id: id }, function() {
                loadTasks();
            });
        });

        $('.orbis-task-filters button').on('click', function() {
            $('.orbis-task-filters button').removeClass('active');
            $(this).addClass('active');
            taskFilter = $(this).data('filter');
            loadTasks();
        });

        /* --- Utilities & Clocks Logic --- */
        let calcExpression = '';
        $(document).on('click', '.orbis-calc-grid button', function() {
            const val = $(this).text();
            const $screen = $('#orbis-calc-screen');

            if (val === '=') {
                try {
                    // Sanitize expression before eval
                    if (/^[0-9+\-*/.() ]+$/.test(calcExpression)) {
                        calcExpression = eval(calcExpression).toString();
                    } else {
                        calcExpression = 'Invalid';
                    }
                } catch (e) {
                    calcExpression = 'Error';
                }
            } else if (val === 'C') {
                calcExpression = '';
            } else {
                calcExpression += val;
            }
            $screen.text(calcExpression || '0');
        });

        // Real-time Clocks
        function updateClocks() {
            const now = new Date();
            $('.orbis-clock-val').each(function() {
                const offset = parseFloat($(this).data('offset'));
                const time = new Date(now.getTime() + (offset * 3600000));
                $(this).text(time.toUTCString().split(' ')[4]);
            });
        }
        setInterval(updateClocks, 1000);

        /* --- BMI App Logic --- */
        $('#orbis-bmi-form').on('submit', function(e) {
            e.preventDefault();
            const h = parseFloat($('#orbis-bmi-height').val()) / 100;
            const w = parseFloat($('#orbis-bmi-weight').val());
            const bmi = (w / (h * h)).toFixed(1);

            let cat = '';
            let color = '';
            if (bmi < 18.5) { cat = 'Underweight'; color = '#3498db'; }
            else if (bmi < 25) { cat = 'Normal'; color = '#2ecc71'; }
            else if (bmi < 30) { cat = 'Overweight'; color = '#f1c40f'; }
            else { cat = 'Obese'; color = '#e74c3c'; }

            $('#orbis-bmi-val').text(bmi);
            $('#orbis-bmi-category').text(cat).css('color', color);
            $('#orbis-bmi-meter-fill').css({'width': Math.min(bmi * 2, 100) + '%', 'background': color});
            $('#orbis-bmi-result').fadeIn();

            $.post(orbis_params.ajax_url, {
                action: 'orbis_save_bmi',
                bmi: bmi,
                category: cat
            });
        });

        /* --- Password Manager Logic --- */
        function loadPasswords() {
            $.post(orbis_params.ajax_url, { action: 'orbis_get_passwords' }, function(response) {
                if (response.success) {
                    let html = '';
                    response.data.forEach(entry => {
                        html += `
                            <div class="orbis-vault-card" data-id="${entry.id}">
                                <div class="vault-header">
                                    <span class="dashicons dashicons-admin-links"></span>
                                    <strong>${entry.url || 'No URL'}</strong>
                                </div>
                                <div class="vault-body">
                                    <p>User: <strong>${entry.username}</strong></p>
                                    <div class="vault-password-wrap">
                                        <code class="pass-val">••••••••</code>
                                        <span class="dashicons dashicons-visibility orbis-reveal-pass" data-pass="${entry.password}"></span>
                                    </div>
                                    <p><small>${entry.notes}</small></p>
                                </div>
                                <div class="vault-actions">
                                    <span class="dashicons dashicons-edit orbis-edit-pass"></span>
                                    <span class="dashicons dashicons-trash orbis-delete-pass"></span>
                                </div>
                            </div>
                        `;
                    });
                    $('#orbis-vault-list').html(html || '<p>Vault is empty.</p>');
                }
            });
        }

        $('#orbis-new-password-btn').on('click', function() {
            $('#orbis-pass-id').val('');
            $('#orbis-password-form')[0].reset();
            $('#orbis-password-modal').fadeIn();
        });

        $(document).on('click', '.orbis-reveal-pass', function() {
            const pass = $(this).data('pass');
            const $code = $(this).prev('.pass-val');
            if ($code.text() === '••••••••') {
                $code.text(pass);
                $(this).removeClass('dashicons-visibility').addClass('dashicons-hidden');
            } else {
                $code.text('••••••••');
                $(this).removeClass('dashicons-hidden').addClass('dashicons-visibility');
            }
        });

        $('#orbis-password-form').on('submit', function(e) {
            e.preventDefault();
            const data = $(this).serialize() + '&action=orbis_save_password';
            $.post(orbis_params.ajax_url, data, function() {
                $('#orbis-password-modal').fadeOut();
                loadPasswords();
            });
        });

        $(document).on('click', '.orbis-delete-pass', function() {
            if (!confirm('Delete this entry?')) return;
            const id = $(this).closest('.orbis-vault-card').data('id');
            $.post(orbis_params.ajax_url, { action: 'orbis_delete_password', pass_id: id }, function() {
                loadPasswords();
            });
        });

        /* --- Finance App Logic --- */
        function loadFinance() {
            $.post(orbis_params.ajax_url, { action: 'orbis_get_finance_data' }, function(response) {
                if (response.success) {
                    let balance = 0;
                    let income = 0;
                    let expense = 0;
                    let html = '';

                    response.data.forEach(t => {
                        const amt = parseFloat(t.amount);
                        if (t.type === 'income') {
                            balance += amt;
                            income += amt;
                        } else {
                            balance -= amt;
                            expense += amt;
                        }

                        html += `
                            <div class="transaction-item ${t.type}">
                                <div><strong>${t.desc}</strong><br><small>${t.date}</small></div>
                                <div class="amount">${t.type === 'income' ? '+' : '-'}$${amt.toFixed(2)}</div>
                            </div>
                        `;
                    });

                    $('#orbis-finance-balance').text(`$${balance.toFixed(2)}`);
                    $('#orbis-finance-income').text(`$${income.toFixed(2)}`);
                    $('#orbis-finance-expense').text(`$${expense.toFixed(2)}`);
                    $('#orbis-transactions-list').html(html || '<p>No transactions recorded.</p>');
                }
            });
        }

        $('#orbis-add-transaction-btn').on('click', function() {
            $('#orbis-transaction-modal').fadeIn();
        });

        $('#orbis-transaction-form').on('submit', function(e) {
            e.preventDefault();
            const data = $(this).serialize() + '&action=orbis_save_transaction';
            $.post(orbis_params.ajax_url, data, function() {
                $('#orbis-transaction-modal').fadeOut();
                loadFinance();
            });
        });

        /* --- Forms App Logic --- */
        $('.orbis-preview-form').on('click', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            $('#orbis-preview-form-id').val(id);
            $('#orbis-form-preview-title').text(title);
            $('#orbis-form-preview-modal').fadeIn();
        });

        $('#orbis-public-form-submit').on('submit', function(e) {
            e.preventDefault();
            const $msg = $('#orbis-form-submit-msg');
            const data = $(this).serialize() + '&action=orbis_submit_form';

            $msg.html('<p style="color:blue;">Submitting...</p>');

            $.post(orbis_params.ajax_url, data, function(response) {
                if (response.success) {
                    $msg.html('<p style="color:green;">' + response.data.message + '</p>');
                    setTimeout(() => $('.orbis-modal').fadeOut(), 2000);
                }
            });
        });

        // Initial Load
        if ($('#orbis-notes-list').length) loadNotes();
        if ($('#orbis-tasks-list').length) loadTasks();
        updateClocks();
    });

})(jQuery);
