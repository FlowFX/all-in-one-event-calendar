<?php
/**
 * Plugin Name: All-in-One Event Calendar by Timely
 * Plugin URI: http://time.ly/
 * Description: A calendar system with posterboard, month, week, day, agenda views, upcoming events widget, color-coded categories, recurrence, and import/export of .ics feeds.
 * Author: Timely Network Inc
 * Author URI: http://time.ly/
 * Version: 1.10.1-standard
 */

@set_time_limit( 0 );
@ini_set( 'memory_limit',           '256M' );
@ini_set( 'max_input_time',         '-1' );
// Define AI1EC_EVENT_PLATFORM as TRUE to turn WordPress into an events-only
// platform. For a multi-site install, setting this to TRUE is equivalent to a
// super-administrator selecting the
//   "Turn this blog into an events-only platform" checkbox
// on the Calendar Settings page of every blog on the network.
// This mode, when enabled on blogs where this plugin is active, hides all
// administrative functions unrelated to events and the calendar (except to
// super-administrators), and sets default WordPress settings appropriate for
// pure event management.
if( isset( $_GET['ai1ec_doing_ajax'] ) ) {
	// Stop the cron ( or at least try )
	if( ! defined( 'DOING_AJAX' ) ) {
		define( 'DOING_AJAX', true );
	}
}
/**
 * Include configuration files and define constants
 */
$ai1ec_base_path = dirname( __FILE__ );
foreach ( array( 'constants-local.php', 'constants.php' ) as $file ) {
	if ( file_exists( $ai1ec_base_path . DIRECTORY_SEPARATOR . $file ) ) {
		include_once $ai1ec_base_path . DIRECTORY_SEPARATOR . $file;
	}
}
if ( ! function_exists( 'ai1ec_initiate_constants' ) ) {
	return trigger_error(
		'File \'constants.php\' defining \'ai1ec_initiate_constants\' function must be present.',
		E_USER_WARNING
	);
}
ai1ec_initiate_constants();

require_once AI1EC_LIB_PATH . DIRECTORY_SEPARATOR . 'global-functions.php';

require_once AI1EC_LIB_PATH . DIRECTORY_SEPARATOR . 'class-ai1ec-loader.php' ;
spl_autoload_register( array( 'Ai1ec_Loader', 'autoload' ) );


global $ai1ec_themes_controller;
$ai1ec_themes_controller    = Ai1ec_Themes_Controller::get_instance();
// get the active theme from the the theme controllor
$active_theme = $ai1ec_themes_controller->active_template_path();
// Are we in preview_mode?
$preview_mode = false;
// If we are previewing the theme, use the theme passed in the url
if( isset( $_GET['preview'] ) && isset( $_GET['ai1ec_stylesheet'] ) ) {
	Ai1ec_Less_Factory::set_preview_mode( true );
	$active_theme = $_GET['ai1ec_stylesheet'];
	$preview_mode = true;
}
// Start_up the factories
Ai1ec_Less_Factory::set_active_theme_path( AI1EC_THEMES_ROOT . DIRECTORY_SEPARATOR . $active_theme );
Ai1ec_Less_Factory::set_default_theme_path( AI1EC_DEFAULT_THEME_PATH );
Ai1ec_Less_Factory::set_default_theme_url( AI1EC_DEFAULT_THEME_URL );
// ==================================
// = Add the hook to render the css =
// ==================================
if( isset( $_GET[Ai1ec_Css_Controller::GET_VARIBALE_NAME] ) ) {
	$css_controller = Ai1ec_Less_Factory::create_css_controller_instance();
	$css_controller->render_css();
	exit(0);
}

// ================================================
// = Disable updates checking for premium version =
// ================================================
function ai1ec_disable_updates( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) )
		return $r; // Not a plugin update request.

	$plugins = unserialize( $r['body']['plugins'] );
	unset( $plugins->plugins[ plugin_basename( __FILE__ ) ] );
	unset( $plugins->active[ array_search( plugin_basename( __FILE__ ), $plugins->active ) ] );
	$r['body']['plugins'] = serialize( $plugins );

	return $r;
}
add_filter( 'http_request_args', 'ai1ec_disable_updates', 5, 2 );

// ===============================
// = Initialize and setup MODELS =
// ===============================
global $ai1ec_settings;

$ai1ec_settings = Ai1ec_Settings::get_instance();
// If GZIP is causing JavaScript failure following query
// parameter disable compression, until reversing change
// is made. Causative issue: AIOEC-1192.
if ( isset( $_REQUEST['ai1ec_disable_gzip_compression'] ) ) {
	$ai1ec_settings->disable_gzip_compression = true;
	$ai1ec_settings->save();
}
// This is a fix for AIOEC-73. I need to set those values as soon as possible so that
// the platofrom controller has the fresh data and can act accordingly
// I do not trigger the save action at this point because there are too many things going on
// there and i might break things
if ( isset( $_POST['ai1ec_save_settings'] ) ) {
	$ai1ec_settings->event_platform = isset( $_POST['event_platform'] );
	$ai1ec_settings->event_platform_strict = isset( $_POST['event_platform_strict'] );
}
// Set up the Routing Factory
Ai1ec_Routing_Factory::set_ai1ec_settings( $ai1ec_settings );

// ================================
// = Initialize and setup HELPERS =
// ================================
global $ai1ec_view_helper,
       $ai1ec_settings_helper,
       $ai1ec_calendar_helper,
       $ai1ec_app_helper,
       $ai1ec_events_helper,
       $ai1ec_importer_helper,
       $ai1ec_exporter_helper,
       $ai1ec_platform_helper,
       $ai1ec_localization_helper,
       $ai1ec_importer_plugin_helper;

$ai1ec_view_helper            = Ai1ec_View_Helper::get_instance();
$ai1ec_settings_helper        = Ai1ec_Settings_Helper::get_instance();
$ai1ec_calendar_helper        = Ai1ec_Calendar_Helper::get_instance();
$ai1ec_app_helper             = Ai1ec_App_Helper::get_instance();
$ai1ec_events_helper          = Ai1ec_Events_Helper::get_instance();
$ai1ec_importer_helper        = Ai1ec_Importer_Helper::get_instance();
$ai1ec_exporter_helper        = Ai1ec_Exporter_Helper::get_instance();
$ai1ec_platform_helper        = Ai1ec_Platform_Helper::get_instance();
$ai1ec_localization_helper    = Ai1ec_Localization_Helper::get_instance();
$ai1ec_importer_plugin_helper = Ai1ec_Importer_Plugin_Helper::get_instance();

if (
	'admin-ajax.php' === basename( $_SERVER['SCRIPT_NAME'] ) &&
	isset( $_REQUEST['lang'] )
) {
	$ai1ec_localization_helper->set_language( $_REQUEST['lang'] );
}

// ====================================
// = Initialize and setup CONTROLLERS =
// ====================================
global $ai1ec_app_controller,
       $ai1ec_settings_controller,
       $ai1ec_events_controller,
       $ai1ec_calendar_controller,
       $ai1ec_importer_controller,
       $ai1ec_exporter_controller,
       $ai1ec_platform_controller,
       $ai1ec_duplicate_controller;

$ai1ec_settings_controller  = Ai1ec_Settings_Controller::get_instance();
$ai1ec_events_controller    = Ai1ec_Events_Controller::get_instance();
$ai1ec_calendar_controller  = Ai1ec_Calendar_Controller::get_instance();
$ai1ec_importer_controller  = Ai1ec_Importer_Controller::get_instance();
$ai1ec_exporter_controller  = Ai1ec_Exporter_Controller::get_instance();
$ai1ec_platform_controller  = Ai1ec_Platform_Controller::get_instance();
$ai1ec_duplicate_controller = Ai1ec_Duplicate_Controller::get_instance();


// Initialize other global classes
global $ai1ec_requirejs_controller,
       $ai1ec_rss_feed,
       $ai1ec_tax_meta_class;
// Create the instance of the class that handles javascript loading
$ai1ec_requirejs_controller = new Ai1ec_Requirejs_Controller();
// Inject settings
$ai1ec_requirejs_controller->set_settings( $ai1ec_settings );
// Inject calendar controller
$ai1ec_requirejs_controller->set_events_helper( $ai1ec_events_helper );
// Se the themes controller
$ai1ec_requirejs_controller->set_ai1ec_themes_controller( $ai1ec_themes_controller );

/**
 * Configure your meta box
 */
$config = array(
	// meta box id, unique per meta box
	'id'             => 'demo_meta_box',
	// meta box title
	'title'          => 'Demo Meta Box',
	// taxonomy name, accept categories, post_tag and custom taxonomies
	'pages'          => array( 'events_categories' ),
	// where the meta box appear: normal (default), advanced, side; optional
	'context'        => 'normal',
	// list of meta fields (can be added by field arrays)
	'fields'         => array(),
	// Use local or hosted images (meta box images for add/remove)
	// 'local_images' => false,
	// change path if used with theme set to true, false for a plugin or anything
	// else for a custom path(default false).
	'use_with_theme' => false
);
/*
 * Initiate your meta box
*/
$ai1ec_tax_meta_class = new Ai1ec_Tax_Meta_Class( $config );

$ai1ec_rss_feed = new Ai1ec_Rss_Feed_Controller();
// ==========================================================================
// = All app initialization is done in Ai1ec_App_Controller::__construct(). =
// ==========================================================================
$ai1ec_app_controller = Ai1ec_App_Controller::get_instance( $preview_mode );

// =============================================================================
// = Delay router initialization until permalinks are set | see App_Controller =
// =============================================================================
global $ai1ec_router;
