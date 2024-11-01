<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option('GTabber_Left');
delete_option('GTabber_Right');
 
// for site options in Multisite
delete_site_option('GTabber_Left');
delete_site_option('GTabber_Right');

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}gtabber");