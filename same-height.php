<?php
/**
 * Plugin Name: Same Height
 * Plugin URI: https://www.facebook.com/damiarita
 * Description: This plugins uses jQuery to force different HTML elements to have the same height. It is very useful when you want to present to boxes side by side and they have to look equal. Youcan edit the HTML code with a class or use the shortcode [sameHeight]
 * Version: 1.4.1
 * Author: Damià Rita
 * Author URI: https://www.facebook.com/damiarita
 */
 
/**
 * We enqueue the JS file
 */

add_action( 'wp_enqueue_scripts', 'enqueue_sameheight_script' );
function enqueue_sameheight_script (){
	$extension='.min.js';
	if( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
		$extension='.js';
	}
	wp_enqueue_script( 'sameHeight', plugins_url( 'sameHeight'.$extension, __FILE__ ), array('jquery'), '1.3.0', true);
}
 
/**
 * We define the shortcode
 */
add_shortcode( 'sameheight', 'sh_print_html' );
 function sh_print_html($atts, $content = ""){

   extract(shortcode_atts(
   			  array('breakpoint'=>'','group'=>'','additional_classes'=>'')
   			 ,$atts
   			 )
   	  );
   
   $return_string = "<div class='".$additional_classes." same-height";
   if ($breakpoint!= ''){
   	$return_string .= "-".$breakpoint;
   }
   $return_string .= "'";
   if ($group != ''){
   	$return_string .= " same-height-group='".$group."'";
   }
   $return_string .= ">";
   $return_string .= $content;
   $return_string .= "</div>";
   
   return $return_string;
 }
 
/*Compatibility with https://wordpress.org/plugins/amp/ by Automattic. same-height-group is not allowed in AMP*/
add_action( 'pre_amp_render_post', 'sh_remove_same_height_group_attr' );
function sh_remove_same_height_group_attr() {
    add_filter( 'the_content', 'sh_remove_same_height_group_attr_from_the_content' );
}
function sh_remove_same_height_group_attr_from_the_content ( $content ){
	$content = preg_replace('/\ssame-height-group(="[^"]*")?(\s|\/|>)/i','$2', $content); //Regular expression that removes all the same-height-group attrs
	$content = preg_replace('/\ssame-height-group(=\'[^\']*\')?(\s|\/|>)/i','$2', $content); //Regular expression that removes all the same-height-group attrs
	return $content;
}
 
 ?>