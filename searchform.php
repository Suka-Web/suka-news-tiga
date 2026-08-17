<?php
/**
 * Form pencarian khusus tema.
 *
 * @package Suka_News_Satu
 */

$search_id = wp_unique_id( 'suka-news-search-' );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="search-form__label" for="<?php echo esc_attr( $search_id ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Cari berita:', 'suka-news' ); ?></span>
		<svg class="search-form__leading-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
			<path d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
		</svg>
		<input
			id="<?php echo esc_attr( $search_id ); ?>"
			type="search"
			class="search-field"
			placeholder="<?php echo esc_attr_x( 'Cari berita terbaru...', 'placeholder', 'suka-news' ); ?>"
			value="<?php echo get_search_query(); ?>"
			name="s"
		>
	</label>
	<button type="submit" class="search-submit">
		<span class="screen-reader-text"><?php esc_html_e( 'Cari', 'suka-news' ); ?></span>
		<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
			<path d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
		</svg>
	</button>
</form>
