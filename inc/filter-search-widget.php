<?php
class R_filter_search_widget extends WP_Widget {

	private $list_data = array();

	function __construct() {
		parent::__construct(
			'R_filter_search_widget', // Base ID
			__( 'Results filter & search ', 'text_domain' ), // Name
			array( 'description' => __( 'Display wp query on frontend as templated lists', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 */

	public function widget( $args, $instance ) {

		//wp_register_style( 'fields-pack-style', plugins_url('/css/list-style.css', __FILE__) );
		//wp_enqueue_style('fields-pack-style');
	
     	echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		?>
				<!--
				<input type="text" name="meta_query[0][key]" value="first key"/>
				<input type="text" name="meta_query[0][value]" value="first value"/>
				
				second meta

				<input type="text" name="meta_query[1][key]" value="second key"/>
				<input type="text" name="meta_query[1][value]" value="second value"/>
				-->
				<?php


			//echo '<pre>';
			//var_dump($_POST);
			//echo '</pre>';

				$filters_schema = array(
					'0' => array(
						'label' => 'label1',
						'format' => 'select', // select input check
						'type' => 'meta_query',
						'key' => 'budget',
						//'value' => 'valueA_name', // optional to default
						'ignore_null' => true,
						'dictionary' => array('200','300') // optional
						),
					'1' => array(
						'label' => 'label2',
						'format' => 'select', // select check
						'type' => 'tax_query',
						'tax_name' => 'category',						
						'field' => 'term_id',
						),
					'2' => array(
						'label' => 'label3',
						'format' => 'select', // select input check
						'type' => 'meta_query',
						'key' => 'keyB_name',
						'value' => 'valueB_name', // optional to default
						'ignore_null' => true,
						'dictionary' => array('valueB1','valueB2') // optional
						),
					/*'3' => array(
						'label' => 'label4',
						'format' => 'text', // select check
						'type' => 'search',

						),*/

					);


				$FILTER1 = new R_search_filter();
				$FILTER1 -> render_search_filter_form($filters_schema);

				?>
		<?php

		


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
/*     	        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
     	        $template = ! empty( $instance['template'] ) ? $instance['template'] : __( 'Template', 'text_domain' );
     	        $post_type = ! empty( $instance['post_type'] ) ? $instance['post_type'] : __( 'post', 'text_domain' );
     	        $adv_query_options = ! empty( $instance['adv_query_options'] ) ? $instance['adv_query_options'] : '{
"query_args": {
		"posts_per_page":"-1"
	},
	"acf_map_name":"location"
}';*/
		?>
		
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 */
	public function update( $new_instance, $old_instance ) {
/*		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? strip_tags( $new_instance['post_type'] ) : '';
		$instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
		$instance['adv_query_options'] = ( ! empty( $new_instance['adv_query_options'] ) ) ? strip_tags( $new_instance['adv_query_options'] ) : '';
		return $instance;*/
	}

} 

// register Results widget
function register_R_filter_search_widget() {
    register_widget( 'R_filter_search_widget' );
}
add_action( 'widgets_init', 'register_R_filter_search_widget' );

/* -------------------------------------------------------------------- */