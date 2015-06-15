<?php


$parsed_data[$key]['width'] = $value['width'];
$parsed_data[$key]['width_unit'] = $value['width_unit'];
$parsed_data[$key]['label'] = $value['label'];


if($key == 'date'){
	$parsed_data[$key]['value'] = get_the_date();
}
if(($key == 'title')||($key == 'title-1')){	
	$parsed_data[$key]['url'] = get_permalink($the_query->post->ID);
	$parsed_data[$key]['value'] = get_the_title();
}
if($key == 'excerpt'){	
	$parsed_data[$key]['value'] = $the_query->post->post_excerpt;
}
if($key == 'column-slug'){
	$parsed_data[$key]['value'] = $the_query->post->post_name;						
}
if($key == 'column-attachment'){						
	$parsed_data[$key]['value'] = get_the_post_thumbnail($the_query->post->ID,$value['image_size']);
}
if($key == 'author'){
	$parsed_data[$key]['value'] = get_the_author();						
}
if($key == 'column-content'){
	$parsed_data[$key]['value'] = get_the_content();
}
if(($key == 'column-meta')||($key =='column-meta-1')||($key =='column-meta-2')||($key =='column-meta-3')||($key =='column-meta-4')){
	//$parsed_data[$key]['value'] = get_post_meta( $the_query->post->ID , $field , true);
	$field = $value['field'];
	if( $adv_query_options['acf_map_name'] != $field){
		$parsed_data[$key]['value'] = get_post_meta( $the_query->post->ID , $field , true);
	}else{
		$location = get_post_meta( $the_query->post->ID , $field , true);
		$parsed_data[$key]['value'] = $location['address'];
	}
}
if($key == 'categories'){
	if($value['type'] == 'categories' ){
		$type = 'category';
	}
	$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
	$terms = wp_get_post_terms( $the_query->post->ID, $type, $args );
	$my_terms = '';
	foreach ($terms as $key1 => $value1) {
		$parsed_data[$key]['value'] .= '<span>'.$value1->name.'</span>  ';
	}
}
if($key == 'tags'){
		$terms = wp_get_post_tags($the_query->post->ID);
		$my_terms = '';
		foreach ($terms as $key1 => $value1) {
			//var_dump($value1);
			$parsed_data[$key]['value'] .= '<span><a href="#">'.$value1->name.'</a></span>  ';
		}
		//$parsed_data[$key]['value'] = get_tags();
}