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
}