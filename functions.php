<?php
/**
 * レストランメニュー（CPT + タクソノミー）
 */
require_once get_theme_file_path( '/inc/restaurant-menu.php' );
require_once get_theme_file_path( '/inc/theme-colors.php' );
require_once get_theme_file_path( '/inc/theme-fonts.php' );
require_once get_theme_file_path( '/inc/liquid-glass.php' );

// ファイルの読み込み
function add_files() {
    $css_path = get_theme_file_path( '/dist/css/app.css' );
    if ( file_exists( $css_path ) ) {
        $style_deps = array();
        if ( wp_style_is( 'theme-google-fonts', 'registered' ) ) {
            $style_deps[] = 'theme-google-fonts';
        }
        wp_enqueue_style(
            'theme-tailwind',
            get_theme_file_uri() . '/dist/css/app.css',
            $style_deps,
            (string) filemtime( $css_path )
        );
    }
    $js_path = get_theme_file_path( '/dist/js/theme.js' );
    if ( file_exists( $js_path ) ) {
        wp_enqueue_script(
            'theme-main',
            get_theme_file_uri() . '/dist/js/theme.js',
            array(),
            (string) filemtime( $js_path ),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'add_files');

// テーマ設定
function theme_setup(){
    // titleタグ
    add_theme_support('title-tag');

    // アイキャッチ画像（ブログ一覧・フロント+投稿一覧用）
    add_theme_support( 'post-thumbnails' );

    // メニュー
    register_nav_menus(
        array(
            'main-menu' => 'メインメニュー',
        )
    );
}
add_action('after_setup_theme', 'theme_setup');

/**
 * 外観 → カスタマイズ: フロントページのヒーロー画像・コンセプト文・フッター連絡先など。
 */
function theme_customize_register( $wp_customize ) {
    $wp_customize->add_section(
        'theme_hero',
        array(
            'title'       => __( 'フロントページ（Hero）', 'demo-site-design-restaurant' ),
            'description' => __( '固定ページをホームにしたときのメインビジュアルです。「コンセプト」はヒーロー直下とフッターのキャッチコピーに共通で使われます（設定 → 一般の「キャッチフレーズ」とは別です）。', 'demo-site-design-restaurant' ),
            'priority'    => 35,
        )
    );

    $wp_customize->add_setting(
        'theme_hero_image',
        array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'theme_hero_image',
            array(
                'label'     => __( 'ホーム画像', 'demo-site-design-restaurant' ),
                'section'   => 'theme_hero',
                'mime_type' => 'image',
            )
        )
    );

    $wp_customize->add_setting(
        'theme_hero_concept',
        array(
            'default'           => '洗練された美食体験',
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );

    $wp_customize->add_control(
        'theme_hero_concept',
        array(
            'label'   => __( 'コンセプト', 'demo-site-design-restaurant' ),
            'section' => 'theme_hero',
            'type'    => 'textarea',
        )
    );

    $wp_customize->add_section(
        'theme_front_sections',
        array(
            'title'       => __( 'フロントページ（About・Gallery）', 'demo-site-design-restaurant' ),
            'description' => __( 'About と Gallery の文言・画像を編集できます。', 'demo-site-design-restaurant' ),
            'priority'    => 36,
        )
    );

    $wp_customize->add_setting(
        'theme_about_title',
        array(
            'default'           => '当店について',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'theme_about_title',
        array(
            'label'   => __( 'About 見出し', 'demo-site-design-restaurant' ),
            'section' => 'theme_front_sections',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'theme_about_text_1',
        array(
            'default'           => 'LUMIÈREは、伝統と革新が融合した新しい美食体験をお届けする高級レストランです。',
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );
    $wp_customize->add_control(
        'theme_about_text_1',
        array(
            'label'   => __( 'About 本文 1', 'demo-site-design-restaurant' ),
            'section' => 'theme_front_sections',
            'type'    => 'textarea',
        )
    );

    $wp_customize->add_setting(
        'theme_about_text_2',
        array(
            'default'           => '季節の厳選された食材を使い、シェフが一皿一皿丁寧に仕上げる料理は、視覚と味覚の両方を満たす芸術作品です。',
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );
    $wp_customize->add_control(
        'theme_about_text_2',
        array(
            'label'   => __( 'About 本文 2', 'demo-site-design-restaurant' ),
            'section' => 'theme_front_sections',
            'type'    => 'textarea',
        )
    );

    $wp_customize->add_setting(
        'theme_about_text_3',
        array(
            'default'           => '洗練された空間で、特別な時間をお過ごしください。',
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );
    $wp_customize->add_control(
        'theme_about_text_3',
        array(
            'label'   => __( 'About 本文 3', 'demo-site-design-restaurant' ),
            'section' => 'theme_front_sections',
            'type'    => 'textarea',
        )
    );

    $wp_customize->add_setting(
        'theme_about_image',
        array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'theme_about_image',
            array(
                'label'     => __( 'About 画像', 'demo-site-design-restaurant' ),
                'section'   => 'theme_front_sections',
                'mime_type' => 'image',
            )
        )
    );

    $wp_customize->add_setting(
        'theme_gallery_title',
        array(
            'default'           => 'ギャラリー',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'theme_gallery_title',
        array(
            'label'   => __( 'Gallery 見出し', 'demo-site-design-restaurant' ),
            'section' => 'theme_front_sections',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'theme_gallery_subtitle',
        array(
            'default'           => '洗練された空間と美しい料理の数々',
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );
    $wp_customize->add_control(
        'theme_gallery_subtitle',
        array(
            'label'   => __( 'Gallery サブテキスト', 'demo-site-design-restaurant' ),
            'section' => 'theme_front_sections',
            'type'    => 'textarea',
        )
    );

    for ( $i = 1; $i <= 6; $i++ ) {
        $setting_id = 'theme_gallery_image_' . $i;
        $wp_customize->add_setting(
            $setting_id,
            array(
                'default'           => 0,
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                $setting_id,
                array(
                    'label'     => sprintf(
                        /* translators: %d: gallery image number */
                        __( 'Gallery 画像 %d', 'demo-site-design-restaurant' ),
                        $i
                    ),
                    'section'   => 'theme_front_sections',
                    'mime_type' => 'image',
                )
            )
        );
    }

    $wp_customize->add_section(
        'theme_footer',
        array(
            'title'       => __( 'フッター', 'demo-site-design-restaurant' ),
            'description' => __( '住所・電話・メール・営業時間を編集できます。店名とキャッチコピーは「サイトのタイトル」とヒーローの「コンセプト」に合わせて表示されます。', 'demo-site-design-restaurant' ),
            'priority'    => 37,
        )
    );

    $wp_customize->add_setting(
        'theme_footer_address',
        array(
            'default'           => '東京都港区南青山1-1-1',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'theme_footer_address',
        array(
            'label'   => __( '住所', 'demo-site-design-restaurant' ),
            'section' => 'theme_footer',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'theme_footer_phone',
        array(
            'default'           => '03-1234-5678',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'theme_footer_phone',
        array(
            'label'       => __( '電話番号', 'demo-site-design-restaurant' ),
            'description' => __( '表示用のまま入力してください（tel: リンクは数字に正規化されます）。', 'demo-site-design-restaurant' ),
            'section'     => 'theme_footer',
            'type'        => 'text',
        )
    );

    $wp_customize->add_setting(
        'theme_footer_email',
        array(
            'default'           => 'info@lumiere.jp',
            'sanitize_callback' => 'sanitize_email',
        )
    );
    $wp_customize->add_control(
        'theme_footer_email',
        array(
            'label'   => __( 'メールアドレス', 'demo-site-design-restaurant' ),
            'section' => 'theme_footer',
            'type'    => 'email',
        )
    );

    $wp_customize->add_setting(
        'theme_footer_hours',
        array(
            'default'           => "ランチ: 11:30 - 15:00\nディナー: 18:00 - 22:00\nmt:定休日: 月曜日",
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );
    $wp_customize->add_control(
        'theme_footer_hours',
        array(
            'label'       => __( '営業時間', 'demo-site-design-restaurant' ),
            'description' => __( '1行に1項目。行頭に mt: を付けると上に余白が付きます（例: 定休日の行）。', 'demo-site-design-restaurant' ),
            'section'     => 'theme_footer',
            'type'        => 'textarea',
        )
    );
}
add_action( 'customize_register', 'theme_customize_register' );

/**
 * フッター「営業時間」行（カスタマイザーのテキストを解析）。
 *
 * @return array<int, array{line: string, class: string}>
 */
function theme_get_footer_hours_rows() {
    $default_raw = "ランチ: 11:30 - 15:00\nディナー: 18:00 - 22:00\nmt:定休日: 月曜日";
    $raw           = (string) get_theme_mod( 'theme_footer_hours', $default_raw );
    $lines         = preg_split( '/\r\n|\r|\n/', $raw );
    $rows          = array();

    foreach ( $lines as $line ) {
        $line = trim( $line );
        if ( '' === $line ) {
            continue;
        }
        $class = '';
        if ( preg_match( '/^mt:\s*(.+)$/u', $line, $m ) ) {
            $class = 'mt-2';
            $line  = $m[1];
        }
        $rows[] = array(
            'line'  => $line,
            'class' => $class,
        );
    }

    if ( empty( $rows ) ) {
        return array(
            array( 'line' => 'ランチ: 11:30 - 15:00', 'class' => '' ),
            array( 'line' => 'ディナー: 18:00 - 22:00', 'class' => '' ),
            array( 'line' => '定休日: 月曜日', 'class' => 'mt-2' ),
        );
    }

    return $rows;
}

/**
 * ヒーロー画像の URL（未設定時は React Home.tsx と同じデフォルト画像）。
 *
 * @return array{url: string, alt: string}
 */
function theme_get_hero_image_attrs() {
    $attachment_id = absint( get_theme_mod( 'theme_hero_image', 0 ) );
    $default_url   = 'https://images.unsplash.com/photo-1768697358705-c1b60333da35?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxyZXN0YXVyYW50JTIwaW50ZXJpb3IlMjBlbGVnYW50fGVufDF8fHx8MTc3NTAyMTI0MHww&ixlib=rb-4.1.0&q=80&w=1080';

    if ( $attachment_id && wp_attachment_is_image( $attachment_id ) ) {
        $src = wp_get_attachment_image_url( $attachment_id, 'full' );
        if ( $src ) {
            $alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
            if ( $alt === '' || $alt === false ) {
                $alt = get_bloginfo( 'name', 'display' );
            }
            return array(
                'url' => $src,
                'alt' => $alt,
            );
        }
    }

    return array(
        'url' => $default_url,
        'alt' => __( 'Elegant restaurant interior', 'demo-site-design-restaurant' ),
    );
}

/**
 * ブログ一覧ヒーロー画像（React Blog.tsx と同系統のデフォルト）。
 *
 * @return array{url: string, alt: string}
 */
function theme_get_blog_hero_image_attrs() {
    $default_url = 'https://images.unsplash.com/photo-1697659602792-31dcb2a5a4ec?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwzfHxjaGVmJTIwY29va2luZyUyMGtpdGNoZW58ZW58MXx8fHwxNzc1MDIxMjQ3fDA&ixlib=rb-4.1.0&q=80&w=1080';

    return array(
        'url' => $default_url,
        'alt' => __( 'Chef in kitchen', 'demo-site-design-restaurant' ),
    );
}

/**
 * 投稿者の公開表示名（ユーザー > プロフィールの「ブログ上の表示名」＝ display_name）。
 *
 * @param int|null $author_id ユーザー ID。省略時はループ中の投稿の投稿者。
 * @return string
 */
function theme_get_post_author_display_name( $author_id = null ) {
    if ( $author_id === null ) {
        $author_id = (int) get_the_author_meta( 'ID' );
    }
    if ( $author_id < 1 ) {
        return '';
    }
    $user = get_userdata( $author_id );
    if ( ! $user instanceof WP_User ) {
        return '';
    }
    $name = $user->display_name;
    return is_string( $name ) ? $name : '';
}

/**
 * 添付画像IDから URL と alt を取得（未設定時はデフォルトを返却）。
 *
 * @param int    $attachment_id 添付画像 ID。
 * @param string $default_url   未設定時の画像URL。
 * @param string $default_alt   未設定時の代替テキスト。
 * @return array{url: string, alt: string}
 */
function theme_get_image_attrs( $attachment_id, $default_url, $default_alt ) {
    $attachment_id = absint( $attachment_id );

    if ( $attachment_id && wp_attachment_is_image( $attachment_id ) ) {
        $src = wp_get_attachment_image_url( $attachment_id, 'full' );
        if ( $src ) {
            $alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
            if ( ! is_string( $alt ) || $alt === '' ) {
                $alt = get_bloginfo( 'name', 'display' );
            }
            return array(
                'url' => $src,
                'alt' => $alt,
            );
        }
    }

    return array(
        'url' => $default_url,
        'alt' => $default_alt,
    );
}

/**
 * About セクション画像属性。
 *
 * @return array{url: string, alt: string}
 */
function theme_get_about_image_attrs() {
    $default_url = 'https://images.unsplash.com/photo-1622021142947-da7dedc7c39a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwyfHxjaGVmJTIwY29va2luZyUyMGtpdGNoZW58ZW58MXx8fHwxNzc1MDIxMjQ3fDA&ixlib=rb-4.1.0&q=80&w=1080';
    $default_alt = __( 'Chef presenting dish', 'demo-site-design-restaurant' );
    return theme_get_image_attrs( get_theme_mod( 'theme_about_image', 0 ), $default_url, $default_alt );
}

/**
 * Gallery セクションの画像一覧。
 *
 * @return array<int, array{url: string, alt: string}>
 */
function theme_get_gallery_images() {
    $defaults = array(
        array(
            'url' => 'https://images.unsplash.com/photo-1768051297578-1ea70392c307?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwyfHxyZXN0YXVyYW50JTIwaW50ZXJpb3IlMjBlbGVnYW50fGVufDF8fHx8MTc3NTAyMTI0MHww&ixlib=rb-4.1.0&q=80&w=1080',
            'alt' => __( 'Elegant chandeliers', 'demo-site-design-restaurant' ),
        ),
        array(
            'url' => 'https://images.unsplash.com/photo-1771574205963-0c1d84ac7354?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwzfHxyZXN0YXVyYW50JTIwaW50ZXJpb3IlMjBlbGVnYW50fGVufDF8fHx8MTc3NTAyMTI0MHww&ixlib=rb-4.1.0&q=80&w=1080',
            'alt' => __( 'Modern restaurant interior', 'demo-site-design-restaurant' ),
        ),
        array(
            'url' => 'https://images.unsplash.com/photo-1756397481872-ed981ef72a51?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHw0fHxyZXN0YXVyYW50JTIwaW50ZXJpb3IlMjBlbGVnYW50fGVufDF8fHx8MTc3NTAyMTI0MHww&ixlib=rb-4.1.0&q=80&w=1080',
            'alt' => __( 'Restaurant table setting', 'demo-site-design-restaurant' ),
        ),
        array(
            'url' => 'https://images.unsplash.com/photo-1758648207365-df458d3e83f4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHw1fHxyZXN0YXVyYW50JTIwaW50ZXJpb3IlMjBlbGVnYW50fGVufDF8fHx8MTc3NTAyMTI0MHww&ixlib=rb-4.1.0&q=80&w=1080',
            'alt' => __( 'Indoor garden dining', 'demo-site-design-restaurant' ),
        ),
        array(
            'url' => 'https://images.unsplash.com/photo-1697659602792-31dcb2a5a4ec?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwzfHxjaGVmJTIwY29va2luZyUyMGtpdGNoZW58ZW58MXx8fHwxNzc1MDIxMjQ3fDA&ixlib=rb-4.1.0&q=80&w=1080',
            'alt' => __( 'Chef preparing dish', 'demo-site-design-restaurant' ),
        ),
        array(
            'url' => 'https://images.unsplash.com/photo-1740727665746-cfe80ababc23?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjaGVmJTIwY29va2luZyUyMGtpdGNoZW58ZW58MXx8fHwxNzc1MDIxMjQ3fDA&ixlib=rb-4.1.0&q=80&w=1080',
            'alt' => __( 'Culinary preparation', 'demo-site-design-restaurant' ),
        ),
    );

    $images = array();
    foreach ( $defaults as $index => $default ) {
        $setting_id = 'theme_gallery_image_' . ( $index + 1 );
        $images[]   = theme_get_image_attrs( get_theme_mod( $setting_id, 0 ), $default['url'], $default['alt'] );
    }

    return $images;
}

/**
 * ブランド表示用アイコン URL（カスタマイザーのサイトアイコン、未設定時はテーマの logo.svg）。
 *
 * @param int $size サイトアイコン要求サイズ（px）。
 * @return string
 */
function theme_get_brand_icon_url( $size = 192 ) {
    return has_site_icon()
        ? get_site_icon_url( $size )
        : get_theme_file_uri( '/images/logo.svg' );
}

/**
 * ヘッダーナビ（React Header.tsx と同じ3項目）の URL・ラベル・アクティブ状態。
 *
 * @return array<int, array{url: string, label: string, active: bool}>
 */
function theme_get_header_nav_items() {
    $page_for_posts = (int) get_option( 'page_for_posts' );
    $blog_url       = $page_for_posts > 0
        ? get_permalink( $page_for_posts )
        : home_url( '/blog/' );

    $items = array(
        array(
            'url'    => home_url( '/' ),
            'label'  => __( 'ホーム', 'demo-site-design-restaurant' ),
            'active' => is_front_page(),
        ),
        array(
            'url'    => theme_get_menu_archive_url(),
            'label'  => __( 'メニュー', 'demo-site-design-restaurant' ),
            'active' => theme_is_menu_nav_active(),
        ),
        array(
            'url'    => $blog_url,
            'label'  => __( 'ブログ', 'demo-site-design-restaurant' ),
            'active' => theme_is_header_blog_nav_active(),
        ),
    );

    return $items;
}

/**
 * ブログナビのアクティブ（投稿・投稿一覧・ブログ用固定ページなど）。
 */
function theme_is_header_blog_nav_active() {
    if ( is_singular( 'post' ) ) {
        return true;
    }
    if ( is_home() && ! is_front_page() ) {
        return true;
    }
    if ( is_category() || is_tag() || is_date() || is_author() ) {
        return true;
    }
    return false;
}
