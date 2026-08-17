<?php
/**
 * Kartu artikel untuk News Feed halaman depan.
 *
 * @package Suka_News_Satu
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'feed-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="feed-card__thumbnail" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'suka-feed-card', array( 'loading' => 'lazy' ) ); ?>
		</a>
	<?php endif; ?>

	<div class="feed-card__content">
		<?php echo wp_kses_post( suka_news_satu_get_category_bubbles() ); ?>
		<h3 class="feed-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php echo suka_news_satu_get_news_meta(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Seluruh nilai dinamis di-escape di dalam helper. ?>
		<div class="feed-card__excerpt"><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 12, '…' ) ); ?></p></div>
	</div>
</article>
