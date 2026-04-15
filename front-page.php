<?php
/**
 * フロントページ
 *
 * ヒーローは外観 → カスタマイズ → 「フロントページ（ヒーロー）」で編集。
 * 「固定ページをホーム」にしたときは、その固定ページの本文をヒーロー下に表示可能。
 */
get_header();

$hero_img   = theme_get_hero_image_attrs();
$concept    = get_theme_mod(
    'theme_hero_concept',
    __( '洗練された美食体験', 'demo-site-design-restaurant' )
);
$menu_url   = theme_get_menu_archive_url();
$site_title = get_bloginfo( 'name', 'display' );
$about_img  = theme_get_about_image_attrs();
$gallery_images = theme_get_gallery_images();
$about_title = get_theme_mod( 'theme_about_title', '当店について' );
$about_texts = array(
    get_theme_mod( 'theme_about_text_1', 'LUMIÈREは、伝統と革新が融合した新しい美食体験をお届けする高級レストランです。' ),
    get_theme_mod( 'theme_about_text_2', '季節の厳選された食材を使い、シェフが一皿一皿丁寧に仕上げる料理は、視覚と味覚の両方を満たす芸術作品です。' ),
    get_theme_mod( 'theme_about_text_3', '洗練された空間で、特別な時間をお過ごしください。' ),
);
$gallery_title = get_theme_mod( 'theme_gallery_title', 'ギャラリー' );
$gallery_subtitle = get_theme_mod( 'theme_gallery_subtitle', '洗練された空間と美しい料理の数々' );
?>

<main class="flex-1">
    <!-- Hero Section -->
    <?php
    /*
     * 固定ヘッダーは h-20。画像・スライダー・見出しは top-20〜bottom のステージ内で中央寄せし、
     * ヘッダー直下の黒帯と画面下端の黒余白が同じになるようにする（全画面 h-screen のまま）。
     */
    ?>
    <section class="relative h-screen overflow-hidden theme-bg-footer js-front-hero">
        <?php /* 参考: animation-website-youtube の .slider（ステージ内でスライド。余白はフッターと同じ --theme-footer-bg） */ ?>
        <div
            class="js-hero-slider absolute inset-x-0 top-20 bottom-0 z-[1] theme-bg-footer pointer-events-none"
            aria-hidden="true"
        ></div>

        <div class="absolute inset-x-0 top-20 bottom-0 z-[2] flex justify-center items-center">
            <div class="js-hero-reveal relative mx-auto w-full overflow-hidden" style="height: 0%;">
                <div class="absolute inset-0 w-full min-h-0">
                    <img
                        class="absolute inset-0 h-full w-full object-cover"
                        src="<?php echo esc_url( $hero_img['url'] ); ?>"
                        alt="<?php echo esc_attr( $hero_img['alt'] ); ?>"
                        width="1920"
                        height="1080"
                        decoding="async"
                        fetchpriority="high"
                    />
                    <div class="absolute inset-0 z-10 theme-bg-footer/40 pointer-events-none" aria-hidden="true"></div>
                </div>
            </div>
        </div>

        <div
            class="absolute inset-x-0 top-20 bottom-0 z-20 flex flex-col items-center justify-center px-4 text-center theme-text-inverse pointer-events-none js-hero-content"
        >
            <h1 class="text-5xl md:text-7xl mb-6 tracking-wider font-medium"><?php echo esc_html( $site_title ); ?></h1>
            <p class="text-xl md:text-2xl mb-8 tracking-wide"><?php echo esc_html( $concept ); ?></p>
            <a
                class="inline-block theme-cta-pill px-8 py-3 hover:bg-gray-100 transition-colors pointer-events-auto rounded-sm"
                href="<?php echo esc_url( $menu_url ); ?>"
            >
                <?php esc_html_e( 'メニューを見る', 'demo-site-design-restaurant' ); ?>
            </a>
        </div>
    </section>


    <section class="py-20 px-4 sm:px-6 lg:px-8 theme-bg-page">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl mb-6 font-medium"><?php echo esc_html( $about_title ); ?></h2>
                    <?php foreach ( $about_texts as $about_text ) : ?>
                        <?php
                        if ( ! is_string( $about_text ) || trim( $about_text ) === '' ) {
                            continue;
                        }
                        ?>
                        <p class="text-lg mb-4 theme-text-body leading-relaxed"><?php echo esc_html( $about_text ); ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="liquid-glass-host relative h-96 md:h-full min-h-[400px]">
                    <?php theme_liquid_glass_open( array( 'class' => 'liquidGlass-wrapper--fill liquidGlass-wrapper--card' ) ); ?>
                    <img
                        class="w-full h-full object-cover"
                        src="<?php echo esc_url( $about_img['url'] ); ?>"
                        alt="<?php echo esc_attr( $about_img['alt'] ); ?>"
                        width="1080"
                        height="1080"
                        loading="lazy"
                        decoding="async"
                    />
                    <?php theme_liquid_glass_close(); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 theme-bg-muted">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl mb-4 font-medium"><?php echo esc_html( $gallery_title ); ?></h2>
                <p class="text-lg theme-text-sub"><?php echo esc_html( $gallery_subtitle ); ?></p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ( $gallery_images as $gallery_image ) : ?>
                    <div class="liquid-glass-host relative group aspect-square liquidGlass-wrapper--radius-gallery">
                        <?php theme_liquid_glass_open( array( 'class' => 'liquidGlass-wrapper--fill liquidGlass-wrapper--card liquidGlass-wrapper--radius-gallery' ) ); ?>
                        <img
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                            src="<?php echo esc_url( $gallery_image['url'] ); ?>"
                            alt="<?php echo esc_attr( $gallery_image['alt'] ); ?>"
                            width="1080"
                            height="1080"
                            loading="lazy"
                            decoding="async"
                        />
                        <?php theme_liquid_glass_close(); ?>
                        <div class="absolute inset-0 z-10 bg-black/0 group-hover:bg-black/20 transition-colors duration-300" aria-hidden="true"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- <?php if ( is_front_page() && ! is_home() ) : ?>
        <?php
        while ( have_posts() ) :
            the_post();
            $raw = get_post()->post_content;
            if ( is_string( $raw ) && trim( $raw ) !== '' ) :
                ?>
                <section class="py-20 px-4 sm:px-6 lg:px-8 theme-bg-page">
                    <div class="max-w-7xl mx-auto post-content theme-text-body">
                        <?php the_content(); ?>
                    </div>
                </section>
                <?php
            endif;
        endwhile;
        ?>

    <?php elseif ( is_front_page() && is_home() ) : ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-12">
            <div class="post-list space-y-12">
                <?php if ( have_posts() ) : ?>
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        ?>
                        <article <?php post_class( 'post-item' ); ?>>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="block mb-4">
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                </a>
                            <?php endif; ?>
                            <header class="post-header">
                                <h2 class="post-title text-2xl font-serif">
                                    <a href="<?php the_permalink(); ?>" class="hover:underline theme-text-strong"><?php the_title(); ?></a>
                                </h2>
                            </header>
                            <div class="post-content mt-4 theme-text-body">
                                <?php the_excerpt(); ?>
                            </div>
                        </article>
                        <?php
                    endwhile;

                    the_posts_pagination(
                        array(
                            'mid_size'  => 2,
                            'prev_text' => __( '前へ', 'demo-site-design-restaurant' ),
                            'next_text' => __( '次へ', 'demo-site-design-restaurant' ),
                        )
                    );
                    ?>
                <?php else : ?>
                    <p><?php esc_html_e( '記事はありません。', 'demo-site-design-restaurant' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?> -->
</main>

<?php
get_footer();
