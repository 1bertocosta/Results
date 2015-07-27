<script>
jQuery(document).ready(function($) {

		function render_grid_group(grid_list){
			$('#grid-list').children().remove();
			$.each( grid_list, function( index, value ) {
			  //alert( index + ": " + value );
			  $('#grid-list').append('<div class="grids-list-row">'+value+'<div class="dashicons dashicons-trash"></div></div>');
			});

		}

		$('#grid-list').on('click','#list_options',function(){
			$.post(ajaxurl, {
				action: 'list_group',
				group_name: 'grids',			
				security: '<?php global $GRIDS; echo wp_create_nonce($GRIDS->scripts_prefix); ?>',
			}, function(response) {
				console.log(response);
			});
		});

		$('#grid-list').on('click','.grids-list-row',function(){
			//alert($(this).text());
			$.post(ajaxurl, {
				action: 'get_option',
				name: $(this).text(),			
				security: '<?php global $GRIDS; echo wp_create_nonce($GRIDS->scripts_prefix); ?>',
			}, function(response) {
				console.log('------get-options-------');
				console.log(response);
				window.grid = response['value'];
				render_blocks();
			});
		});


		$('#grid-list').on('click','.grids-list-row .dashicons-trash',function(e){

			e.stopPropagation();
			$.post(ajaxurl, {
				action: 'del_option',
				name: $(this).parent().text(),			
				security: '<?php global $GRIDS; echo wp_create_nonce($GRIDS->scripts_prefix); ?>',
			}, function(response) {
				render_grid_group(response['group']);
			});

		});

		$('.save-btn').click(function(){
			if($('#register-grid-input input').val()==''){
				alert('name your grid now !!!')
				return false;
			}else{
				var value = encodeURIComponent(JSON.stringify(window.grid));
				$.post(ajaxurl, {
					action: 'add_option',
					name: $('#register-grid-input input').val(),	
					value: value,	
					autoload: 'no',	
					encode: 'yes',	
					security: '<?php global $GRIDS; echo wp_create_nonce($GRIDS->scripts_prefix); ?>',
				}, function(response) {
					render_grid_group(response['group']);
				});

			}
			
		});

		

		
});

</script>
Create and register new template page grid.
<div class="container grid-app">

	<div class="row" style="margin-top:20px; margin-bottom:20px">

<!-- 			<div class="two columns">&nbsp;</div> -->
			<div class="nine columns">
				
				<div id="register-grid-input">
						<input type="text" name="grid_title" size="30" value="" spellcheck="true" autocomplete="off" placeholder="name your registered grid">
				</div>
			</div>
			<div class="three columns">
				<div class="save-btn"><div class="button">Save created grid</div></div>
			</div>

	</div>

	<div class="row">	
		
		<div id="grid_controlls" class="two columns">
			<div class="grid-btn"><div data-name="top_header" class="button">Top header</div></div>
			<div class="grid-btn"><div data-name="results_header" class="button">Results header</div></div>
			<div class="grid-btn"><div data-name="left_bar" class="button">Left bar</div></div>
			<div class="grid-btn"><div data-name="results_loop" class="button">Results loop</div></div>
			<div class="grid-btn"><div data-name="right_bar" class="button">Right bar</div></div>
			<div class="grid-btn"><div data-name="bottom_bar" class="button">Bottom bar</div></div>
			<div class="grid-btn"><div data-name="bottom_bar_half" class="button">Bottom bar half</div></div>
			<div class="grid-btn"><div data-name="bottom_bar_third" class="button">Bottom bar third</div></div>
		</div>

		<div id="grid"  class="seven columns u-max-width">
			<article>
			</article>
		</div>

		<div class="three columns">
			<div class="title">Grid list</div>
			<div id="grid-list">
			<?php
				global $GRIDS;

				foreach ($GRIDS->list_group('grids') as $key) {
					echo '<div class="grids-list-row">'.$key.'<div class="dashicons dashicons-trash"></div></div>';
				}
			?>
			</div>
		</div>

	</div>
</div>

<div id="my-content-id" style="display:none;">
	<h2>Link sidebar with selected block</h2>
	<p>This is list of sidebars registered to your usage theme (<?php echo get_current_theme(); ?>)</p>
     <?php
     global $wp_registered_sidebars;
     foreach ($wp_registered_sidebars as $key => $value) {
     ?>
     <div class="grid-btn"><div data-name="<?php echo $value['id']; ?>" class="button"><?php echo $value['name']; ?></div></div>
     <?php } ?>
</div>