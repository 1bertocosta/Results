<?php
/*
Plugin Name: WP Results
Plugin URI: https://github.com/dadmor/Results
Description: Display wp query on frontend as templated lists
Author: gdurtan
Author URI: https://pl.linkedin.com/pub/grzegorz-durtan/11/b74/296
Version: 0.0.2
License: GPL2
*/

/* Include better manage wp options */
include plugin_dir_path( __FILE__ ).'class/wp-options-manager.class.php';
$GRIDS = new wp_options_manager('grids');
$GRIDS -> register_ajax_methods();

include plugin_dir_path( __FILE__ ).'class/admin-column-frontend.class.php';
$ACOL = new admin_column_frontend();

/* Include class to inject custom templates int wordpress pages */
include plugin_dir_path( __FILE__ ).'class/virtual-template.class.php';

/* Inclide search and filters class */
include plugin_dir_path( __FILE__ ).'class/search-filter.class.php';
include plugin_dir_path( __FILE__ ).'inc/filter-search-widget.php';

/* widget to display loop with sidebars */
include plugin_dir_path( __FILE__ ).'inc/result-widget.php';

include plugin_dir_path( __FILE__ ).'inc/cart-widget.php';

/* ADD CUSTOMIZE CONTROLLS TO THIS THEME */
include plugin_dir_path( __FILE__ ).'inc/customize-controlls.php';

/* Register manu and display block */
function wp_results_menu()
{  
    add_menu_page('Results', 'Results', 'administrator', 'url_wp_results', 'wp_results_callback', 'dashicons-align-left');
}
add_action('admin_menu', 'wp_results_menu');

function wp_results_callback(){
	
	wp_register_style( 'skeleton-style', plugins_url('/css/skeleton-grid-creator.css', __FILE__) );
	wp_enqueue_style('skeleton-style');

	wp_register_style( 'grid-creator-style', plugins_url('/css/grid-creator.css', __FILE__) );
	wp_enqueue_style('grid-creator-style');

	wp_register_script( 'grid-creator-script', plugins_url('/js/grid-creator.js', __FILE__) );
	wp_enqueue_script('grid-creator-script');

	?>
	<div class="wrap">
		<h2>WP Results plugin</h2>
		<?php
		include 'inc/grid.php';
		?>
	</div>
	<?php
}

function wp_result_theme_scripts() {
	//echo 'skeleton-style';
	wp_register_style( 'skeleton-style', plugins_url('/css/skeleton-only-grid.css', __FILE__) );
	wp_enqueue_style('skeleton-style');
	
	//echo 'template parts styles';
	wp_register_style( 'fields-pack-style', plugins_url('/css/list-style.css', __FILE__) );
	wp_enqueue_style('fields-pack-style');
}

add_action( 'wp_enqueue_scripts', 'wp_result_theme_scripts' );

/* dynamic template helpers functions */
function get_skeleton_class($tpl){
	if($tpl['results_loop']){
		if(($tpl['left_bar'])&&($tpl['results_loop'])){
			$side_class = 'four';
			$loop_class = 'eight';	
		}
		if(($tpl['right_bar'])&&($tpl['results_loop'])){
			$side_class = 'four';
			$loop_class = 'eight';	
		}
		if(($tpl['left_bar'])&&($tpl['right_bar'])){
			$side_class = 'three';
			$loop_class = 'six';	
		}
	}else{
		if(($tpl['left_bar'])||($tpl['right_loop'])){
			$side_class = 'twelve';
		}
		if(($tpl['left_bar'])&&($tpl['right_loop'])){
			$side_class = 'six';
		}
	}

	return (object)array('side'=> $side_class, 'loop' => $loop_class);
}

function my_sidebar($id){
	
	//var_dump($id);
	if($id['id']){
		// TODO check it if you change template !!!!
		if ( is_active_sidebar( $id['id'] ) ) {
			dynamic_sidebar($id['name']);
		}
	}else{
		if($id == true){
			echo '&nbsp;';
		}
	}

}

/* ACTIONS */

function search_filter($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    //if ($query->is_search) {
      
		// ignore null metas
		foreach ($_POST['meta_query'] as $key => $value) {
			if(($value['ignore_null'] == 'true')&&($value['value'] == 'null')){
				unset($_POST['meta_query'][$key]);
			}
		}
		foreach ($_POST['tax_query'] as $key => $value) {
			if(($value['ignore_null'] == 'true')&&($value['terms'] == 'null')){
				unset($_POST['meta_query'][$key]);
			}
		}

		

      	if (!empty($_POST['meta_query'])) {
			$query->set('meta_query', $_POST['meta_query'] );
		}

      	$query->set('tax_query', $_POST['tax_query'] );
   // }
  }
}

add_action('pre_get_posts','search_filter');
