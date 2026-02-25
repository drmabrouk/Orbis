<?php
/**
 * Utilities App Partial
 */
?>
<div class="orbis-app-utilities">
    <h2><?php echo orbis_t('Advanced Tools'); ?></h2>

    <div class="orbis-grid">
        <!-- Currency Converter -->
        <div class="orbis-card">
            <h3><?php echo orbis_t('Currency Converter'); ?></h3>
            <div class="orbis-form-group">
                <input type="number" id="orbis-curr-amount" class="orbis-input" placeholder="Amount">
            </div>
            <div class="orbis-form-group" style="display:flex; gap:10px;">
                <select id="orbis-curr-from" class="orbis-input">
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="SAR">SAR</option>
                </select>
                <span style="align-self:center;">to</span>
                <select id="orbis-curr-to" class="orbis-input">
                    <option value="SAR">SAR</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                </select>
            </div>
            <button class="orbis-btn orbis-btn-primary" id="orbis-convert-curr" style="width:100%;"><?php echo orbis_t('Convert'); ?></button>
            <div id="orbis-curr-result" style="margin-top:15px; font-weight:bold; text-align:center;"></div>
        </div>

        <!-- Unit Converter -->
        <div class="orbis-card">
            <h3><?php echo orbis_t('Unit Converter'); ?></h3>
            <div class="orbis-form-group">
                <input type="number" id="orbis-unit-val" class="orbis-input" placeholder="Value">
            </div>
            <div class="orbis-form-group">
                <select id="orbis-unit-type" class="orbis-input">
                    <option value="km-mi">Kilometers to Miles</option>
                    <option value="mi-km">Miles to Kilometers</option>
                    <option value="kg-lb">Kilograms to Pounds</option>
                    <option value="lb-kg">Pounds to Kilograms</option>
                </select>
            </div>
            <button class="orbis-btn orbis-btn-primary" id="orbis-convert-unit" style="width:100%;"><?php echo orbis_t('Convert'); ?></button>
            <div id="orbis-unit-result" style="margin-top:15px; font-weight:bold; text-align:center;"></div>
        </div>
    </div>
</div>
