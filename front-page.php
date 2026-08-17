<?php
/**
 * Template halaman depan Suka News Tiga.
 *
 * @package Suka_News_Satu
 */

get_header();

$latest_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 20,
		'ignore_sticky_posts' => true,
	)
);

$posts        = $latest_query->posts;
$slider_posts = array_slice( $posts, 0, 5 );
?>

<div class="home-layout home-grid">
	<aside class="home-column home-left-list" aria-labelledby="home-left-title">
		<h2 id="home-left-title" class="section-title"><?php esc_html_e( 'Berita Terbaru', 'suka-news' ); ?></h2>
		<?php foreach ( array_slice( $posts, 0, 8 ) as $index => $post ) : setup_postdata( $post ); ?>
			<article <?php post_class( 'home-side-item home-side-item--left' ); ?>>
				<span class="home-side-item__number"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</article>
		<?php endforeach; wp_reset_postdata(); ?>
	</aside>

	<section class="home-main" aria-labelledby="home-main-title">
		<h1 id="home-main-title" class="screen-reader-text"><?php esc_html_e( 'Berita Pilihan', 'suka-news' ); ?></h1>

		<?php if ( $slider_posts ) : ?>
			<div class="home-main-slider" data-slider-interval="5000">
				<div class="home-slider-slides">
					<?php foreach ( $slider_posts as $index => $post ) : setup_postdata( $post ); ?>
						<article <?php post_class( 'home-slider-slide' . ( 0 === $index ? ' is-active' : '' ) ); ?> data-slide="<?php echo esc_attr( $index ); ?>">
							<a class="home-main-slider__image" href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'suka-news-wide' ); endif; ?>
							</a>
							<div class="home-main-slider__content">
								<?php echo wp_kses_post( suka_news_satu_get_category_bubbles( 0, 1 ) ); ?>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							</div>
						</article>
					<?php endforeach; wp_reset_postdata(); ?>
				</div>
			</div>

			<div class="home-slider-thumbs" aria-label="<?php esc_attr_e( 'Thumbnail slider', 'suka-news' ); ?>">
				<?php foreach ( $slider_posts as $index => $post ) : setup_postdata( $post ); ?>
					<button class="home-slider-thumb<?php echo 0 === $index ? ' is-active' : ''; ?>" type="button" data-slide="<?php echo esc_attr( $index ); ?>">
						<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'suka-sidebar-thumb' ); endif; ?>
						<span><?php the_title(); ?></span>
					</button>
				<?php endforeach; wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>

		<?php $feed_ads = function_exists( 'suka_core_get_banners' ) ? suka_core_get_banners( 'feed' ) : array(); ?>
		<?php if ( $feed_ads ) : ?>
			<aside class="home-banner-ad" aria-label="<?php esc_attr_e( 'Iklan', 'suka-news' ); ?>">
				<?php foreach ( $feed_ads as $feed_ad ) : ?>
					<div class="home-banner-ad__item">
						<?php if ( $feed_ad['url'] ) : ?><a href="<?php echo esc_url( $feed_ad['url'] ); ?>"<?php echo $feed_ad['newTab'] ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php endif; ?>
						<?php echo wp_get_attachment_image( $feed_ad['id'], 'suka-feed-ad', false, array( 'loading' => 'lazy' ) ); ?>
						<?php if ( $feed_ad['url'] ) : ?></a><?php endif; ?>
					</div>
				<?php endforeach; ?>
			</aside>
		<?php endif; ?>

		<div class="home-feed-grid">
			<?php foreach ( array_slice( $posts, 5, 6 ) as $post ) : setup_postdata( $post ); ?>
				<article <?php post_class( 'home-text-card' ); ?>>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?></p>
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				</article>
			<?php endforeach; wp_reset_postdata(); ?>
		</div>
	</section>

	<aside class="home-column home-right-list" aria-labelledby="home-right-title">
		<h2 id="home-right-title" class="section-title"><?php esc_html_e( 'Pilihan Editor', 'suka-news' ); ?></h2>
		<?php foreach ( array_slice( $posts, 11, 8 ) as $post ) : setup_postdata( $post ); ?>
			<article <?php post_class( 'home-side-item home-side-item--right' ); ?>>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 10 ) ); ?></p>
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</article>
		<?php endforeach; wp_reset_postdata(); ?>
	</aside>
</div>

<section class="home-row-two" aria-label="<?php esc_attr_e( 'Berita utama dan sidebar', 'suka-news' ); ?>">
	<div class="home-main-news">
		<h2 class="section-title"><?php esc_html_e( 'Berita Utama', 'suka-news' ); ?></h2>

		<?php if ( ! empty( $posts[12] ) ) : $post = $posts[12]; setup_postdata( $post ); ?>
			<article <?php post_class( 'home-video-card' ); ?>>
				<a class="home-video-card__image" href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'suka-news-wide' ); endif; ?>
					<span class="home-video-card__category"><?php echo wp_kses_post( suka_news_satu_get_category_bubbles( 0, 1 ) ); ?></span>
				</a>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</article>
		<?php endif; wp_reset_postdata(); ?>

		<div class="home-main-news-list">
			<?php foreach ( array_slice( $posts, 13, 10 ) as $post ) : setup_postdata( $post ); ?>
				<article <?php post_class( 'home-news-row' ); ?>>
					<a class="home-news-row__thumb" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'suka-sidebar-thumb' ); endif; ?>
					</a>
					<div>
						<?php echo wp_kses_post( suka_news_satu_get_category_bubbles( 0, 1 ) ); ?>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					</div>
				</article>
			<?php endforeach; wp_reset_postdata(); ?>
		</div>
	</div>

	<aside class="home-row-sidebar" aria-label="<?php esc_attr_e( 'Sidebar halaman depan', 'suka-news' ); ?>">
		<?php $sidebar_ads = function_exists( 'suka_core_get_banners' ) ? suka_core_get_banners( 'sidebar' ) : array(); ?>
		<?php if ( $sidebar_ads ) : ?>
			<div class="home-sidebar-ad" aria-label="<?php esc_attr_e( 'Iklan Sidebar', 'suka-news' ); ?>">
				<?php foreach ( $sidebar_ads as $sidebar_ad ) : ?>
					<div class="home-sidebar-ad__item">
						<?php if ( $sidebar_ad['url'] ) : ?><a href="<?php echo esc_url( $sidebar_ad['url'] ); ?>"<?php echo $sidebar_ad['newTab'] ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php endif; ?>
						<?php echo wp_get_attachment_image( $sidebar_ad['id'], 'suka-sidebar-ad', false, array( 'loading' => 'lazy' ) ); ?>
						<?php if ( $sidebar_ad['url'] ) : ?></a><?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<section class="home-latest-sidebar" aria-labelledby="home-latest-sidebar-title">
			<h2 id="home-latest-sidebar-title" class="section-title"><?php esc_html_e( 'Berita Terbaru', 'suka-news' ); ?></h2>
			<?php foreach ( array_slice( $posts, 0, 6 ) as $post ) : setup_postdata( $post ); ?>
				<article <?php post_class( 'home-latest-sidebar-item' ); ?>>
					<a class="home-latest-sidebar-item__thumb" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'suka-sidebar-thumb' ); endif; ?>
					</a>
					<div>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					</div>
				</article>
			<?php endforeach; wp_reset_postdata(); ?>
		</section>
	</aside>
</section>

<?php get_footer(); ?>
