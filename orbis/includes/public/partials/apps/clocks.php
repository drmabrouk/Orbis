<?php
/**
 * Multi-timezone Clock Application
 */
?>
<div class="orbis-app-clocks">
    <div class="orbis-clocks-grid">
        <div class="orbis-clock-card">
            <h4><?php echo orbis_t('london', 'London', 'لندن', 'Clocks'); ?></h4>
            <div class="orbis-clock-val" data-offset="0">--:--:--</div>
            <small>GMT +0</small>
        </div>
        <div class="orbis-clock-card">
            <h4><?php echo orbis_t('new_york', 'New York', 'نيويورك', 'Clocks'); ?></h4>
            <div class="orbis-clock-val" data-offset="-5">--:--:--</div>
            <small>GMT -5</small>
        </div>
        <div class="orbis-clock-card">
            <h4><?php echo orbis_t('dubai', 'Dubai', 'دبي', 'Clocks'); ?></h4>
            <div class="orbis-clock-val" data-offset="4">--:--:--</div>
            <small>GMT +4</small>
        </div>
        <div class="orbis-clock-card">
            <h4><?php echo orbis_t('tokyo', 'Tokyo', 'طوكيو', 'Clocks'); ?></h4>
            <div class="orbis-clock-val" data-offset="9">--:--:--</div>
            <small>GMT +9</small>
        </div>
    </div>
</div>

<style>
.orbis-clocks-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px; }
.orbis-clock-card { background: #2d3748; color: #fff; padding: 25px; border-radius: 12px; text-align: center; }
.orbis-clock-val { font-size: 24px; font-weight: 700; font-family: monospace; margin: 10px 0; color: #63b3ed; }
</style>
