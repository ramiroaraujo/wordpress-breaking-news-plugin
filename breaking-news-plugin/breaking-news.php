<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link              https://github.com/ramiroaraujo/wordpress-breaking-news-plugin
 * @since             1.0.0
 * @package           Breaking News
 *
 * @wordpress-plugin
 * Plugin Name:       Breaking News
 * Plugin URI:        https://github.com/ramiroaraujo/wordpress-breaking-news-plugin
 * Description:       Demo plugin for testing
 * Version:           1.0.0
 * Author:            Ramiro Araujo
 * Author URI:        http://ramiroaraujo.tumblr.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Breaking News
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/breaking-news-activator.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/breaking-news-deactivator.php';

/** This action is documented in includes/breaking-news-activator.php */
register_activation_hook( __FILE__, array( 'Breaking_News_Activator', 'activate' ) );

/** This action is documented in includes/breaking-news-deactivator.php */
register_deactivation_hook( __FILE__, array( 'Breaking_News_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/breaking-news.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_breaking_news() {

	$plugin = new Breaking_News();
	$plugin->run();

}
run_breaking_news();
