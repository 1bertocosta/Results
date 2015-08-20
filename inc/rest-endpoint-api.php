<?php
/* ENDPOINTS */ 

/* Return json to alpaca */
function alpaca_api_type_endpoint() {
 
    add_rewrite_tag( '%alpaca_api_type%', '([^&]+)' );
    add_rewrite_rule( 'alpaca/([^&]+)/?', 'index.php?alpaca_api_type=$matches[1]', 'top' );
 
}
add_action( 'init', 'alpaca_api_type_endpoint' );

function alpaca_api_type_endpoint_data() {

    global $wp_query;
    if($wp_query->get( 'alpaca_api_type' ) == ''){
      return false;
    }

    $endpoint = explode("/",  $wp_query->get( 'alpaca_api_type' ));
    
    if($endpoint[0]=='post_metas'){
    	
    	foreach (get_post_custom_keys() as $key => $value) {
    		if($value[0]!='_'){
				$output[$key] =  array('text'=>$value, 'value'=>$value);
    		}
    	}
    }
    if($endpoint[0]=='taxonomies'){
    	$taxonomies = get_taxonomies(); 
      $counter = 0;
  		foreach ( $taxonomies as $key => $value ) {
  		    $output[ $counter ] = array('text'=>$value, 'value'=>$value);
          $counter ++;
  		}
    }
 
    wp_send_json( $output );
 
}
add_action( 'template_redirect', 'alpaca_api_type_endpoint_data' );
?>