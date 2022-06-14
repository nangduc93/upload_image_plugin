<?php
/**
 * demo
 *
 * @package       DEMO
 * @author        Đức Nguyễn Năng
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   demo
 * Plugin URI:    https://demo-plugin.com
 * Description:   This is my first plugin
 * Version:       1.0.0
 * Author:        Đức Nguyễn Năng
 * Author URI:    http://nangduc.com
 * Text Domain:   demo
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with demo. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

function custom_function2() {
	include_once('tailen.php');
	insert_data_table();
}

add_action('admin_menu', 'custom_function1');
// add_menu_page();

function custom_function1() {
	add_menu_page (
		'page_title',
		'Form Insert',
		'manage_options',
		'custom_plugin',
		'custom_function2'
		// plugins_url('images/icon.pgn', __FILE__)
	);
}

global $jal_db_version;
$jal_db_version = '1.0';

function jal_install() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'upload_images';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id int(9) NOT NULL AUTO_INCREMENT,
		images text NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}
register_activation_hook( __FILE__, 'jal_install' );
// register_activation_hook( __FILE__, 'jal_install_data' );
?>