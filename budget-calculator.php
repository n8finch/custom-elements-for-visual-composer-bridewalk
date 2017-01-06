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

		$init_array_args = array(
			total_budget => '$10,000',
			ceremony_venue_fee => '$3,200',
		);

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




	 //All the vars
	// total_budget
	//  ceremony_venue_fee
	//  ceremony_ceremony_venue_accessories
	//  ceremony_other
	//  reception_reception_venue_fee
	//  reception_reception_venue_accessories
	//  reception_other
	//  photographer_photographer
	//  photographer_additional_prints
	//  photographer_other
	//  caterer_rehersal_dinner_venue
	//  caterer_beverage_bartenders
	//  caterer_food_service
	//  caterer_other
	//  attire_bride_accessories
	//  attire_dress_altertations
	//  attire_groom_accessories
	//  attire_groom_tux_suit
	//  attire_headpiece_veil
	//  attire_other
	//  florist_bouquets
	//  florist_ceremony_decorations
	//  florist_flower_girl_flowers
	//  florist_groom_groomsmen_boutonnieres
	//  florist_reception_decorations_centerpieces
	//  florist_other
	//  dj_dj
 // 	 dj_band
 // 	 dj_ceremony_musicians
	//  dj_other
	//  videographer_videographer
	//  videographer_other
	//  desserts_cake_cutting_fee
	//  desserts_other
	//  lodging_accomodations_wedding_night
	//  lodging_hotel_rooms_guests
	//  lodging_other
	//  transportation_guest_shuttle_parking
	//  transportation_limo_car_rentals
	//  transportation_other
	//  rentals_reception_rentals
	//  rentals_other
	//  beauty_hair_makeup
	//  beauty_prewedding_pampering
	//  beauty_other


	$user_ID = get_current_user_id();
	$user_meta_key = 'budget_calculator_data';
	$bc_array = get_user_meta( $user_ID, $user_meta_key, true);

	// Initializes if budget_calculator_data in db doesn't exist
	// TODO: can this be moved out to another scope?
	if( !$bc_array ) {

		$init_array_args = array(
			total_budget => '$10,000',
			ceremony_venue_fee => '$3,200',
		);

		//Asign the init_array_args to the bc_array since they're not there.
		$bc_array = $init_array_args;

		add_user_meta( $user_ID, $user_meta_key, $init_array_args , true );
	}

	 /**
	  * Budget Calculater View
	  */
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
                    <div class="spent_container">$8,700</div>
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
                    <div class="actual_cost">$3,200</div>
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
                    <div class="sub_cost">$155.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">777.00</div>
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
                    <div class="actual_cost">$5,400</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Reception Venue Fee</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$5,400</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Reception Venue Accessories</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="actual_cost">$1,500</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Photographer</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$1,500</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Additional Prints</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="actual_cost">$500</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Rehersal Dinner Venue</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$500</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Beverage and Bartenders</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Food and Service</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="actual_cost">$180</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Bride's Accessories</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$180</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Dress and Altertations</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Groom's Accessories</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Groom's Tux or Suit</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Headpiece and Veil</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="actual_cost">$126</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Bouquets</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$126</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Ceremony Decorations</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Flower Girl Flowers</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Groom and Groomsmen Boutonnieres</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Reception Decorations and Centerpieces</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="actual_cost">$800</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">DJ</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$800</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Band</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Ceremony Musicians</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="actual_cost">$950</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Videographer</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$950</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="actual_cost">$400</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Cake and Cutting Fee</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$400</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="actual_cost">$250</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Accomodations for Wedding Night</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$250</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Hotel Rooms for Out-of-Town Guests</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Limo or Car Rentals</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="sub_cost">$250</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
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
                    <div class="sub_cost">$250</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Prewedding Pampering</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                <div class="section group sub_category">
                    <div class="col span_1_of_2">
                    <div class="sub_name">Other</div>
                    </div>
                    <div class="col span_2_of_2">
                    <div class="sub_cost">$0.00</div>
                    </div>
                </div>
                </div>
            </div>



	<?php
}


add_shortcode( 'bw-budget-calculator', 'bw_budget_calculator' );
