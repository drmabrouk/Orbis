<?php
/**
 * Documents App Partial (File Conversion)
 */
?>
<div class="orbis-app-documents">
    <h2><?php echo orbis_t('File Conversion'); ?></h2>
    <div class="orbis-card">
        <p><?php echo orbis_t('Convert your documents easily between formats.'); ?></p>

        <div class="orbis-converter-box">
            <div class="orbis-form-group">
                <label><?php echo orbis_t('Select Format'); ?></label>
                <select id="orbis-conv-format" class="orbis-input">
                    <option value="docx-pdf">Word to PDF</option>
                    <option value="pdf-docx">PDF to Word</option>
                </select>
            </div>

            <div class="orbis-upload-zone" id="orbis-doc-upload">
                <i class="fas fa-cloud-upload-alt"></i>
                <p><?php echo orbis_t('Click or Drag & Drop file to upload'); ?></p>
                <input type="file" id="orbis-conv-file" style="display:none;">
            </div>

            <button class="orbis-btn orbis-btn-primary" id="orbis-start-conv" style="width:100%; margin-top:20px;">
                <?php echo orbis_t('Start Conversion'); ?>
            </button>
        </div>

        <div id="orbis-conv-status" style="margin-top:20px; display:none;">
            <div class="orbis-progress-bar">
                <div class="orbis-progress-fill" style="width: 0%"></div>
            </div>
            <p class="orbis-text-center"><?php echo orbis_t('Conversion in progress... (Cloud Processing)'); ?></p>
        </div>

        <div class="orbis-alert orbis-alert-info" style="margin-top:20px;">
            <p><strong>Note:</strong> Professional file conversion requires the <code>LibreOffice</code> or <code>Pandoc</code> server-side modules. In this demo, conversion is simulated.</p>
        </div>
    </div>
</div>

<style>
.orbis-upload-zone { border: 2px dashed #ccc; padding: 40px; text-align: center; border-radius: 8px; cursor: pointer; transition: 0.3s; }
.orbis-upload-zone:hover { border-color: var(--orbis-primary); background: #f9f9f9; }
.orbis-upload-zone i { font-size: 40px; color: #aaa; margin-bottom: 10px; }
</style>
