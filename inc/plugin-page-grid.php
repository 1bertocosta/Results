<div class="container subtitle">Create and register new template page grid.</div>
<div class="container grid-app">
	<!-- top bar with input title and save button -->
	<div class="row" style="margin-top:20px; margin-bottom:20px">
			<div class="nine columns">
				<div id="register-grid-input">
						<input type="text" name="grid_title" size="30" value="" spellcheck="true" autocomplete="off" placeholder="name your registered grid">
				</div>
			</div>
			<div class="three columns">
				<div class="save-btn"><div class="button">Save created grid</div></div>
			</div>
	</div>
	<!-- body container with main grid creator -->
	<div class="row">	
		<!-- left column -->
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
		<!-- middle column -->
		<div id="grid"  class="seven columns u-max-width">
			<article>
			</article>
		</div>
		<!-- right column -->
		<div class="three columns">
			<div class="title">Grid list</div>
			<div id="grid-list">
			<?php
				global $R_OPTIONS;
				foreach ($R_OPTIONS->list_group('grids') as $key) {
					echo '<div class="grids-list-row">'.$key.'<div class="dashicons dashicons-trash"></div></div>';
				}
/*				echo '<pre style="font-size:11px">';
				var_dump( $R_OPTIONS->get_all_of_group('grids'));
				echo '</pre>';*/
			?>
			</div>
		</div>
	</div>
	<!-- end main containers -->
</div>

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
			security: '<?php echo wp_create_nonce($_SERVER["SERVER_NAME"]); ?>',
		}, function(response) {
			console.log(response);
		});
	});

	$('#grid-list').on('click','.grids-list-row',function(){
		$('#sidebar-list-body').remove();
		$('#grid article').fadeOut();
		var _text = $(this).text();
		$('#register-grid-input input').val( '' );
		$.post(ajaxurl, {
			action: 'get_option',
			name: $(this).text(),			
			security: '<?php echo wp_create_nonce($_SERVER["SERVER_NAME"]); ?>',
		}, function(response) {
			console.log('------get-options-------');
			console.log(response);
			
			GRID_CREATOR.grid = response['value'];
			GRID_CREATOR.reset_schema();
			GRID_CREATOR.render_blocks();

			$('#register-grid-input input').val( _text );
			$('#grid article').fadeIn();
		
		});
	});

	$('#grid-list').on('click','.grids-list-row .dashicons-trash',function(e){
		$('#sidebar-list-body').remove();
		$('#grid article').fadeOut();
		e.stopPropagation();
		$.post(ajaxurl, {
			action: 'del_option',
			group_name: 'grids',
			name: $(this).parent().text(),			
			security: '<?php echo wp_create_nonce($_SERVER["SERVER_NAME"]); ?>',
		}, function(response) {
			
			render_grid_group(response['group']);
			GRID_CREATOR.reset_schema();
			GRID_CREATOR.reset_grid();
			GRID_CREATOR.render_blocks();

			$('#grid article').fadeIn();
		});

	});

	$('.save-btn').click(function(){
		if($('#register-grid-input input').val()==''){
			
			alert('name your grid now !!!')
			return false;

		}else{
			var value = encodeURIComponent(JSON.stringify( GRID_CREATOR.grid ));
			$.post(ajaxurl, {
				action: 'add_option',
				name: $('#register-grid-input input').val(),	
				value: value,
				group_name: 'grids',	
				autoload: 'no',	
				encode: 'yes',	
				security: '<?php echo wp_create_nonce($_SERVER["SERVER_NAME"]); ?>',
			}, function(response) {
				render_grid_group(response['group']);
			});
		}
	});
});
</script>

<script id="sidebars-list" type="text/x-jquery-tmpl">
	<div id="sidebar-list-body">
	<h2>Link sidebar with selected block</h2>
	<p>This is list of sidebars registered to your usage theme (<?php echo wp_get_theme() -> get( 'Name' ); ?>)</p>
     <?php
     global $wp_registered_sidebars;
     foreach ($wp_registered_sidebars as $key => $value) {
     ?>
     <div class="grid-btn"><div data-name="<?php echo $value['id']; ?>" class="button"><?php echo $value['name']; ?></div></div>
     <?php } ?>
     </div>
</script>

<script id="one-column-with-link" type="text/x-jquery-tmpl">
	<section data-name="${index}" class="grid-row ">
		<div class="twelve column blue">
			${index}
			<div class="dashicons dashicons-admin-links"></div>
		</div>
	</section>
</script>

<script id="one-column" type="text/x-jquery-tmpl">
	<section data-name="${index}" class="grid-row ">
		<div class="twelve column blue">
			${index}
		</div>
	</section>
</script>

<script id="two-columns" type="text/x-jquery-tmpl">
	<section data-name="container" class="grid-row ">
		<div data-name="${index}-one" class="one-half column blue">${index}<div class="dashicons dashicons-admin-links"></div></div>
		<div data-name="${index}-two" class="one-half column blue">${index}<div class="dashicons dashicons-admin-links"></div></div>
	</section>
</script>

<script id="three-columns" type="text/x-jquery-tmpl">
	<section data-name="container" class="grid-row ">
		<div data-name="${index}-one" class="one-third column blue">${index}<div class="dashicons dashicons-admin-links"></div></div>
		<div data-name="${index}-two" class="one-third column blue">${index}<div class="dashicons dashicons-admin-links"></div></div>
		<div data-name="${index}-three" class="one-third column blue">${index}<div class="dashicons dashicons-admin-links"></div></div>
	</section>
</script>

<script id="loop-tpl" type="text/x-jquery-tmpl">
	<section data-name="container" class="grid-row loop"></div>
</script>

<script id="loop-cell" type="text/x-jquery-tmpl">
	<div class="${row} green">
		<div>resoults_loop</div>
		<div>&nbsp;</div>
		<div>&nbsp;</div>
	</div>
</script>

<script id="left-bar" type="text/x-jquery-tmpl">
	<div data-name="left_bar" class="${bar} blue bar">
		<span>left_bar</span> 
		<div class="dashicons dashicons-admin-links"></div>
	</div>
</script>

<script id="right-bar" type="text/x-jquery-tmpl">
	<div data-name="right_bar" class="${bar} blue bar">
		<span>left_bar</span> 
		<div class="dashicons dashicons-admin-links"></div>
	</div>
</script>

