<?php
/**
 * Tampilan ringkas satu artikel di dalam daftar berita.
 *
 * @package Suka_News_Satu
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'large' ); ?>
		</a>
	<?php endif; ?>

	<?php echo wp_kses_post( suka_news_satu_get_category_bubbles() ); ?>

	<h2 class="post-card__title">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h2>

	<div class="post-card__meta">
		<?php echo suka_news_satu_get_news_meta(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Seluruh nilai dinamis di-escape di dalam helper. ?>
	</div>

	<div class="post-card__excerpt">
		<?php the_excerpt(); ?>
	</div>
</article>
