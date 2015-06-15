<?php
/* template: List Main Page */

?>

	
	<ul>
	<!-- List body -->
	<?php foreach ($this->list_data as $key => $list_row) { ?>
		
		<li class="services-block">
			
			<div class="list-widget-title">
				<a href="<?php echo $list_row['title']['url']; ?>">
					<?php echo $list_row['title']['value'];?>
				</a>
			</div>
			<div class="list-text-widget">
				<?php echo $list_row['excerpt']['value']; ?>

				
			</div>
			<a class="read-more" title="Kontakt" href="<?php echo $list_row['title']['url']; ?>">
					<?php _e( 'Czytaj więcej', 'text_domain' ); ?>
				</a>
				<br style="clear:both"/>
				
	
			
		</li>

	<?php } ?>
	</ul>



<!-- <div class="main_wp_list">
	
	<ul>
	List body
	<?php foreach ($this->list_data as $key => $list_row) { ?>
		
		<li class="main_wp_list_row">
			
			<h3 class="widget-title"><span><?php echo $list_row['title']['value']; ?></span></h3>
			<div class="entry-content clearfix">
				<?php echo $list_row['column-content']['value']; ?>
			</div>
			
		</li>

	<?php } ?>
	</ul>

</div> -->