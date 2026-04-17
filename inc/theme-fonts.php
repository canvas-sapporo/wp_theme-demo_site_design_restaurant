<?php
/**
 * Google Fonts（日本語対応のみ）— 外観 → カスタマイズ「フォント」
 *
 * @package demo-site-design-restaurant
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 既定のフォントスラッグ（Zen Kaku Gothic New）。
 *
 * @return string
 */
function theme_get_default_font_slug() {
	return 'zen-kaku-gothic-new';
}

/**
 * フォント設定の初期値。
 *
 * @return array<string, string>
 */
function theme_get_font_defaults() {
	$d = theme_get_default_font_slug();
	return array(
		'theme_font_header_title' => 'shippori-antique-b1',
		'theme_font_hero_title'   => 'shippori-antique-b1',
		'theme_font_hero_concept' => $d,
		'theme_font_button'      => $d,
		'theme_font_link'        => $d,
		'theme_font_title'       => $d,
		'theme_font_heading'     => $d,
		'theme_font_body'        => $d,
	);
}

/**
 * 日本語向け Google Fonts のホワイトリスト。
 *
 * 各キーは theme_mod に保存する値。google は CSS2 の family= パラメータ用（URL エンコード済み想定の断片）。
 *
 * @return array<string, array{label:string,family:string,google:string}>
 */
function theme_get_font_registry() {
	return array(
		'shippori-antique-b1' => array(
			'label'  => 'Shippori Antique B1',
			'family' => '"Shippori Antique B1"',
			'google' => 'Shippori+Antique+B1:wght@400;500;600;700',
		),
		'noto-sans-jp'        => array(
			'label'  => 'Noto Sans JP',
			'family' => '"Noto Sans JP"',
			'google' => 'Noto+Sans+JP:wght@400;500;600;700',
		),
		'noto-serif-jp'       => array(
			'label'  => 'Noto Serif JP',
			'family' => '"Noto Serif JP"',
			'google' => 'Noto+Serif+JP:wght@400;500;600;700',
		),
		'm-plus-1p'           => array(
			'label'  => 'M PLUS 1p',
			'family' => '"M PLUS 1p"',
			'google' => 'M+PLUS+1p:wght@400;500;700',
		),
		'm-plus-rounded-1c'   => array(
			'label'  => 'M PLUS Rounded 1c',
			'family' => '"M PLUS Rounded 1c"',
			'google' => 'M+PLUS+Rounded+1c:wght@400;500;700',
		),
		'zen-kaku-gothic-new' => array(
			'label'  => 'Zen Kaku Gothic New',
			'family' => '"Zen Kaku Gothic New"',
			'google' => 'Zen+Kaku+Gothic+New:wght@400;500;700',
		),
		'zen-maru-gothic'     => array(
			'label'  => 'Zen Maru Gothic',
			'family' => '"Zen Maru Gothic"',
			'google' => 'Zen+Maru+Gothic:wght@400;500;700',
		),
		'zen-old-mincho'      => array(
			'label'  => 'Zen Old Mincho',
			'family' => '"Zen Old Mincho"',
			'google' => 'Zen+Old+Mincho:wght@400;500;600;700',
		),
		'shippori-mincho'     => array(
			'label'  => 'Shippori Mincho',
			'family' => '"Shippori Mincho"',
			'google' => 'Shippori+Mincho:wght@400;500;600;700',
		),
		'yuji-syuku'          => array(
			'label'  => 'Yuji Syuku',
			'family' => '"Yuji Syuku"',
			'google' => 'Yuji+Syuku:wght@400;500;600;700',
		),
		'kaisei-decol'        => array(
			'label'  => 'Kaisei Decol',
			'family' => '"Kaisei Decol"',
			'google' => 'Kaisei+Decol:wght@400;500;700',
		),
		'dela-gothic-one'     => array(
			'label'  => 'Dela Gothic One',
			'family' => '"Dela Gothic One"',
			'google' => 'Dela+Gothic+One:wght@400',
		),
		'dotgothic16'         => array(
			'label'  => 'DotGothic16',
			'family' => '"DotGothic16"',
			'google' => 'DotGothic16:wght@400',
		),
	);
}

/**
 * @param mixed $value Raw theme_mod.
 * @return string
 */
function theme_sanitize_font_choice( $value ) {
	$r = theme_get_font_registry();
	if ( is_string( $value ) && isset( $r[ $value ] ) ) {
		return $value;
	}
	return theme_get_default_font_slug();
}

/**
 * @param string $slug Slug.
 * @return string font-family 用（フォールバック付き）
 */
function theme_get_font_stack_for_slug( $slug ) {
	$r    = theme_get_font_registry();
	$slug = theme_sanitize_font_choice( $slug );
	$fam  = $r[ $slug ]['family'];
	return $fam . ', "Hiragino Kaku Gothic ProN", "Hiragino Sans", Meiryo, sans-serif';
}

/**
 * 読み込む Google Fonts の URL（重複ファミリーは1つにまとめる）。
 *
 * @return string
 */
function theme_get_google_fonts_url() {
	$r       = theme_get_font_registry();
	$default = theme_get_default_font_slug();
	$defaults = theme_get_font_defaults();
	$mods    = array(
		get_theme_mod( 'theme_font_header_title', $defaults['theme_font_header_title'] ?? $default ),
		get_theme_mod( 'theme_font_hero_title', $defaults['theme_font_hero_title'] ?? $default ),
		get_theme_mod( 'theme_font_hero_concept', $defaults['theme_font_hero_concept'] ?? $default ),
		get_theme_mod( 'theme_font_button', $defaults['theme_font_button'] ?? $default ),
		get_theme_mod( 'theme_font_link', $defaults['theme_font_link'] ?? $default ),
		get_theme_mod( 'theme_font_title', $defaults['theme_font_title'] ?? $default ),
		get_theme_mod( 'theme_font_heading', $defaults['theme_font_heading'] ?? $default ),
		get_theme_mod( 'theme_font_body', $defaults['theme_font_body'] ?? $default ),
	);

	$google_params = array();
	foreach ( $mods as $mod ) {
		$slug = theme_sanitize_font_choice( $mod );
		if ( isset( $r[ $slug ]['google'] ) ) {
			$google_params[ $r[ $slug ]['google'] ] = true;
		}
	}

	if ( empty( $google_params ) ) {
		return '';
	}

	$parts = array();
	foreach ( array_keys( $google_params ) as $param ) {
		$parts[] = 'family=' . $param;
	}
	$parts[] = 'display=swap';

	return 'https://fonts.googleapis.com/css2?' . implode( '&', $parts );
}

/**
 * Google Fonts の URL を検証する（wp_enqueue_style 出力時に esc_url がかかる前提で、
 * esc_url_raw はクエリ内の ; を除去して CSS2 の wght@400;700 を壊すことがあるため使わない）。
 *
 * @param string $url URL.
 * @return string 安全でない場合は空文字。
 */
function theme_sanitize_google_fonts_css2_url( $url ) {
	if ( ! is_string( $url ) || $url === '' ) {
		return '';
	}
	if ( strpos( $url, 'https://fonts.googleapis.com/css2' ) !== 0 ) {
		return '';
	}
	return $url;
}

/**
 * @return void
 */
function theme_enqueue_google_fonts() {
	$url = theme_sanitize_google_fonts_css2_url( theme_get_google_fonts_url() );
	if ( $url === '' ) {
		return;
	}
	wp_enqueue_style(
		'theme-google-fonts',
		$url,
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_google_fonts', 5 );

/**
 * @param array<int, array<string, mixed>> $urls          URLs.
 * @param string                            $relation_type Relation.
 * @return array<int, array<string, mixed>>
 */
function theme_fonts_resource_hints( $urls, $relation_type ) {
	if ( $relation_type !== 'preconnect' ) {
		return $urls;
	}
	$url = theme_get_google_fonts_url();
	if ( $url === '' ) {
		return $urls;
	}
	$urls[] = array(
		'href' => 'https://fonts.googleapis.com',
	);
	$urls[] = array(
		'href'        => 'https://fonts.gstatic.com',
		'crossorigin' => 'anonymous',
	);
	return $urls;
}
add_filter( 'wp_resource_hints', 'theme_fonts_resource_hints', 10, 2 );

/**
 * @return string
 */
function theme_build_font_inline_css() {
	$d = theme_get_default_font_slug();
	$defaults = theme_get_font_defaults();

	$h_header   = theme_get_font_stack_for_slug( (string) get_theme_mod( 'theme_font_header_title', $defaults['theme_font_header_title'] ?? $d ) );
	$h_hero     = theme_get_font_stack_for_slug( (string) get_theme_mod( 'theme_font_hero_title', $defaults['theme_font_hero_title'] ?? $d ) );
	$h_concept  = theme_get_font_stack_for_slug( (string) get_theme_mod( 'theme_font_hero_concept', $defaults['theme_font_hero_concept'] ?? $d ) );
	$h_button   = theme_get_font_stack_for_slug( (string) get_theme_mod( 'theme_font_button', $defaults['theme_font_button'] ?? $d ) );
	$h_link     = theme_get_font_stack_for_slug( (string) get_theme_mod( 'theme_font_link', $defaults['theme_font_link'] ?? $d ) );
	$h_title    = theme_get_font_stack_for_slug( (string) get_theme_mod( 'theme_font_title', $defaults['theme_font_title'] ?? $d ) );
	$h_heading  = theme_get_font_stack_for_slug( (string) get_theme_mod( 'theme_font_heading', $defaults['theme_font_heading'] ?? $d ) );
	$h_body     = theme_get_font_stack_for_slug( (string) get_theme_mod( 'theme_font_body', $defaults['theme_font_body'] ?? $d ) );

	$css = ':root{'
		. '--theme-font-header-title:' . $h_header . ';'
		. '--theme-font-hero-title:' . $h_hero . ';'
		. '--theme-font-hero-concept:' . $h_concept . ';'
		. '--theme-font-button:' . $h_button . ';'
		. '--theme-font-link:' . $h_link . ';'
		. '--theme-font-title:' . $h_title . ';'
		. '--theme-font-heading:' . $h_heading . ';'
		. '--theme-font-body:' . $h_body . ';'
		. '}'
		. 'body.antialiased.theme-body-bg{font-family:var(--theme-font-body);}'
		. 'a.theme-font-header-title,.theme-font-header-title{font-family:var(--theme-font-header-title);}'
		. '.theme-font-hero-title{font-family:var(--theme-font-hero-title);}'
		. '.theme-font-hero-concept{font-family:var(--theme-font-hero-concept);}'
		. '.theme-font-button,.theme-font-button *{font-family:var(--theme-font-button);}'
		. '.theme-font-title{font-family:var(--theme-font-title);}'
		. '.theme-font-heading{font-family:var(--theme-font-heading);}'
		. 'a.theme-nav-link,.theme-shell-footer a.theme-link-on-inverse,.theme-shell-footer a[href^="tel:"],.theme-shell-footer a[href^="mailto:"],'
		. '.entry-content a,.post-content a,a.theme-link-subtle-hover,nav.navigation.pagination a,a.page-numbers,a.theme-font-link-inline'
		. '{font-family:var(--theme-font-link);}';

	return $css;
}

/**
 * @return void
 */
function theme_enqueue_font_variables() {
	if ( ! wp_style_is( 'theme-tailwind', 'enqueued' ) ) {
		return;
	}
	$css = theme_build_font_inline_css();
	if ( $css !== '' ) {
		wp_add_inline_style( 'theme-tailwind', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_font_variables', 26 );

/**
 * @param WP_Customize_Manager $wp_customize Manager.
 * @return void
 */
function theme_customize_register_fonts( $wp_customize ) {
	if ( ! class_exists( 'WP_Customize_Control', false ) ) {
		return;
	}

	if ( ! class_exists( 'Theme_Customize_Fonts_Reset_Control', false ) ) {
		/**
		 * カスタマイザー用「フォントを初期化する」ボタン。
		 */
		class Theme_Customize_Fonts_Reset_Control extends WP_Customize_Control {
			/**
			 * @var string
			 */
			public $type = 'theme_fonts_reset';

			/**
			 * @return void
			 */
			public function render_content() {
				?>
				<p>
					<button type="button" class="button js-theme-reset-fonts"><?php esc_html_e( 'フォントを初期化する', 'demo-site-design-restaurant' ); ?></button>
				</p>
				<?php if ( $this->description ) : ?>
					<p class="description"><?php echo wp_kses_post( $this->description ); ?></p>
				<?php endif; ?>
				<?php
			}
		}
	}

	$default  = theme_get_default_font_slug();
	$defaults = theme_get_font_defaults();
	$r       = theme_get_font_registry();
	$choices = array();
	foreach ( $r as $slug => $data ) {
		$choices[ $slug ] = $data['label'];
	}

	$wp_customize->add_section(
		'theme_fonts',
		array(
			'title'       => __( 'フォント', 'demo-site-design-restaurant' ),
			'description' => __( '日本語に対応した Google Fonts から選べます。用途ごとにフォントを変えられます。', 'demo-site-design-restaurant' ),
			'priority'    => 32,
		)
	);

	$defs = array(
		'theme_font_header_title'   => __( 'ヘッダーのサイト名', 'demo-site-design-restaurant' ),
		'theme_font_hero_title'     => __( 'ヒーローのタイトル（サイト名など）', 'demo-site-design-restaurant' ),
		'theme_font_hero_concept'   => __( 'ヒーローのコンセプト文', 'demo-site-design-restaurant' ),
		'theme_font_button'         => __( 'ボタン', 'demo-site-design-restaurant' ),
		'theme_font_link'           => __( 'リンク（ナビ・本文・フッター・ページネーションなど）', 'demo-site-design-restaurant' ),
		'theme_font_title'          => __( 'タイトル（記事・メニュー品名など）', 'demo-site-design-restaurant' ),
		'theme_font_heading'        => __( '見出し（セクション見出し・フッター見出しなど）', 'demo-site-design-restaurant' ),
		'theme_font_body'           => __( '本文・本文周りのベース', 'demo-site-design-restaurant' ),
	);

	foreach ( $defs as $setting_id => $label ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $defaults[ $setting_id ] ?? $default,
				'sanitize_callback' => 'theme_sanitize_font_choice',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'label'   => $label,
				'section' => 'theme_fonts',
				'type'    => 'select',
				'choices' => $choices,
			)
		);
	}

	$wp_customize->add_setting( 'theme_font_reset_stub', array( 'sanitize_callback' => '__return_empty_string' ) );
	$wp_customize->add_control(
		new Theme_Customize_Fonts_Reset_Control(
			$wp_customize,
			'theme_font_reset_stub',
			array(
				'label'       => __( 'フォントの初期化', 'demo-site-design-restaurant' ),
				'description' => __( '保存済みのフォント選択を破棄し、用途ごとの初期フォントに戻します（「公開」で確定）。', 'demo-site-design-restaurant' ),
				'section'     => 'theme_fonts',
			)
		)
	);
}
add_action( 'customize_register', 'theme_customize_register_fonts', 14 );

/**
 * @return void
 */
function theme_font_reset_customize_footer_script() {
	$defaults = theme_get_font_defaults();
	?>
	<script>
	(function($){
		var defaults = <?php echo wp_json_encode( $defaults ); ?>;
		wp.customize.bind('ready', function(){
			$(document).on('click', '.js-theme-reset-fonts', function(e){
				e.preventDefault();
				if (!window.confirm(<?php echo wp_json_encode( __( 'フォントをテーマの初期状態に戻しますか？', 'demo-site-design-restaurant' ) ); ?>)) {
					return;
				}
				Object.keys(defaults).forEach(function(key){
					wp.customize(key, function(setting){
						setting.set(defaults[key]);
					});
				});
			});
		});
	})(jQuery);
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'theme_font_reset_customize_footer_script' );
