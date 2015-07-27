# wp-options-manager-class

# usage:

include class file (example)

<pre>include plugin_dir_path( __FILE__ ).'class/wp-options-manager.class.php';</pre>

register options group:

<pre>$main_group = new wp_options_manager('main-group');</pre>

add first option to group

<pre>$main_group -> add_option('option1','my first option with group');</pre>

add second option to group

<pre>$main_group -> add_option('option2','my second option with group');</pre>

list your group

<pre>$output = $main_group -> list_group('main-group');
var_dump($output);</pre>

# AJAX example:

register ajax methods:

<pre>
$main_group -> register_ajax_methods();
</pre>

ajax methods list:

- list_group [group_name]
- get_option [name]
- add_option [name, value, autoload, encode]
- del_option [name]

simple usage

<pre>
$.post(ajaxurl, {
	action: 'list_group',
	group_name: 'main-group',			
	security: '\<\?php global $main_group; echo wp_create_nonce($main_group-\>scripts_prefix); \?\>',
}, function(response) {
	console.log(response);
});
</pre>


