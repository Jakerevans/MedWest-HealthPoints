<?php
/**
 * MedWesthealthpoints MedWesthealthpoints_Toplevel_Form Submenu Class
 *
 * @author   Jake Evans
 * @category ??????
 * @package  ??????
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MedWesthealthpoints_Toplevel_Form', false ) ) :
/**
 * MedWesthealthpoints_Toplevel_Form Class.
 */
class MedWesthealthpoints_Toplevel_Form {

	public static function output_medwesthealthpoints_form(){

		global $wpdb;
	
		// For grabbing an image from media library
		wp_enqueue_media();

		$string1 = '';
		
    	return $string1;
	}
}

endif;