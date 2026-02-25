<?php
/**
 * Calendar App Partial
 */
?>
<div class="orbis-app-calendar">
    <div class="orbis-app-header">
        <h2><?php echo orbis_t('Schedule & Events'); ?></h2>
        <button class="orbis-btn orbis-btn-primary">+ <?php echo orbis_t('Add Event'); ?></button>
    </div>

    <div class="orbis-calendar-wrapper">
        <div class="orbis-calendar-sidebar">
            <h3><?php echo orbis_t('Upcoming'); ?></h3>
            <ul class="orbis-event-list">
                <li>
                    <span class="event-date">Oct 25</span>
                    <span class="event-name">Business Meeting</span>
                </li>
                <li>
                    <span class="event-date">Oct 28</span>
                    <span class="event-name">Project Deadline</span>
                </li>
            </ul>
        </div>
        <div class="orbis-calendar-main">
            <!-- Simulated Calendar Grid -->
            <div class="orbis-mock-calendar">
                <div class="calendar-header">
                    <span>October 2023</span>
                </div>
                <div class="calendar-grid">
                    <?php for($i=1; $i<=31; $i++): ?>
                        <div class="calendar-day"><?php echo $i; ?></div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.orbis-calendar-wrapper { display: flex; gap: 20px; margin-top: 20px; }
.orbis-calendar-sidebar { width: 250px; background: #f8f9fa; padding: 15px; border-radius: 8px; }
.orbis-calendar-main { flex: 1; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
.orbis-mock-calendar .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); border: 1px solid #eee; }
.calendar-day { height: 80px; border: 1px solid #eee; padding: 5px; font-size: 12px; }
.event-list { list-style: none; padding: 0; }
.event-list li { padding: 10px 0; border-bottom: 1px solid #eee; }
.event-date { font-weight: bold; margin-right: 10px; color: var(--orbis-primary); }
</style>
