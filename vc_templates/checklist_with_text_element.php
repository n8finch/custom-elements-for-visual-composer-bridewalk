<?php

// d($atts);

//Colors


//Variables
$user_ID = get_current_user_id();
$fa_icon = $atts['font_awesome_icon'];
$title = $atts['list_item_title'];
$descritpion = $atts['list_item_description'];
$data_storage = $atts['user_meta_key_checked'];
$is_checked = get_user_meta( $user_ID, 'checklist_'.$data_storage, true);


$check_color = '#46B1BB';
$check_background = '#fff';
$check_border = '#46B1BB';

if( $is_checked === "checked" ){
  $check_color = '#fff';
  $check_background = '#e37171';
  $check_border = '#e37171';
}

?>
<style>
span.checkbox-with-text-checklist .unchecked {
  color: <?php echo $check_color; ?>;
  background-color: <?php echo $check_background; ?>;
  border-color: <?php echo $check_border; ?>;
}

span.checkbox-with-text-checklist .checked {
  color: <?php echo $check_color_hover; ?>;
  background-color: <?php echo $check_background_hover; ?>;
  border-color: <?php echo $check_border_hover; ?>;
}

</style>
<div class="eltd-iwt clearfix eltd-iwt-icon-left eltd-iwt-icon-medium">
    <div class="eltd-iwt-icon-holder">
        <span class="eltd-icon-shortcode circle checkbox-with-text-checklist <?php echo $is_checked; ?>" style="width: 70px; height: 70px; line-height: 70px; background-color: <?php echo $check_background; ?>; border-style: solid; border-color: <?php echo $check_border; ?>; border-width: 2px;" data-hover-border-color="#e37171" data-hover-background-color="#e37171" data-hover-color="#ffffff" data-color="#46b1bb" data-user-checklist="checklist_<?php echo $data_storage; ?>">

	        <span class="eltd-icon-font-awesome fa <?php echo $fa_icon; ?> eltd-icon-element" style="color: <?php echo $check_color; ?>; font-size: 35px;"></span>

				</span>

    </div>
    <div class="eltd-iwt-content-holder">
        <div class="eltd-iwt-title-holder">
            <h4><?php echo $title; ?></h4>
        </div>
        <div class="eltd-iwt-text-holder">
            <p><?php echo $descritpion; ?></p>

                    </div>
    </div>
</div>
