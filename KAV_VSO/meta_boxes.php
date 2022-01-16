<?php

add_action( 'add_meta_boxes', 'kavvso_add_custom_box' );
add_action( 'save_post', 'wpt_save_events_meta', 1, 2 );

function kavvso_add_custom_box() {
  //  $screens = [ 'post', 'kav-vso' ];
  //  foreach ( $screens as $screen ) {

        add_meta_box(
            'kav_vso_webinfo',
            'Name of VSO website',
            'kav_vso_webname',
            'kav-vso',
            'side',
            'high'
      );

        add_meta_box(
          //  'kavvso_box_id',
            'wporg_box_id',      // Unique ID
            'VSO Website Address',      // Box title
            'kav_vso_information',  // Content callback, must be of type callable
             'kav-vso',
             'side',
             'high'
          //  $screen                            // Post type
        );
//    }
}


function kav_vso_webname() {
  global $post;

  	// Nonce field to validate form request came from current site
  	wp_nonce_field( basename( __FILE__ ), 'vso_fields' );

  	// Get the location data if it's already been entered
  	$webname = get_post_meta( $post->ID, 'webname', true );

  	// Output the field
  	echo ' <p><b>ATTENTION:  </b> Neil and KAV admin staff.
     Enter the exact website name of the VSO if you want it to show in the VSO search page.  Remember to Save or
     Update the Post after you enter it or change it.
     </p>
    <label for="webname"><b>Enter VSO website name:</b> </label>
    <input type="text" id="webname" name="webname" placeholder="website name here"
    value="'. esc_textarea( $webname )  .'" class="widefat">';
}

function kav_vso_information() {
  global $post;

  	// Nonce field to validate form request came from current site ; don't need for all metabox callbacks?
  //	wp_nonce_field( basename( __FILE__ ), 'vso_fields' );

  	// Get the location data if it's already been entered
  	$webaddress = get_post_meta( $post->ID, 'webaddress', true );

  	// Output the field
  	echo ' <p><b>ATTENTION:  </b> Neil and KAV admin staff.
     Enter the full web address of this VSO in this box to show in the VSO search page.  Remember to Save or
     Update the Post after you enter it or change it.
     The web address can also be updated/changed/deleted from here.  Use the FULL address, including
     http:// or https://</p>
    <label for="webaddress"><b>Enter State VSO full web address here:</b></label>
    <input type="text" id="webaddress" name="webaddress" placeholder="website address here"
    value="' . esc_textarea( $webaddress )  . '" class="widefat">';

   if($webaddress !== '') {
     echo '<br/><p>current VSO web address is: '. esc_textarea( $webaddress ) .'</p>';
     echo '<p>You can change or update by entering into the field above and remember to UPDATE the post!</p>';

   }
}

function wpt_save_events_meta( $post_id, $post ) {

	// Return if the user doesn't have edit permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	if ( ! isset( $_POST['webaddress'] ) || ! wp_verify_nonce( $_POST['vso_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}

	// Now that we're authenticated, time to save the data.
	// This sanitizes the data from the field and saves it into an array $events_meta.
	$events_meta['webaddress'] = esc_textarea( $_POST['webaddress'] );
  $events_meta['webname'] = esc_textarea( $_POST['webname'] );

	// Cycle through the $events_meta array.
	// Note, in this example we just have one item, but this is helpful if you have multiple.
	foreach ( $events_meta as $key => $value ) :

		// Don't store custom data twice
		if ( 'revision' === $post->post_type ) {
			return;
		}

		if ( get_post_meta( $post_id, $key, false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, $key, $value );
		} else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, $key, $value);
		}

		if ( ! $value ) {
			// Delete the meta key if there's no value
			delete_post_meta( $post_id, $key );
		}

	endforeach;

}


 ?>
