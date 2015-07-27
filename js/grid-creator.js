window.grid = {
	'top_header':true,
	'wp_header':true,
	'results_loop':true,
	'wp_footer':true,
}
var render_blocks;


jQuery(document).ready(function($) {

	var schema = {
		'top_header':true,
		'wp_header':true,
		'results_header':true,
		'left_bar':true,
		'results_loop':true,
		'right_bar':true,
		'bottom_bar':true,
		'bottom_bar_half':{'one':true,'two':true},
		'bottom_bar_third':{'one':true,'two':true,'three':true},
		'wp_footer':true,
	};



	
	var sidebar_target;

	render_blocks = function(){

		window.grid = resort_keys(schema);

		$('#grid article').children().remove();
		$( ".grid-btn div" ).removeClass('button-primary');

		var main_content = 0;
		//console.log(grid);
		$.each(window.grid, function( index, value ) {
			if((index != 'right_bar')&&(index != 'left_bar')&&(index != 'bottom_bar_half')&&(index != 'bottom_bar_third')&&(index != 'results_loop')){
				// add row
				if((index != 'wp_header')&&(index != 'wp_footer')){
					
					$('#grid article').append('<section data-name="'+index+'" class="grid-row "><div class="twelve column blue">'+index+' <a href="#TB_inline?width=650&height=420&inlineId=my-content-id" class="thickbox"><div class="dashicons dashicons-admin-links"></div></a></div></section>');
				
				}else{
					
					$('#grid article').append('<section data-name="'+index+'" class="grid-row  "><div class="twelve column">'+index+'</div></section>');
				}				
			}

			// bottom bars
			if(index == 'bottom_bar_half'){
				var output = '';
				output += '	<section data-name="container" class="grid-row ">';
				output += '		<div data-name="'+index+'-one" class="one-half column blue">'+index+' <a href="#TB_inline?width=650&height=420&inlineId=my-content-id" class="thickbox"><div class="dashicons dashicons-admin-links"></div></a></div>';
				output += '		<div data-name="'+index+'-two" class="one-half column blue">'+index+' <a href="#TB_inline?width=650&height=420&inlineId=my-content-id" class="thickbox"><div class="dashicons dashicons-admin-links"></div></a></div>';
				output += '	</section>';
				$('#grid article').append(output);
			}
			if(index == 'bottom_bar_third'){
				var output = '';
				output += '	<section data-name="container" class="grid-row ">';
				output += '		<div data-name="'+index+'-one" class="one-third column blue">'+index+' <a href="#TB_inline?width=650&height=420&inlineId=my-content-id" class="thickbox"><div class="dashicons dashicons-admin-links"></div></a></div>';
				output += '		<div data-name="'+index+'-two" class="one-third column blue">'+index+' <a href="#TB_inline?width=650&height=420&inlineId=my-content-id" class="thickbox"><div class="dashicons dashicons-admin-links"></div></a></div>';
				output += '		<div data-name="'+index+'-three" class="one-third column blue">'+index+' <a href="#TB_inline?width=650&height=420&inlineId=my-content-id" class="thickbox"><div class="dashicons dashicons-admin-links"></div></a></div>';
				output += '	</section>';
				$('#grid article').append(output);
			}

			// loop, left and right
			if((index == 'right_bar')||(index == 'left_bar')||(index == 'results_loop')){
				if(main_content==0){
					$('#grid article').append('<section data-name="container" class="grid-row loop"></div>');
				}
				main_content++;
			}

			// set button
			//$( ".grid-btn div[data-name='"+index+"']" ).removeClass('button');
			$( ".grid-btn div[data-name='"+index+"']" ).toggleClass('button-primary');
		});

		if(main_content == 1){
			var row = 'twelve column';
			var bar = 'twelve column'
		}
		if(main_content == 2){
			var row = 'two-thirds column';
			var bar = 'one-third column'
		}
		if(main_content == 3){
			var row = 'one-third column';
			var bar = 'one-third column'
		}

		if(window.grid['left_bar']!=undefined){
			$( ".loop" ).append('<div data-name="left_bar" class="'+bar+' blue bar">left_bar <a href="#TB_inline?width=650&height=420&inlineId=my-content-id" class="thickbox"><div class="dashicons dashicons-admin-links"></div></a></div>');
		}
		if(window.grid['results_loop']==true){
			
			$( ".loop" ).append('<div class="'+row+' green"><div>resoults_loop</div><div>&nbsp;</div><div>&nbsp;</div></div>');
		}
		if(window.grid['right_bar']!=undefined){
			$( ".loop" ).append('<div data-name="right_bar" class="'+bar+' blue bar">right_bar <a href="#TB_inline?width=650&height=420&inlineId=my-content-id" class="thickbox"><div class="dashicons dashicons-admin-links"></div></a></div>');
		}

		//colored linked elements
		//console.log(value);
		$.each(window.grid, function( index, value ) {
			
			if(value != true){

				if(value['id'] != undefined){
					
					if((index == 'right_bar')||(index == 'left_bar')){

						$('section div[data-name="'+index+'"]').addClass('green');
						$('section div[data-name="'+index+'"]').append('<pre class="reg_sidebar">['+value['name']+']</pre>');
				
						
					}else{

						$('section[data-name="'+index+'"]').children().addClass('green');
						$('section[data-name="'+index+'"]').children().append('<pre class="reg_sidebar">['+value['name']+']</pre>');

					}


				}else{

					$.each(value, function(index1, value1){
						if(value1 != true){
							$('section div[data-name="'+index+'-'+index1+'"]').addClass('green');
							$('section div[data-name="'+index+'-'+index1+'"]').append('<pre class="reg_sidebar">['+value1['name']+']</pre>');
						}
					});

				}

			}
		});

	}
	render_blocks();

	function resort_keys(schema){
		
		var tech_schema = {};
		$.each(schema, function( index, value ) {
			if(window.grid[index] != undefined){
				tech_schema[index] = value;
				//tech_schema[index] = window.grid[index];
			}
		});
		console.log('tech_schema');
		console.log(tech_schema);
		return tech_schema;
	
	}

	function link_sidebar(sidebar,target){

		var input = target.split('-');

		if(input[1] == undefined){
			schema[input[0]] = sidebar;			
		}else{
			schema[input[0]][input[1]] = sidebar;			
		}

		render_blocks();
	}

	$('#grid_controlls .button').click(function(){
		if($(this).hasClass('button-primary')){
			
			delete window.grid[$(this).attr('data-name')];
			render_blocks();
		
		}else{

			window.grid[$(this).attr('data-name')] = true;
			render_blocks();
		}
	});

	$('#TB_ajaxContent .button').live('click',function(){
		
		var sidebar = {'id':null,'name':null};
		sidebar['id'] = $(this).attr('data-name');
		sidebar['name'] = $(this).text();
		link_sidebar(sidebar,sidebar_target);
		tb_remove();

	});

	$('#grid').on('click','.dashicons-admin-links',function(){

		sidebar_target = $(this).closest('section').attr('data-name');
		if(sidebar_target == 'container'){
			sidebar_target = $(this).closest('.column').attr('data-name');
		}

	});



});