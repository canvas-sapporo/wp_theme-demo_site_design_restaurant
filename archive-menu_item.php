<?php
/**
 * メニュー品アーカイブ（通常は /menu/）
 *
 * レイアウト: React Menu.tsx およびメニューページ参考デザイン（ヒーロー・セクション見出し中央・帯の交互背景）。
 *
 * 管理画面: レストランメニュー → メニュー品 / メニューカテゴリ
 */
get_header();

$hero_img    = theme_get_menu_hero_image_attrs();
$hero_title  = get_theme_mod( 'theme_menu_hero_title', 'Menu' );
$hero_sub    = get_theme_mod(
	'theme_menu_hero_subtitle',
	__( '厳選された季節の食材を使用した特別な料理', 'demo-site-design-restaurant' )
);
$footer_note = get_theme_mod(
	'theme_menu_footer_note',
	__( '※表示価格は税込です。食物アレルギーをお持ちの方はスタッフまでお申し出ください。', 'demo-site-design-restaurant' )
);

$categories = theme_get_menu_categories_sorted();
if ( is_wp_error( $categories ) ) {
	$categories = array();
}

$counts  = wp_count_posts( 'menu_item' );
$has_any = isset( $counts->publish ) && (int) $counts->publish > 0;
?>

<main class="flex-1">
	<!-- Hero（参考: メニューページ全面ヒーロー） -->
	<section class="relative min-h-[50vh] flex items-center justify-center overflow-hidden">
		<div class="absolute inset-0 z-0">
			<img
				class="w-full h-full object-cover"
				src="<?php echo esc_url( $hero_img['url'] ); ?>"
				alt="<?php echo esc_attr( $hero_img['alt'] ); ?>"
				width="1920"
				height="1080"
				decoding="async"
				fetchpriority="high"
			/>
			<div class="absolute inset-0 z-10 bg-black/40 pointer-events-none" aria-hidden="true"></div>
		</div>
		<div class="relative z-20 text-center text-white px-4 pt-24 pb-16">
			<h1 class="text-5xl md:text-7xl mb-6 tracking-wider font-serif font-medium"><?php echo esc_html( $hero_title ); ?></h1>
			<?php if ( is_string( $hero_sub ) && trim( $hero_sub ) !== '' ) : ?>
				<p class="text-lg md:text-2xl text-white/95 max-w-2xl mx-auto leading-relaxed"><?php echo esc_html( $hero_sub ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( ! is_array( $categories ) || empty( $categories ) ) : ?>
		<!-- No Menu Categories Section -->
		<section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
			<div class="max-w-7xl mx-auto">
				<p class="text-center text-gray-600"><?php esc_html_e( 'メニューカテゴリを準備中です。', 'demo-site-design-restaurant' ); ?></p>
				<?php if ( is_string( $footer_note ) && trim( $footer_note ) !== '' ) : ?>
					<p class="text-center text-sm text-gray-500 max-w-3xl mx-auto leading-relaxed mt-12"><?php echo esc_html( $footer_note ); ?></p>
				<?php endif; ?>
			</div>
		</section>
	<?php elseif ( ! $has_any ) : ?>
		<!-- No Menu Items Section -->
		<section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
			<div class="max-w-7xl mx-auto">
				<p class="text-center text-gray-600"><?php esc_html_e( 'メニュー品がまだ登録されていません。管理画面の「レストランメニュー」から追加してください。', 'demo-site-design-restaurant' ); ?></p>
				<?php if ( is_string( $footer_note ) && trim( $footer_note ) !== '' ) : ?>
					<p class="text-center text-sm text-gray-500 max-w-3xl mx-auto leading-relaxed mt-12"><?php echo esc_html( $footer_note ); ?></p>
				<?php endif; ?>
			</div>
		</section>
	<?php else : ?>
		<!-- Menu Section -->
		<?php
		$visible_section_index = 0;
		foreach ( $categories as $term ) :
			$section_query = new WP_Query(
				array(
					'post_type'      => 'menu_item',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'tax_query'      => array(
						array(
							'taxonomy' => 'menu_category',
							'field'    => 'term_id',
							'terms'    => $term->term_id,
						),
					),
				)
			);
			if ( ! $section_query->have_posts() ) {
				wp_reset_postdata();
				continue;
			}

			$layout = get_term_meta( $term->term_id, 'menu_category_layout', true );
			$layout = function_exists( 'theme_sanitize_menu_category_layout' )
				? theme_sanitize_menu_category_layout( is_string( $layout ) ? $layout : 'grid' )
				: 'grid';
			$desc = term_description( $term, 'menu_category' );

			$strip_class = ( $visible_section_index % 2 === 1 ) ? 'bg-gray-50' : 'bg-white';
			$visible_section_index++;
			?>
			<section class="py-20 px-4 sm:px-6 lg:px-8 <?php echo esc_attr( $strip_class ); ?>">
				<div class="max-w-7xl mx-auto">
					<?php if ( $layout === 'list' ) : ?>
						<!-- pages/Menu.tsx「コースメニュー」相当: max-w-4xl に見出し＋一覧をまとめる -->
						<div class="max-w-4xl mx-auto">
							<div class="text-center mb-16">
								<h2 class="text-4xl mb-4"><?php echo esc_html( $term->name ); ?></h2>
								<?php if ( is_string( $desc ) && trim( wp_strip_all_tags( $desc ) ) !== '' ) : ?>
									<div class="text-lg text-gray-600"><?php echo wp_kses_post( $desc ); ?></div>
								<?php endif; ?>
							</div>
							<div class="space-y-6">
								<?php
								while ( $section_query->have_posts() ) :
									$section_query->the_post();
									$price = get_post_meta( get_the_ID(), 'menu_item_price', true );
									$price = is_string( $price ) ? $price : '';
									$short = theme_get_menu_item_short_description( get_the_ID() );
									?>
									<div class="border-b border-gray-200 pb-6 last:border-b-0">
										<div class="flex justify-between items-start mb-2">
											<h3 class="text-2xl"><?php the_title(); ?></h3>
											<?php if ( $price !== '' ) : ?>
												<span class="text-xl whitespace-nowrap ml-4 flex-shrink-0"><?php echo esc_html( $price ); ?></span>
											<?php endif; ?>
										</div>
										<?php if ( $short !== '' ) : ?>
											<p class="text-gray-600 leading-relaxed"><?php echo esc_html( $short ); ?></p>
										<?php endif; ?>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
					<?php else : ?>
						<div class="text-center mb-12 md:mb-16">
							<h2 class="text-3xl md:text-4xl mb-4 font-medium"><?php echo esc_html( $term->name ); ?></h2>
							<?php if ( is_string( $desc ) && trim( wp_strip_all_tags( $desc ) ) !== '' ) : ?>
								<div class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed"><?php echo wp_kses_post( $desc ); ?></div>
							<?php endif; ?>
						</div>
						<!-- Menu.tsx 相当: grid + カード（枠線なし・画像 h-64・object-cover） -->
						<div class="grid md:grid-cols-3 gap-8">
							<?php
							while ( $section_query->have_posts() ) :
								$section_query->the_post();
								$price = get_post_meta( get_the_ID(), 'menu_item_price', true );
								$price = is_string( $price ) ? $price : '';
								$short = theme_get_menu_item_short_description( get_the_ID() );
								?>
								<article <?php post_class( 'bg-white overflow-hidden hover:shadow-xl transition-shadow duration-300' ); ?>>
									<div class="relative h-64 overflow-hidden bg-gray-100">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php
											the_post_thumbnail(
												'large',
												array(
													'class'    => 'absolute inset-0 w-full h-full object-cover',
													'loading'  => 'lazy',
													'decoding' => 'async',
												)
											);
											?>
										<?php else : ?>
											<div class="absolute inset-0 flex items-center justify-center text-gray-400 text-sm" aria-hidden="true">
												<?php esc_html_e( '画像なし', 'demo-site-design-restaurant' ); ?>
											</div>
										<?php endif; ?>
									</div>
									<div class="p-6">
										<div class="flex justify-between items-start mb-3">
											<h3 class="text-xl font-medium"><?php the_title(); ?></h3>
											<?php if ( $price !== '' ) : ?>
												<span class="text-lg whitespace-nowrap ml-4 flex-shrink-0"><?php echo esc_html( $price ); ?></span>
											<?php endif; ?>
										</div>
										<?php if ( $short !== '' ) : ?>
											<p class="text-gray-600 leading-relaxed"><?php echo esc_html( $short ); ?></p>
										<?php endif; ?>
									</div>
								</article>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
			<?php
			wp_reset_postdata();
		endforeach;
		?>

		<!-- Info Section -->
		<?php if ( is_string( $footer_note ) && trim( $footer_note ) !== '' ) : ?>
			<section class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
				<div class="max-w-4xl mx-auto text-center">
					<p class="text-gray-600 leading-relaxed"><?php echo esc_html( $footer_note ); ?></p>
				</div>
			</section>
		<?php endif; ?>
	<?php endif; ?>
</main>

<?php
get_footer();
