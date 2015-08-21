window.grid = {}
var render_blocks;

(function($) { 
//jQuery(document).ready(function($) {

	var sidebar_target;
	var schema = {}

	reset_schema = function(){
		schema = {
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
		}
	}

	reset_grid = function(){
		window.grid = {
			'top_header':true,
			'wp_header':true,
			'results_loop':true,
			'wp_footer':true,
		}
	}
	
	reset_grid();
	reset_schema();

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
					$("#one-column-with-link").tmpl({index: index}).appendTo("#grid article");
				}else{					
					$("#one-column").tmpl({index: index}).appendTo("#grid article");
				}				
			}

			// bottom bars
			if(index == 'bottom_bar_half'){
				//$('#grid article').append(output);
				$("#two-columns").tmpl({index: index}).appendTo("#grid article");
			}
			if(index == 'bottom_bar_third'){
				//$('#grid article').append(output);
				$("#three-columns").tmpl({index: index}).appendTo("#grid article");
			}

			// loop, left and right
			if((index == 'right_bar')||(index == 'left_bar')||(index == 'results_loop')){
				if(main_content==0){
					$("#loop-tpl").tmpl({}).appendTo("#grid article");
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
			$("#left-bar").tmpl({bar: bar}).appendTo(".loop");
		}
		if(window.grid['results_loop']==true){
			$("#loop-cell").tmpl({row: row}).appendTo(".loop");
		}
		if(window.grid['right_bar']!=undefined){
			$("#right-bar").tmpl({bar: bar}).appendTo(".loop");
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
		
		if(window.grid == undefined){
			alert('something wrong');
			return schema;
		}
		
		$.each(schema, function( index, value ) {
			if(window.grid[index] != undefined){
				//tech_schema[index] = value;
				if(value == true){
					tech_schema[index] = window.grid[index];
				}else{
					tech_schema[index] = value;
				}

				console.log(value);
			}
		});
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

	function run_sidebars_panel(){
		
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

	//$('article .grid-btn .button').live('click',function(){
	$('#grid').on('click','.grid-btn .button',function(){	

		var sidebar = {'id':null,'name':null};
		sidebar['id'] = $(this).attr('data-name');
		sidebar['name'] = $(this).text();
		link_sidebar(sidebar,sidebar_target);

		$('#sidebar-list-body').remove();
		$('#grid article').fadeIn();

	});

	$('#grid').on('click','.dashicons-admin-links',function(){


		$('#grid article').fadeOut();
		$("#sidebars-list").tmpl({}).appendTo("#grid");

		sidebar_target = $(this).closest('section').attr('data-name');
		if(sidebar_target == 'container'){
			sidebar_target = $(this).closest('.column').attr('data-name');
		}

	});



//});
})(jQuery);