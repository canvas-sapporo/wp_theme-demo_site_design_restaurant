<?php
/**
 * Footer テンプレート（React Footer.tsx 相当）
 *
 * 店名: 設定 → 一般「サイトのタイトル」
 * キャッチ: 外観 → カスタマイズ「フロントページ（ヒーロー）」の「コンセプト」（theme_hero_concept）
 * 連絡先・営業時間: 外観 → カスタマイズ「フッター」
 */
$nav_items = theme_get_header_nav_items();

$footer_tagline = get_theme_mod(
    'theme_hero_concept',
    __( '洗練された美食体験', 'demo-site-design-restaurant' )
);

$footer_hours = theme_get_footer_hours_rows();

$footer_address = get_theme_mod( 'theme_footer_address', '東京都港区南青山1-1-1' );
$footer_phone   = get_theme_mod( 'theme_footer_phone', '03-1234-5678' );
$footer_email   = get_theme_mod( 'theme_footer_email', 'info@lumiere.jp' );

$footer_year          = (int) gmdate( 'Y' );
$footer_brand         = get_bloginfo( 'name', 'display' );
$footer_site_icon_url = theme_get_brand_icon_url();
?>
    <footer class="theme-shell-footer py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <a
                        href="<?php echo esc_url( home_url( '/' ) ); ?>"
                        class="flex items-center gap-2 md:gap-3 mb-4 min-w-0 theme-link-on-inverse transition-colors"
                    >
                        <img
                            src="<?php echo esc_url( $footer_site_icon_url ); ?>"
                            alt=""
                            class="h-8 w-8 md:h-9 md:w-9 shrink-0 object-contain"
                            width="36"
                            height="36"
                            decoding="async"
                        />
                        <span class="text-3xl tracking-wider min-w-0 truncate"><?php echo esc_html( $footer_brand ); ?></span>
                    </a>
                    <p class="theme-text-on-footer-muted"><?php echo esc_html( $footer_tagline ); ?></p>
                </div>

                <div>
                    <h3 class="text-lg mb-4"><?php esc_html_e( 'ナビゲーション', 'demo-site-design-restaurant' ); ?></h3>
                    <nav class="flex flex-col gap-2" aria-label="<?php esc_attr_e( 'フッターナビゲーション', 'demo-site-design-restaurant' ); ?>">
                        <?php foreach ( $nav_items as $item ) : ?>
                            <a
                                href="<?php echo esc_url( $item['url'] ); ?>"
                                class="theme-text-on-footer-muted theme-link-on-inverse transition-colors"
                            >
                                <?php echo esc_html( $item['label'] ); ?>
                            </a>
                        <?php endforeach; ?>
                    </nav>
                </div>

                <div>
                    <h3 class="text-lg mb-4"><?php esc_html_e( '営業時間', 'demo-site-design-restaurant' ); ?></h3>
                    <div class="flex items-start gap-2 theme-text-on-footer-muted mb-2">
                        <span class="mt-1 flex-shrink-0" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </span>
                        <div>
                            <?php foreach ( $footer_hours as $row ) : ?>
                                <p<?php echo $row['class'] ? ' class="' . esc_attr( $row['class'] ) . '"' : ''; ?>><?php echo esc_html( $row['line'] ); ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg mb-4"><?php esc_html_e( 'お問い合わせ', 'demo-site-design-restaurant' ); ?></h3>
                    <div class="space-y-2 theme-text-on-footer-muted">
                        <div class="flex items-start gap-2">
                            <span class="flex-shrink-0 mt-0.5" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            </span>
                            <span><?php echo esc_html( $footer_address ); ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="flex-shrink-0" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <?php
                            $tel_href = preg_replace( '/\s+/', '', $footer_phone );
                            $tel_href = preg_replace( '/[^0-9+]/', '', $tel_href );
                            ?>
                            <a href="tel:<?php echo esc_attr( $tel_href ); ?>" class="theme-link-on-inverse transition-colors"><?php echo esc_html( $footer_phone ); ?></a>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="flex-shrink-0" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            </span>
                            <a href="mailto:<?php echo esc_attr( $footer_email ); ?>" class="theme-link-on-inverse transition-colors break-all"><?php echo esc_html( $footer_email ); ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-gray-500">
                    &copy; <?php echo esc_html( (string) $footer_year ); ?>
                    <?php echo esc_html( $footer_brand ); ?>.
                    <?php esc_html_e( 'All rights reserved.', 'demo-site-design-restaurant' ); ?>
                </p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</div>
</body>
</html>
