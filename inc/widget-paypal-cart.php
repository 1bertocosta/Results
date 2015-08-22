<?php
class R_simple_cart_widget extends WP_Widget {

	private $list_data = array();

	function __construct() {
		parent::__construct(
			'R_simple_cart_widget', // Base ID
			__( 'Results with cart ', 'text_domain' ), // Name
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


		 	 //wp_register_style( 'simple-cart-CSS', plugins_url().'/../css/qunit.css', __FILE__);
 			// wp_enqueue_style('simple-cart-CSS');


			//wp_register_style( 'cart', plugins_url('/../js/cart.min.js', __FILE__) );
			//wp_enqueue_style('cart');
		?>
			
			SIMPLE CART ICO
			<?php global $ACOL; $ACOL -> action_cell = 'CART'; ?>
			<script src="//cdnjs.cloudflare.com/ajax/libs/minicart/3.0.6/minicart.min.js"></script>
			<script>

				var myTemplate = "";

			    paypal.minicart.render({
			    strings: {
			        button: "Caisse",
			        buttonAlt: "Total:",
			        discount: "Reduction:"
			    },
			    //template: myTemplate
			});
			</script>

			



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
		You want some data????
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
function register_R_simple_cart_widget() {
    register_widget( 'R_simple_cart_widget' );
}
add_action( 'widgets_init', 'register_R_simple_cart_widget' );

/* -------------------------------------------------------------------- */