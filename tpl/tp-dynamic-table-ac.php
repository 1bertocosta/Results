<?php
/* template: List Table */
?>


<div class="wp_list_row <?php global $ACOL; echo ( $ACOL -> rows_color_counter++%2==1)?"color_row":NULL; ?>">
		
		<?php 
			foreach ($ACOL -> data_schema as $key => $value) { 
			$data = $ACOL->get_value($key,$value); 
			?>
			
			<div class="wp_list_header_cell" style="">
				
				<?php if(@$data['url']){?><a href="<?php echo @$data['url']; ?>"><?php } ?>
					
					<?php echo $data['value'] ?>
				
				<?php if(@$data['url']){?></a><?php } ?>

			</div>
		
		<?php } ?>
		
</div>	

