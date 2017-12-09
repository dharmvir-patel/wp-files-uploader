<?php
   /*
   Plugin Name: WP Files Uploader
   Plugin URI: http://www.digitalcahoots.com
   Description: Easily upload files to wordpress from any post, page. Easy shortcode to add and no dependencies on jQuery library. It uses dropzone JS to upload the files.
   Version: 0.0.1
   Author: Dharmvir Patel
   Author URI: http://www.digitalcahoots.com/dharmvir/
   License: GPL2
   */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'DV_FILES_UPLOADER_PLUGIN_URL',   plugin_dir_url( __FILE__ ) );		
define( 'DV_FILES_UPLOADER_PLUGIN_VERSION', '0.0.1' );

/*
* Enqueue required scripts
* DropzoneJS and DropzoneCSS
*/

add_action( 'wp_enqueue_scripts', 'dv_files_uploader_scripts' );

function dv_files_uploader_scripts(){
	wp_enqueue_script(
		'dropzonejs',				
		'https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js',				
		 array(),				
		 DV_FILES_UPLOADER_PLUGIN_VERSION			
	);			

	// Load custom dropzone javascript			
	wp_enqueue_script(				
		'customdropzonejs',				
		 DV_FILES_UPLOADER_PLUGIN_URL. '/js/customize_dropzonejs.js',				
		 array( 'dropzonejs' ),				
		 DV_FILES_UPLOADER_PLUGIN_VERSION			
	);
    //localize script for admin ajax url.
	wp_localize_script( 'customdropzonejs', 'dv_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );			
			
	wp_enqueue_style(				
		'dropzonecss',				
		'https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.css',				
		 array(),				
		 DV_FILES_UPLOADER_PLUGIN_VERSION			
	);
}

/*
* Add shortcode to use in pages, posts.
* 
*/

add_shortcode( 'filesuploader', 'dv_files_uploader_shortcode' );

function dv_files_uploader_shortcode( $atts){
	$nonce_files = wp_nonce_field( 'protect_content', 'dv_files_uploader_nonce' );

	return $nonce_files. '<div id="dv-files-uploader" class="dropzone"></div>';

}

add_action( 'wp_ajax_nopriv_dv_files_upload_action', 'dv_files_upload_action_upload' ); //allow on front-end
add_action( 'wp_ajax_dv_files_upload_action', 'dv_files_upload_action_upload' );

/**		
* dv_files_upload_action is the action triggers on file select.
* dv_files_upload_action_upload() handles the AJAX request.
*/
function dv_files_upload_action_upload(){
	//if(!empty($_FILES) && wp_verify_nonce( $_REQUEST['dv_files_uploader_nonce'], 'protect_content' )) {
    if(!empty($_FILES)){
		$uploaded_bits = wp_upload_bits(					
			$_FILES['file']['name'],					
			null, //deprecated					
			file_get_contents( $_FILES['file']['tmp_name'] )				
		);
	}
	die();
}
   
?>