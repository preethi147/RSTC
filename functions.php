<?php
//add js, css, function custom for child theme
 function wsme_script_enqueuer() {

  // wp_register_script('vendors', get_stylesheet_directory_uri().'/js/vendors.js', array('jquery') );
  // wp_enqueue_script('vendors');
  // wp_register_script('custom', get_stylesheet_directory_uri().'/js/custom.min.js', array('jquery') );
  // wp_enqueue_script('custom');
  //wp_register_style('screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen');
  //wp_enqueue_style('screen');
  wp_register_style('screen', get_template_directory_uri().'/style.css', '', '', 'screen');
  wp_enqueue_style('screen');
 }
add_action( 'wp_enqueue_scripts', 'wsme_script_enqueuer' );

function b5f_increase_upload( $bytes ) {
    return 67108864; // 32 megabytes
}
add_filter( 'upload_size_limit', 'b5f_increase_upload' );