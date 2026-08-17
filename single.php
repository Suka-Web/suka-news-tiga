<?php
/**
 * Template halaman detail artikel.
 *
 * @package Suka_News_Satu
 */

get_header();
?>

<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>
	<?php
	$categories       = get_the_category();
	$primary_category = $categories ? $categories[0] : null;
	$share_position   = function_exists( 'suka_core_get_share_position' ) ? suka_core_get_share_position() : 'after';
	?>

	<div class="single-layout">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>
			<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'suka-news' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Beranda', 'suka-news' ); ?></a>
				<span aria-hidden="true">/</span>
				<?php if ( $primary_category ) : ?>
					<a href="<?php echo esc_url( get_category_link( $primary_category->term_id ) ); ?>"><?php echo esc_html( $primary_category->name ); ?></a>
					<span aria-hidden="true">/</span>
				<?php endif; ?>
				<span aria-current="page"><?php the_title(); ?></span>
			</nav>

			<header class="article-header">
				<?php echo wp_kses_post( suka_news_satu_get_category_bubbles( 0, 100 ) ); ?>
				<h1 class="article-title"><?php the_title(); ?></h1>

				<div class="article-byline">
					<div class="article-author">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 42 ); ?>
						<div>
							<span><?php esc_html_e( 'Ditulis oleh', 'suka-news' ); ?></span>
							<strong><?php the_author(); ?></strong>
						</div>
					</div>
					<?php echo suka_news_satu_get_news_meta(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Seluruh nilai dinamis di-escape di dalam helper. ?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="article-featured-image">
					<?php the_post_thumbnail( 'suka-news-wide' ); ?>
					<?php if ( get_the_post_thumbnail_caption() ) : ?>
						<figcaption><?php echo wp_kses_post( get_the_post_thumbnail_caption() ); ?></figcaption>
					<?php endif; ?>
				</figure>
			<?php endif; ?>

			<?php if ( 'before' === $share_position && function_exists( 'suka_core_render_share_buttons' ) ) suka_core_render_share_buttons(); ?>
			<div class="article-content">
				<?php if ( 'side' === $share_position && function_exists( 'suka_core_render_share_buttons' ) ) suka_core_render_share_buttons(); ?>
				<?php the_content(); ?>
				<?php
				wp_link_pages(
					array(
						'before' => '<nav class="page-links">' . esc_html__( 'Halaman:', 'suka-news' ),
						'after'  => '</nav>',
					)
				);
				?>
			</div>

			<footer class="article-footer">
				<?php $tags = get_the_tags(); ?>
				<?php if ( $tags ) : ?>
					<div class="article-tags" aria-label="<?php esc_attr_e( 'Tag artikel', 'suka-news' ); ?>">
						<span><?php esc_html_e( 'Tag:', 'suka-news' ); ?></span>
						<?php foreach ( $tags as $tag ) : ?>
							<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			</footer>
			<?php if ( 'after' === $share_position && function_exists( 'suka_core_render_share_buttons' ) ) suka_core_render_share_buttons(); ?>

			<nav class="post-navigation-modern" aria-label="<?php esc_attr_e( 'Navigasi artikel', 'suka-news' ); ?>">
				<div><?php previous_post_link( '<span>' . esc_html__( 'Berita sebelumnya', 'suka-news' ) . '</span>%link', '%title' ); ?></div>
				<div><?php next_post_link( '<span>' . esc_html__( 'Berita selanjutnya', 'suka-news' ) . '</span>%link', '%title' ); ?></div>
			</nav>

			<?php
			$related_query = new WP_Query(
				array(
					'post_type'           => 'post',
					'posts_per_page'      => 3,
					'post__not_in'        => array( get_the_ID() ),
					'category__in'        => wp_list_pluck( $categories, 'term_id' ),
					'ignore_sticky_posts' => true,
				)
			);
			?>
			<?php if ( $related_query->have_posts() ) : ?>
				<section class="related-news" aria-labelledby="related-news-title">
					<h2 id="related-news-title" class="section-title"><?php esc_html_e( 'Berita Terkait', 'suka-news' ); ?></h2>
					<div class="related-news__grid">
						<?php while ( $related_query->have_posts() ) : ?>
							<?php $related_query->the_post(); ?>
							<article class="related-card">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail( 'suka-related-card', array( 'loading' => 'lazy' ) ); ?></a>
								<?php endif; ?>
								<?php echo wp_kses_post( suka_news_satu_get_category_bubbles() ); ?>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php echo suka_news_satu_get_news_meta(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Seluruh nilai dinamis di-escape di dalam helper. ?>
							</article>
						<?php endwhile; ?>
					</div>
				</section>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</article>

		<?php get_sidebar(); ?>
	</div>
<?php endwhile; ?>

<?php get_footer(); ?>
