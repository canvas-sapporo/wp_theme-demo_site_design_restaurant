<?php
/**
 * 単一投稿
 *
 * @package demo-site-design-restaurant
 */

get_header();

if ( is_singular( 'post' ) && have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$categories     = get_the_category();
		$cat_label      = ! empty( $categories ) ? $categories[0]->name : '';
		$author_display = theme_get_post_author_display_name();
		$tags           = get_the_tags();
		?>
<main class="pt-20 flex-1">
	<div class="liquid-glass-host relative w-full h-[min(50vh,560px)] min-h-[280px] bg-gray-200">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php
			the_post_thumbnail(
				'full',
				array(
					'class'    => 'w-full h-full object-cover',
					'decoding' => 'async',
				)
			);
			?>
		<?php else : ?>
			<div class="w-full h-full bg-gray-200" aria-hidden="true"></div>
		<?php endif; ?>
	</div>

	<header class="py-10 md:py-14 px-4 sm:px-6">
		<div class="max-w-3xl mx-auto text-center">
			<?php if ( $cat_label !== '' ) : ?>
				<p class="text-sm text-gray-500 mb-4">
					<span class="inline-block bg-gray-100 text-gray-900 px-3 py-1"><?php echo esc_html( $cat_label ); ?></span>
				</p>
			<?php endif; ?>
			<h1 class="text-3xl md:text-4xl lg:text-[2.75rem] font-normal text-gray-900 leading-tight tracking-tight font-serif"><?php the_title(); ?></h1>
		</div>
	</header>

	<div class="max-w-3xl mx-auto px-4 sm:px-6 pb-12 md:pb-20">
		<p class="text-sm text-gray-500">
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'Y年n月j日' ) ); ?></time>
		</p>

		<div class="mt-8 entry-content theme-text-body leading-[1.85] text-base md:text-lg [&_p]:mb-6 [&_ul]:my-4 [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:my-4 [&_ol]:list-decimal [&_ol]:pl-6 [&_figure]:my-10 [&_img]:w-full [&_img]:h-auto">
			<?php the_content(); ?>
		</div>

		<?php if ( $author_display !== '' ) : ?>
			<p class="mt-14 text-sm md:text-base theme-text-sub text-right"><?php echo esc_html( $author_display ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
			<div class="mt-10 pt-10 border-t border-gray-200">
				<p class="text-xs uppercase tracking-widest theme-text-soft mb-3"><?php esc_html_e( 'タグ', 'demo-site-design-restaurant' ); ?></p>
				<ul class="flex flex-wrap gap-2">
					<?php foreach ( $tags as $tag ) : ?>
						<li>
							<a class="inline-block border border-gray-300 px-3 py-1 text-sm theme-text-body theme-hover-bg-muted" href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</main>
		<?php
	endwhile;
elseif ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
<main class="flex-1 pt-24 pb-12">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<article <?php post_class( 'post-item' ); ?>>
			<header class="post-header mb-8">
				<h1 class="post-title text-3xl font-serif"><?php the_title(); ?></h1>
			</header>
			<div class="post-content theme-text-body">
				<?php the_content(); ?>
			</div>
		</article>
	</div>
</main>
		<?php
	endwhile;
endif;

get_footer();
