<?php
/* ENDPOINTS */ 

/* Return json to alpaca */
function alpaca_api_type_endpoint() {
 
    add_rewrite_tag( '%wpresults_api_type%', '([^&]+)' );
    add_rewrite_rule( 'wp-result/([^&]+)/?', 'index.php?wpresults_api_type=$matches[1]', 'top' );
 
}
add_action( 'init', 'alpaca_api_type_endpoint' );

function alpaca_api_type_endpoint_data() {

    global $wp_query;
    if($wp_query->get( 'wpresults_api_type' ) == ''){
      return false;
    }

    $endpoint = explode("/",  $wp_query->get( 'wpresults_api_type' ));
    
    if($endpoint[0]=='post-metas'){
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

    if($endpoint[0]=='options-group'){
      $group = $endpoint[1];
      $option = $endpoint[2];
      global $R_OPTIONS;
      if($endpoint[2] == ''){
        $options_list = $R_OPTIONS->list_group( $group );
        foreach ($options_list as $key => $value) {
          $output[$key] =  array('text'=>$value, 'value'=>$value);
        }
      }else{
        $options = $R_OPTIONS->list_group( $group );
        /* check is option in group */
        foreach ($options as $key => $value) {
          if($option == $value){            
            $output = $R_OPTIONS->get_option($option);
          }
        }
      }
    }
 
    wp_send_json( $output );
 
}
add_action( 'template_redirect', 'alpaca_api_type_endpoint_data' );
?>