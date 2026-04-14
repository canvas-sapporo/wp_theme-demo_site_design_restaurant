<?php
/**
 * メインテンプレート（フォールバック）
 *
 * @package demo-site-design-restaurant
 */

get_header();

get_template_part(
	'template-parts/blog',
	'list',
	array(
		'hero_title'    => __( 'Blog', 'demo-site-design-restaurant' ),
		'hero_subtitle' => __( 'レストランからのお知らせとストーリー', 'demo-site-design-restaurant' ),
	)
);

get_footer();
