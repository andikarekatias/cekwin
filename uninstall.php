<?php 
/**
 * Trigger this file on Plugin uninstall
 * 
 * @package Cekwin
 */
if (! defined(' WP_UNINSTALL_PLUGIN ')) {
	die;
}
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}cekwin");
?>