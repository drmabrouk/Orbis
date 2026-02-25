<?php
/**
 * Notes Application Interface
 */
?>
<div class="orbis-app-notes">
    <div class="orbis-app-toolbar">
        <button id="orbis-new-note-btn" class="button button-primary"><?php echo orbis_t('new_note', 'Create New Note', 'إنشاء ملاحظة جديدة', 'Notes'); ?></button>
        <input type="text" id="orbis-note-search" placeholder="<?php echo orbis_t('search_notes', 'Search notes...', 'بحث في الملاحظات...', 'Notes'); ?>" class="orbis-search-input">
    </div>

    <div id="orbis-notes-list" class="orbis-notes-grid">
        <!-- Notes will be loaded here via AJAX -->
        <p><?php echo orbis_t('loading', 'Loading...', 'جاري التحميل...', 'General'); ?></p>
    </div>

    <!-- Note Modal -->
    <div id="orbis-note-modal" class="orbis-modal" style="display:none;">
        <div class="orbis-modal-content">
            <span class="orbis-close-modal">&times;</span>
            <h3 id="orbis-note-modal-title"><?php echo orbis_t('edit_note', 'Edit Note', 'تعديل الملاحظة', 'Notes'); ?></h3>
            <form id="orbis-note-form">
                <input type="hidden" id="orbis-note-id" name="note_id">
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('title', 'Title', 'العنوان', 'General'); ?></label>
                    <input type="text" id="orbis-note-title-field" name="note_title" required>
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('content', 'Content', 'المحتوى', 'General'); ?></label>
                    <div id="orbis-note-editor" contenteditable="true" style="min-height: 200px; border: 1px solid #ddd; padding: 10px; border-radius: 6px; background: #fff;"></div>
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('category', 'Category', 'الفئة', 'General'); ?></label>
                    <select id="orbis-note-cat-field" name="note_category"></select>
                </div>
                <button type="submit" class="orbis-auth-submit"><?php echo orbis_t('save_note', 'Save Note', 'حفظ الملاحظة', 'Notes'); ?></button>
            </form>
        </div>
    </div>
</div>

<style>
.orbis-app-toolbar { display: flex; gap: 20px; margin-bottom: 30px; }
.orbis-notes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
.orbis-note-card { background: #fff; padding: 25px; border-radius: 12px; box-shadow: var(--orbis-shadow); border: 1px solid #eee; position: relative; transition: all 0.2s; }
.orbis-note-card:hover { border-color: var(--orbis-primary); transform: translateY(-3px); }
.orbis-note-card h4 { margin: 0 0 10px; font-size: 18px; }
.orbis-note-card p { font-size: 14px; color: #666; margin-bottom: 15px; }
.orbis-note-meta { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 15px; }
.orbis-note-actions { display: flex; gap: 10px; }
.orbis-note-actions .dashicons { cursor: pointer; color: #888; }
.orbis-note-actions .dashicons:hover { color: var(--orbis-primary); }
.orbis-note-card.pinned { border-left: 4px solid #f1c40f; }

/* Modal */
.orbis-modal { position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; }
.orbis-modal-content { background: #fff; padding: 30px; border-radius: 15px; width: 90%; max-width: 600px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
.orbis-close-modal { float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
</style>
