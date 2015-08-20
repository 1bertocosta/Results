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

define("PLUGIN_SANDF_DIR", dirname(__FILE__));
define("PLUGIN_SANDF_URI", plugin_dir_url( __FILE__ ));

/* Include better manage wp options */
include plugin_dir_path( __FILE__ ).'class/wp-options-manager.class.php';
$GRIDS = new wp_options_manager('grids');
$GRIDS -> register_ajax_methods();

include plugin_dir_path( __FILE__ ).'class/admin-column-frontend.class.php';
$ACOL = new admin_column_frontend();

/* Include class to inject custom templates int wordpress pages */
include plugin_dir_path( __FILE__ ).'class/virtual-template.class.php';

/* Inclide search and filters class - remove it on another plugin */
include plugin_dir_path( __FILE__ ).'class/wp-alpaca-options.class.php';
include plugin_dir_path( __FILE__ ).'class/wp-search-and-filter.class.php';
include plugin_dir_path( __FILE__ ).'inc/filter-search-widget.php';

/* Inclide search and filters class */


/* widget to display loop with sidebars */
/* result widget remove admin bar ??? */
//include plugin_dir_path( __FILE__ ).'inc/result-widget.php';

include plugin_dir_path( __FILE__ ).'inc/cart-widget.php';

/* ADD CUSTOMIZE CONTROLLS TO THIS THEME */
include plugin_dir_path( __FILE__ ).'inc/customize-controlls.php';

/* ADD ENDPOINT REST API */
include plugin_dir_path( __FILE__ ).'inc/rest-endpoint-api.php';

/* Register manu and display block */
function wp_results_menu()
{  
	add_menu_page('Results', 'Results', 'administrator', 'url_wp_results', 'wp_results_callback');
	add_submenu_page('url_wp_results', 'Results GRID', 'Results GRID', 'administrator', 'url_wp_results_grid', 'add_grid_callback');
	add_submenu_page('url_wp_results', 'Results TPL parts', 'Results TPL parts', 'administrator', 'url_wp_results_parts', 'add_parts_callback');
}



add_action('admin_menu', 'wp_results_menu');



function wp_results_callback() {

	echo '<div class="wrap">';
		echo '<h2>WP Results plugin</h2>';
		echo '<div style="border-top:1px solid #666; margin-bottom:20px;">OVERVIEW</div>';
		echo '<div style="float:left; width:30%; margin-right:3%"><h3>Lite Page builder</h3>';
		echo '<img style="width:100%; height:auto" src="'.plugins_url('/github-assets/overview-grid.png', __FILE__) .'">';
		echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
		echo '</div>';
		echo '<div style="float:left; width:30%; margin-right:3%"><h3>Display composer</h3>';
		echo '<img style="width:100%; height:auto" src="'.plugins_url('/github-assets/overview-composer.png', __FILE__) .'">';
		echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>';
		echo '</div>';
		echo '<div style="float:left; width:30%; margin-right:3%"><h3>Search and filter</h3>';
		echo '<img style="width:100%; height:auto" src="'.plugins_url('/github-assets/overview-filter.png', __FILE__) .'">';
		echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
		echo '</div>';
	echo '</div>';
	echo '<div class="wrap">';
		echo '<div style="float:left; width:30%; margin-right:3%"><h3>Add cart (PAYPAL)</h3>';
		echo '<img style="width:100%; height:auto" src="'.plugins_url('/github-assets/overview-pay.png', __FILE__) .'">';
		echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
		echo '</div>';
		echo '<div style="float:left; width:30%; margin-right:3%"><h3>Loop posts as widget</h3>';
		echo '<img style="width:100%; height:auto" src="'.plugins_url('/github-assets/overview-list.png', __FILE__) .'">';
		echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
		echo '</div>';
		echo '<div style="float:left; width:30%; margin-right:3%"><h3>Integration with admin columns</h3>';
		echo '<img style="width:100%; height:auto" src="'.plugins_url('/github-assets/overview-columns.png', __FILE__) .'">';
		echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
		echo '</div>';
	echo '</div>';

}

function add_grid_callback(){
	
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

function add_parts_callback() {

	echo '<div class="wrap">';
		echo '<h2>WP Results plugin</h2>';
		echo '<div style="border-top:1px solid #666; margin-bottom:20px;">Template parts</div>';
		
		

		echo '<div style="float:left; width:30%; margin-right:3%">';
		echo '<h3>Dynamic table (WP Results)</h3>';
		echo '<img style="width:100%; height:auto" src="'.plugins_url('/github-assets/tpl-part-table.png', __FILE__) .'">';
		echo '<p><b>Description:</b></p>';
		echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>';
		echo '<p><b>Options:</b></p>';
		echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>';
		echo '</div>';
		
		

		echo '<h3>Dynamic table (Admin columns)</h3>';
		echo '<h3>Dynamic table in CART (Admin columns)</h3>';
	echo '</div>';
	
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

