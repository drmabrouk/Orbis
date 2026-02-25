(function($) {
    'use strict';

    window.OrbisTasks = {
        filter: 'all',

        init: function() {
            this.load();
            this.bindEvents();
        },

        load: function() {
            const $list = $('#orbis-tasks-list');
            if (!$list.length) return;

            $.post(orbis_params.ajax_url, {
                action: 'orbis_get_tasks',
                nonce: orbis_params.nonce
            }, (response) => {
                if (response.success) {
                    let html = '';
                    response.data.forEach(task => {
                        if (this.filter !== 'all' && task.status !== this.filter) return;

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
                    $list.html(html || '<p>No tasks found.</p>');
                }
            });
        },

        bindEvents: function() {
            const self = this;

            $('#orbis-add-task-btn').on('click', function() {
                $('#orbis-task-id').val('0');
                $('#orbis-task-form')[0].reset();
                $('#orbis-task-modal').fadeIn();
            });

            $('#orbis-task-form').on('submit', function(e) {
                e.preventDefault();
                const data = $(this).serialize() + '&action=orbis_save_task&nonce=' + orbis_params.nonce;
                $.post(orbis_params.ajax_url, data, function() {
                    $('#orbis-task-modal').fadeOut();
                    self.load();
                });
            });

            $(document).on('change', '.orbis-toggle-task', function() {
                const id = $(this).closest('.orbis-task-item').data('id');
                $.post(orbis_params.ajax_url, {
                    action: 'orbis_toggle_task',
                    task_id: id,
                    nonce: orbis_params.nonce
                }, () => self.load());
            });

            $(document).on('click', '.orbis-delete-task', function() {
                if (!confirm('Delete task?')) return;
                const id = $(this).closest('.orbis-task-item').data('id');
                $.post(orbis_params.ajax_url, {
                    action: 'orbis_delete_task',
                    task_id: id,
                    nonce: orbis_params.nonce
                }, () => self.load());
            });

            $('.orbis-task-filters button').on('click', function() {
                $('.orbis-task-filters button').removeClass('active');
                $(this).addClass('active');
                self.filter = $(this).data('filter');
                self.load();
            });
        }
    };

    $(function() {
        if ($('#orbis-tasks-list').length) window.OrbisTasks.init();
    });

})(jQuery);
