<?php

/**
* Budget Calculator Shortcode for BrideWalk
*
* Includes AJAX handler and Budget Calculator Shortcode
*
*/

//AJAX function for budget calculator, should only work if user is logged in
add_action( 'wp_ajax_update_budget_calculator_totals', 'update_budget_calculator_totals' );


/**
* This is the main AJAX function that fires every time an input box is "blur" (someone clicks out).
*
*/

function update_budget_calculator_totals() {

	//Get the info we need
	$user_ID = get_current_user_id();
	$user_meta_key = 'budget_calculator_data';
	$bc_array = get_user_meta( $user_ID, $user_meta_key, true);
	$budget_line_item = $_POST['budget_line_item'];
	$budget_new_amout = $_POST['budget_new_amout'];


	// Initializes if budget_calculator_data in db doesn't exist
	// TODO: can this be moved out to another scope?
	if( !$bc_array ) {


		// $init_array_args = array(
		// 	total_budget => '$10,000',
		// 	ceremony_venue_fee => '$3,200',
		// );

		//Asign the init_array_args to the bc_array since they're not there.
		$bc_array = $init_array_args;

		add_user_meta( $user_ID, $user_meta_key, $init_array_args , true );
	}



	// $user_meta_value = get_user_meta( $user_ID, $user_meta_key, true);
	//
	// //Asign value to meta key if it exists or not
	// if ($user_meta_value) {
	// 	if ( $user_meta_value === 'checked') {
	// 		update_user_meta( $user_ID, $user_meta_key, 'unchecked')	;
	// 	} else {
	// 		update_user_meta( $user_ID, $user_meta_key, 'checked')	;
	// 	}
	// } else {
	// 	add_user_meta( $user_ID, $user_meta_key, 'checked', true );
	// }
	//
	// $user_meta_value = get_user_meta( $user_ID, $user_meta_key, true);

	echo 'Key is: ' . $budget_line_item . "\n";
	echo 'Key type: ' . gettype($budget_line_item) . "\n";

	$arr_current_val = $bc_array[$budget_line_item];

	echo 'Current value of the key is: ' . $arr_current_val . "\n";

	$bc_array[$budget_line_item] = '$'.$budget_new_amout;

	update_user_meta( $user_ID, $user_meta_key, $bc_array);

	echo 'New Value of the key is: ' . $bc_array[$budget_line_item] . "\n";

	echo '----New Array ------';
	print_r($bc_array);
	echo '----New Array ------';

	wp_die();
}



function bw_budget_calculator() {
	/**
	* Budget Calculator Model get the data here
	*/

	$init_array_args = array(
		total_budget => '$0.00',
		ceremony_venue_fee => '$0.00',
		ceremony_ceremony_venue_accessories => '$0.00',
		ceremony_other  => '$0.00',
		reception_reception_venue_fee => '$0.00',
		reception_reception_venue_accessories => '$0.00',
		reception_other => '$0.00',
		photographer_photographer => '$0.00',
		photographer_additional_prints => '$0.00',
		photographer_other => '$0.00',
		caterer_rehersal_dinner_venue => '$0.00',
		caterer_beverage_bartenders => '$0.00',
		caterer_food_service => '$0.00',
		caterer_other => '$0.00',
		attire_bride_accessories => '$0.00',
		attire_dress_altertations => '$0.00',
		attire_groom_accessories => '$0.00',
		attire_groom_tux_suit => '$0.00',
		attire_headpiece_veil => '$0.00',
		attire_other => '$0.00',
		florist_bouquets => '$0.00',
		florist_ceremony_decorations => '$0.00',
		florist_flower_girl_flowers => '$0.00',
		florist_groom_groomsmen_boutonnieres => '$0.00',
		florist_reception_decorations_centerpieces => '$0.00',
		florist_other => '$0.00',
		dj_dj => '$0.00',
		dj_band => '$0.00',
		dj_ceremony_musicians => '$0.00',
		dj_other => '$0.00',
		videographer_videographer => '$0.00',
		videographer_other => '$0.00',
		desserts_cake_cutting_fee => '$0.00',
		desserts_other => '$0.00',
		lodging_accomodations_wedding_night => '$0.00',
		lodging_hotel_rooms_guests => '$0.00',
		lodging_other => '$0.00',
		transportation_guest_shuttle_parking => '$0.00',
		transportation_limo_car_rentals => '$0.00',
		transportation_other => '$0.00',
		rentals_reception_rentals => '$0.00',
		rentals_other => '$0.00',
		beauty_hair_makeup => '$0.00',
		beauty_prewedding_pampering => '$0.00',
		beauty_other => '$0.00',
	);

	$user_ID = get_current_user_id();
	$user_meta_key = 'budget_calculator_data';
	$bc_array = get_user_meta( $user_ID, $user_meta_key, true);

	// Initializes if budget_calculator_data in db doesn't exist
	// TODO: can this be moved out to another scope?
	if( !$bc_array && is_user_logged_in() ) {

		//Asign the init_array_args to the bc_array since they're not there.
		$bc_array = $init_array_args;

		add_user_meta( $user_ID, $user_meta_key, $init_array_args , true );
	}

/**
* Budget Calculater View
*/


	if( !is_user_logged_in() ) {

		$bc_array = $init_array_args;


	}
?>
<div class="budget_calculator_holder">
    <div class="section group calculator_bar">
    <div class="calcbar">
        <div class="col span_1_of_2">
        <div class="total_budget">Total Budget</div>
        <div class="budget_container" data-line-item="total_budget"><?php echo $bc_array['total_budget']; ?></div>
		<!-- <i id="total_buget_pencil_icon" class="eltd-icon-linear-icon lnr lnr-pencil "></i> -->
        </div>
        <div class="col span_2_of_2">
        <div class="total_budget">Total Spent</div>
        <div class="spent_container">$0.00</div>
        </div>
    </div>
    </div>
    <div class="section group calculator_titles">
        <div class="col span_1_of_2">
        <div class="title_expense_categories">Expense Categories</div>
        <div class="title_recommended_budget">Recommended Budget</div>
        </div>
        <div class="col span_2_of_2">
        <div class="title_actual_cost">Actual Cost</div>
        </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Ceremony</div>
        <div class="recommended">$4,125</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Ceremony Venue Fee</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="ceremony_venue_fee"><?php echo $bc_array['ceremony_venue_fee']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Ceremony Venue Accessories</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="ceremony_ceremony_venue_accessories"><?php echo $bc_array['ceremony_ceremony_venue_accessories']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="ceremony_other"><?php echo $bc_array['ceremony_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Reception</div>
        <div class="recommended">$4,125</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Reception Venue Fee</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="reception_reception_venue_fee"><?php echo $bc_array['reception_reception_venue_fee']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Reception Venue Accessories</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="reception_reception_venue_accessories"><?php echo $bc_array['reception_reception_venue_accessories']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="reception_other"><?php echo $bc_array['reception_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Photographer</div>
        <div class="recommended">$1,750</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Photographer</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="photographer_photographer"><?php echo $bc_array['photographer_photographer']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Additional Prints</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="photographer_additional_prints"><?php echo $bc_array['photographer_additional_prints']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="photographer_other"><?php echo $bc_array['photographer_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Caterer</div>
        <div class="recommended">$8,460</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Rehersal Dinner Venue</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="caterer_rehersal_dinner_venue"><?php echo $bc_array['caterer_rehersal_dinner_venue']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Beverage and Bartenders</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="caterer_beverage_bartenders"><?php echo $bc_array['caterer_beverage_bartenders']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Food and Service</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="caterer_food_service"><?php echo $bc_array['caterer_food_service']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="caterer_other"><?php echo $bc_array['caterer_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Attire</div>
        <div class="recommended">$1,460</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Bride's Accessories</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="attire_bride_accessories"><?php echo $bc_array['attire_bride_accessories']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Dress and Altertations</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="attire_dress_altertations"><?php echo $bc_array['attire_dress_altertations']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Groom's Accessories</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="attire_groom_accessories"><?php echo $bc_array['attire_groom_accessories']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Groom's Tux or Suit</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="attire_groom_tux_suit"><?php echo $bc_array['attire_groom_tux_suit']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Headpiece and Veil</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="attire_headpiece_veil"><?php echo $bc_array['attire_headpiece_veil']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="attire_other"><?php echo $bc_array['attire_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Florists</div>
        <div class="recommended">$1,602</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Bouquets</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="florist_bouquets"><?php echo $bc_array['florist_bouquets']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Ceremony Decorations</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="florist_ceremony_decorations"><?php echo $bc_array['florist_ceremony_decorations']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Flower Girl Flowers</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="florist_flower_girl_flowers"><?php echo $bc_array['florist_flower_girl_flowers']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Groom and Groomsmen Boutonnieres</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="florist_groom_groomsmen_boutonnieres"><?php echo $bc_array['florist_groom_groomsmen_boutonnieres']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Reception Decorations and Centerpieces</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="florist_reception_decorations_centerpieces"><?php echo $bc_array['florist_reception_decorations_centerpieces']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="florist_other"><?php echo $bc_array['florist_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">DJ</div>
        <div class="recommended">$720</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">DJ</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="dj_dj"><?php echo $bc_array['dj_dj']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Band</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="dj_band"><?php echo $bc_array['dj_band']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Ceremony Musicians</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="dj_ceremony_musicians"><?php echo $bc_array['dj_ceremony_musicians']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="dj_other"><?php echo $bc_array['dj_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Videographer</div>
        <div class="recommended">$1,100</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Videographer</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="videographer_videographer"><?php echo $bc_array['videographer_videographer']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="videographer_other"><?php echo $bc_array['videographer_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Desserts</div>
        <div class="recommended">$450</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Cake and Cutting Fee</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="desserts_cake_cutting_fee"><?php echo $bc_array['desserts_cake_cutting_fee']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="desserts_other"><?php echo $bc_array['desserts_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Lodging</div>
        <div class="recommended">$216</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Accomodations for Wedding Night</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="lodging_accomodations_wedding_night"><?php echo $bc_array['lodging_accomodations_wedding_night']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Hotel Rooms for Out-of-Town Guests</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="lodging_hotel_rooms_guests"><?php echo $bc_array['lodging_hotel_rooms_guests']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="lodging_other"><?php echo $bc_array['lodging_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Transportation</div>
        <div class="recommended">$0.00</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Guest Shuttle or Parking</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="transportation_guest_shuttle_parking"><?php echo $bc_array['transportation_guest_shuttle_parking']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Limo or Car Rentals</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="transportation_limo_car_rentals"><?php echo $bc_array['transportation_limo_car_rentals']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="transportation_other"><?php echo $bc_array['transportation_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Rentals</div>
        <div class="recommended">$0.00</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Reception Rentals</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="rentals_reception_rentals"><?php echo $bc_array['rentals_reception_rentals']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="rentals_other"><?php echo $bc_array['rentals_other']; ?></div>
        </div>
    </div>
    </div>
    <div class="section group category_holder">
    <div class="section group category">
        <div class="col span_1_of_2">
        <div class="name">Beauty</div>
        <div class="recommended">$0.00</div>
        </div>
        <div class="col span_2_of_2">
        <div class="actual_cost">$0.00</div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Hair and Makeup</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="beauty_hair_makeup"><?php echo $bc_array['beauty_hair_makeup']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Prewedding Pampering</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="beauty_prewedding_pampering"><?php echo $bc_array['beauty_prewedding_pampering']; ?></div>
        </div>
    </div>
    <div class="section group sub_category">
        <div class="col span_1_of_2">
        <div class="sub_name">Other</div>
        </div>
        <div class="col span_2_of_2">
        <div class="sub_cost" data-line-item="beauty_other"><?php echo $bc_array['beauty_other']; ?></div>
        </div>
    </div>
    </div>
</div>



<?php
}


add_shortcode( 'bw-budget-calculator', 'bw_budget_calculator' );
