(function($) {
    'use strict';

    window.OrbisNotes = {
        init: function() {
            this.load();
            this.bindEvents();
        },

        load: function() {
            const $list = $('#orbis-notes-list');
            if (!$list.length) return;

            $.post(orbis_params.ajax_url, {
                action: 'orbis_get_notes',
                nonce: orbis_params.nonce
            }, function(response) {
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
                    $list.html(html || '<p>No notes found. Create your first note!</p>');
                }
            });
        },

        bindEvents: function() {
            const self = this;

            $('#orbis-new-note-btn').on('click', function() {
                $('#orbis-note-id').val('0');
                $('#orbis-note-title-field').val('');
                $('#orbis-note-editor').html('');
                $('#orbis-note-modal-title').text('Create New Note');
                $('#orbis-note-modal').fadeIn();
            });

            $('#orbis-note-form').on('submit', function(e) {
                e.preventDefault();
                const data = {
                    action: 'orbis_save_note',
                    nonce: orbis_params.nonce,
                    note_id: $('#orbis-note-id').val(),
                    note_title: $('#orbis-note-title-field').val(),
                    note_content: $('#orbis-note-editor').html()
                };

                $.post(orbis_params.ajax_url, data, function(response) {
                    if (response.success) {
                        $('.orbis-modal').fadeOut();
                        self.load();
                    }
                });
            });

            $(document).on('click', '.orbis-edit-note', function() {
                const id = $(this).closest('.orbis-note-card').data('id');
                $.post(orbis_params.ajax_url, {
                    action: 'orbis_get_notes',
                    nonce: orbis_params.nonce
                }, function(response) {
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

            $(document).on('click', '.orbis-pin-note', function() {
                const id = $(this).closest('.orbis-note-card').data('id');
                $.post(orbis_params.ajax_url, {
                    action: 'orbis_toggle_pin_note',
                    note_id: id,
                    nonce: orbis_params.nonce
                }, () => self.load());
            });

            $(document).on('click', '.orbis-delete-note', function() {
                if (!confirm('Delete this note?')) return;
                const id = $(this).closest('.orbis-note-card').data('id');
                $.post(orbis_params.ajax_url, {
                    action: 'orbis_delete_note',
                    note_id: id,
                    nonce: orbis_params.nonce
                }, () => self.load());
            });
        }
    };

    $(function() {
        if ($('#orbis-notes-list').length) window.OrbisNotes.init();
    });

})(jQuery);
