<?php
/* template: List Table */

?>
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" class="wp_list_row <?php global $ACOL; echo ( $ACOL -> rows_color_counter++%2==1)?"color_row":NULL; ?>">
		<?php 
			/* meta_name -> label */
			$mappedMetaArray= array(
				//'budget'=>array('label'=>'Budget', 'is_array' => false),
				'location' => array('label'=>'Location', 'is_array' => true ),
				'budget' => array('label'=>'Price', 'cart_field' => 'amount')

				);

			$title = '';

			foreach ($ACOL -> data_schema as $key => $value) { 
			$data = $ACOL->get_value($key,$value); 
			?>
			
			<div class="wp_list_header_cell" style="">
				
				<?php if($data['url']){?><a href="<?php echo $data['url']; ?>"><?php } ?>
					
					<?php if($key == 'title'){
						$title = $data['value'];
					} ?>

					<?php echo $data['value'] ?>
				
				<?php if($data['url']){?></a><?php } ?>

			</div>
		
		<?php } ?>

		<div class="wp_list_header_cell">

			<?php
			global $post;
			$counter = 0;
			foreach ($mappedMetaArray as $key => $value) {

			 if($value['is_array']==true){ 
	    		$output = get_post_meta($post->ID,$key,true); 
	    		$output = $output[key($output)];
	    	 }else{
	    	 	$output = get_post_meta($post->ID,$key,true); 
	    	 } 

				if($value['cart_field']== null){
					//$output = $value['array'];
					//$output = 'japioerdole';
					?>	
					<input type="hidden" name="on<?php echo $counter; ?>" value="<?php echo $value['label']; ?>" />
	            	<input type="hidden" name="os<?php echo $counter; ?>" value="<?php echo $output; ?>"/>
	            	
					<?php
					$counter++;

				}else{

					

						?><input type="hidden" name="<?php echo $value['cart_field'];?>" value="<?php echo get_post_meta($post->ID,$key,true);?>"><?php

					
				}
			}
            
            ?>
			<input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="add" value="1">
            <input type="hidden" name="business" value="example@minicartjs.com">
            <input type="hidden" name="item_name" value="<?php echo $title; ?>">
            <!-- <input type="hidden" name="amount" value="2.00"> -->
            <!-- <input type="hidden" name="discount_amount" value="2.00"> -->
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="return" value="http://www.minicartjs.com/?success">
            <input type="hidden" name="cancel_return" value="http://www.minicartjs.com/?cancel">
            <input type="submit" name="submit" value="Add to cart" class="button">
        </div>
 </form>
