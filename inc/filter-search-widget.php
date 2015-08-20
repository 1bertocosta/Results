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

				//var_dump(json_decode(urldecode($instance['tech_widget_data']), true));
				$filters_schema = json_decode(urldecode($instance['tech_widget_data']), true);

				$FILTER1 = new wp_search_and_filter();
				$FILTER1 -> render_search_filter_form($filters_schema);
				
				
				

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
		
		$init_paths = array(
			'base' => PLUGIN_SANDF_URI,
			'scripts' => 'js/',
			'styles' => 'css/',
			'schemas' => 'js/'
		);	
		$ALPC_SANDF = new wp_alpaca_options($init_paths); 

		$form_args = array(
			'name' => 'SANDF',
			'render' => array('type' => 'wp_widget', 'render_handler' => 'widget-'.$this->number .'_'. $this->id_base.'-__i__' )			
		);	



		$ALPC_SANDF -> add_widget_tech_data_field($instance,$this->get_field_id( 'tech_widget_data' ),$this->get_field_name( 'tech_widget_data' ));
		$ALPC_SANDF -> render_form($form_args);

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 */

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['tech_widget_data'] = ( ! empty( $new_instance['tech_widget_data'] ) ) ? strip_tags( $new_instance['tech_widget_data'] ) : '';
		return $instance;
	}

} 

// register Results widget
function register_R_filter_search_widget() {
    register_widget( 'R_filter_search_widget' );
}
add_action( 'widgets_init', 'register_R_filter_search_widget' );

/* -------------------------------------------------------------------- */