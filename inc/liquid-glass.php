<?php
/**
 * Apple 風リキッドグラス（画像ラッパー用 SVG フィルター + マークアップ補助）。
 *
 * @package demo-site-design-restaurant
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * feDisplacementMap 用フィルター（本文末に1回だけ出力）。
 *
 * @return void
 */
function theme_liquid_glass_print_svg_filter() {
	if ( is_admin() ) {
		return;
	}
	?>
	<svg class="liquid-glass-svg-defs" aria-hidden="true" focusable="false" width="0" height="0" style="position:absolute;overflow:hidden;clip:rect(0,0,0,0)">
		<filter id="glass-distortion" x="0%" y="0%" width="100%" height="100%" filterUnits="objectBoundingBox">
			<feTurbulence type="fractalNoise" baseFrequency="0.01 0.01" numOctaves="1" seed="5" result="turbulence" />
			<feComponentTransfer in="turbulence" result="mapped">
				<feFuncR type="gamma" amplitude="1" exponent="10" offset="0.5" />
				<feFuncG type="gamma" amplitude="0" exponent="1" offset="0" />
				<feFuncB type="gamma" amplitude="0" exponent="1" offset="0.5" />
			</feComponentTransfer>
			<feGaussianBlur in="turbulence" stdDeviation="3" result="softMap" />
			<feSpecularLighting in="softMap" surfaceScale="5" specularConstant="1" specularExponent="100" lighting-color="white" result="specLight">
				<fePointLight x="-200" y="-200" z="300" />
			</feSpecularLighting>
			<feComposite in="specLight" operator="arithmetic" k1="0" k2="1" k3="1" k4="0" result="litImage" />
			<feDisplacementMap in="SourceGraphic" in2="softMap" scale="55" xChannelSelector="R" yChannelSelector="G" />
		</filter>
	</svg>
	<?php
}
add_action( 'wp_footer', 'theme_liquid_glass_print_svg_filter', 5 );

/**
 * リキッドグラス開始タグ（中に img 等を置き、theme_liquid_glass_close で閉じる）。
 *
 * @param array<string, string> $args {
 *     @type string $class 追加クラス（wrapper に付与）。
 * }
 * @return void
 */
function theme_liquid_glass_open( $args = array() ) {
	$class = '';
	if ( isset( $args['class'] ) && is_string( $args['class'] ) ) {
		$class = ' ' . esc_attr( trim( $args['class'] ) );
	}
	echo '<div class="liquidGlass-wrapper' . $class . '">';
	echo '<div class="liquidGlass-effect" aria-hidden="true"></div>';
	echo '<div class="liquidGlass-tint" aria-hidden="true"></div>';
	echo '<div class="liquidGlass-shine" aria-hidden="true"></div>';
	echo '<div class="liquidGlass-text liquidGlass-text--media">';
}

/**
 * theme_liquid_glass_open の閉じタグ。
 *
 * @return void
 */
function theme_liquid_glass_close() {
	echo '</div></div>';
}

/**
 * アイキャッチ HTML をリキッドグラスでラップする。
 *
 * @param string       $html              サムネイル HTML。
 * @param int          $post_id           投稿 ID。
 * @param int          $post_thumbnail_id 添付 ID。
 * @param string|int[] $size              サイズ。
 * @param string|array $attr              属性。
 * @return string
 */
function theme_filter_post_thumbnail_liquid_glass( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
	if ( ! is_string( $html ) || $html === '' ) {
		return $html;
	}
	if ( strpos( $html, 'liquidGlass-wrapper' ) !== false ) {
		return $html;
	}
	ob_start();
	theme_liquid_glass_open( array( 'class' => 'liquidGlass-wrapper--fill liquidGlass-wrapper--card' ) );
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core が生成した img。
	echo $html;
	theme_liquid_glass_close();
	return (string) ob_get_clean();
}
add_filter( 'post_thumbnail_html', 'theme_filter_post_thumbnail_liquid_glass', 10, 5 );
