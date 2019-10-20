<?php
/**
 * WordPress Book List MedWestHealthPoints Extension
 *
 * @package     WordPress Book List MedWestHealthPoints Extension
 * @author      Jake Evans
 * @copyright   2018 Jake Evans
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: MedWestHealthPoints Extension
 * Plugin URI: https://www.jakerevans.com
 * Description: A Boilerplate Extension for MedWesthealthpoints that creates a menu page and has it's own tabs.
 * Version: 1.0.0
 * Author: Jake Evans
 * Text Domain: medwesthealthpoints
 * Author URI: https://www.jakerevans.com
 */

/*
 * SETUP NOTES:
 *
 * Change all filename instances from medwesthealthpoints to desired plugin name
 *
 * Modify Plugin Name
 *
 * Modify Description
 *
 * Modify Version Number in Block comment and in Constant
 *
 * Find & Replace these 3 strings:
 * medwesthealthpoints
 * medwestHealthpoints
 * Medwesthealthpoints
 * MedWestHealthPoints
 * MEDWESTHEALTHPOINTS
 * MedWesthealthpoints
 * medwesthpplugin
 * $medwesthealthpoints
 * MEDWEST
 * repw with something also random - db column that holds license.
 *
 *
 * Change the EDD_SL_ITEM_ID_MEDWESTHEALTHPOINTS contant below.
 *
 * Install Gulp & all Plugins listed in gulpfile.js
 *
 *
 *
 *
 */




// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpdb;

/* REQUIRE STATEMENTS */
	require_once 'includes/class-medwesthealthpoints-general-functions.php';
	require_once 'includes/class-medwesthealthpoints-ajax-functions.php';
	require_once 'includes/classes/update/class-medwesthealthpoints-update.php';
/* END REQUIRE STATEMENTS */

/* CONSTANT DEFINITIONS */

	if ( ! defined('MEDWESTHEALTHPOINTS_VERSION_NUM' ) ) {
		define( 'MEDWESTHEALTHPOINTS_VERSION_NUM', '1.0.0' );
	}

	// This is the URL our updater / license checker pings. This should be the URL of the site with EDD installed.
	define( 'EDD_SL_STORE_URL_MEDWESTHEALTHPOINTS', 'https://medwesthpplugin.com' );

	// The id of your product in EDD.
	define( 'EDD_SL_ITEM_ID_MEDWESTHEALTHPOINTS', 46 );

	// This Extension's Version Number.
	define( 'MEDWESTHEALTHPOINTS_VERSION_NUM', '1.0.0' );

	// Root plugin folder directory.
	define( 'MEDWESTHEALTHPOINTS_ROOT_DIR', plugin_dir_path( __FILE__ ) );

	// Root WordPress Plugin Directory. The If is for taking into account the update process - a temp folder gets created when updating, which temporarily replaces the 'medwesthpplugin-bulkbookupload' folder.
	if ( false !== stripos( plugin_dir_path( __FILE__ ) , '/medwesthealthpoints' ) ) { 
		define( 'MEDWESTHEALTHPOINTS_ROOT_WP_PLUGINS_DIR', str_replace( '/medwesthealthpoints', '', plugin_dir_path( __FILE__ ) ) );
	} else {
		$temp = explode( 'plugins/', plugin_dir_path( __FILE__ ) );
		define( 'MEDWESTHEALTHPOINTS_ROOT_WP_PLUGINS_DIR', $temp[0] . 'plugins/' );
	}

	// Root plugin folder URL .
	define( 'MEDWESTHEALTHPOINTS_ROOT_URL', plugins_url() . '/medwesthealthpoints/' );

	// Root Classes Directory.
	define( 'MEDWESTHEALTHPOINTS_CLASS_DIR', MEDWESTHEALTHPOINTS_ROOT_DIR . 'includes/classes/' );

	// Root Update Directory.
	define( 'MEDWESTHEALTHPOINTS_UPDATE_DIR', MEDWESTHEALTHPOINTS_CLASS_DIR . 'update/' );

	// Root REST Classes Directory.
	define( 'MEDWESTHEALTHPOINTS_CLASS_REST_DIR', MEDWESTHEALTHPOINTS_ROOT_DIR . 'includes/classes/rest/' );

	// Root Compatability Classes Directory.
	define( 'MEDWESTHEALTHPOINTS_CLASS_COMPAT_DIR', MEDWESTHEALTHPOINTS_ROOT_DIR . 'includes/classes/compat/' );

	// Root Transients Directory.
	define( 'MEDWESTHEALTHPOINTS_CLASS_TRANSIENTS_DIR', MEDWESTHEALTHPOINTS_ROOT_DIR . 'includes/classes/transients/' );

	// Root Image URL.
	define( 'MEDWESTHEALTHPOINTS_ROOT_IMG_URL', MEDWESTHEALTHPOINTS_ROOT_URL . 'assets/img/' );

	// Root Image Icons URL.
	define( 'MEDWESTHEALTHPOINTS_ROOT_IMG_ICONS_URL', MEDWESTHEALTHPOINTS_ROOT_URL . 'assets/img/icons/' );

	// Root CSS URL.
	define( 'MEDWESTHEALTHPOINTS_CSS_URL', MEDWESTHEALTHPOINTS_ROOT_URL . 'assets/css/' );

	// Root JS URL.
	define( 'MEDWESTHEALTHPOINTS_JS_URL', MEDWESTHEALTHPOINTS_ROOT_URL . 'assets/js/' );

	// Root UI directory.
	define( 'MEDWESTHEALTHPOINTS_ROOT_INCLUDES_UI', MEDWESTHEALTHPOINTS_ROOT_DIR . 'includes/ui/' );

	// Root UI Admin directory.
	define( 'MEDWESTHEALTHPOINTS_ROOT_INCLUDES_UI_ADMIN_DIR', MEDWESTHEALTHPOINTS_ROOT_DIR . 'includes/ui/' );

	// Define the Uploads base directory.
	$uploads     = wp_upload_dir();
	$upload_path = $uploads['basedir'];
	define( 'MEDWESTHEALTHPOINTS_UPLOADS_BASE_DIR', $upload_path . '/' );

	// Define the Uploads base URL.
	$upload_url = $uploads['baseurl'];
	define( 'MEDWESTHEALTHPOINTS_UPLOADS_BASE_URL', $upload_url . '/' );

	// Nonces array.
	define( 'MEDWESTHEALTHPOINTS_NONCES_ARRAY',
		wp_json_encode(array(
			'adminnonce1' => 'medwesthealthpoints_register_new_user_action_callback',
		))
	);

/* END OF CONSTANT DEFINITIONS */

/* MISC. INCLUSIONS & DEFINITIONS */

	// Loading textdomain.
	load_plugin_textdomain( 'medwesthealthpoints', false, MEDWESTHEALTHPOINTS_ROOT_DIR . 'languages' );

/* END MISC. INCLUSIONS & DEFINITIONS */

/* CLASS INSTANTIATIONS */

	// Call the class found in medwesthpplugin-functions.php.
	$medwesthealthpoints_general_functions = new MedWestHealthPoints_General_Functions();

	// Call the class found in medwesthpplugin-functions.php.
	$medwesthealthpoints_ajax_functions = new MedWestHealthPoints_Ajax_Functions();

	// Include the Update Class.
	$medwesthealthpoints_update_functions = new MedWesthealthpoints_Toplevel_Update();


/* END CLASS INSTANTIATIONS */


/* FUNCTIONS FOUND IN CLASS-WPPLUGIN-GENERAL-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */

	// Adding Ajax library.
	add_action( 'wp_head', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_jre_prem_add_ajax_library' ) );

	// For the admin pages.
	add_action( 'admin_menu', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_jre_my_admin_menu' ) );


	// Adding the function that will take our MEDWESTHEALTHPOINTS_NONCES_ARRAY Constant from above and create actual nonces to be passed to Javascript functions.
	add_action( 'init', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_create_nonces' ) );

	// Function that logs in a user automatically after they've first registered.
	add_action( 'after_setup_theme', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_autologin_after_registering' ) );

	// Adding the admin js file.
	add_action( 'admin_enqueue_scripts', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_admin_js' ) );

	// Adding the frontend js file.
	add_action( 'wp_enqueue_scripts', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_frontend_js' ) );

	// Adding the admin css file for this extension.
	add_action( 'admin_enqueue_scripts', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_admin_style' ) );

	// Adding the Front-End css file for this extension.
	add_action( 'wp_enqueue_scripts', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_frontend_style' ) );

	// Function to add table names to the global $wpdb.
	add_action( 'admin_footer', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_register_table_name' ) );

	// Function that adds in any possible admin pointers
	add_action( 'admin_footer', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_admin_pointers_javascript' ) );

	// Creates tables upon activation.
	register_activation_hook( __FILE__, array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_create_tables' ) );

	// Adding the front-end login / dashboard shortcode.
	add_shortcode( 'medwesthealthpoints_login_shortcode', array( $medwesthealthpoints_general_functions, 'medwesthealthpoints_login_shortcode_function' ) );



/* END OF FUNCTIONS FOUND IN CLASS-WPPLUGIN-GENERAL-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */

/* FUNCTIONS FOUND IN CLASS-WPPLUGIN-AJAX-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */
	add_action( 'wp_ajax_medwesthealthpoints_register_new_user_action', array( $medwesthealthpoints_ajax_functions, 'medwesthealthpoints_register_new_user_action_callback' ) );
	add_action( 'wp_ajax_nopriv_medwesthealthpoints_register_new_user_action', array( $medwesthealthpoints_ajax_functions, 'medwesthealthpoints_register_new_user_action_callback' ) );






/* END OF FUNCTIONS FOUND IN CLASS-WPPLUGIN-AJAX-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */






















