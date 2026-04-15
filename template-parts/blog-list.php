<?php
/**
 * ブログ一覧（ヒーロー + カードグリッド）。
 *
 * @package demo-site-design-restaurant
 *
 * get_template_part( ..., ..., array( 'hero_title' => ..., 'hero_subtitle' => ... ) ) で渡す。
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $hero_title ) || ! is_string( $hero_title ) ) {
	$hero_title = __( 'Blog', 'demo-site-design-restaurant' );
}
if ( ! isset( $hero_subtitle ) || ! is_string( $hero_subtitle ) ) {
	$hero_subtitle = __( 'レストランからのお知らせとストーリー', 'demo-site-design-restaurant' );
}

$hero_img = theme_get_blog_hero_image_attrs();
?>
<div class="pt-20 flex-1 flex flex-col">
	<section class="relative h-[50vh] flex items-center justify-center bg-gray-900 min-h-[280px]">
		<div class="absolute inset-0 z-0">
			<img
				src="<?php echo esc_url( $hero_img['url'] ); ?>"
				alt="<?php echo esc_attr( $hero_title ); ?>"
				class="w-full h-full object-cover opacity-40"
				width="1080"
				height="720"
				decoding="async"
			/>
		</div>
		<div class="relative z-10 text-center theme-text-inverse px-4">
			<h1 class="text-5xl md:text-6xl mb-4 tracking-wider font-serif"><?php echo esc_html( $hero_title ); ?></h1>
			<?php if ( is_string( $hero_subtitle ) && $hero_subtitle !== '' ) : ?>
				<p class="text-xl tracking-wide"><?php echo esc_html( $hero_subtitle ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="js-blog-grid-section py-20 px-4 sm:px-6 lg:px-8 theme-bg-muted">
		<div class="max-w-7xl mx-auto">
			<?php if ( have_posts() ) : ?>
				<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content-post', 'card' );
					endwhile;
					?>
				</div>
				<div class="mt-12 flex justify-center">
					<?php
					the_posts_pagination(
						array(
							'mid_size'  => 2,
							'prev_text' => __( '前へ', 'demo-site-design-restaurant' ),
							'next_text' => __( '次へ', 'demo-site-design-restaurant' ),
						)
					);
					?>
				</div>
			<?php else : ?>
				<p class="text-center theme-text-sub"><?php esc_html_e( '記事はありません。', 'demo-site-design-restaurant' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</div>
