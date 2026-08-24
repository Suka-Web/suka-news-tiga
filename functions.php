<?php
/**
 * Fungsi dan konfigurasi dasar tema.
 *
 * @package Suka_News
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mengaktifkan fitur bawaan WordPress yang dibutuhkan tema.
 */
function suka_news_satu_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'suka-news-wide', 1200, 0, false );
	add_image_size( 'suka-feed-card', 520, 390, true );
	add_image_size( 'suka-archive-card', 640, 400, true );
	add_image_size( 'suka-sidebar-thumb', 160, 140, true );
	add_image_size( 'suka-related-card', 420, 260, true );
	add_image_size( 'suka-header-ad', 900, 0, false );
	add_image_size( 'suka-sidebar-ad', 420, 0, false );
	add_image_size( 'suka-feed-ad', 800, 0, false );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary'   => __( 'Menu Utama', 'suka-news' ),
			'secondary' => __( 'Menu Sekunder', 'suka-news' ),
		)
	);
}
add_action( 'after_setup_theme', 'suka_news_satu_setup' );

/**
 * Menghilangkan awalan seperti "Kategori:" dari judul archive.
 *
 * @return string
 */
function suka_news_satu_archive_title_prefix() {
	return '';
}
add_filter( 'get_the_archive_title_prefix', 'suka_news_satu_archive_title_prefix' );

/**
 * Memuat stylesheet utama tema.
 */
function suka_news_satu_enqueue_assets() {
	$style_path  = get_stylesheet_directory() . '/style.css';
	$script_path = get_template_directory() . '/assets/js/theme.js';

	wp_enqueue_style(
		'suka-news-satu-style',
		get_stylesheet_uri(),
		array(),
		file_exists( $style_path ) ? (string) filemtime( $style_path ) : wp_get_theme()->get( 'Version' )
	);

	$base_color   = sanitize_hex_color( get_theme_mod( 'suka_news_satu_base_color', '#0f172a' ) );
	$accent_color = sanitize_hex_color( get_theme_mod( 'suka_news_satu_accent_color', '#b91c1c' ) );
	$text_color   = sanitize_hex_color( get_theme_mod( 'suka_news_satu_text_color', '#1f2937' ) );

	if ( ! $base_color ) {
		$base_color = '#0f172a';
	}

	if ( ! $accent_color ) {
		$accent_color = '#b91c1c';
	}

	if ( ! $text_color ) {
		$text_color = '#1f2937';
	}

	wp_add_inline_style(
		'suka-news-satu-style',
		sprintf(
			':root{--color-base:%1$s;--color-accent:%2$s;--color-text:%3$s;}',
			$base_color,
			$accent_color,
			$text_color
		)
	);

	wp_enqueue_script(
		'suka-news-satu-script',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		file_exists( $script_path ) ? (string) filemtime( $script_path ) : wp_get_theme()->get( 'Version' ),
		true
	);
	wp_script_add_data( 'suka-news-satu-script', 'strategy', 'defer' );

	wp_localize_script(
		'suka-news-satu-script',
		'sukaNewsSatu',
		array(
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'loadingText'  => __( 'Memuat berita...', 'suka-news' ),
			'loadMoreText' => __( 'Tampilkan Berita Selanjutnya', 'suka-news' ),
			'errorText'    => __( 'Berita gagal dimuat. Silakan coba lagi.', 'suka-news' ),
			'expandSubmenu'   => __( 'Buka submenu', 'suka-news' ),
			'collapseSubmenu' => __( 'Tutup submenu', 'suka-news' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'suka_news_satu_enqueue_assets' );


/**
 * Mendaftarkan area widget sidebar yang dipakai di seluruh halaman.
 */
function suka_news_satu_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar Utama', 'suka-news' ),
			'id'            => 'sidebar-main',
			'description'   => __( 'Widget di area ini ditampilkan pada sidebar halaman depan dan halaman lainnya.', 'suka-news' ),
			'before_widget' => '<section id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="sidebar-widget__title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'suka_news_satu_widgets_init' );

function suka_news_satu_get_news_meta( $post_id = 0 ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	$views   = function_exists( 'suka_core_get_post_views' ) ? suka_core_get_post_views( $post_id ) : 0;
	return sprintf(
		'<div class="news-meta"><time datetime="%1$s">%2$s</time><span class="news-views" aria-label="%3$s"><svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/></svg><span>%4$s</span></span></div>',
		esc_attr( get_the_date( DATE_W3C, $post_id ) ), esc_html( get_the_date( '', $post_id ) ),
		esc_attr( sprintf( _n( '%s kali dilihat', '%s kali dilihat', $views, 'suka-news' ), number_format_i18n( $views ) ) ),
		esc_html( number_format_i18n( $views ) )
	);
}

/**
 * Membuat maksimal dua bubble kategori untuk sebuah artikel.
 *
 * @param int $post_id ID artikel. Nilai 0 memakai artikel aktif.
 * @param int $limit   Jumlah maksimum kategori.
 * @return string
 */
function suka_news_satu_get_category_bubbles( $post_id = 0, $limit = 2 ) {
	$categories = get_the_category( $post_id );

	if ( ! $categories ) {
		return '';
	}

	$categories = array_slice( $categories, 0, absint( $limit ) );
	$links      = array();

	foreach ( $categories as $category ) {
		$links[] = sprintf(
			'<a class="news-category" href="%1$s">%2$s</a>',
			esc_url( get_category_link( $category->term_id ) ),
			esc_html( $category->name )
		);
	}

	return '<div class="news-categories">' . implode( '', $links ) . '</div>';
}

function suka_news_satu_get_social_links() {
	$icons = array(
		'facebook'  => array( 'Facebook', '<path d="M14 8h3V4h-3c-3 0-5 2-5 5v3H6v4h3v8h4v-8h3.5l.5-4h-4V9c0-.7.3-1 1-1Z"/>' ),
		'instagram' => array( 'Instagram', '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" class="icon-fill"/>' ),
		'x'         => array( 'X', '<path d="M5 4l14 16M19 4 5 20"/>' ),
		'youtube'   => array( 'YouTube', '<path d="M22 12s0-4-1-6c-.5-1-1.5-1.5-2.5-1.5C16.5 4 12 4 12 4s-4.5 0-6.5.5C4.5 4.5 3.5 5 3 6c-1 2-1 6-1 6s0 4 1 6c.5 1 1.5 1.5 2.5 1.5C7.5 20 12 20 12 20s4.5 0 6.5-.5c1 0 2-.5 2.5-1.5 1-2 1-6 1-6Z"/><path d="m10 9 5 3-5 3V9Z" class="icon-fill"/>' ),
		'tiktok'    => array( 'TikTok', '<path class="icon-fill" d="M14.2 3h3.1c.3 1.7 1.3 3.1 3.2 3.6v3.1a8.3 8.3 0 0 1-3.2-1v6.1a6 6 0 1 1-5.2-5.9V12a2.9 2.9 0 1 0 2.1 2.8V3Z"/>' ),
		'threads'   => array( 'Threads', '<circle cx="12" cy="12" r="9"/><path d="M8.5 9.2c.7-1.8 4.8-2.5 6.5-.4 1.6 2 .8 6.6-2.5 7-2.8.4-4.1-2.7-2.2-4.2 1.5-1.2 5-.5 6.3.7"/>' ),
	);
	$links = array();
	foreach ( $icons as $network => $icon ) {
		$url = get_theme_mod( 'suka_news_satu_social_' . $network, '' );
		if ( $url ) {
			$links[] = array( 'label' => $icon[0], 'network' => $network, 'svg' => $icon[1], 'url' => $url, 'color' => get_theme_mod( 'suka_news_satu_social_color_' . $network, '' ) );
		}
	}
	return $links;
}

/**
 * Menambahkan pengaturan gambar iklan header ke Customizer.
 *
 * Logo menggunakan fitur Custom Logo bawaan WordPress pada panel Identitas Situs.
 *
 * @param WP_Customize_Manager $wp_customize Objek Customizer WordPress.
 */
function suka_news_satu_customize_register( $wp_customize ) {
	$wp_customize->add_setting(
		'suka_news_satu_base_color',
		array(
			'default'           => '#0f172a',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'suka_news_satu_base_color',
			array(
				'label'       => __( 'Warna Dasar', 'suka-news' ),
				'description' => __( 'Digunakan pada navigasi dan elemen utama yang gelap.', 'suka-news' ),
				'section'     => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'suka_news_satu_text_color',
		array(
			'default'           => '#1f2937',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'suka_news_satu_text_color',
			array(
				'label'       => __( 'Warna Teks', 'suka-news' ),
				'description' => __( 'Warna teks isi di seluruh halaman: paragraf berita, ringkasan, dan teks yang tidak memakai warna khusus.', 'suka-news' ),
				'section'     => 'colors',
			)
		)
	);

	$wp_customize->add_section(
		'suka_news_satu_header',
		array(
			'title'       => __( 'Header', 'suka-news' ),
			'description' => __( 'Atur elemen yang tampil pada bagian atas situs.', 'suka-news' ),
			'priority'    => 33,
		)
	);

	$wp_customize->add_setting(
		'suka_news_satu_ticker',
		array(
			'default'           => true,
			'sanitize_callback' => 'suka_news_satu_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'suka_news_satu_ticker',
		array(
			'label'       => __( 'Tampilkan ticker berita terkini', 'suka-news' ),
			'description' => __( 'Baris berjalan berisi delapan berita terbaru di bawah menu utama.', 'suka-news' ),
			'section'     => 'suka_news_satu_header',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_section(
		'suka_news_satu_single',
		array(
			'title'       => __( 'Artikel Single', 'suka-news' ),
			'description' => __( 'Atur elemen yang tampil pada halaman detail berita.', 'suka-news' ),
			'priority'    => 34,
		)
	);

	$wp_customize->add_setting(
		'suka_news_satu_inline_related',
		array(
			'default'           => false,
			'sanitize_callback' => 'suka_news_satu_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'suka_news_satu_inline_related',
		array(
			'label'       => __( 'Tampilkan artikel terkait di tengah berita', 'suka-news' ),
			'description' => __( 'Blok berisi dua artikel terkait dan ditempatkan setelah paragraf ketiga.', 'suka-news' ),
			'section'     => 'suka_news_satu_single',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'suka_news_satu_accent_color',
		array(
			'default'           => '#b91c1c',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'suka_news_satu_accent_color',
			array(
				'label'       => __( 'Warna Aksen', 'suka-news' ),
				'description' => __( 'Digunakan pada tombol, sorotan, dan keadaan aktif.', 'suka-news' ),
				'section'     => 'colors',
			)
		)
	);

	$wp_customize->add_section(
		'suka_news_satu_footer',
		array(
			'title'       => __( 'Footer dan Akun Sosial', 'suka-news' ),
			'description' => __( 'Atur footer dan URL akun media sosial untuk header serta footer.', 'suka-news' ),
			'priority'    => 36,
		)
	);

	$wp_customize->add_setting(
		'suka_news_satu_footer_description',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);

	$wp_customize->add_control(
		'suka_news_satu_footer_description',
		array(
			'label'       => __( 'Teks di Bawah Logo', 'suka-news' ),
			'description' => __( 'Tulis deskripsi singkat website yang ditampilkan di bawah logo footer.', 'suka-news' ),
			'section'     => 'suka_news_satu_footer',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'suka_news_satu_footer_white_logo',
		array(
			'default'           => true,
			'sanitize_callback' => 'suka_news_satu_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'suka_news_satu_footer_white_logo',
		array(
			'label'   => __( 'Jadikan logo footer berwarna putih', 'suka-news' ),
			'section' => 'suka_news_satu_footer',
			'type'    => 'checkbox',
		)
	);

	$social_networks = array(
		'facebook'  => __( 'URL Facebook', 'suka-news' ),
		'instagram' => __( 'URL Instagram', 'suka-news' ),
		'x'         => __( 'URL X / Twitter', 'suka-news' ),
		'youtube'   => __( 'URL YouTube', 'suka-news' ),
		'tiktok'    => __( 'URL TikTok', 'suka-news' ),
		'threads'   => __( 'URL Threads', 'suka-news' ),
	);

	foreach ( $social_networks as $network => $label ) {
		$setting_id = 'suka_news_satu_social_' . $network;

		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			$setting_id,
			array(
				'label'   => $label,
				'section' => 'suka_news_satu_footer',
				'type'    => 'url',
			)
		);

		$color_setting_id = 'suka_news_satu_social_color_' . $network;

		$wp_customize->add_setting(
			$color_setting_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color_setting_id,
				array(
					'label'       => sprintf( __( 'Warna %s', 'suka-news' ), $label ),
					'description' => __( 'Kosongkan untuk memakai warna bawaan platform.', 'suka-news' ),
					'section'     => 'suka_news_satu_footer',
				)
			)
		);
	}
}
add_action( 'customize_register', 'suka_news_satu_customize_register' );

/**
 * Membersihkan nilai checkbox dari Customizer.
 *
 * @param mixed $checked Nilai checkbox.
 * @return bool
 */
function suka_news_satu_sanitize_checkbox( $checked ) {
	return (bool) $checked;
}

/**
 * Menyisipkan artikel terkait setelah paragraf ketiga isi berita.
 *
 * @param string $content Isi artikel yang telah diformat WordPress.
 * @return string
 */
function suka_news_satu_add_inline_related_news( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() || ! get_theme_mod( 'suka_news_satu_inline_related', false ) ) {
		return $content;
	}

	$post_id      = get_the_ID();
	$category_ids = wp_get_post_categories( $post_id );
	$related_ids  = get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 1,
			'fields'              => 'ids',
			'post__not_in'        => array( $post_id ),
			'category__in'        => $category_ids,
			'ignore_sticky_posts' => true,
		)
	);

	if ( ! $related_ids ) {
		return $content;
	}

	$related_html  = '<aside class="inline-related-news" aria-label="' . esc_attr__( 'Artikel terkait', 'suka-news' ) . '">';
	$related_html .= '<h2>' . esc_html__( 'Artikel Terkait', 'suka-news' ) . '</h2>';
	$related_html .= '<div class="inline-related-news__list">';

	foreach ( $related_ids as $related_id ) {
		$related_html .= '<article class="inline-related-card">';
		if ( has_post_thumbnail( $related_id ) ) {
			$related_html .= '<a class="inline-related-card__image" href="' . esc_url( get_permalink( $related_id ) ) . '" tabindex="-1" aria-hidden="true">';
			$related_html .= get_the_post_thumbnail( $related_id, 'suka-sidebar-thumb', array( 'loading' => 'lazy' ) );
			$related_html .= '</a>';
		}
		$related_html .= '<div><h3><a href="' . esc_url( get_permalink( $related_id ) ) . '">' . esc_html( get_the_title( $related_id ) ) . '</a></h3></div>';
		$related_html .= '</article>';
	}

	$related_html .= '</div></aside>';

	$offset   = 0;
	$position = false;
	for ( $paragraph = 0; $paragraph < 3; $paragraph++ ) {
		$position = stripos( $content, '</p>', $offset );
		if ( false === $position ) {
			break;
		}
		$offset = $position + 4;
	}

	if ( false === $position ) {
		return $content . $related_html;
	}

	return substr( $content, 0, $offset ) . $related_html . substr( $content, $offset );
}
add_filter( 'the_content', 'suka_news_satu_add_inline_related_news', 20 );

/**
 * Mengirim kelompok berita berikutnya untuk tombol load more.
 */
function suka_news_satu_load_more_news() {
	check_ajax_referer( 'suka_news_satu_load_more', 'nonce' );

	$page = isset( $_POST['page'] ) ? max( 2, absint( $_POST['page'] ) ) : 2;
	$query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 10,
			'paged'               => $page,
			'ignore_sticky_posts' => true,
		)
	);

	ob_start();
	while ( $query->have_posts() ) {
		$query->the_post();
		get_template_part( 'template-parts/content', 'feed' );
	}
	$html = ob_get_clean();
	wp_reset_postdata();

	wp_send_json_success(
		array(
			'html'     => $html,
			'hasMore'  => $page < $query->max_num_pages,
			'nextPage' => $page + 1,
		)
	);
}
add_action( 'wp_ajax_suka_news_satu_load_more', 'suka_news_satu_load_more_news' );
add_action( 'wp_ajax_nopriv_suka_news_satu_load_more', 'suka_news_satu_load_more_news' );
