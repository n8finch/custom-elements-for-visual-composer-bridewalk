<?php
/**
 * File for handling admin ajax functions for markbooked functionality
 */

 /**
  * Add ajax actions for checlist functionality
  */
 add_action( 'wp_ajax_mark_as_booked_vendors', 'mark_as_booked_vendors' );

 function mark_as_booked_vendors() {

 	$user_ID = get_current_user_id();
 	$user_meta_key_booked = $_POST['booked_item'];
 	$user_meta_value_booked = get_user_meta( $user_ID, $user_meta_key_booked, true);

	echo 'Request received. ';
	echo 'First Status: ' . $user_meta_key_booked . ' is ' . $user_meta_value_booked . '. ';

 	//Asign value to meta key if it exists or not
 	if ( $user_meta_key_booked ) {
 		if ( $user_meta_value_booked === 'booked') {
 			update_user_meta( $user_ID, $user_meta_key_booked, 'not booked')	;
 		} else {
 			update_user_meta( $user_ID, $user_meta_key_booked, 'booked')	;
 		}
 	} else {
 		add_user_meta( $user_ID, $user_meta_key_booked, 'booked', true );
 	}

	$final_booked_status = get_user_meta( $user_ID, $user_meta_key_booked, true);

	echo 'Final Status: ' . $user_meta_key_booked . ' is ' . $final_booked_status;


 	//Must end with die()
 	die();
 }
