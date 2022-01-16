<?php
/**
 * Plugin Name: KAV Veterans Services Organization custom post type
 * Plugin URI: https://github.com/Ebcosio/CLT_News
 * Description: This plugin registers the custom Post type for our KAV VSOs.  Also contains shortcode to output and
 * display all states on a page.  Use shortcode [kav_states_vso] to do so!
 * Version: 1.0.0
 * Author: Eric Cosio
 *
*/

defined('ABSPATH') || die;
define('KAV_VSO_CPT', '1.0.0');
define('KAV_VSO_CPT', plugin_dir_path( __FILE__ ) );
define('KAV_VSO_CPT_TRANS', 'kav-vso-plugin');

 include_once('meta_boxes.php');
 include_once('taxonomy.php');
 include_once('shortcodes.php');

 wp_register_style( 'vso-styling', plugins_url( 'vso_styling.css' , __FILE__ ));
 wp_register_style( 'vso-accordion-styling', plugins_url( 'accordion.css' , __FILE__ ));
 wp_register_script( 'vso-accordion-script', plugins_url( 'accordion.js' , __FILE__ ));


function vso_scripts(){
  // add condition if shortcode
  $post = get_page(get_the_ID());
    if( has_shortcode( $post->post_content, 'kav_states_vso') ) {

      wp_enqueue_style('vso-styling');
      wp_enqueue_style('vso-accordion-styling');
      wp_enqueue_script('vso-accordion-script');
            }
        unset($post);

}
add_action( 'wp_enqueue_scripts', 'vso_scripts');
add_action('init', 'create_VSOposttype', 0);

register_activation_hook( __FILE__, 'flush_activate_cpt' );
register_deactivation_hook( __FILE__, 'flush_deactivate' );

function flush_activate_cpt(){
        // First, we "add" the custom post type via the above written function.
    create_VSOposttype();

    // ATTENTION: This is *only* done during plugin activation/deactivation hook in this example!
   // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}

function flush_deactivate(){
  // ATTENTION: This is *only* done during plugin activation/deactivation hook in this example!
 // You should *NEVER EVER* do this on every page load!!
  flush_rewrite_rules();
}

function create_VSOposttype() {

$labels = array(
    'name'                  => _x( 'KAV VSOs', 'Post Type General Name', KAV_VSO_CPT_TRANS ),
    'singular_name'         => _x( 'KAV VSO', 'Post Type Singular Name', KAV_VSO_CPT_TRANS ),
    'menu_name'             => __( 'KAV VSOs', KAV_VSO_CPT_TRANS ),
    'name_admin_bar'        => __( 'KAV VSOs', KAV_VSO_CPT_TRANS ),
    'archives'              => __( 'KAV VSOs', KAV_VSO_CPT_TRANS ),
    'attributes'            => __( 'Event Attributes', KAV_VSO_CPT_TRANS ),
    'parent_item_colon'     => __( 'Parent Event', KAV_VSO_CPT_TRANS ),
    'all_items'             => __( 'All KAV VSOs', KAV_VSO_CPT_TRANS ),
    'add_new_item'          => __( 'Add New KAV VSO', KAV_VSO_CPT_TRANS ),
    'add_new'               => __( 'Add New', KAV_VSO_CPT_TRANS ),
    'new_item'              => __( 'New KAV VSO', KAV_VSO_CPT_TRANS ),
    'edit_item'             => __( 'Edit KAV VSO', KAV_VSO_CPT_TRANS ),
    'update_item'           => __( 'Update KAV VSO', KAV_VSO_CPT_TRANS ),
    'view_item'             => __( 'View KAV VSO', KAV_VSO_CPT_TRANS ),
    'view_items'            => __( 'View KAV VSOs', KAV_VSO_CPT_TRANS ),
    'search_items'          => __( 'Search KAV VSO', KAV_VSO_CPT_TRANS ),
    'not_found'             => __( 'Not found', KAV_VSO_CPT_TRANS ),
    'not_found_in_trash'    => __( 'Not found in Trash', KAV_VSO_CPT_TRANS ),
    'featured_image'        => __( 'Featured image', KAV_VSO_CPT_TRANS ),
    'set_featured_image'    => __( 'Set featured image', KAV_VSO_CPT_TRANS ),
    'remove_featured_image' => __( 'Remove featured image', KAV_VSO_CPT_TRANS ),
    'use_featured_image'    => __( 'Use as featured image', KAV_VSO_CPT_TRANS ),
    'insert_into_item'      => __( 'Insert into KAV VSO', KAV_VSO_CPT_TRANS ),
    'uploaded_to_this_item' => __( 'Uploaded to this KAV VSO', KAV_VSO_CPT_TRANS ),
    'items_list'            => __( 'KAV VSOs list', KAV_VSO_CPT_TRANS ),
    'items_list_navigation' => __( 'KAV VSOs list navigation', KAV_VSO_CPT_TRANS ),
    'filter_items_list'     => __( 'Filter KAV VSOs list', KAV_VSO_CPT_TRANS ),
);
$args = array(
    'label'                 => __( 'KAV VSO', KAV_VSO_CPT_TRANS ),
    'description'           => __( 'KAV VSOs by month', KAV_VSO_CPT_TRANS ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'custom-fields', 'revisions', 'editor' ),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 8,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => false,
    'has_archive'           => true,
    'exclude_from_search'   => true,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
    'show_in_rest'          => true,
    );
    register_post_type( 'kav-vso', $args );
  }
