<?php
/**
 * Sidebar utama tema.
 *
 * @package Suka_News_Satu
 */
?>

<aside class="site-sidebar home-row-sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'suka-news' ); ?>">
	<?php
	$sidebar_ads = function_exists( 'suka_core_get_banners' ) ? suka_core_get_banners( 'sidebar' ) : array();
	?>
	<?php if ( $sidebar_ads ) : ?>
		<div class="home-sidebar-ad sidebar-ads" aria-label="<?php esc_attr_e( 'Iklan Sidebar', 'suka-news' ); ?>">
			<?php foreach ( $sidebar_ads as $sidebar_ad ) : ?>
				<div class="home-sidebar-ad__item sidebar-ad">
					<?php if ( $sidebar_ad['url'] ) : ?><a href="<?php echo esc_url( $sidebar_ad['url'] ); ?>"<?php echo $sidebar_ad['newTab'] ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php endif; ?>
					<?php echo wp_get_attachment_image( $sidebar_ad['id'], 'suka-sidebar-ad', false, array( 'loading' => 'lazy' ) ); ?>
					<?php if ( $sidebar_ad['url'] ) : ?></a><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-main' ); ?>
	<?php endif; ?>

	<?php
	$latest_query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 6,
			'ignore_sticky_posts' => true,
		)
	);
	?>

	<?php if ( $latest_query->have_posts() ) : ?>
		<section class="home-latest-sidebar sidebar-widget" aria-labelledby="sidebar-latest-title">
			<h2 id="sidebar-latest-title" class="section-title sidebar-widget__title"><?php esc_html_e( 'Berita Terbaru', 'suka-news' ); ?></h2>
			<?php while ( $latest_query->have_posts() ) : ?>
				<?php $latest_query->the_post(); ?>
				<article <?php post_class( 'home-latest-sidebar-item' ); ?>>
					<a class="home-latest-sidebar-item__thumb" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'suka-sidebar-thumb', array( 'loading' => 'lazy' ) ); endif; ?>
					</a>
					<div>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					</div>
				</article>
			<?php endwhile; ?>
		</section>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</aside>
