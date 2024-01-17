<?php 
/**
 * @package Cekwin
 */
/**
* Plugin Name: Cekwin
* Plugin URI: https://github.com/andikarekatias/cekwin
* Description: Cek kelulusan siswa
* Version: 1.0.4
* Tested up to: 6.2
* Author: Andika Rekatias
* Author URI: https://andikarekatias.com/contact.html
* License: GPL2 or later
* Text Domain: cekwin 
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/
require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/andikarekatias/cekwin/',
	__FILE__,
	'cekwin'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

if( ! defined ('ABSPATH')){
	echo "404";
	die;
}
class Cekwin{
	function __construct(){
		add_action('init', array( $this, 'app_output_buffer' ));
	}
	function register(){
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'cekwin_form_enqueue_style' ) );
	}
	function activate(){
		$this->make_db();
		flush_rewrite_rules();
	}
	function deactivate(){
		flush_rewrite_rules();
	}	
	function uninstall(){
		include( plugin_dir_path( __FILE__ ) . 'uninstall.php' );
	}
	function app_output_buffer() {
    	ob_start();
	} 
	function make_db(){
		global $wpdb;
		$cekwin = $wpdb->prefix.'cekwin';
		$charset = $wpdb->get_charset_collate();
		if ($wpdb->get_var("SHOW TABLES LIKE '$cekwin'") != $cekwin) {
			$create_cekwin = "CREATE TABLE ".$cekwin."(
				cw_id	int	NOT NULL	AUTO_INCREMENT,
				nama	varchar(55)	NOT NULL,
				id_login varchar(20) NOT NULL,
				kode	varchar(7) NOT NULL,
				status	int(1) NOT NULL,
				PRIMARY KEY (cw_id)
			)$charset;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $create_cekwin );
		}				
	}	
	function admin_enqueue() {
		$current_screen = get_current_screen();
		if ($current_screen && $current_screen->id === 'toplevel_page_cekwin') {
			// Datatable
			wp_enqueue_style( 'dt-jquerycss','https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' );
			wp_enqueue_style( 'dt-css','https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' );
			// Custom
			wp_register_style( 'custom_wp_admin_css', plugin_dir_url( __FILE__ ) . 'assets/w3.css', false, '4.0.0' );
			wp_enqueue_style( 'custom_wp_admin_css' );
			wp_enqueue_style( 'custom_wp_admin_css2', plugin_dir_url( __FILE__ ) . 'assets/custom.css', false, '1.0.0' );

			wp_register_script( 'main', plugin_dir_url( __FILE__ ) . 'assets/main.js', array('jquery-core'), false, true );
			wp_enqueue_script( 'main' );
			wp_enqueue_script( 'custom', plugin_dir_url( __FILE__ ) . 'assets/custom.js', array(), false, true );

			// Datatable
			wp_enqueue_script( 'dt-jquery','https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js' );
			wp_enqueue_script( 'dt-btn','https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js' );
			wp_enqueue_script( 'dt-jszip','https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js' );
			wp_enqueue_script( 'dt-pdfmake','https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js' );
			wp_enqueue_script( 'dt-html5','https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js' );
			wp_enqueue_script( 'dt-print','https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js' );	
			return;
		}		
	}
	function cekwin_form_enqueue_style(){
		wp_register_style( 'w3_css', plugin_dir_url( __FILE__ ) . 'assets/w3.css', false, '4.0.0' );
	    wp_enqueue_style( 'w3_css' );
	    wp_enqueue_style( 'custom_wp_admin_css2', plugin_dir_url( __FILE__ ) . 'assets/custom.css', false, '1.0.0' );
	}
}


if( class_exists('Cekwin')){
	$cekwin = new Cekwin();
	$cekwin->register();

	register_activation_hook( __FILE__, array( $cekwin, 'activate' ));
	register_deactivation_hook( __FILE__, array( $cekwin, 'deactivate'));
	register_uninstall_hook( __FILE__, 'uninstall');
}

function delete_myplugin_database() {
	global $wpdb;
	$cekwin = new Cekwin();
	$table_name = $wpdb->prefix . 'cekwin';
	$wpdb->query("DROP TABLE IF EXISTS $table_name");				
	$cekwin->make_db();
	wp_die();
}
add_action('wp_ajax_delete_myplugin_database', 'delete_myplugin_database');

define('TEMP_DIR', plugin_dir_path(__FILE__).'/views/');

include 'menu/functions-menu.php';
include 'sql.php';
add_shortcode('cekwin-form','cekwin_form');
function cekwin_form(){
	require_once(plugin_dir_path(__FILE__)."/views/cekwin-form.php");
	global $wpdb;
	$nama_table = "cekwin";

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cekwin_nonce']) && wp_verify_nonce($_POST['cekwin_nonce'], 'cekwin_form_nonce')) {
		$id_login = isset($_POST['id_login']) ? sanitize_text_field($_POST['id_login']) : '';
        $kode = isset($_POST['kode']) ? sanitize_text_field($_POST['kode']) : '';
		$andwhere = $wpdb->prepare(" AND kode=%s", $kode);

		$get_data_row = ambil_data($nama_table,$andwhere);

		if (!empty($get_data_row->id_login) && !empty($get_data_row->kode) &&  $get_data_row->id_login == $id_login && $get_data_row->kode == $kode) {
			$id_r = $get_data_row->cw_id;
			$nama_r = $get_data_row->nama;
			$id_login_r = $get_data_row->id_login;
			$kode_r = $get_data_row->kode;
			$status_r = $get_data_row->status;
			if ($status_r == 0) {
				?>
				<div class="w3-container">
					<div class="w3-panel w3-leftbar w3-dark-grey w3-border-red">
					<p class="w3-xxlarge w3-serif">
					<i>&#10077 Maaf Segera Hadir disekolah tanggal: <strong>4 Juni 2022 - jam 09.00 WIB</strong> bertemu dengan wali kelas &#10078</i></p>
					<p><?= $nama_r ?></p>
					</div>
				</div>
				<?php
			}elseif ($status_r == 1) {
				?>
				<div class="w3-container">
					<div class="w3-panel w3-leftbar w3-dark-gray w3-border-green">
						<div class="cw-firework"></div>
						<div class="cw-firework"></div>
						<div class="cw-firework"></div>
						<p class="w3-xxlarge w3-serif">
						<i>&#10077 Selamat Anda dinyatakan <strong class="w3-text-green">LULUS</strong> &#10078 </i></p>
						<p><?= $nama_r ?></p>
					</div>
				</div>
				<?php
			}		
	}else{
		echo '<div class="w3-container w3-red"><p>No matching data found.</p></div>';
	}
	}
}

?>
