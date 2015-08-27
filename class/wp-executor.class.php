<?php
class wp_executor {
	
	/* ####################################################################### */
	/* Class properties */
	/* ----------------------------------------------------------------------- */
	
	public $execute_data = null;
	/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */
	/* ####################################################################### */
	/* Constructor */
	/* ----------------------------------------------------------------------- */
	public function __construct(){
		// INIT CONSTRUCTOR 
		// :/
		
		//var_dump( dirname(__FILE__) );
		//require_once realpath(dirname(__FILE__)) . '/Spyc.php';
		//$output = Spyc::YAMLLoad( $args['input']['path'] . $args['input']['file'] );
	}
	/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */
	/* ####################################################################### */
	/* core PHP methods */
	/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */
	public function execute($frame, $args){
		
		/* check is frame id direct or flow */
		if(is_array ( $frame )){
			
			$frame = $this -> flow_steps($frame);
		}
		function data_chcekpoint(&$item, $key, $execute_data){
		   
		   if(substr($item, 0, 8) == 'output%%'){
		   		
		   		$item = $execute_data['data'][$execute_data['frame']]['output'][substr($item, 8)];
		   		
		   } 
		   if(substr($item, 0, 6) == 'post%%'){
		   		
		   		$item = $_POST[substr($item, 6)];
		   		
		   } 
		   if(substr($item, 0, 5) == 'get%%'){
		   		
				/* TODO */
		   		
		   }
		   if(substr($item, 0, 5) == 'request%%'){
		   		
				/* TODO */
		   		
		   }
		}
		foreach ($args[$frame]['input'] as $key => $value) {
			
			array_walk_recursive($value, 'data_chcekpoint', array('data' => $this -> execute_data, 'frame' => $frame));
			$last_callback_char = substr($key, -1);
			if((string)(int)$last_callback_char == $last_callback_char) {
				// last char is int [0-9]
				$args[$frame]['output'][$key] = call_user_func_array( substr($key, 0, -1), $value );
			}else{
				// last char is'nt int [0-9]
				$args[$frame]['output'][$key] = call_user_func_array( $key, $value );
			}
			
			$this -> execute_data = $args;
			//call_user_func(array( $UIGEN_API , $_POST['method']) , $_POST['args']);  // calback to classes methods
		
		}
		/* this element should be discuss to depreciated */
		if(is_array ( $args[$frame]['render'] ) ){
			
			print('RENDER ME !!!!');
		}
	}
	private function flow_steps($flow){
		$flow_keys = array_keys( $flow ); 
		$first_key = $flow_keys[0];
		return $flow[$first_key]['frame_name'];
	}
}
