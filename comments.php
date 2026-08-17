<?php
/**
 * Template komentar artikel.
 *
 * @package Suka_News_Satu
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf(
				/* translators: %s: jumlah komentar. */
				esc_html( _n( '%s Komentar', '%s Komentar', get_comments_number(), 'suka-news' ) ),
				esc_html( number_format_i18n( get_comments_number() ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 48 ) ); ?>
		</ol>

		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Komentar telah ditutup.', 'suka-news' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'        => __( 'Tulis Komentar', 'suka-news' ),
			'label_submit'       => __( 'Kirim Komentar', 'suka-news' ),
			'class_submit'       => 'submit-comment',
			'comment_notes_after' => '',
		)
	);
	?>
</section>
