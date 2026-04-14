<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ( ! has_site_icon() ) : ?>
        <link rel="icon" href="<?php echo esc_url( get_theme_file_uri( '/images/logo.svg' ) ); ?>" type="image/svg+xml">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'antialiased theme-body-bg' ); ?>>
<?php wp_body_open(); ?>
<div
    class="js-page-loader theme-surface-header fixed inset-0 z-[100] flex flex-col items-center justify-center backdrop-blur-sm transition-opacity duration-300"
    role="status"
    aria-live="polite"
>
    <span class="sr-only"><?php esc_html_e( '読み込み中', 'demo-site-design-restaurant' ); ?></span>
    <div class="h-12 w-12 rounded-full border-4 border-gray-200 border-t-black animate-spin" aria-hidden="true"></div>
    <p class="mt-4 text-sm tracking-wide theme-text-sub">Loading...</p>
</div>
<?php
$nav_items            = theme_get_header_nav_items();
$header_site_icon_url = theme_get_brand_icon_url();
?>
<div class="min-h-screen flex flex-col">
    <header class="theme-surface-header fixed top-0 left-0 right-0 z-50 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a
                    href="<?php echo esc_url( home_url( '/' ) ); ?>"
                    class="flex items-center gap-2 md:gap-3 min-w-0 shrink"
                    aria-label="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
                >
                    <?php theme_liquid_glass_open( array( 'class' => 'liquidGlass-wrapper--icon' ) ); ?>
                    <img
                        src="<?php echo esc_url( $header_site_icon_url ); ?>"
                        alt=""
                        class="object-contain"
                        width="36"
                        height="36"
                        decoding="async"
                    />
                    <?php theme_liquid_glass_close(); ?>
                    <span class="text-2xl font-serif tracking-wider theme-text-strong truncate hidden md:block">
                        <?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?>
                    </span>
                </a>

                <nav class="hidden md:flex items-center gap-8" aria-label="<?php esc_attr_e( 'メインナビゲーション', 'demo-site-design-restaurant' ); ?>">
                    <?php foreach ( $nav_items as $item ) : ?>
                        <a
                            href="<?php echo esc_url( $item['url'] ); ?>"
                            class="<?php echo $item['active'] ? 'text-sm tracking-wide theme-nav-link' : 'text-sm tracking-wide theme-nav-link'; ?>"
                            <?php echo $item['active'] ? 'aria-current="page"' : ''; ?>
                        >
                            <?php echo esc_html( $item['label'] ); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>

                <button
                    type="button"
                    class="md:hidden p-2 text-gray-900 js-menu-toggle"
                    aria-label="<?php esc_attr_e( 'メニュー', 'demo-site-design-restaurant' ); ?>"
                    aria-expanded="false"
                    aria-controls="primary-mobile-nav"
                >
                    <span class="js-menu-icon-open" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                    </span>
                    <span class="js-menu-icon-close hidden" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </span>
                </button>
            </div>

            <nav
                id="primary-mobile-nav"
                class="hidden md:hidden py-4 border-t border-gray-200"
                aria-hidden="true"
            >
                <?php foreach ( $nav_items as $item ) : ?>
                    <a
                        href="<?php echo esc_url( $item['url'] ); ?>"
                        class="<?php echo $item['active'] ? 'block py-3 text-sm tracking-wide theme-nav-link' : 'block py-3 text-sm tracking-wide theme-nav-link'; ?>"
                        <?php echo $item['active'] ? 'aria-current="page"' : ''; ?>
                    >
                        <?php echo esc_html( $item['label'] ); ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>
