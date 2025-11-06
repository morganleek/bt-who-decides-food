<?php
	if( !function_exists( '___' ) ) {
    function ___( $object, $return = false ) {
      $pre = '<pre>' . print_r( $object, true ) . '</pre>';
      if( $return ) {
        return $pre;
      }
      print $pre;
    }
  }

  // function bones_theme_the_html_classes() {
  //   $classes = apply_filters( 'bones_theme_html_classes', '' );
  //   if ( !$classes ) {
  //     return;
  //   }
  //   echo 'class="' . esc_attr( $classes ) . '"';
  // }