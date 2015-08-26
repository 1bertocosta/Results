<?php
/* METABOX start ------------------------------------ */
function WP_Results_add_meta_box() {
	/* only editors or administrator can display forms */

	if( current_user_can('edit_others_pages') ) {
		$title_box = __( 'WP Results FORM', 'WP_Results' );
		/* display ACF frontend metabox */
		add_meta_box(
			'myplugin_sectionid',
			$title_box,
			'WP_Results_forms_meta_box_callback',
			$screen,
			'side'
		);
	}
}
add_action( 'add_meta_boxes', 'WP_Results_add_meta_box');

function WP_Results_forms_meta_box_callback( $post ) {

	if( $post->post_type == 'page' ){

		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'myplugin_save_meta_box_data', 'myplugin_meta_box_nonce' );
		
		$init_paths = array(
			'base' => PLUGIN_SANDF_URI,
			'scripts' => 'js/',
			'styles' => 'css/',
			'schemas' => 'js/'
		);	

		global $ALPC_FRM_RULEZ;
		$ALPC_FRM_RULEZ = new wp_alpaca_options($init_paths); 

		$form_args = array(
			'name' => 'FRM_RULEZ',
			'render' => array( 'type' => 'wp_metabox' ),
			'save' => array( 'save_method' => 'wp_postmeta' ),
			'run' => 'init_post_meta_methods'			
		);	
		$output = $ALPC_FRM_RULEZ -> render_form( $form_args );
		echo $output;
	}
}
function save_alpaca_meta( $post_id, $post ) {

	$name = 'FRM_RULEZ';
	$output = add_post_meta( $post_id, '_alpaca-data-' . $name, $_POST["alpaca-data-".$name], true );
	
	if( $output == false ){
		update_post_meta( $post_id, '_alpaca-data-' . $name, $_POST["alpaca-data-".$name] ); 
	}

}
add_action( 'save_post', 'save_alpaca_meta', 10, 3 );
/* ---------------------------------------------------- */

function WP_RESULTS_forms_Rulez(){
/*	'form1': {	
	target_type:page [page, post, post_type, users]
	target_id: 44
	target_name: post / if type is posttype
	},*/
}



function display_in_post() {
    
    if(is_page()){
		add_filter( 'the_content', 'my_the_content_filter', 20 );
	}

	function my_the_content_filter( $content ) {

		global $post;
		$name = 'FRM_RULEZ';	
		$name = json_decode( urldecode( get_post_meta( $post->ID, '_alpaca-data-' . $name,  true )), true);

		$name = $name['form_name'];

		$init_paths = array(
			'base' => PLUGIN_SANDF_URI,
			'scripts' => 'js/',
			'styles' => 'css/',
			'schemas' => 'js/'
		);	

		global $ALPC_FRM_RULEZ;
		$ALPC_FRM_RULEZ = new wp_alpaca_options($init_paths); 

		$form_args = array(
			'name' => $name,
			'render' => array( 'type' => 'wp_metabox' ),
			'schema' => array(
				'method' => 'rest', 
				'url' => get_bloginfo('home').'/wp-result/options-group/forms/'.$name.'/'
			),
			'options' => array(
				'method' => 'rest', 
				'url' => get_bloginfo('home').'/wp-result/options-group/forms/'.$name.'/'
			),				
			'save' => array('save_method' => 'wp_postmeta' ),
			'run' => 'init_post_meta_methods'			
		);	
		$output = $ALPC_FRM_RULEZ -> render_form($form_args);

	    // Add image to the beginning of each page
	    $content = $content.$output;

	    // Returns the content.
	    return $content;
	}
}
add_action( 'wp', 'display_in_post' );

