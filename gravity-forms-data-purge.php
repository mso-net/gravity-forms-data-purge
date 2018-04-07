<?php
/*
Plugin Name: Gravity Forms Data Purge
Plugin URI: https://github.com/mso-net/gravity-forms-data-purge/
Description: Adds the ability to purge gravity form entries after a certain amount of time to comply with GDPR.
Author: mso.net
Version: 1.0.4
Author URI: https://www.mso.net/
Text Domain: gravity-forms-data-purge
Domain Path: /languages
License: GPLv2
*/

function gfdp_register_settings() {
	add_option( 'gfdp_option_name', '');
   	register_setting( 'gfdp_options_group', 'gfdp_option_name', 'gfdp_callback' );
}
add_action( 'admin_init', 'gfdp_register_settings' );


add_filter( 'gform_addon_navigation', 'create_menu' );
function create_menu( $menus ) {
	$menus[] = array( 'name' => 'Purge Data', 'label' => __( 'Purge Data' ), 'callback' =>  'gfdp_options_page' );
  	return $menus;
}

function gfdp_options_page(){
	echo '<div>';
		echo '<h2>Gravity Forms Data Purge Settings</h2>';
		echo '<form method="post" action="options.php">';
			settings_fields( 'gfdp_options_group' );
			echo "<h3>How long should the system keep your gravity form entries?</h3>";
			echo "<p>Please provide the number of days that you would like to keep gravity form entries on the server.</p>";
			echo '<table>';
				echo '<tr valign="top">';
					echo '<th scope="row"><label for="gfdp_option_name">Number of days (leave empty to keep data indefinitely)</label></th>';
					echo '<td><input type="text" id="gfdp_option_name" name="gfdp_option_name" value="'.get_option('gfdp_option_name').'" /></td>';
				echo '</tr>';
			echo '</table>';
			submit_button();
		echo '</form>';
	echo '</div>';
}


add_action('gfdp_check_for_expired_entries', 'gfdp_checkForExpiredEntries');

function gfdp_activateCheckForExpiredEntries() {
	if ( !wp_next_scheduled( 'gfdp_check_for_expired_entries' ) ) {
		wp_schedule_event( current_time( 'timestamp' ), 'hourly', 'gfdp_check_for_expired_entries');
	}
}

add_action('wp', 'gfdp_activateCheckForExpiredEntries');


function gfdp_checkForExpiredEntries() {
	if( get_option('gfdp_option_name') != '' ){

        //see which entries are over the allowed time
		$search_criteria = array();
		$form_id = 1;

		$expiredEntryTime = '-'.get_option('gfdp_option_name').' days';

		$start_date = date( 'Y-m-d', strtotime('-3650 days') );
		$end_date = date( 'Y-m-d', strtotime( $expiredEntryTime ));
		$paging = array( 'offset' => 0, 'page_size' => 10000 );
		$search_criteria['start_date'] = $start_date;
		$search_criteria['end_date'] = $end_date;
		 
		$entries = GFAPI::get_entries(0, $search_criteria, null, $paging);

		foreach ($entries as $entry) {
			//delete the entry from the system
			$deleteit = GFAPI::delete_entry($entry);
			$deleteitfromtrash = GFAPI::delete_entry($entry['id']);	
		}
	}        
}