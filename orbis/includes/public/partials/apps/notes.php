<?php
/**
 * Standardized Notes Application Interface
 */
?>
<div class="orbis-app-notes">
    <div class="orbis-app-toolbar">
        <div class="toolbar-left">
            <button id="orbis-new-note-btn" class="orbis-btn orbis-btn-primary">
                <span class="dashicons dashicons-plus"></span> <?php echo orbis_t('new_note', 'Create New Note', 'إنشاء ملاحظة جديدة', 'Notes'); ?>
            </button>
        </div>
        <div class="toolbar-right">
            <input type="text" id="orbis-note-search" placeholder="<?php echo orbis_t('search_notes', 'Search notes...', 'بحث في الملاحظات...', 'Notes'); ?>" class="orbis-search-input">
        </div>
    </div>

    <div id="orbis-notes-list" class="orbis-notes-grid">
        <div class="orbis-skeleton-card"></div>
        <div class="orbis-skeleton-card"></div>
        <div class="orbis-skeleton-card"></div>
    </div>

    <!-- Note Modal -->
    <div id="orbis-note-modal" class="orbis-modal" style="display:none;">
        <div class="orbis-modal-content">
            <header class="modal-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
                <h3 id="orbis-note-modal-title" style="margin:0;"><?php echo orbis_t('edit_note', 'Edit Note', 'تعديل الملاحظة', 'Notes'); ?></h3>
                <span class="orbis-close-modal" style="cursor:pointer; font-size:24px;">&times;</span>
            </header>
            <form id="orbis-note-form">
                <input type="hidden" id="orbis-note-id" name="note_id">
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('title', 'Title', 'العنوان', 'General'); ?></label>
                    <input type="text" id="orbis-note-title-field" name="note_title" required placeholder="Note Title...">
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('content', 'Content', 'المحتوى', 'General'); ?></label>
                    <div id="orbis-note-editor" contenteditable="true" style="min-height: 250px; border: 1px solid var(--orbis-border); padding: 15px; border-radius: 10px; background: #fff; line-height: 1.6;"></div>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:25px;">
                    <button type="button" class="orbis-btn orbis-btn-secondary orbis-close-modal"><?php echo orbis_t('cancel', 'Cancel', 'إلغاء', 'General'); ?></button>
                    <button type="submit" class="orbis-btn orbis-btn-primary"><?php echo orbis_t('save_note', 'Save Changes', 'حفظ التغييرات', 'Notes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.orbis-note-card { background: #fff; padding: 25px; border-radius: 14px; border: 1px solid var(--orbis-border); position: relative; transition: all 0.3s; box-shadow: var(--orbis-shadow-sm); }
.orbis-note-card:hover { border-color: var(--orbis-primary); transform: translateY(-5px); box-shadow: var(--orbis-shadow-lg); }
.orbis-note-card h4 { margin: 0 0 12px; font-size: 18px; font-weight: 700; color: var(--orbis-secondary); }
.orbis-note-card p { font-size: 14px; color: var(--orbis-text-muted); line-height: 1.5; margin-bottom: 20px; }
.orbis-note-meta { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--orbis-border); padding-top: 15px; }
.orbis-note-actions { display: flex; gap: 14px; }
.orbis-note-actions .dashicons { cursor: pointer; color: var(--orbis-text-muted); transition: color 0.2s; font-size: 18px; width: 18px; height: 18px; }
.orbis-note-actions .dashicons:hover { color: var(--orbis-primary); }
.orbis-note-card.pinned { border-left: 5px solid var(--orbis-warning); }
.orbis-skeleton-card { height: 200px; border-radius: 14px; background: #eee; opacity: 0.6; }
