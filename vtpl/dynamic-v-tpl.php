<?php
/**
 * A custom -not from the theme- template
 *
 * @package WordPress
 * @subpackage Virtual_Template
 */

	$TPL = $VT -> defined_Template;
	//echo '<pre>';
	//var_dump('template',$TPL);
	//echo '</pre>';
?>

<?php if($TPL['top_header']){ ?>
	<div class="row">
		<div class="twelve columns">top_header</div>
	</div>
<?php } ?>

<?php get_header(); ?>

<div class="container">

	<?php if($TPL['results_header']){ ?>
		<div class="row">
			<div class="twelve columns"><?php my_sidebar( $TPL['results_header'] ); ?></div>
		</div>
	<?php } ?>

	<?php 
		


	?>
	
	<div class="row">
		<?php if($TPL['left_bar']){ ?>
			<div class="<?php echo get_skeleton_class($TPL)->side; ?> columns"><?php my_sidebar( $TPL['left_bar'] ); ?></div>
		<?php } ?>

		<?php if($TPL['results_loop']){ ?>
			<div class="<?php echo get_skeleton_class($TPL)->loop; ?> columns">
				<?php if($ACOL){ $ACOL -> render_loop_header(); } ?>
				<?php while ( have_posts() ) : the_post(); $theID = $post->ID; ?>

				    <?php $VT->get_template_part( get_theme_mod( 'content_part_'.$VT -> tfname ) ); ?>

				<?php endwhile; ?>
				<?php if($ACOL){ $ACOL -> render_loop_footer(); } ?>
			</div>
		<?php } ?>

		<?php if($TPL['right_bar']){ ?>
			<div class="<?php echo get_skeleton_class($TPL)->side; ?> columns"><?php my_sidebar( $TPL['right_bar'] ); ?></div>
		<?php } ?>
	</div>

	<?php if($TPL['bottom_bar']){ ?>
		<div class="row">
			<div class="six columns"><?php my_sidebar( $TPL['bottom_bar'] ); ?></div>
		</div>
	<?php } ?>

	<?php if($TPL['bottom_bar_half']){ ?>
		<div class="row">
			<div class="six columns"><?php my_sidebar( $TPL['bottom_bar_half']['one'] ); ?></div>
			<div class="six columns"><?php my_sidebar( $TPL['bottom_bar_half']['two'] ); ?></div>
		</div>		
	<?php } ?>

	<?php if($TPL['bottom_bar_third']){ ?>
		<div class="row">
			<div class="four columns"><?php my_sidebar( $TPL['bottom_bar_third']['one'] ); ?></div>
			<div class="four columns"><?php my_sidebar( $TPL['bottom_bar_third']['two'] ); ?></div>
			<div class="four columns"><?php my_sidebar( $TPL['bottom_bar_third']['three'] ); ?></div>
		</div>		
	<?php } ?>

</div>
	
<?php get_footer(); ?>

</body>
</html>