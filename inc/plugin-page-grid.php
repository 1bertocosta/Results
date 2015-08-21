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
				global $GRIDS;

				foreach ($GRIDS->list_group('grids') as $key) {
					echo '<div class="grids-list-row">'.$key.'<div class="dashicons dashicons-trash"></div></div>';
				}
			?>
			</div>
		</div>
	</div>
	<!-- end main containers -->
</div>

<script id="sidebars-list" type="text/x-jquery-tmpl">
	<div id="sidebar-list-body">
	<h2>Link sidebar with selected block</h2>
	<p>This is list of sidebars registered to your usage theme (<?php echo get_current_theme(); ?>)</p>
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

