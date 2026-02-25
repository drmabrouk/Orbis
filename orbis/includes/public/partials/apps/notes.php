<?php
/**
 * Notes Application Interface
 */
?>
<div class="orbis-app-notes">
    <div class="orbis-app-toolbar">
        <button class="button button-primary"><?php echo orbis_t('new_note', 'Create New Note', 'إنشاء ملاحظة جديدة', 'Notes'); ?></button>
        <input type="text" placeholder="<?php echo orbis_t('search_notes', 'Search notes...', 'بحث في الملاحظات...', 'Notes'); ?>" class="orbis-search-input">
    </div>

    <div class="orbis-notes-grid">
        <!-- Mock Notes for UI Demo -->
        <div class="orbis-note-capsule" style="border-left: 5px solid #3498db;">
            <h4><?php echo orbis_t('example_note_title', 'Project Brainstorming', 'عصف ذهني للمشروع', 'Notes'); ?></h4>
            <p>Initial ideas for the Orbis system architecture...</p>
            <div class="orbis-note-tags">
                <span class="tag">#work</span> <span class="tag">#orbis</span>
            </div>
        </div>
        <div class="orbis-note-capsule" style="border-left: 5px solid #e74c3c;">
            <h4><?php echo orbis_t('shopping_list', 'Shopping List', 'قائمة التسوق', 'Notes'); ?></h4>
            <p>Milk, Bread, Coffee, Fruits...</p>
            <div class="orbis-note-tags">
                <span class="tag">#personal</span>
            </div>
        </div>
    </div>
</div>

<style>
.orbis-app-toolbar { display: flex; gap: 20px; margin-bottom: 30px; }
.orbis-notes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
.orbis-note-capsule { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
.orbis-note-capsule h4 { margin-top: 0; margin-bottom: 10px; }
.orbis-note-tags { margin-top: 15px; font-size: 12px; color: #888; }
.tag { background: #eee; padding: 2px 8px; border-radius: 4px; margin-right: 5px; }
</style>
