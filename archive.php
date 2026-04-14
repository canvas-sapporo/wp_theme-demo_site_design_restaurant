<?php
/**
 * 投稿アーカイブ（カテゴリー・タグ・日付・著者など）。
 *
 * @package demo-site-design-restaurant
 */

get_header();

$hero_title    = wp_strip_all_tags( get_the_archive_title() );
$desc          = get_the_archive_description();
$hero_subtitle = is_string( $desc ) ? $desc : '';

get_template_part(
	'template-parts/blog',
	'list',
	array(
		'hero_title'    => $hero_title,
		'hero_subtitle' => $hero_subtitle,
	)
);

get_footer();
