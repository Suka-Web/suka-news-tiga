<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary-content"><?php esc_html_e( 'Lewati ke konten utama', 'suka-news' ); ?></a>

<header class="site-header">
	<div class="header-top">
		<div class="header-container header-top__inner">
			<p class="header-date">
				<?php echo esc_html( wp_date( 'l, j F Y' ) ); ?>
			</p>

			<nav class="header-secondary-navigation" aria-label="<?php esc_attr_e( 'Menu Sekunder', 'suka-news' ); ?>">
				<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'fallback_cb' => false, 'menu_class' => 'header-secondary-menu' ) ); ?>
			</nav>

		</div>
	</div>

	<div class="header-branding">
		<div class="header-container header-branding__inner">
			<div class="site-logo">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				}
				?>
			</div>

			<div class="header-ad">
				<?php
				$header_ads = function_exists( 'suka_core_get_banners' ) ? suka_core_get_banners( 'header' ) : array();
				foreach ( $header_ads as $header_ad ) {
					echo '<div class="header-ad__item">';
					if ( $header_ad['url'] ) {
						echo '<a href="' . esc_url( $header_ad['url'] ) . '"' . ( $header_ad['newTab'] ? ' target="_blank" rel="noopener noreferrer"' : '' ) . '>';
					}
					echo wp_get_attachment_image(
						$header_ad['id'],
						'suka-header-ad',
						false,
						array( 'class' => 'header-ad__image' )
					);
					if ( $header_ad['url'] ) {
						echo '</a>';
					}
					echo '</div>';
				}
				?>
			</div>
		</div>
	</div>

	<div class="header-navigation">
		<div class="header-container header-navigation__inner">
			<nav class="primary-navigation" aria-label="<?php esc_attr_e( 'Menu Utama', 'suka-news' ); ?>">
				<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu-panel">
					<span class="menu-toggle__label"><?php esc_html_e( 'Menu', 'suka-news' ); ?></span>
					<span class="menu-toggle__icon" aria-hidden="true">
						<span></span><span></span><span></span>
					</span>
				</button>

				<div class="primary-menu-panel" id="primary-menu-panel">
					<nav class="mobile-secondary-navigation" aria-label="<?php esc_attr_e( 'Menu Sekunder', 'suka-news' ); ?>">
						<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'fallback_cb' => false, 'menu_class' => 'mobile-secondary-menu' ) ); ?>
					</nav>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'fallback_cb'    => false,
							'menu_class'     => 'primary-menu',
						)
					);
					?>
				</div>
			</nav>
			<div class="header-social" aria-label="<?php esc_attr_e( 'Media sosial', 'suka-news' ); ?>">
				<?php foreach ( suka_news_satu_get_social_links() as $social ) : ?>
					<a class="header-social__link header-social__link--<?php echo esc_attr( $social['network'] ); ?>" href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener noreferrer"<?php echo $social['color'] ? ' style="--social-color:' . esc_attr( $social['color'] ) . '"' : ''; ?>>
						<span class="screen-reader-text"><?php echo esc_html( $social['label'] ); ?></span>
						<svg viewBox="0 0 24 24" aria-hidden="true"><?php echo $social['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG statis dari tema. ?></svg>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<?php if ( get_theme_mod( 'suka_news_satu_ticker', true ) ) : ?>
	<?php $ticker_query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 8, 'no_found_rows' => true ) ); ?>
	<?php if ( $ticker_query->have_posts() ) : ?>
		<div class="news-ticker" aria-label="<?php esc_attr_e( 'Berita terkini', 'suka-news' ); ?>">
			<div class="header-container news-ticker__inner">
				<strong class="news-ticker__label"><?php esc_html_e( 'Terkini', 'suka-news' ); ?></strong>
				<div class="news-ticker__viewport"><div class="news-ticker__track">
					<div class="news-ticker__items"><?php while ( $ticker_query->have_posts() ) : $ticker_query->the_post(); ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php endwhile; ?></div>
					<div class="news-ticker__items" aria-hidden="true"><?php $ticker_query->rewind_posts(); while ( $ticker_query->have_posts() ) : $ticker_query->the_post(); ?><a href="<?php the_permalink(); ?>" tabindex="-1"><?php the_title(); ?></a><?php endwhile; ?></div>
				</div></div>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
	<?php endif; ?>
</header>

<main id="primary-content" class="site-main" tabindex="-1">
