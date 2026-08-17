<?php
/**
 * Template halaman statis.
 *
 * @package Suka_News_Satu
 */

get_header();
?>

<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>
	<div class="page-layout">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'static-page' ); ?>>
			<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'suka-news' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Beranda', 'suka-news' ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php the_title(); ?></span>
			</nav>

			<header class="static-page__header">
				<p><?php esc_html_e( 'Informasi', 'suka-news' ); ?></p>
				<h1><?php the_title(); ?></h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="static-page__image"><?php the_post_thumbnail( 'suka-news-wide' ); ?></figure>
			<?php endif; ?>

			<div class="static-page__content article-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
		</article>

		<?php get_sidebar(); ?>
	</div>
<?php endwhile; ?>

<?php get_footer(); ?>
