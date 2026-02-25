<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Orbis
 * @subpackage Orbis/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Orbis
 * @subpackage Orbis/includes
 * @author     Jules
 */
class Orbis {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Orbis_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ORBIS_VERSION' ) ) {
			$this->version = ORBIS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'orbis';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
        $this->define_custom_post_types();
        $this->define_module_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Orbis_Loader. Orchestrates the hooks of the plugin.
	 * - Orbis_i18n. Defines internationalization functionality.
	 * - Orbis_Admin. Defines all hooks for the admin area.
	 * - Orbis_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'class-orbis-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'class-orbis-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'admin/class-orbis-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'public/class-orbis-public.php';

        /**
         * Load Modules
         */
        require_once plugin_dir_path( __FILE__ ) . 'modules/notes/class-orbis-notes.php';
        require_once plugin_dir_path( __FILE__ ) . 'modules/tasks/class-orbis-tasks.php';
        require_once plugin_dir_path( __FILE__ ) . 'modules/projects/class-orbis-projects.php';
        require_once plugin_dir_path( __FILE__ ) . 'modules/calendar/class-orbis-calendar.php';
        require_once plugin_dir_path( __FILE__ ) . 'modules/tools/class-orbis-tools.php';
        require_once plugin_dir_path( __FILE__ ) . 'modules/forms/class-orbis-forms.php';

		$this->loader = new Orbis_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Orbis_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Orbis_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Orbis_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Orbis_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

    /**
     * Register all of the hooks related to the modules.
     */
    private function define_module_hooks() {
        $plugin_notes = new Orbis_Notes();
        $this->loader->add_action( 'init', $plugin_notes, 'init' );

        $plugin_tasks = new Orbis_Tasks();
        $this->loader->add_action( 'init', $plugin_tasks, 'init' );

        $plugin_projects = new Orbis_Projects();
        $this->loader->add_action( 'init', $plugin_projects, 'init' );

        $plugin_calendar = new Orbis_Calendar();
        $this->loader->add_action( 'init', $plugin_calendar, 'init' );

        $plugin_tools = new Orbis_Tools();
        $this->loader->add_action( 'init', $plugin_tools, 'init' );

        $plugin_forms = new Orbis_Forms();
        $this->loader->add_action( 'init', $plugin_forms, 'init' );
    }

    /**
     * Define Custom Post Types and Taxonomies.
     */
    private function define_custom_post_types() {
        $this->loader->add_action( 'init', $this, 'register_cpts' );
    }

    public function register_cpts() {
        // Notes CPT
        register_post_type( 'orbis_note', array(
            'labels'      => array( 'name' => 'Notes', 'singular_name' => 'Note' ),
            'public'      => true,
            'has_archive' => true,
            'supports'    => array( 'title', 'editor', 'author' ),
            'menu_icon'   => 'dashicons-welcome-write-blog',
            'show_in_rest' => true,
        ) );

        // Tasks CPT
        register_post_type( 'orbis_task', array(
            'labels'      => array( 'name' => 'Tasks', 'singular_name' => 'Task' ),
            'public'      => true,
            'has_archive' => true,
            'supports'    => array( 'title', 'editor', 'author', 'custom-fields' ),
            'menu_icon'   => 'dashicons-list-view',
            'show_in_rest' => true,
        ) );

        // Projects CPT
        register_post_type( 'orbis_project', array(
            'labels'      => array( 'name' => 'Projects', 'singular_name' => 'Project' ),
            'public'      => true,
            'has_archive' => true,
            'supports'    => array( 'title', 'editor', 'author' ),
            'menu_icon'   => 'dashicons-portfolio',
            'show_in_rest' => true,
        ) );

        // Taxonomies
        register_taxonomy( 'orbis_note_category', 'orbis_note', array(
            'label'        => 'Note Categories',
            'hierarchical' => true,
            'show_in_rest' => true,
        ) );

        register_taxonomy( 'orbis_project_status', 'orbis_project', array(
            'label'        => 'Project Status',
            'hierarchical' => true,
            'show_in_rest' => true,
        ) );
    }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Orbis_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
