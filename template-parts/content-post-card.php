<?php
/**
 * 投稿一覧用カード（アイキャッチ・カテゴリー・抜粋・日付・著者表示名）。
 *
 * @package demo-site-design-restaurant
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$permalink = get_permalink();
$title     = get_the_title();

$categories = get_the_category();
$cat_label  = '';
if ( ! empty( $categories ) ) {
	$cat_label = $categories[0]->name;
}

$author_display = theme_get_post_author_display_name();
$date_display   = get_the_date( 'Y年n月j日' );
?>
<a
	href="<?php echo esc_url( $permalink ); ?>"
	class="js-blog-grid-item group block focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900"
>
	<article class="theme-bg-page overflow-hidden rounded-xl hover:shadow-xl transition-shadow duration-300">
		<div class="relative h-64 overflow-hidden bg-gray-100">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php
				the_post_thumbnail(
					'large',
					array(
						'class'    => 'absolute inset-0 w-full h-full object-cover',
						'loading' => 'lazy',
						'decoding' => 'async',
					)
				);
				?>
			<?php else : ?>
				<div class="absolute inset-0 bg-gray-200" aria-hidden="true"></div>
			<?php endif; ?>
			<?php if ( $cat_label !== '' ) : ?>
				<div class="absolute top-4 left-4">
					<span class="theme-bg-page px-3 py-1 text-sm text-gray-900"><?php echo esc_html( $cat_label ); ?></span>
				</div>
			<?php endif; ?>
		</div>
		<div class="p-6">
			<h2 class="text-xl mb-3 leading-tight text-gray-900 group-hover:underline underline-offset-4 decoration-gray-400 font-serif">
				<?php echo esc_html( $title ); ?>
			</h2>
			<p class="theme-text-sub leading-relaxed mb-4 line-clamp-3">
				<?php echo esc_html( get_the_excerpt() ); ?>
			</p>
			<div class="flex items-center gap-4 text-sm text-gray-500 flex-wrap">
				<div class="flex items-center gap-1">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( $date_display ); ?></time>
				</div>
				<?php if ( $author_display !== '' ) : ?>
					<div class="flex items-center gap-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" view="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
						<span><?php echo esc_html( $author_display ); ?></span>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</article>
</a>
