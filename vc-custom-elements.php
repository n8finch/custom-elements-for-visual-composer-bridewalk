<?php
/*
Plugin Name: Custom Visual Composer Elements
Plugin URI: http://vc.wpbakery.com
Description: Taken from vc starter plugin
Version: 0.1
Author: Nate Finch
Author URI: https://n8finch.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


function n8f_vc_map_dependencies() {
	if ( ! defined( 'WPB_VC_VERSION' ) ) {
		$plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
        </div>';
	}
}
add_action( 'admin_notices', 'n8f_vc_map_dependencies' );


/**
 * [load_checklist_with_text_element_scripts_on_front_end description]
 * @return [type] [description]
 */
function load_checklist_with_text_element_scripts_on_front_end() {

	wp_enqueue_script( 'checklist-script', plugins_url() . '/vc-custom-elements/assets/js/checklist_with_text_element.js', array( 'jquery'), false, false );

	wp_localize_script( 'checklist-script', 'checklist_ajax_object', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	));
}
add_action('wp_enqueue_scripts', 'load_checklist_with_text_element_scripts_on_front_end', 999);



add_action( 'wp_ajax_checklist_item_check_uncheck', 'checklist_item_check_uncheck' );

function checklist_item_check_uncheck() {
	$user_ID = get_current_user_id();
	$user_meta_key = $_POST['checklist_item'];
	$user_meta_value = get_user_meta( $user_ID, $user_meta_key, true);

	//Asign value to meta key if it exists or not
	if ($user_meta_value) {
		if ( $user_meta_value === 'checked') {
			update_user_meta( $user_ID, $user_meta_key, 'unchecked')	;
		} else {
			update_user_meta( $user_ID, $user_meta_key, 'checked')	;
		}
	} else {
		add_user_meta( $user_ID, $user_meta_key, 'checked', true );
	}

	$user_meta_value = get_user_meta( $user_ID, $user_meta_key, true);

	echo 'Server says: ' . $user_meta_value;

	//Must end with die()
	die();
}


function text_vc_map_init() {
	// Note that all keys=values in mapped shortcode can be used with javascript variable vc.map, and php shortcode settings variable.
	$settings = array(
		'name'                    => __( 'Checkbox with Text', 'js_composer' ),
		// shortcode name

		'base'                    => 'checklist_with_text_element',
		// shortcode base [test_element]

		'category'                => __( 'Custom Elements', 'js_composer' ),
		// param category tab in add elements view

		'description'             => __( 'Custom element for BrideWalk', 'js_composer' ),
		// element description in add elements view

		'show_settings_on_create' => false,
		// don't show params window after adding

		'weight'                  => - 5,
		// Depends on ordering in list, Higher weight first

		'html_template'           => dirname( __FILE__ ) . '/vc_templates/checklist_with_text_element.php',
		// if you extend VC within your theme then you don't need this, VC will look for shortcode template in "wp-content/themes/your_theme/vc_templates/test_element.php" automatically. In this example we are extending VC from plugin, so we rewrite template

		'admin_enqueue_js'        => preg_replace( '/\s/', '%20', plugins_url( 'assets/admin_enqueue_js.js', __FILE__ ) ),
		// This will load extra js file in backend (when you edit page with VC)
		// use preg replace to be sure that "space" will not break logic

		'admin_enqueue_css'       => preg_replace( '/\s/', '%20', plugins_url( 'assets/admin_enqueue_css.css', __FILE__ ) ),
		// This will load extra css file in backend (when you edit page with VC)

		'front_enqueue_js'        => preg_replace( '/\s/', '%20', plugins_url( 'assets/front_enqueue_js.js', __FILE__ ) ),
		// This will load extra js file in frontend editor (when you edit page with VC)

		'front_enqueue_css'       => preg_replace( '/\s/', '%20', plugins_url( 'assets/front_enqueue_css.css', __FILE__ ) ),
		// This will load extra css file in frontend editor (when you edit page with VC)

		'js_view'                 => 'ViewTestElement',
		// JS View name for backend. Can be used to override or add some logic for shortcodes in backend (cloning/rendering/deleting/editing).

		'params'                  => array(
			array(
				"type"        => "textfield",
				"heading"     => __( "Font Awesome Icon", "js_composer" ),
				"param_name"  => "font_awesome_icon",
				"description" => __( "Use \"fa-check\" or similar format.", "js_composer" )
			),
			array(
				"type"        => "textfield",
				"heading"     => __( "List Item Title", "js_composer" ),
				"param_name"  => "list_item_title",
				"value"				=> "This is the default title",
				"description" => __( "Title of the list item.", "js_composer" )
			),
			array(
				"type"        => "textfield",
				"heading"     => __( "List Item Description", "js_composer" ),
				"param_name"  => "list_item_description",
				"value"				=> "This is the default description.",
				"description" => __( "Description of the list item.", "js_composer" )
			),
			array(
				"type"        => "textfield",
				"heading"     => __( "User Meta Key", "js_composer" ),
				"param_name"  => "user_meta_key_checked",
				"value"				=> "something_like_this (replace me!)",
				"description" => __( "This is the meta key to store info in the db. No spaces, only - and _ , for example wedding_photographer.", "js_composer" )
			),
		)
	);
	vc_map( $settings );

	if ( class_exists( "WPBakeryShortCode" ) ) {
		// Class Name should be WPBakeryShortCode_Your_Short_Code
		// See more in vc_composer/includes/classes/shortcodes/shortcodes.php
		class WPBakeryShortCode_Checklist_With_Text_Element extends WPBakeryShortCode {

			public function __construct( $settings ) {
				parent::__construct( $settings ); // !Important to call parent constructor to active all logic for shortcode.
				$this->jsCssScripts();
			}

			public function vcLoadIframeJsCss() {
				wp_enqueue_style( 'checklist_with_text_element_iframe' );
			}

			public function contentInline( $atts, $content ) {
				$this->vcLoadIframeJsCss();
			}

			// Register scripts and styles there (for preview and frontend editor mode).
			public function jsCssScripts() {
				wp_register_script( 'checklist_with_text_element', plugins_url( 'assets/js/checklist_with_text_element.js', __FILE__ ), array( 'jquery' ), time(), false );
				wp_register_style( 'checklist_with_text_element_iframe', plugins_url( 'assets/front_enqueue_iframe_css.css', __FILE__ ) );
			}

			// Some custom helper function that can be used in content element template (vc_templates/test_element.php)
			// This function check some string if it matches "yes","true",1,"1" return TRUE if yes, false if NOT.
			public function checkBool( $in ) {
				if ( strlen( $in ) > 0 && in_array( strtolower( $in ), array(
					"yes",
					"true",
					"1",
					1
				) )
				) {
					return true;
				}
				return false;
			}

		}
	} // End Class
}


add_action('vc_after_init', 'text_vc_map_init');
