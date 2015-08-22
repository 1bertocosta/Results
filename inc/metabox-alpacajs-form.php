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
	echo 'Form box - add alpaca here';

		$init_paths = array(
			'base' => PLUGIN_SANDF_URI,
			'scripts' => 'js/',
			'styles' => 'css/',
			'schemas' => 'js/'
		);	
		$ALPC_FRM_RULEZ = new wp_alpaca_options($init_paths); 

		$form_args = array(
			'name' => 'SANDF',
			'render' => array('type' => 'post_meta' ),
			'run' => 'init_post_meta_methods'			
		);	
		$ALPC_FRM_RULEZ -> render_form($form_args);
}
/* ---------------------------------------------------- */

function WP_RESULTS_forms_Rulez(){
/*	'form1': {	
	target_type:page [page, post, post_type, users]
	target_id: 44
	target_name: post / if type is posttype
	},*/
}