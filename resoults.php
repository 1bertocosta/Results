<?php
/*
Plugin Name: Resoults
Plugin URI: https://jeszcze.nic.pl
Description: Display wp query on frontend as templated lists
Author: gdurtan
Author URI: grzegorz.durtan.pl
Version: 0.0.1
License: GPL2
*/


class R_Lists_widget extends WP_Widget {

	private $list_data = array();

	function __construct() {
		parent::__construct(
			'R_Lists_widget', // Base ID
			__( 'Post lists ', 'text_domain' ), // Name
			array( 'description' => __( 'Resoults list', 'text_domain' ), ) // Args
		);
	}

	private function set_dimention($width,$unit){
			$style = 'width: '.$width.''.$unit.'; ';
			return $style;
	}

	private function array_equal($a, $b) {
    	return (is_array($a) && is_array($b) && array_diff($a, $b) === array_diff($b, $a));
	}

	private function list_controller( $the_query, $post_type, $adv_query_options){	

			$prepare_resoult = array();
				
			$std_schema_data = get_option( 'cpac_options_'.$instance['post_type']);
			if($std_schema_data == false){
				require( plugin_dir_path( __FILE__ ) . '/std-data.php' );
			};
			
			while ( $the_query->have_posts() ) {
			
				$the_query->the_post();

				$parsed_data = array();
				foreach ($std_schema_data as $key => $value) {
					require( plugin_dir_path( __FILE__ ) . '/inc/data-parser.php' );
				}

				$prepare_resoult[$the_query->post->ID] = $parsed_data;
				$prepare_resoult[$the_query->post->ID]['id'] = $the_query->post->ID;
			}
			$this -> list_data = $prepare_resoult;
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */

	public function widget( $args, $instance ) {

		wp_register_style( 'fields-pack-style', plugins_url('/list_style.css', __FILE__) );
		wp_enqueue_style('fields-pack-style');
	
     	echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$adv_query_options = json_decode( $instance['adv_query_options'], true );

		$adv_query_options['query_args']['post_type'] = $instance['post_type'];

		global $wp_query;

		include plugin_dir_path( __FILE__ ).'inc/query_support.class.php';

		$Q = new uigen_query();

		$Q -> run($adv_query_options['query_args'],true);
		
		/* check queries difference */
/*		$diff = array_diff($adv_query_options['query_args'] ,$wp_query->query_vars );
		if (empty($diff)) {
			echo 'no differences in queryies';
		}else{
			echo 'i have differences in queries';
		}*/
		
		//$wp_query = new WP_Query( $adv_query_options['query_args'] );
		
		$this -> list_controller( $Q->last_query, $instance['post_type'] , $adv_query_options);

		
			
		
/*		echo '<pre style="font-size:11px">';
		var_dump($this->list_data);
		echo '</pre>';*/

		/* TEMPLATE */
		require( plugin_dir_path( __FILE__ ) . '/tpl/'.$instance['template'] );
	
		/* Restore original Post Data */
		wp_reset_postdata();

		// end Widget Body
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
     	        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
     	        $template = ! empty( $instance['template'] ) ? $instance['template'] : __( 'Template', 'text_domain' );
     	        $post_type = ! empty( $instance['post_type'] ) ? $instance['post_type'] : __( 'post', 'text_domain' );
     	        $adv_query_options = ! empty( $instance['adv_query_options'] ) ? $instance['adv_query_options'] : '{
"query_args": {
		"posts_per_page":"-1"
	},
	"acf_map_name":"location",
}';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post type' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>" type="text" value="<?php echo esc_attr( $post_type ); ?>">
		</p>
		<p>
		<select class='widefat' id="<?php echo $this->get_field_id('template'); ?>"
                name="<?php echo $this->get_field_name('template'); ?>" type="text">
          <option value='list-main-page-1.php'<?php echo ($template=='list-main-page-1.php')?'selected':''; ?>>
            Main page list 1 
          </option>
          <option value='list-table-1.php'<?php echo ($template=='list-table-1.php')?'selected':''; ?>>
            Table 1
          </option> 
          <option value='Boston'<?php echo ($template=='Boston')?'selected':''; ?>>
            Template 3 (not yet)
          </option> 
        </select>      	
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'adv_query_options' ); ?>"><?php _e( 'Adv query options:' ); ?></label> 
		<textarea class="widefat" style="height:150px; font-size:11px" id="<?php echo $this->get_field_id( 'adv_query_options' ); ?>" name="<?php echo $this->get_field_name( 'adv_query_options' ); ?>" type="text"><?php echo esc_attr( $adv_query_options ); ?></textarea>
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? strip_tags( $new_instance['post_type'] ) : '';
		$instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
		$instance['adv_query_options'] = ( ! empty( $new_instance['adv_query_options'] ) ) ? strip_tags( $new_instance['adv_query_options'] ) : '';
		return $instance;
	}

} // class Markers_MAP


// register Markers_MAP widget
function register_R_Lists_widget() {
    register_widget( 'R_Lists_widget' );
}
add_action( 'widgets_init', 'register_R_Lists_widget' );