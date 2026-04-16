<?php
/**
 * サイト配色（外観 → カスタマイズ）。
 *
 * @package demo-site-design-restaurant
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 初期配色（現行 Tailwind ユーティリティ相当）。
 *
 * @return array<string, string|int>
 */
function theme_get_color_defaults() {
	return array(
		'theme_color_header_base'     => '#ffffff',
		'theme_color_header_opacity'  => 95,
		'theme_color_bg_page'         => '#ffffff',
		'theme_color_bg_muted'        => '#f9fafb',
		'theme_color_footer_bg'       => '#000000',
		'theme_color_text_inverse'    => '#ffffff',
		'theme_color_text_strong'     => '#000000',
		'theme_color_text_body'       => '#000000',
		'theme_color_text_sub'        => '#000000',
		'theme_color_text_soft'       => '#7a7a7a',
		'theme_color_silk_wave'       => '#ffffff',
	);
}

/**
 * @param string $hex #rrggbb
 * @param float  $alpha 0..1
 * @return string
 */
function theme_hex_to_rgba( $hex, $alpha ) {
	$hex = is_string( $hex ) ? sanitize_hex_color( $hex ) : '';
	if ( ! is_string( $hex ) || $hex === '' ) {
		return 'rgba(255,255,255,0.95)';
	}
	$h       = ltrim( $hex, '#' );
	$length  = strlen( $h );
	$expand3 = static function ( $s ) {
		return $s[0] . $s[0] . $s[1] . $s[1] . $s[2] . $s[2];
	};
	if ( $length === 3 ) {
		$h = $expand3( $h );
	}
	if ( strlen( $h ) !== 6 ) {
		return 'rgba(255,255,255,0.95)';
	}
	$r   = hexdec( substr( $h, 0, 2 ) );
	$g   = hexdec( substr( $h, 2, 2 ) );
	$b   = hexdec( substr( $h, 4, 2 ) );
	$alpha = max( 0.0, min( 1.0, (float) $alpha ) );
	return sprintf( 'rgba(%d,%d,%d,%s)', $r, $g, $b, $alpha );
}

/**
 * @param string               $key Setting key.
 * @param string|int|float|null $fallback Default.
 * @return string|int
 */
function theme_get_color_mod( $key, $fallback ) {
	$val = get_theme_mod( $key, $fallback );
	if ( $val === null || $val === '' ) {
		return $fallback;
	}
	return $val;
}

/**
 * @return string
 */
function theme_build_color_inline_css() {
	$d  = theme_get_color_defaults();
	$hb = (string) theme_get_color_mod( 'theme_color_header_base', $d['theme_color_header_base'] );
	$ho = (int) theme_get_color_mod( 'theme_color_header_opacity', $d['theme_color_header_opacity'] );
	$ho = max( 0, min( 100, $ho ) );

	$header_rgba = theme_hex_to_rgba( $hb, $ho / 100.0 );

	$bg_page   = sanitize_hex_color( (string) theme_get_color_mod( 'theme_color_bg_page', $d['theme_color_bg_page'] ) );
	$bg_muted  = sanitize_hex_color( (string) theme_get_color_mod( 'theme_color_bg_muted', $d['theme_color_bg_muted'] ) );
	$footer_bg = sanitize_hex_color( (string) theme_get_color_mod( 'theme_color_footer_bg', $d['theme_color_footer_bg'] ) );

	$text_inv   = sanitize_hex_color( (string) theme_get_color_mod( 'theme_color_text_inverse', $d['theme_color_text_inverse'] ) );
	$text_str   = sanitize_hex_color( (string) theme_get_color_mod( 'theme_color_text_strong', $d['theme_color_text_strong'] ) );
	$text_body  = sanitize_hex_color( (string) theme_get_color_mod( 'theme_color_text_body', $d['theme_color_text_body'] ) );
	$text_sub   = sanitize_hex_color( (string) theme_get_color_mod( 'theme_color_text_sub', $d['theme_color_text_sub'] ) );
	$text_soft  = sanitize_hex_color( (string) theme_get_color_mod( 'theme_color_text_soft', $d['theme_color_text_soft'] ) );
	$silk_wave  = sanitize_hex_color( (string) theme_get_color_mod( 'theme_color_silk_wave', $d['theme_color_silk_wave'] ) );

	if ( ! $bg_page ) {
		$bg_page = (string) $d['theme_color_bg_page'];
	}
	if ( ! $bg_muted ) {
		$bg_muted = (string) $d['theme_color_bg_muted'];
	}
	if ( ! $footer_bg ) {
		$footer_bg = (string) $d['theme_color_footer_bg'];
	}
	if ( ! $text_inv ) {
		$text_inv = (string) $d['theme_color_text_inverse'];
	}
	if ( ! $text_str ) {
		$text_str = (string) $d['theme_color_text_strong'];
	}
	if ( ! $text_body ) {
		$text_body = (string) $d['theme_color_text_body'];
	}
	if ( ! $text_sub ) {
		$text_sub = (string) $d['theme_color_text_sub'];
	}
	if ( ! $text_soft ) {
		$text_soft = (string) $d['theme_color_text_soft'];
	}
	if ( ! $silk_wave ) {
		$silk_wave = (string) $d['theme_color_silk_wave'];
	}

	$css = ':root{'
		. '--theme-header-bg:' . esc_attr( $header_rgba ) . ';'
		. '--theme-bg-page:' . esc_attr( $bg_page ) . ';'
		. '--theme-bg-muted:' . esc_attr( $bg_muted ) . ';'
		. '--theme-footer-bg:' . esc_attr( $footer_bg ) . ';'
		. '--theme-text-inverse:' . esc_attr( $text_inv ) . ';'
		. '--theme-text-strong:' . esc_attr( $text_str ) . ';'
		. '--theme-text-body:' . esc_attr( $text_body ) . ';'
		. '--theme-text-sub:' . esc_attr( $text_sub ) . ';'
		. '--theme-text-soft:' . esc_attr( $text_soft ) . ';'
		. '--theme-silk-wave:' . esc_attr( $silk_wave ) . ';'
		. '}'
		. 'body.antialiased.theme-body-bg{background-color:var(--theme-bg-page);}'
		. '.theme-surface-header{background-color:var(--theme-header-bg);}'
		. '.theme-bg-page{background-color:var(--theme-bg-page);}'
		. '.theme-bg-muted{background-color:var(--theme-bg-muted);}'
		. '.theme-bg-footer{background-color:var(--theme-footer-bg);}'
		. '.theme-text-strong{color:var(--theme-text-strong);}'
		. '.theme-text-body{color:var(--theme-text-body);}'
		. '.theme-text-sub{color:var(--theme-text-sub);}'
		. '.theme-text-soft{color:var(--theme-text-soft);}'
		. '.theme-text-inverse{color:var(--theme-text-inverse);}'
		. '.theme-shell-footer{background-color:var(--theme-footer-bg);color:var(--theme-text-inverse);}'
		. '.theme-text-on-footer-muted{color:var(--theme-text-soft);}'
		. '.theme-shell-footer a.theme-link-on-inverse:hover{color:var(--theme-text-inverse);}'
		. '.theme-nav-link{color:var(--theme-text-sub);transition:color .15s ease;}'
		. '.theme-nav-link:hover,.theme-nav-link[aria-current="page"]{color:var(--theme-text-strong);}'
		. '.theme-cta-pill{background-color:var(--theme-bg-page);color:var(--theme-text-strong);}'
		. '.theme-hover-bg-muted:hover{background-color:var(--theme-bg-muted);}'
		. 'a.theme-link-subtle-hover:hover{color:var(--theme-text-sub);}'
		. '.theme-opacity-95{opacity:0.95;}';

	return $css;
}

/**
 * @return void
 */
function theme_enqueue_color_variables() {
	if ( ! wp_style_is( 'theme-tailwind', 'enqueued' ) ) {
		return;
	}
	$css = theme_build_color_inline_css();
	if ( $css !== '' ) {
		wp_add_inline_style( 'theme-tailwind', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_color_variables', 25 );

/**
 * @param WP_Customize_Manager $wp_customize Manager.
 * @return void
 */
function theme_customize_register_colors( $wp_customize ) {
	if ( ! class_exists( 'WP_Customize_Control', false ) ) {
		return;
	}

	if ( ! class_exists( 'Theme_Customize_Palette_Reset_Control', false ) ) {
		/**
		 * カスタマイザー用「配色を初期化する」ボタン。
		 */
		class Theme_Customize_Palette_Reset_Control extends WP_Customize_Control {
			/**
			 * @var string
			 */
			public $type = 'theme_palette_reset';

			/**
			 * @return void
			 */
			public function render_content() {
				?>
				<p>
					<button type="button" class="button js-theme-reset-palette"><?php esc_html_e( '配色を初期化する', 'demo-site-design-restaurant' ); ?></button>
				</p>
				<?php if ( $this->description ) : ?>
					<p class="description"><?php echo wp_kses_post( $this->description ); ?></p>
				<?php endif; ?>
				<?php
			}
		}
	}

	$d = theme_get_color_defaults();

	$wp_customize->add_section(
		'theme_colors',
		array(
			'title'       => __( '配色', 'demo-site-design-restaurant' ),
			'description' => __( 'ヘッダー・本文・フッターの背景色と、主要な文字色を変更できます。', 'demo-site-design-restaurant' ),
			'priority'    => 33,
		)
	);

	$wp_customize->add_setting(
		'theme_color_header_base',
		array(
			'default'           => $d['theme_color_header_base'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_color_header_base',
			array(
				'label'       => __( 'ヘッダー・ローダー背景のベース色', 'demo-site-design-restaurant' ),
				'description' => __( '従来の bg-white/95 の「白」に相当します。不透明度は下のスライダーで調整します。', 'demo-site-design-restaurant' ),
				'section'     => 'theme_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_color_header_opacity',
		array(
			'default'           => $d['theme_color_header_opacity'],
			'sanitize_callback' => 'theme_sanitize_color_header_opacity',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'theme_color_header_opacity',
		array(
			'label'       => __( 'ヘッダー・ローダー背景の不透明度（%）', 'demo-site-design-restaurant' ),
			'section'     => 'theme_colors',
			'type'        => 'range',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'theme_color_bg_page',
		array(
			'default'           => $d['theme_color_bg_page'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_color_bg_page',
			array(
				'label'   => __( '背景', 'demo-site-design-restaurant' ),
				'section' => 'theme_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_color_bg_muted',
		array(
			'default'           => $d['theme_color_bg_muted'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_color_bg_muted',
			array(
				'label'   => __( '背景（サブ）', 'demo-site-design-restaurant' ),
				'section' => 'theme_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_color_footer_bg',
		array(
			'default'           => $d['theme_color_footer_bg'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_color_footer_bg',
			array(
				'label'   => __( '背景（Hero・Footer相当）', 'demo-site-design-restaurant' ),
				'section' => 'theme_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_color_text_inverse',
		array(
			'default'           => $d['theme_color_text_inverse'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_color_text_inverse',
			array(
				'label'   => __( '文字色（逆色（Header・Loading））', 'demo-site-design-restaurant' ),
				'section' => 'theme_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_color_text_strong',
		array(
			'default'           => $d['theme_color_text_strong'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_color_text_strong',
			array(
				'label'   => __( '文字色（強調）', 'demo-site-design-restaurant' ),
				'section' => 'theme_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_color_text_body',
		array(
			'default'           => $d['theme_color_text_body'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_color_text_body',
			array(
				'label'   => __( '文字色（本文（段落））', 'demo-site-design-restaurant' ),
				'section' => 'theme_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_color_text_sub',
		array(
			'default'           => $d['theme_color_text_sub'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_color_text_sub',
			array(
				'label'   => __( '文字色（補助（サブテキスト））', 'demo-site-design-restaurant' ),
				'section' => 'theme_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_color_text_soft',
		array(
			'default'           => $d['theme_color_text_soft'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_color_text_soft',
			array(
				'label'   => __( '文字色（淡色（控えめ表示））', 'demo-site-design-restaurant' ),
				'section' => 'theme_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_color_silk_wave',
		array(
			'default'           => $d['theme_color_silk_wave'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_color_silk_wave',
			array(
				'label'       => __( 'シルク波の色', 'demo-site-design-restaurant' ),
				'description' => __( '固定背景のシルク波の色を変更します。', 'demo-site-design-restaurant' ),
				'section'     => 'theme_colors',
			)
		)
	);

	$wp_customize->add_setting( 'theme_color_reset_stub', array( 'sanitize_callback' => '__return_empty_string' ) );
	$wp_customize->add_control(
		new Theme_Customize_Palette_Reset_Control(
			$wp_customize,
			'theme_color_reset_stub',
			array(
				'label'       => __( '配色の初期化', 'demo-site-design-restaurant' ),
				'description' => __( '保存済みの配色を破棄し、テーマ同梱の初期配色に戻します（公開前に「公開する」で確定）。', 'demo-site-design-restaurant' ),
				'section'     => 'theme_colors',
			)
		)
	);
}
add_action( 'customize_register', 'theme_customize_register_colors', 15 );

/**
 * @param mixed $value Raw.
 * @return int
 */
function theme_sanitize_color_header_opacity( $value ) {
	$n = absint( $value );
	if ( $n > 100 ) {
		return 100;
	}
	return $n;
}

/**
 * @return void
 */
function theme_color_reset_customize_footer_script() {
	$defaults = theme_get_color_defaults();
	?>
	<script>
	(function($){
		var defaults = <?php echo wp_json_encode( $defaults ); ?>;
		wp.customize.bind('ready', function(){
			$(document).on('click', '.js-theme-reset-palette', function(e){
				e.preventDefault();
				if (!window.confirm(<?php echo wp_json_encode( __( '配色をテーマの初期状態に戻しますか？', 'demo-site-design-restaurant' ) ); ?>)) {
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
add_action( 'customize_controls_print_footer_scripts', 'theme_color_reset_customize_footer_script' );
