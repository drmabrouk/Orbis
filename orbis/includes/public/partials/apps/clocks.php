<?php
/**
 * Clocks App Partial
 */
?>
<div class="orbis-app-clocks">
    <h2><?php echo orbis_t('World Clocks'); ?></h2>
    <div class="orbis-clocks-container">
        <div class="orbis-clock-card" data-timezone="UTC">
            <h3 class="orbis-clock-label">UTC</h3>
            <div class="orbis-clock-time">00:00:00</div>
            <div class="orbis-clock-date">---- -- --</div>
        </div>
        <div class="orbis-clock-card" data-timezone="America/New_York">
            <h3 class="orbis-clock-label">New York</h3>
            <div class="orbis-clock-time">00:00:00</div>
            <div class="orbis-clock-date">---- -- --</div>
        </div>
        <div class="orbis-clock-card" data-timezone="Europe/London">
            <h3 class="orbis-clock-label">London</h3>
            <div class="orbis-clock-time">00:00:00</div>
            <div class="orbis-clock-date">---- -- --</div>
        </div>
        <div class="orbis-clock-card" data-timezone="Asia/Dubai">
            <h3 class="orbis-clock-label">Dubai</h3>
            <div class="orbis-clock-time">00:00:00</div>
            <div class="orbis-clock-date">---- -- --</div>
        </div>
        <div class="orbis-clock-card" data-timezone="Asia/Riyadh">
            <h3 class="orbis-clock-label">Riyadh</h3>
            <div class="orbis-clock-time">00:00:00</div>
            <div class="orbis-clock-date">---- -- --</div>
        </div>
    </div>
</div>

<style>
.orbis-clocks-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; }
.orbis-clock-card { background: var(--orbis-white); padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center; }
.orbis-clock-time { font-size: 24px; font-weight: bold; color: var(--orbis-primary); margin: 10px 0; }
.orbis-clock-date { font-size: 14px; color: #666; }
</style>
