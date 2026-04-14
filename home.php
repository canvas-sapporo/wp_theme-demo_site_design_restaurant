<?php
/**
 * 投稿一覧（設定 → 表示で指定した「投稿ページ」）。
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
