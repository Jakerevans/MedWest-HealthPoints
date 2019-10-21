<?php
/**
 * Class MedWestHealthPoints_Ajax_Functions - class-medwesthpplugin-ajax-functions.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes
 * @version  6.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MedWestHealthPoints_Ajax_Functions', false ) ) :
	/**
	 * MedWestHealthPoints_Ajax_Functions class. Here we'll do things like enqueue scripts/css, set up menus, etc.
	 */
	class MedWestHealthPoints_Ajax_Functions {

		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {


		}


		public function medwesthealthpoints_register_new_user_action_callback() {
			error_log('fdsfdsa');

			global $wpdb;
			//check_ajax_referer( 'medwesthealthpoints_register_new_user_action', 'security' );

			$userfirstname  = '';
			$userlastname   = '';
			$useremail      = '';
			$userpassword   = '';
			$userdepartment = '';
			$useridnumber   = '';

			if ( isset( $_POST['userfirstname'] ) ) {
				$userfirstname = filter_var( wp_unslash( $_POST['userfirstname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userlastname'] ) ) {
				$userlastname = filter_var( wp_unslash( $_POST['userlastname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['useremail'] ) ) {
				$useremail = filter_var( wp_unslash( $_POST['useremail'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userpassword'] ) ) {
				$userpassword = filter_var( wp_unslash( $_POST['userpassword'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userdepartment'] ) ) {
				$userdepartment = filter_var( wp_unslash( $_POST['userdepartment'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['useridnumber'] ) ) {
				$useridnumber = filter_var( wp_unslash( $_POST['useridnumber'] ), FILTER_SANITIZE_STRING );
			}


			// Let's make checks for WordPress user/e-mail already being taken.
			$user_id       = '';
			$usernamecheck = username_exists( $useremail );
			if ( $usernamecheck ) {
				$error = 'Username Exists';
				wp_die( $error );
			}

			if ( email_exists( $useremail ) ) {
				$error = 'E-Mail Exists';
				wp_die( $error );
			}

			if ( ! $usernamecheck && false === email_exists( $useremail ) ) {
				$user_id = wp_create_user( $useremail, $userpassword, $useremail );
				if ( is_wp_error( $user_id ) ) {
					$user_id = 'Unknown error creating WordPress User';
					wp_die( $user_id );
				} else {

					// Now add the user to the custom table.
					$user_table_array = array(
						'userfirstname'    => $userfirstname,
						'userlastname'     => $userlastname,
						'userjoindate'     => date("m/d/Y"),
						'userwpuserid'     => $user_id,
						'userdepartment'   => $userdepartment,
						'useridnumber'     => $useridnumber,
						'userhealthpoints' => 0,
						'userlastlogin'    => date("m/d/Y"),
						'useremail'        => $useremail,
					);

					$user_table_dbtype_array = array(
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%d',
						'%s',
						'%s',
					);

					$users_table_result = $wpdb->insert( $wpdb->prefix . 'medwesthealthpoints_users', $user_table_array, $user_table_dbtype_array );
					$user_id            = $wpdb->insert_id;
					wp_die( $user_id . '--$user_id--' . $useremail );
				}
			}

		}



















		public function medwesthealthpoints_save_activity_user_action_callback() {
			error_log('fdsfdgfgfdgfdsa');

			global $wpdb;
			//check_ajax_referer( 'mmedwesthealthpoints_save_activity_user_action', 'security' );

			$activityname           = '';
			$activitycategory       = '';
			$activitydateperformed  = '';
			$activitysupportingdocs = '';
			$activitywpuserid       = '';
			$activityemployeeid     = '';

			if ( isset( $_POST['activityname'] ) ) {
				$activityname = filter_var( wp_unslash( $_POST['activityname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitycategory'] ) ) {
				$activitycategory = filter_var( wp_unslash( $_POST['activitycategory'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitydateperformed'] ) ) {
				$activitydateperformed = filter_var( wp_unslash( $_POST['activitydateperformed'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitysupportingdocs'] ) ) {
				$activitysupportingdocs = filter_var( wp_unslash( $_POST['activitysupportingdocs'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitywpuserid'] ) ) {
				$activitywpuserid = filter_var( wp_unslash( $_POST['activitywpuserid'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activityemployeeid'] ) ) {
				$activityemployeeid = filter_var( wp_unslash( $_POST['activityemployeeid'] ), FILTER_SANITIZE_STRING );
			}


			// Now add the user to the custom table.
			$activitiessubmitted_table_array = array(
				'activityname'           => $activityname,
				'activitycategory'       => $activitycategory,
				'activitydateperformed'  => $activitydateperformed,
				'activitysupportingdocs' => $activitysupportingdocs,
				'activitywpuserid'       => $activitywpuserid,
				'activityemployeeid'     => $activityemployeeid,
				'activitystatus'         => 'pending',
			);

			$activitiessubmitted_table_dbtype_array = array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%d',
				'%s',
				'%s',
			);

			$activitiessubmitted_table_result = $wpdb->insert( $wpdb->prefix . 'medwesthealthpoints_activities_submitted', $activitiessubmitted_table_array, $activitiessubmitted_table_dbtype_array );
			$activitiessubmitted_id           = $wpdb->insert_id;
			wp_die( $activitiessubmitted_id );

		}



	}
endif;

/*



function medwesthealthpoints_settings_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		$("#medwesthealthpoints-img-remove-1").click(function(event){
  			$('#medwesthealthpoints-preview-img-1').attr('src', '<?php echo ROOT_IMG_ICONS_URL ?>'+'book-placeholder.svg');
  		});

  		$("#medwesthealthpoints-img-remove-2").click(function(event){
  			$('#medwesthealthpoints-preview-img-2').attr('src', '<?php echo ROOT_IMG_ICONS_URL ?>'+'book-placeholder.svg');
  		});



	  	$("#medwesthealthpoints-save-settings").click(function(event){

	  		$('#medwesthealthpoints-success-div').html('');
	  		$('#medwesthpplugin-spinner-storfront-lib').animate({'opacity':'1'});

	  		var callToAction = $('#medwesthealthpoints-call-to-action-input').val();
	  		var libImg = $('#medwesthealthpoints-preview-img-1').attr('src');
	  		var bookImg = $('#medwesthealthpoints-preview-img-2').attr('src');

		  	var data = {
				'action': 'medwesthealthpoints_settings_action',
				'security': '<?php echo wp_create_nonce( "medwesthealthpoints_settings_action_callback" ); ?>',
				'calltoaction':callToAction,
				'libimg':libImg,
				'bookimg':bookImg			
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {

			    	$('#medwesthpplugin-spinner-storfront-lib').animate({'opacity':'0'});
			    	$('#medwesthealthpoints-success-div').html('<span id="medwesthpplugin-add-book-success-span">Success!</span><br/><br/> You\'ve saved your MedWestHealthPoints Settings!<div id="medwesthpplugin-addstylepak-success-thanks">Thanks for using WPBooklist! If you happen to be thrilled with MedWesthealthpoints, then by all means, <a id="medwesthpplugin-addbook-success-review-link" href="https://wordpress.org/support/plugin/medwesthpplugin/reviews/?filter=5">Feel Free to Leave a 5-Star Review Here!</a><img id="medwesthpplugin-smile-icon-1" src="http://evansclienttest.com/wp-content/plugins/medwesthpplugin/assets/img/icons/smile.png"></div>')
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}


function medwesthealthpoints_settings_action_callback(){
	global $wpdb;
	check_ajax_referer( 'medwesthealthpoints_settings_action_callback', 'security' );
	$call_to_action = filter_var($_POST['calltoaction'],FILTER_SANITIZE_STRING);
	$lib_img = filter_var($_POST['libimg'],FILTER_SANITIZE_URL);
	$book_img = filter_var($_POST['bookimg'],FILTER_SANITIZE_URL);
	$table_name = MEDWEST_PREFIX.'medwesthealthpoints_jre_toplevel_options';

	if($lib_img == '' || $lib_img == null || strpos($lib_img, 'placeholder.svg') !== false){
		$lib_img = 'Purchase Now!';
	}

	if($book_img == '' || $book_img == null || strpos($book_img, 'placeholder.svg') !== false){
		$book_img = 'Purchase Now!';
	}

	$data = array(
        'calltoaction' => $call_to_action, 
        'libraryimg' => $lib_img, 
        'bookimg' => $book_img 
    );
    $format = array( '%s','%s','%s'); 
    $where = array( 'ID' => 1 );
    $where_format = array( '%d' );
    echo $wpdb->update( $table_name, $data, $where, $format, $where_format );


	wp_die();
}


function medwesthealthpoints_save_default_action_javascript() { 

	$trans1 = __("Success!", 'medwesthpplugin');
	$trans2 = __("You've saved your default Toplevel WooCommerce Settings!", 'medwesthpplugin');
	$trans6 = __("Thanks for using MedWesthealthpoints, and", 'medwesthpplugin');
	$trans7 = __("be sure to check out the MedWesthealthpoints Extensions!", 'medwesthpplugin');
	$trans8 = __("If you happen to be thrilled with MedWesthealthpoints, then by all means,", 'medwesthpplugin');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'medwesthpplugin');

	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#medwesthealthpoints-woo-settings-button").click(function(event){

	  		$('#medwesthealthpoints-woo-set-success-div').html('');
	  		$('.medwesthpplugin-spinner').animate({'opacity':'1'});

	  		var salePrice = $( "input[name='book-woo-sale-price']" ).val();
			var regularPrice = $( "input[name='book-woo-regular-price']" ).val();
			var stock = $( "input[name='book-woo-stock']" ).val();
			var length = $( "input[name='book-woo-length']" ).val();
			var width = $( "input[name='book-woo-width']" ).val();
			var height = $( "input[name='book-woo-height']" ).val();
			var weight = $( "input[name='book-woo-weight']" ).val();
			var sku = $("#medwesthpplugin-addbook-woo-sku" ).val();
			var virtual = $("input[name='medwesthpplugin-woocommerce-vert-yes']").prop('checked');
			var download = $("input[name='medwesthpplugin-woocommerce-download-yes']").prop('checked');
			var salebegin = $('#medwesthpplugin-addbook-woo-salebegin').val();
			var saleend = $('#medwesthpplugin-addbook-woo-saleend').val();
			var purchasenote = $('#medwesthpplugin-addbook-woo-note').val();
			var productcategory = $('#medwesthpplugin-woocommerce-category-select').val();
			var reviews = $('#medwesthpplugin-woocommerce-review-yes').prop('checked');
			var upsells = $('#select2-upsells').val();
			var crosssells = $('#select2-crosssells').val();

			var upsellString = '';
			var crosssellString = '';

			// Making checks to see if Toplevel extension is active
			if(upsells != undefined){
				for (var i = 0; i < upsells.length; i++) {
					upsellString = upsellString+','+upsells[i];
				};
			}

			if(crosssells != undefined){
				for (var i = 0; i < crosssells.length; i++) {
					crosssellString = crosssellString+','+crosssells[i];
				};
			}

			if(salebegin != undefined && saleend != undefined){
				// Flipping the sale date start
				if(salebegin.indexOf('-')){
					var finishedtemp = salebegin.split('-');
					salebegin = finishedtemp[0]+'-'+finishedtemp[1]+'-'+finishedtemp[2]
				}

				// Flipping the sale date end
				if(saleend.indexOf('-')){
					var finishedtemp = saleend.split('-');
					saleend = finishedtemp[0]+'-'+finishedtemp[1]+'-'+finishedtemp[2]
				}	
			}

		  	var data = {
				'action': 'medwesthealthpoints_save_action_default',
				'security': '<?php echo wp_create_nonce( "medwesthealthpoints_save_default_action_callback" ); ?>',
				'saleprice':salePrice,
				'regularprice':regularPrice,
				'stock':stock,
				'length':length,
				'width':width,
				'height':height,
				'weight':weight,
				'sku':sku,
				'virtual':virtual,
				'download':download,
				'salebegin':salebegin,
				'saleend':saleend,
				'purchasenote':purchasenote,
				'productcategory':productcategory,
				'reviews':reviews,
				'upsells':upsellString,
				'crosssells':crosssellString
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);


			    	$('#medwesthealthpoints-woo-set-success-div').html("<span id='medwesthpplugin-add-book-success-span'><?php echo $trans1 ?></span><br/><br/>&nbsp;<?php echo $trans2 ?><div id='medwesthpplugin-addtemplate-success-thanks'><?php echo $trans6 ?>&nbsp;<a href='http://medwesthpplugin.com/index.php/extensions/'><?php echo $trans7 ?></a><br/><br/>&nbsp;<?php echo $trans8 ?> &nbsp;<a id='medwesthpplugin-addbook-success-review-link' href='https://wordpress.org/support/plugin/medwesthpplugin/reviews/?filter=5'><?php echo $trans9 ?></a><img id='medwesthpplugin-smile-icon-1' src='http://evansclienttest.com/wp-content/plugins/medwesthpplugin/assets/img/icons/smile.png'></div>");

			    	$('.medwesthpplugin-spinner').animate({'opacity':'0'});

			    	$('html, body').animate({
				        scrollTop: $("#medwesthealthpoints-woo-set-success-div").offset().top-100
				    }, 1000);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function medwesthealthpoints_save_default_action_callback(){
	global $wpdb;
	check_ajax_referer( 'medwesthealthpoints_save_default_action_callback', 'security' );
	$saleprice = filter_var($_POST['saleprice'],FILTER_SANITIZE_STRING);
	$regularprice = filter_var($_POST['regularprice'],FILTER_SANITIZE_STRING);
	$stock = filter_var($_POST['stock'],FILTER_SANITIZE_STRING);
	$length = filter_var($_POST['length'],FILTER_SANITIZE_STRING);
	$width = filter_var($_POST['width'],FILTER_SANITIZE_STRING);
	$height = filter_var($_POST['height'],FILTER_SANITIZE_STRING);
	$weight = filter_var($_POST['weight'],FILTER_SANITIZE_STRING);
	$sku = filter_var($_POST['sku'],FILTER_SANITIZE_STRING);
	$virtual = filter_var($_POST['virtual'],FILTER_SANITIZE_STRING);
	$download = filter_var($_POST['download'],FILTER_SANITIZE_STRING);
	$woofile = filter_var($_POST['woofile'],FILTER_SANITIZE_STRING);
	$salebegin = filter_var($_POST['salebegin'],FILTER_SANITIZE_STRING);
	$saleend = filter_var($_POST['saleend'],FILTER_SANITIZE_STRING);
	$purchasenote = filter_var($_POST['purchasenote'],FILTER_SANITIZE_STRING);
	$productcategory = filter_var($_POST['productcategory'],FILTER_SANITIZE_STRING);
	$reviews = filter_var($_POST['reviews'],FILTER_SANITIZE_STRING);
	$crosssells = filter_var($_POST['crosssells'],FILTER_SANITIZE_STRING);
	$upsells = filter_var($_POST['upsells'],FILTER_SANITIZE_STRING);


	$data = array(
		'defaultsaleprice' => $saleprice,
		'defaultprice' => $regularprice,
		'defaultstock' => $stock,
		'defaultlength' => $length,
		'defaultwidth' => $width,
		'defaultheight' => $height,
		'defaultweight' => $weight,
		'defaultsku' => $sku,
		'defaultvirtual' => $virtual,
		'defaultdownload' => $download,
		'defaultsalebegin' => $salebegin,
		'defaultsaleend' => $saleend,
		'defaultnote' => $purchasenote,
		'defaultcategory' => $productcategory,
		'defaultreviews' => $reviews,
		'defaultcrosssell' => $crosssells,
		'defaultupsell' => $upsells
	);

 	$table = $wpdb->prefix."medwesthealthpoints_jre_toplevel_options";
   	$format = array( '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'); 
    $where = array( 'ID' => 1 );
    $where_format = array( '%d' );
    $result = $wpdb->update( $table, $data, $where, $format, $where_format );

	echo $result;



	wp_die();
}


function medwesthealthpoints_upcross_pop_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

		  	var data = {
				'action': 'medwesthealthpoints_upcross_pop_action',
				'security': '<?php echo wp_create_nonce( "medwesthealthpoints_upcross_pop_action_callback" ); ?>',
			};

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = response.split('–sep-seperator-sep–');
			    	var upsellstitles = '';
			    	var crosssellstitles = '';


			    	if(response[0] != 'null'){
				    	upsellstitles = response[0];
				    	if(upsellstitles.includes(',')){
				    		var upsellArray = upsellstitles.split(',');
				    	} else {
				    		var upsellArray = upsellstitles;
				    	}

				    	$("#select2-upsells").val(upsellArray).trigger('change');
			    	}

			    	if(response[1] != 'null'){
				    	crosssellstitles = response[1];
				    	if(crosssellstitles.includes(',')){
				    		var upsellArray = crosssellstitles.split(',');
				    	} else {
				    		var upsellArray = crosssellstitles;
				    	}

				    	$("#select2-crosssells").val(upsellArray).trigger('change');
			    	}


			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});


	});
	</script>
	<?php
}

// Callback function for creating backups
function medwesthealthpoints_upcross_pop_action_callback(){
	global $wpdb;
	check_ajax_referer( 'medwesthealthpoints_upcross_pop_action_callback', 'security' );
		
	// Get saved settings
    $settings_table = $wpdb->prefix."medwesthealthpoints_jre_toplevel_options";
    $settings = $wpdb->get_row("SELECT * FROM $settings_table");

    echo $settings->defaultupsell.'–sep-seperator-sep–'.$settings->defaultcrosssell;

	wp_die();
}

/*
// For adding a book from the admin dashboard
add_action( 'admin_footer', 'medwesthealthpoints_action_javascript' );
add_action( 'wp_ajax_medwesthealthpoints_action', 'medwesthealthpoints_action_callback' );
add_action( 'wp_ajax_nopriv_medwesthealthpoints_action', 'medwesthealthpoints_action_callback' );


function medwesthealthpoints_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#medwesthpplugin-admin-addbook-button").click(function(event){

		  	var data = {
				'action': 'medwesthealthpoints_action',
				'security': '<?php echo wp_create_nonce( "medwesthealthpoints_action_callback" ); ?>',
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function medwesthealthpoints_action_callback(){
	global $wpdb;
	check_ajax_referer( 'medwesthealthpoints_action_callback', 'security' );
	//$var1 = filter_var($_POST['var'],FILTER_SANITIZE_STRING);
	//$var2 = filter_var($_POST['var'],FILTER_SANITIZE_NUMBER_INT);
	echo 'hi';
	wp_die();
}*/



