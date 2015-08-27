<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!-- <script type="text/javascript" src="js/alpaca-core.min.js"></script>
<script type="text/javascript" src="js/lodash.js"></script>
<script type="text/javascript" src="js/lodash-deep.js"></script>
<script type="text/javascript" src="js/alpacajs-ux-form-editor.js"></script>

<script type="text/javascript" src="js/main-templates.js"></script>

<link type="text/css" href="css/alpaca-min.css" rel="stylesheet"/>
<link type="text/css" href="css/ux-form-editop-style.css" rel="stylesheet"/> -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
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
			<a id="add_input" href="#" class="button action" >+ ADD FIELD (text)</a><Br/>
			<!-- <a id="add_select" href="#" class="button action" style="width:200px; margin-bottom:2px">multi choice</a><Br/>
			<a id="add_checkbox" href="#" class="button action" style="width:200px; margin-bottom:2px">single checkbox</a><Br/> -->
			<a id="add_object" href="#" class="button action" >CONTAINER (fieldset)</a><Br/>
			<a id="add_array" href="#" class="button action">REPEATER (array)</a><Br/>
			<div style="line-height:40px">WordPress Templates</div>
			<a href="#" class="button action new_element" data-object-name="wp_mail" data-type="object-schema" >wp_mail</a><Br/>
			<a href="#" class="button action new_element" data-object-name="wp_insert_post" data-type="object-schema" >wp_insert_post</a><Br/>

			<a id=".add_model_insert_post" href="#" class="button action" >wp_insert_user</a><Br/>
			<a id=".add_model_insert_post" href="#" class="button action" >wp_signon</a><Br/>
			<a id=".add_model_insert_post" href="#" class="button action" >wp_redirect</a><Br/>
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
	<div class="helper-items-body" style="width:70%; float:right">
		
	</div>
	<br style="clear:both">
	</div>
</script>

<script id="helper-input-tpl" type="text/x-jquery-tmpl">
	<label class="label">${label}</label>
	<input class="input-helper" type="text" name="${name}" data-type="${type}" value="${value}">
</script>

<script type="text/javascript">
window.wp_result_json_path = '<?php echo PLUGIN_SANDF_URI; ?>';
jQuery(document).ready(function($) {
<?php if(@$_POST["schema_output"] != ''){ ?>

	window.post_options = <?php echo stripslashes(@$_POST["options_output"]); ?>;
	window.post_schema = <?php echo stripslashes(@$_POST["schema_output"]); ?>;
	var data = {
		"options":window.post_options,
		"schema": window.post_schema, 
		"view":"VIEW_WEB_DISPLAY_LIST",
		
	}
	_UXFORM.funcrion_render_alpaca(data);

<?php }else{ ?>

	/* standard init method */
		_UXFORM.funcrion_render_alpaca(_UXFORM.data);

<?php } ?>
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

