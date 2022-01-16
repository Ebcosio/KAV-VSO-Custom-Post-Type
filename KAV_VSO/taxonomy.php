<?php

add_action( 'init', 'create_vso_hierarchical_taxonomy');
function create_vso_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

  $labels = array(
    'name' => _x( 'VSO Type', 'taxonomy general name' ),
    'singular_name' => _x( 'VSO Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search VSO Type' ),
    'all_items' => __( 'All VSO Type' ),
    'parent_item' => __( 'Parent VSO Type' ),
    'parent_item_colon' => __( 'Parent VSO Type:' ),
    'edit_item' => __( 'Edit VSO Type' ),
    'update_item' => __( 'Update VSO Type' ),
    'add_new_item' => __( 'Add New VSO Type' ),
    'new_item_name' => __( 'New VSO Type Name' ),
    'menu_name' => __( 'VSO Type' ),
  );

// Now register the taxonomy
  register_taxonomy('VSO Type',array('kav-vso'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => false,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'VSO Type' ),
  ));

}

 ?>
