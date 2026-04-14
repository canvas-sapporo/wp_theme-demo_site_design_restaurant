<?php get_header(); ?>

<main class="flex-1 pt-24 pb-12">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'post-item' ); ?>>
					<header class="post-header mb-8">
						<h1 class="post-title text-3xl font-serif"><?php the_title(); ?></h1>
					</header>
					<div class="post-content text-gray-700">
						<?php the_content(); ?>
					</div>
				</article>
				<?php
			endwhile;
		else :
			?>
			<p><?php esc_html_e( '記事はありません。', 'demo-site-design-restaurant' ); ?></p>
			<?php
		endif;
		?>
	</div>
</main>

<?php get_footer(); ?>
