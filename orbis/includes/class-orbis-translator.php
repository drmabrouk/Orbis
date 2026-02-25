<?php

/**
 * The Translator module.
 *
 * @package    Orbis
 * @subpackage Orbis/includes/modules/translator
 */

class Orbis_Translator {

    private $translations;
    private $option_name = 'orbis_translations';

    public function __construct() {
        $this->translations = get_option( $this->option_name, array() );
    }

    public function init() {
        // Any hooks for translator
    }

    /**
     * Get a translation for a key. Auto-registers if missing.
     */
    public function get( $key, $default_en = '', $default_ar = '', $category = 'General' ) {
        if ( ! isset( $this->translations[$key] ) ) {
            $this->register( $key, $default_en, $default_ar, $category );
        }

        $lang = $this->get_current_language();
        return ! empty( $this->translations[$key][$lang] ) ? $this->translations[$key][$lang] : $this->translations[$key]['en'];
    }

    /**
     * Register a new string in the system.
     */
    private function register( $key, $en, $ar, $cat ) {
        $this->translations[$key] = array(
            'en' => $en,
            'ar' => $ar,
            'category' => $cat
        );
        update_option( $this->option_name, $this->translations );
    }

    /**
     * Get the language for the current user.
     */
    public function get_current_language() {
        if ( is_user_logged_in() ) {
            $pref = get_user_meta( get_current_user_id(), 'orbis_pref_lang', true );
            if ( $pref ) return $pref;
        }
        return 'en'; // Default
    }

    /**
     * Get all registered translations.
     */
    public function get_all() {
        return $this->translations;
    }
}

/**
 * Global helper for Orbis translations.
 */
function orbis_t( $key, $en = '', $ar = '', $cat = 'General' ) {
    global $orbis_translator;
    if ( ! isset( $orbis_translator ) ) {
        $orbis_translator = new Orbis_Translator();
    }
    return $orbis_translator->get( $key, $en, $ar, $cat );
}
