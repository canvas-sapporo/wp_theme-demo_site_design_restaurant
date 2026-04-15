<?php
/**
 * 単一メニュー品（共有リンク用の簡易表示）
 */
get_header();

$price = get_post_meta( get_the_ID(), 'menu_item_price', true );
$price = is_string( $price ) ? $price : '';
?>

<main class="flex-1 pt-24 pb-16 px-4 sm:px-6 lg:px-8">
	<div class="max-w-3xl mx-auto">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class(); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="mb-8 relative aspect-video overflow-hidden rounded-xl bg-gray-100">
						<?php
						the_post_thumbnail(
							'large',
							array(
								'class'    => 'w-full h-full object-cover',
								'loading'  => 'eager',
								'decoding' => 'async',
							)
						);
						?>
					</div>
				<?php endif; ?>

				<header class="mb-6">
					<div class="flex flex-wrap justify-between items-baseline gap-4">
						<h1 class="text-3xl font-serif font-medium"><?php the_title(); ?></h1>
						<?php if ( $price !== '' ) : ?>
							<span class="text-xl whitespace-nowrap"><?php echo esc_html( $price ); ?></span>
						<?php endif; ?>
					</div>
				</header>

				<div class="post-content theme-text-body leading-relaxed max-w-none">
					<?php the_content(); ?>
				</div>

				<p class="mt-10">
					<a href="<?php echo esc_url( theme_get_menu_archive_url() ); ?>" class="text-gray-900 underline underline-offset-4 theme-link-subtle-hover transition-colors">
						<?php esc_html_e( '← メニュー一覧へ戻る', 'demo-site-design-restaurant' ); ?>
					</a>
				</p>
			</article>
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
