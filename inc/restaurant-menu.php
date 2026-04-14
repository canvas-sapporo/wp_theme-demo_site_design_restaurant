<?php
/**
 * レストランメニュー: カスタム投稿タイプ menu_item + タクソノミー menu_category
 *
 * @package demo-site-design-restaurant
 */

defined( 'ABSPATH' ) || exit;

/**
 * メニュー一覧のアーカイブ URL（CPT 登録後に利用）。
 *
 * @return string
 */
function theme_get_menu_archive_url() {
	$link = get_post_type_archive_link( 'menu_item' );
	return is_string( $link ) && $link !== '' ? $link : home_url( '/menu/' );
}

/**
 * メニューページ相当の表示か（ナビのアクティブ用）。
 *
 * @return bool
 */
function theme_is_menu_nav_active() {
	if ( is_post_type_archive( 'menu_item' ) || is_singular( 'menu_item' ) ) {
		return true;
	}
	if ( is_tax( 'menu_category' ) ) {
		return true;
	}
	return false;
}

/**
 * カスタム投稿タイプ・タクソノミー登録。
 */
function theme_register_menu_item_cpt() {
	$labels = array(
		'name'               => __( 'メニュー品', 'demo-site-design-restaurant' ),
		'singular_name'      => __( 'メニュー品', 'demo-site-design-restaurant' ),
		'add_new'            => __( '新規追加', 'demo-site-design-restaurant' ),
		'add_new_item'       => __( 'メニュー品を追加', 'demo-site-design-restaurant' ),
		'edit_item'          => __( 'メニュー品を編集', 'demo-site-design-restaurant' ),
		'new_item'           => __( '新しいメニュー品', 'demo-site-design-restaurant' ),
		'view_item'          => __( 'メニュー品を表示', 'demo-site-design-restaurant' ),
		'search_items'       => __( 'メニュー品を検索', 'demo-site-design-restaurant' ),
		'not_found'          => __( 'メニュー品が見つかりません', 'demo-site-design-restaurant' ),
		'not_found_in_trash' => __( 'ゴミ箱にメニュー品はありません', 'demo-site-design-restaurant' ),
		'all_items'          => __( 'メニュー一覧', 'demo-site-design-restaurant' ),
		'menu_name'          => __( 'レストランメニュー', 'demo-site-design-restaurant' ),
	);

	register_post_type(
		'menu_item',
		array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-carrot',
			'menu_position'       => 20,
			'capability_type'     => 'post',
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'rewrite'             => array(
				'slug'       => 'menu',
				'with_front' => false,
			),
		)
	);

	$tax_labels = array(
		'name'          => __( 'メニューカテゴリ', 'demo-site-design-restaurant' ),
		'singular_name' => __( 'メニューカテゴリ', 'demo-site-design-restaurant' ),
		'search_items'  => __( 'カテゴリを検索', 'demo-site-design-restaurant' ),
		'all_items'     => __( 'すべてのカテゴリ', 'demo-site-design-restaurant' ),
		'edit_item'     => __( 'カテゴリを編集', 'demo-site-design-restaurant' ),
		'update_item'   => __( 'カテゴリを更新', 'demo-site-design-restaurant' ),
		'add_new_item'  => __( '新規カテゴリを追加', 'demo-site-design-restaurant' ),
		'new_item_name' => __( '新しいカテゴリ名', 'demo-site-design-restaurant' ),
	);

	register_taxonomy(
		'menu_category',
		array( 'menu_item' ),
		array(
			'labels'            => $tax_labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'         => 'menu-category',
				'with_front'   => false,
				'hierarchical' => true,
			),
		)
	);
}
add_action( 'init', 'theme_register_menu_item_cpt', 0 );

/**
 * 投稿メタ: 価格表示用（税込表記などそのまま入力）。
 */
function theme_register_menu_item_post_meta() {
	register_post_meta(
		'menu_item',
		'menu_item_price',
		array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'theme_register_menu_item_post_meta' );

/**
 * 管理画面: 価格メタボックス。
 */
function theme_menu_item_price_meta_box() {
	add_meta_box(
		'theme_menu_item_price',
		__( '価格', 'demo-site-design-restaurant' ),
		'theme_menu_item_price_meta_box_render',
		'menu_item',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'theme_menu_item_price_meta_box' );

/**
 * @param WP_Post $post Post object.
 */
function theme_menu_item_price_meta_box_render( $post ) {
	wp_nonce_field( 'theme_menu_item_price_save', 'theme_menu_item_price_nonce' );
	$value = get_post_meta( $post->ID, 'menu_item_price', true );
	if ( ! is_string( $value ) ) {
		$value = '';
	}
	?>
	<p>
		<label for="theme_menu_item_price_input" class="screen-reader-text"><?php esc_html_e( '価格', 'demo-site-design-restaurant' ); ?></label>
		<input
			type="text"
			id="theme_menu_item_price_input"
			name="menu_item_price"
			class="widefat"
			value="<?php echo esc_attr( $value ); ?>"
			placeholder="<?php echo esc_attr( '例: ¥8,800' ); ?>"
		/>
	</p>
	<p class="description"><?php esc_html_e( '表示用にそのまま入力してください（税込など）。', 'demo-site-design-restaurant' ); ?></p>
	<?php
}

/**
 * @param int $post_id Post ID.
 */
function theme_menu_item_price_save( $post_id ) {
	if ( ! isset( $_POST['theme_menu_item_price_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['theme_menu_item_price_nonce'] ) ), 'theme_menu_item_price_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( get_post_type( $post_id ) !== 'menu_item' ) {
		return;
	}
	$raw = isset( $_POST['menu_item_price'] ) ? wp_unslash( $_POST['menu_item_price'] ) : '';
	$raw = is_string( $raw ) ? $raw : '';
	update_post_meta( $post_id, 'menu_item_price', sanitize_text_field( $raw ) );
}
add_action( 'save_post_menu_item', 'theme_menu_item_price_save' );

/**
 * タームメタ: 表示順・レイアウト（グリッド / リスト）。
 */
function theme_register_menu_category_term_meta() {
	register_term_meta(
		'menu_category',
		'menu_category_order',
		array(
			'type'              => 'integer',
			'single'            => true,
			'default'           => 0,
			'sanitize_callback' => 'absint',
			'show_in_rest'      => true,
			'auth_callback'     => function () {
				return current_user_can( 'manage_categories' );
			},
		)
	);
	register_term_meta(
		'menu_category',
		'menu_category_layout',
		array(
			'type'              => 'string',
			'single'            => true,
			'default'           => 'grid',
			'sanitize_callback' => 'theme_sanitize_menu_category_layout',
			'show_in_rest'      => true,
			'auth_callback'     => function () {
				return current_user_can( 'manage_categories' );
			},
		)
	);
}
add_action( 'init', 'theme_register_menu_category_term_meta' );

/**
 * @param string $value Raw layout.
 * @return string
 */
function theme_sanitize_menu_category_layout( $value ) {
	$allowed = array( 'grid', 'list' );
	$value   = is_string( $value ) ? $value : 'grid';
	return in_array( $value, $allowed, true ) ? $value : 'grid';
}

/**
 * @param string $taxonomy Taxonomy slug.
 */
function theme_menu_category_add_layout_field( $taxonomy ) {
	wp_nonce_field( 'theme_menu_category_meta_save', 'theme_menu_category_meta_nonce' );
	?>
	<div class="form-field term-layout-wrap">
		<label for="menu_category_layout"><?php esc_html_e( 'レイアウト', 'demo-site-design-restaurant' ); ?></label>
		<select name="menu_category_layout" id="menu_category_layout">
			<option value="grid"><?php esc_html_e( 'カード（画像付きグリッド）', 'demo-site-design-restaurant' ); ?></option>
			<option value="list"><?php esc_html_e( 'リスト（コース向け）', 'demo-site-design-restaurant' ); ?></option>
		</select>
		<p class="description"><?php esc_html_e( 'コースメニューなどは「リスト」を選ぶと区切り線付きの一覧になります。', 'demo-site-design-restaurant' ); ?></p>
	</div>
	<div class="form-field term-order-wrap">
		<label for="menu_category_order"><?php esc_html_e( '表示順（小さいほど上）', 'demo-site-design-restaurant' ); ?></label>
		<input type="number" name="menu_category_order" id="menu_category_order" value="0" min="0" step="1" class="small-text" />
	</div>
	<?php
}
add_action( 'menu_category_add_form_fields', 'theme_menu_category_add_layout_field' );

/**
 * @param WP_Term $term Term object.
 */
function theme_menu_category_edit_layout_field( $term ) {
	wp_nonce_field( 'theme_menu_category_meta_save', 'theme_menu_category_meta_nonce' );
	$layout = get_term_meta( $term->term_id, 'menu_category_layout', true );
	$layout = theme_sanitize_menu_category_layout( is_string( $layout ) ? $layout : 'grid' );
	$order  = (int) get_term_meta( $term->term_id, 'menu_category_order', true );
	?>
	<tr class="form-field term-layout-wrap">
		<th scope="row"><label for="menu_category_layout"><?php esc_html_e( 'レイアウト', 'demo-site-design-restaurant' ); ?></label></th>
		<td>
			<select name="menu_category_layout" id="menu_category_layout">
				<option value="grid" <?php selected( $layout, 'grid' ); ?>><?php esc_html_e( 'カード（画像付きグリッド）', 'demo-site-design-restaurant' ); ?></option>
				<option value="list" <?php selected( $layout, 'list' ); ?>><?php esc_html_e( 'リスト（コース向け）', 'demo-site-design-restaurant' ); ?></option>
			</select>
			<p class="description"><?php esc_html_e( 'コースメニューなどは「リスト」を選ぶと区切り線付きの一覧になります。', 'demo-site-design-restaurant' ); ?></p>
		</td>
	</tr>
	<tr class="form-field term-order-wrap">
		<th scope="row"><label for="menu_category_order"><?php esc_html_e( '表示順（小さいほど上）', 'demo-site-design-restaurant' ); ?></label></th>
		<td>
			<input type="number" name="menu_category_order" id="menu_category_order" value="<?php echo esc_attr( (string) $order ); ?>" min="0" step="1" class="small-text" />
		</td>
	</tr>
	<?php
}
add_action( 'menu_category_edit_form_fields', 'theme_menu_category_edit_layout_field' );

/**
 * @param int $term_id Term ID.
 */
function theme_menu_category_save_layout_field( $term_id ) {
	if ( ! isset( $_POST['theme_menu_category_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['theme_menu_category_meta_nonce'] ) ), 'theme_menu_category_meta_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_categories' ) ) {
		return;
	}
	$layout = isset( $_POST['menu_category_layout'] ) ? sanitize_text_field( wp_unslash( $_POST['menu_category_layout'] ) ) : 'grid';
	update_term_meta( $term_id, 'menu_category_layout', theme_sanitize_menu_category_layout( $layout ) );
	$order = isset( $_POST['menu_category_order'] ) ? absint( $_POST['menu_category_order'] ) : 0;
	update_term_meta( $term_id, 'menu_category_order', $order );
}
add_action( 'created_menu_category', 'theme_menu_category_save_layout_field' );
add_action( 'edited_menu_category', 'theme_menu_category_save_layout_field' );

/**
 * メニューページ（アーカイブ）用ヒーロー画像。
 *
 * @return array{url: string, alt: string}
 */
function theme_get_menu_hero_image_attrs() {
	$attachment_id = absint( get_theme_mod( 'theme_menu_hero_image', 0 ) );
	$default_url   = 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1920';
	if ( $attachment_id && wp_attachment_is_image( $attachment_id ) ) {
		$src = wp_get_attachment_image_url( $attachment_id, 'full' );
		if ( $src ) {
			$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
			if ( ! is_string( $alt ) || $alt === '' ) {
				$alt = __( 'メニュー', 'demo-site-design-restaurant' );
			}
			return array(
				'url' => $src,
				'alt' => $alt,
			);
		}
	}
	return array(
		'url' => $default_url,
		'alt' => __( 'Restaurant dining', 'demo-site-design-restaurant' ),
	);
}

/**
 * メニュー品の短い説明文（抜粋優先）。
 *
 * @param int $post_id Post ID.
 * @return string
 */
function theme_get_menu_item_short_description( $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post instanceof WP_Post ) {
		return '';
	}
	$excerpt = $post->post_excerpt;
	if ( is_string( $excerpt ) && trim( $excerpt ) !== '' ) {
		return trim( wp_strip_all_tags( $excerpt ) );
	}
	$content = $post->post_content;
	if ( ! is_string( $content ) || trim( $content ) === '' ) {
		return '';
	}
	return wp_trim_words( wp_strip_all_tags( $content ), 40, '…' );
}

/**
 * カスタマイザー: メニューアーカイブ用ヒーロー文言・注記。
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function theme_menu_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'theme_menu_archive',
		array(
			'title'       => __( 'メニューページ', 'demo-site-design-restaurant' ),
			'description' => __( '「レストランメニュー」のアーカイブ（通常は /menu/）のヒーローと注記を編集できます。', 'demo-site-design-restaurant' ),
			'priority'    => 38,
		)
	);

	$wp_customize->add_setting(
		'theme_menu_hero_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'theme_menu_hero_image',
			array(
				'label'     => __( 'メニュー ヒーロー画像', 'demo-site-design-restaurant' ),
				'section'   => 'theme_menu_archive',
				'mime_type' => 'image',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_menu_hero_title',
		array(
			'default'           => 'Menu',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'theme_menu_hero_title',
		array(
			'label'   => __( 'ヒーロー見出し', 'demo-site-design-restaurant' ),
			'section' => 'theme_menu_archive',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'theme_menu_hero_subtitle',
		array(
			'default'           => '厳選された季節の食材を使用した特別な料理',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'theme_menu_hero_subtitle',
		array(
			'label'   => __( 'ヒーロー補足文', 'demo-site-design-restaurant' ),
			'section' => 'theme_menu_archive',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'theme_menu_footer_note',
		array(
			'default'           => '※表示価格は税込です。食物アレルギーをお持ちの方はスタッフまでお申し出ください。',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'theme_menu_footer_note',
		array(
			'label'   => __( 'メニュー末尾の注記', 'demo-site-design-restaurant' ),
			'section' => 'theme_menu_archive',
			'type'    => 'textarea',
		)
	);
}
add_action( 'customize_register', 'theme_menu_customize_register', 20 );

/**
 * 初期カテゴリ（前菜・メイン・コース）を未登録時のみ作成。
 */
function theme_seed_menu_categories() {
	if ( get_option( 'theme_menu_categories_seeded' ) ) {
		return;
	}

	$defs = array(
		array(
			'name'        => __( '前菜', 'demo-site-design-restaurant' ),
			'slug'        => 'appetizer',
			'description' => __( '季節の食材を活かした繊細な前菜', 'demo-site-design-restaurant' ),
			'order'       => 10,
			'layout'      => 'grid',
		),
		array(
			'name'        => __( 'メイン料理', 'demo-site-design-restaurant' ),
			'slug'        => 'main',
			'description' => __( 'こだわりの調理法で仕上げた逸品', 'demo-site-design-restaurant' ),
			'order'       => 20,
			'layout'      => 'grid',
		),
		array(
			'name'        => __( 'コースメニュー', 'demo-site-design-restaurant' ),
			'slug'        => 'course',
			'description' => __( '特別な日のためのコース料理', 'demo-site-design-restaurant' ),
			'order'       => 30,
			'layout'      => 'list',
		),
	);

	foreach ( $defs as $def ) {
		if ( term_exists( $def['slug'], 'menu_category' ) ) {
			continue;
		}
		$result = wp_insert_term(
			$def['name'],
			'menu_category',
			array(
				'slug'        => $def['slug'],
				'description' => $def['description'],
			)
		);
		if ( is_wp_error( $result ) ) {
			continue;
		}
		$term_id = isset( $result['term_id'] ) ? (int) $result['term_id'] : 0;
		if ( $term_id > 0 ) {
			update_term_meta( $term_id, 'menu_category_order', (int) $def['order'] );
			update_term_meta( $term_id, 'menu_category_layout', $def['layout'] );
		}
	}

	update_option( 'theme_menu_categories_seeded', '1', false );
}

/**
 * テーマ有効化時: リライトルール更新・初期カテゴリ。
 */
function theme_menu_on_switch_theme() {
	theme_seed_menu_categories();
	flush_rewrite_rules( false );
}
add_action( 'after_switch_theme', 'theme_menu_on_switch_theme' );

/**
 * アーカイブ表示用: 投稿があるカテゴリを「表示順」メタでソート。
 *
 * @return array<int, WP_Term>|WP_Error
 */
function theme_get_menu_categories_sorted() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'menu_category',
			'hide_empty' => true,
		)
	);

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return is_wp_error( $terms ) ? $terms : array();
	}

	usort(
		$terms,
		function ( $a, $b ) {
			$oa = (int) get_term_meta( $a->term_id, 'menu_category_order', true );
			$ob = (int) get_term_meta( $b->term_id, 'menu_category_order', true );
			if ( $oa === $ob ) {
				return $a->term_id <=> $b->term_id;
			}
			return $oa <=> $ob;
		}
	);

	return $terms;
}

/**
 * 既存サイトで CPT を追加した直後もパーマリンクを効かせる（初回のみ）。
 */
function theme_menu_maybe_flush_rewrite_once() {
	if ( get_option( 'theme_menu_rewrite_v1' ) ) {
		return;
	}
	theme_seed_menu_categories();
	flush_rewrite_rules( false );
	update_option( 'theme_menu_rewrite_v1', '1', false );
}
add_action( 'init', 'theme_menu_maybe_flush_rewrite_once', 99 );
