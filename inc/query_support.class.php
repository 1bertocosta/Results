<?php
class uigen_query {
	
	/* ####################################################################### */
	/* Class properties */
	/* ----------------------------------------------------------------------- */
	
	public $resoult_array = array();
	public $last_query = array();
	

	/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */

	/* ####################################################################### */
	/* Constructor */
	/* ----------------------------------------------------------------------- */
	public function __construct(){
		//global $wp_query;
		//$this->last_query = $wp_query;
		//var_dump('last_query',$wp_query);
	}
	/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */
	
	/* Scripts list --------------------------------------------- */
	/* queries types
		['important': run and save as new ]
		['diff': check on list and run is unique as new ]
		['query_id': run as selected on list]
	*/

	public function run( $args = false, $diff = false, $query_id = false ){

		global $wp_query;
		
		if($args == false){
			$args = array();
		}

		$wp_query = new WP_Query( $args );
		$this->last_query = $wp_query;
		return $wp_query;

	}
	public function get_defined_queries(){

		//return get_option( 'wp_exe_script_list' );
	}
	public function decode_url( $get_url ){

		//return get_option( 'wp_exe_script_list' );
	}
	public function encode_url( $get_url ){

		//return get_option( 'wp_exe_script_list' );
	}
	public function diff_queries( $args ){

		//return get_option( 'wp_exe_script_list' );
	}		
}