(function($) { 
//jQuery(document).ready(function($) {


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
		alert($(this).text());
		$.post(ajaxurl, {
			action: 'get_option',
			name: $(this).text(),			
			security: '<?php global $GRIDS; echo wp_create_nonce($GRIDS->scripts_prefix); ?>',
		}, function(response) {
			console.log('------get-options-------');
			console.log(response);
			window.grid = response['value'];
			reset_schema();
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
			reset_schema();
			render_blocks();
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
//});
})(jQuery);