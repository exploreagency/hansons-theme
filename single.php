<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package venture-theme
 */

get_header();
?>

	<main class="main main--single-page">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content( '', true ); ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</main>

<?php
// get_sidebar();
get_footer();