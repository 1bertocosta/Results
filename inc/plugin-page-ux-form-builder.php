<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!-- <script type="text/javascript" src="js/alpaca-core.min.js"></script>
<script type="text/javascript" src="js/lodash.js"></script>
<script type="text/javascript" src="js/lodash-deep.js"></script>
<script type="text/javascript" src="js/alpacajs-ux-form-editor.js"></script>

<script type="text/javascript" src="js/main-templates.js"></script>

<link type="text/css" href="css/alpaca-min.css" rel="stylesheet"/>
<link type="text/css" href="css/ux-form-editop-style.css" rel="stylesheet"/> -->


<div class="container subtitle">Create and define executions for your forms.</div>
<div class="container grid-app">
	<!-- top bar with input title and save button -->
	<div class="row" style="margin-top:20px; margin-bottom:20px">
			<div class="nine columns">
				<div id="register-grid-input">
						<input type="text" name="grid_title" size="30" value="" spellcheck="true" autocomplete="off" placeholder="name your created form">
				</div>
			</div>
			<div class="three columns">
				<div class="save-btn"><div class="button">Save created form</div></div>
			</div>
	</div>
	<!-- body container with main grid creator -->
	<div class="row">	
		<!-- left column -->
		<div id="grid_controlls" class="two columns">
			<a id="add_input" href="#" class="button action">+ ADD FIELD (text)</a><Br/>
			<!-- <a id="add_select" href="#" class="button action">multi choice</a><Br/>
			<a id="add_checkbox" href="#" class="button action">single checkbox</a><Br/> -->
			<a id="add_object" href="#" class="button action">CONTAINER (fieldset)</a><Br/>
			<a id="add_array" href="#" class="button action">REPEATER (array)</a><Br/>
			<div style="line-height:40px">WordPress Templates</div>
			<a id="add_model_insert_post" href="#" class="button action">wp_mail</a><Br/>
			<a id="add_model_insert_post" href="#" class="button action">wp_insert_post</a><Br/>
			<a id="add_model_insert_post" href="#" class="button action">wp_insert_user</a><Br/>
			<a id="add_model_insert_post" href="#" class="button action">wp_signon</a><Br/>
			<a id="add_model_insert_post" href="#" class="button action">wp_redirect</a><Br/>
		</div>
		<!-- middle column -->
		<div id="main_container" class="seven columns u-max-width">
		</div>
		<!-- right column -->
		<div class="three columns">
			<div class="title">Forms list</div>
			<div id="group-options-list">
			<?php
				global $R_OPTIONS;

				foreach ($R_OPTIONS->list_group('forms') as $key) {
					echo '<div class="options-list-row">'.$key.'<div class="dashicons dashicons-trash"></div></div>';
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



<br style="clear:both"/>
<br style="clear:both"/>
<br style="clear:both"/>
<br style="clear:both"/>
<h2>Form schema and options output (for programmers)</h2>
<form method="post" action="test/index.php">
	
	<div>Schema</div>
	<textarea id="schema_output" name="schema_output" style="width:100%; font-size:11px; font-family:courier;"></textarea>
	<div>Options</div>
	<textarea id="options_output" name="options_output" style="width:100%; font-size:11px; font-family:courier"></textarea>
		
	<input type="submit" id="renderForm" href="#" class="buttondown" value="Show created form">
			
</form>
	


<script id="helper-container-tpl" type="text/x-jquery-tmpl">
	<div class="helper-item-details">
	<div class="context-mnu"> 
		<div class="context-mnu-item">Basic</div>
		<div class="context-mnu-item">Advanced</div>
		<div class="context-mnu-item">Dependency</div>
		<div class="context-mnu-item">WP Action</div>
	</div>
	<div class="helper-items-body" style="width:80%; float:right">
		<label class="label">name</label>
		<input class="input-helper" type="text" name="name" data-type="shema-key">
	</div>
	<br style="clear:both">
	</div>

</script>

<script id="helper-input-tpl" type="text/x-jquery-tmpl">
	<label class="label">${label}</label>
	<input class="input-helper" type="text" name="${name}" data-type="${type}" value="${value}">
</script>

<script type="text/javascript">

	jQuery(document).ready(function($) {

		window.update_textareas = function(options,schema){
			$("#schema_output").text(JSON.stringify(schema));
			$("#options_output").text(JSON.stringify(options));
		}

		/* ACTIONS EVENTS HANDLERS */

		$(document).on("click", "div .helper-object-remove", function(e) { 
			
			e.stopPropagation();

			_UXFORM.paths_helper.keys_array = [];
			_UXFORM.get_paths( $(this).parent() );
			_UXFORM.remove_element( $(this).parent() );
			
		});

		$(document).on("click", "li.alpaca-fieldset-item-container", function(e) { 
		//$(".alpaca-fieldset-item-container").live('click', function(e) {
			e.stopPropagation();

			if( $(this).hasClass('alpaca_container_selected') ){
				$(this).find('.helper-item-details').remove();
			}else{
				_UXFORM.render_field_options($(this));
			}

			_UXFORM.paths_helper.keys_array = [];
			_UXFORM.get_paths( $(this) );

			_UXFORM.colorize_path(_UXFORM.paths_helper.keys_array);

			$('html, body').animate({
		        scrollTop: parseInt($(this).offset().top) - 20
		    }, 300);

	    });

		$(document).on("click", "div.helper-item-details", function(e) { 
		//$(".helper-item-details").live('click', function(e) {                 
	        e.stopPropagation();
	    });

	    $('#add_input').click(function(){
		    _UXFORM.add_new_element('string','');
		});

		$('#add_select').click(function(){
			_UXFORM.add_new_element('string',['option1','option2','option3']);
		});

		$('#add_checkbox').click(function(){
			_UXFORM.add_new_element( 'boolean' , '' );
		});

		$('#add_object').click(function(){
			_UXFORM.add_new_element( 'object' , '' );
		});

		$('#add_array').click(function(){
			_UXFORM.add_new_element( 'array' , '' );
		});

		$(document).on("change", "input.input-helper", function(e) { 
			
			if($(this).attr('data-type') == 'option'){				
				_UXFORM.add_option_value($(this), $(this).attr('name'));
			}
			if($(this).attr('data-type') == 'shema-key'){
				var output = _UXFORM.rename_schema_key($(this));
			}
			window.update_textareas(_UXFORM.data.options,_UXFORM.data.schema);

		});

		/* INIT  */
	    
	    <?php if(@$_POST["schema_output"] != ''){ ?>
			
			var data = {
				"options":<?php echo $_POST["options_output"]; ?>,
				"schema": <?php echo $_POST["schema_output"]; ?>, 
				"view":"VIEW_WEB_DISPLAY_LIST"
			}
			_UXFORM.funcrion_render_alpaca(data);
	    
	    <?php }else{ ?>

	    	/* standard init method */
 			_UXFORM.funcrion_render_alpaca(_UXFORM.data);

	    <?php } ?>

	    window.run_sortable = function(){

    		

	    }


		window.wordpress_autocomple_names = function (data){
			/* WORDPRESS names mapping */
			dictionary = {
				'wp_actions':[
					'wp_mail',
					'wp_insert_comment',
					'wp_insert_post',
					'wp_insert_user',
					'wp_signon',
					'wp_redirect',
					'register_post_type'
				],
				'wp_insert_post':[
					'post_content',
					'post_name',
					'post_title',
					'post_status',
					'post_type',
					'post_author',
					'ping_status',
					'default_ping_status',
					'post_parent',
					'menu_order',
					'to_ping',
					'pinged',
					'post_password',
					'guid',
					'post_content_filtered',
					'post_excerpt',
					'post_date_gmt',
					'comment_status',
					'post_category',
					'tags_input',
					'tax_input',
					'page_template'
				],
				'wp_insert_user':[
					'user_pass',
					'user_login',
					'user_nicename',
					'user_url',
					'user_email',
					'display_name',
					'nickname',
					'first_name',
					'last_name',
					'description',
					'rich_editing',
					'user_registered',
					'role',
					'jabber',
					'aim',
					'yim'
				]
			};

		    $( "input[name='name']" ).autocomplete({
		      source: dictionary[data],
		      close: function( event, ui ) {
		      	console.log(event);
		        if($(this).attr('data-type') == 'shema-key'){
					
					var output = _UXFORM.rename_schema_key($(event.target));
					$(event.target).parents('li').find('.helper-object-key').text(output);
					/* OR */
					$(event.target).parents('li').find('.alpaca-fieldset-legend').children('.title').text(output);
					
				}
				window.update_textareas(_UXFORM.data.options,_UXFORM.data.schema);
		      },
		    });
		}
	});

</script>

<script>
jQuery(document).ready(function($) {
	function render_group(list){
		$('#group-options-list').children().remove();
		$.each( list, function( index, value ) {
		  //alert( index + ": " + value );
		  $('#group-options-list').append('<div class="options-list-row">'+value+'<div class="dashicons dashicons-trash"></div></div>');
		});
	}

	$('#group-options-list').on('click','.options-list-row',function(){
		$('#main_container').children().remove();
		$('#main_container').fadeOut();
		var _text = $(this).text();
		$('#register-grid-input input').val( '' );
		$.post(ajaxurl, {
			action: 'get_option',
			name: $(this).text(),			
			security: '<?php echo wp_create_nonce($_SERVER["SERVER_NAME"]); ?>',
		}, function(response) {
			console.log('------get-options-------');
			console.log(response);
			
			_UXFORM.funcrion_render_alpaca(response['value']);

			$('#register-grid-input input').val( _text );
			$('#main_container').fadeIn();
		
		});
	});
	
	$('.save-btn').click(function(){

		if($('#register-grid-input input').val()==''){
			
			alert('name your grid now !!!')
			return false;

		}else{
			var value = encodeURIComponent(JSON.stringify( _UXFORM.data ));
			$.post(ajaxurl, {
				action: 'add_option',
				name: $('#register-grid-input input').val(),	
				value: value,
				group_name: 'forms',	
				autoload: 'no',	
				encode: 'yes',	
				security: '<?php echo wp_create_nonce($_SERVER["SERVER_NAME"]); ?>',
			}, function(response) {
				render_group(response['group']);
			});
		}
	});
});
</script>

