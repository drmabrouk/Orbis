<?php

/**
 * The Calendar module.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/modules/calendar
 */

class Orbis_Calendar {

    public function init() {
        add_shortcode( 'orbis_calendar', array( $this, 'render_calendar' ) );
    }

    public function render_calendar() {
        return '<div id="orbis-calendar">Calendar view will be loaded here.</div>';
    }
}
