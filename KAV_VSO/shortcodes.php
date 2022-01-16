<?php
function get_kav_states_vso(){
$the_query = new WP_Query( array(
    'post_type' => 'kav-vso',
    'orderby'=>'post_title',
    'order'=>'ASC',
    'tax_query' => array(
        array (
            'taxonomy' => 'VSO Type',
            'field' => 'slug',
            'terms' => array( 'state' ),
        )
    ),
) );

/*
while ( $the_query->have_posts() ) :
    $the_query->the_post();
    // Show Posts ...
  ?>  <h2><?php the_title(); ?></h2>

        <?php the_content();
       	$webaddress = get_post_meta( get_the_ID(), 'webaddress', true );
        ?>  <p><?php echo $webaddress;  ?></p><?php

endwhile;
*/
 echo '<div class="states-vso-information-wrapper Accordion" id="accordionGroup" data-allow-multiple>';
while ( $the_query->have_posts() ) :
    $the_query->the_post();
    // Show Posts ...
    $post_id = get_the_ID();
  ?>
<div class="cpt-state-vso-card">
    <h2 class="cpt-vso-title"><?php the_title(); ?></h2>
    <button disabled="true" aria-expanded="false" aria-controls="content-<?php echo $post_id; ?>"
            class="Accordion-trigger"  id="accordion-id-<?php echo $post_id; ?>"> contact info</button>

            <?php
            $webaddress = get_post_meta( $post_id, 'webaddress', true );
            $webname = get_post_meta( $post_id, 'webname', true );
            ?>
    <div class="Accordion-panel cpt-vso-text" aria-labelledby="accordion-id-<?php echo $post_id; ?>"
      id="content-<?php echo $post_id; ?>">
      <?php  the_content();    ?>
     </div>

        <p class="cpt-vso-link"><?php echo get_vso_link($webname, $webaddress);  ?></p>
        <?php if($webaddress !== '') {echo '<p class="center-vso" aria-hidden="true">web address: '. $webaddress .'</p>';} ?>


</div>
        <?php
endwhile;
echo '</div>';
/* Restore original Post Data
 *  Because we are using new WP_Query we aren't stomping on the
 * original $wp_query and it does not need to be reset.
*/
wp_reset_postdata();

}

//helpers
function get_vso_link($name, $href){
  if($name && !$href){
    return $name;
  }
  if($name && $href){
    return '<a href="'. $href .'" target="_blank">' . $name . '</a>';
  }
  if(!$name && $href){
    return '<a href="'. $href .'" target="_blank">View VSO website</a>';
  }
  if(!$name && !$href){
    return;
  }
}
add_shortcode('kav_states_vso', 'get_kav_states_vso', 1);
 ?>
