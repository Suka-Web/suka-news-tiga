</main>

<footer class="site-footer">
	<div class="footer-container">
		<div class="footer-brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php $white_footer_logo = (bool) get_theme_mod( 'suka_news_satu_footer_white_logo', true ); ?>
				<div class="footer-logo<?php echo $white_footer_logo ? ' footer-logo--white' : ''; ?>">
					<?php the_custom_logo(); ?>
				</div>
			<?php endif; ?>

			<?php $footer_description = get_theme_mod( 'suka_news_satu_footer_description', '' ); ?>
			<?php if ( $footer_description ) : ?>
				<p class="footer-description"><?php echo nl2br( esc_html( $footer_description ) ); ?></p>
			<?php endif; ?>

			<p class="footer-copyright">
				&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?>
				<?php bloginfo( 'name' ); ?>.
				<?php esc_html_e( 'All rights reserved. Design by', 'suka-news' ); ?>
				<a href="https://suka-web.com/" target="_blank" rel="noopener noreferrer">suka-web.com</a>
			</p>
		</div>

		<div class="footer-content">
			<section class="footer-newsletter" aria-labelledby="footer-newsletter-title">
				<div>
					<h2 id="footer-newsletter-title"><?php esc_html_e( 'Berlangganan Newsletter', 'suka-news' ); ?></h2>
					<p><?php esc_html_e( 'Dapatkan rangkuman berita pilihan langsung melalui email.', 'suka-news' ); ?></p>
				</div>
				<form class="newsletter-form" action="#" method="post">
					<label class="screen-reader-text" for="footer-newsletter-email">
						<?php esc_html_e( 'Alamat email', 'suka-news' ); ?>
					</label>
					<input id="footer-newsletter-email" type="email" name="newsletter_email" placeholder="<?php esc_attr_e( 'Alamat email Anda', 'suka-news' ); ?>" required>
					<button type="submit"><?php esc_html_e( 'Daftar', 'suka-news' ); ?></button>
				</form>
			</section>

			<div class="footer-social" aria-label="<?php esc_attr_e( 'Media sosial', 'suka-news' ); ?>">
				<?php
				$social_links = array(
					'facebook'  => array( 'Facebook', '<path d="M14 8h3V4h-3c-3 0-5 2-5 5v3H6v4h3v8h4v-8h3.5l.5-4h-4V9c0-.7.3-1 1-1Z"/>' ),
					'instagram' => array( 'Instagram', '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" class="icon-fill"/>' ),
					'x'         => array( 'X', '<path d="M5 4l14 16M19 4 5 20"/>' ),
					'youtube'   => array( 'YouTube', '<path d="M22 12s0-4-1-6c-.5-1-1.5-1.5-2.5-1.5C16.5 4 12 4 12 4s-4.5 0-6.5.5C4.5 4.5 3.5 5 3 6c-1 2-1 6-1 6s0 4 1 6c.5 1 1.5 1.5 2.5 1.5C7.5 20 12 20 12 20s4.5 0 6.5-.5c1 0 2-.5 2.5-1.5 1-2 1-6 1-6Z"/><path d="m10 9 5 3-5 3V9Z" class="icon-fill"/>' ),
					'tiktok'    => array( 'TikTok', '<path class="icon-fill" d="M14.2 3h3.1c.3 1.7 1.3 3.1 3.2 3.6v3.1a8.3 8.3 0 0 1-3.2-1v6.1a6 6 0 1 1-5.2-5.9V12a2.9 2.9 0 1 0 2.1 2.8V3Z"/>' ),
					'threads'   => array( 'Threads', '<circle cx="12" cy="12" r="9"/><path d="M8.5 9.2c.7-1.8 4.8-2.5 6.5-.4 1.6 2 .8 6.6-2.5 7-2.8.4-4.1-2.7-2.2-4.2 1.5-1.2 5-.5 6.3.7"/>' ),
				);

				foreach ( $social_links as $network => $social ) {
					$url = get_theme_mod( 'suka_news_satu_social_' . $network, '' );
					if ( ! $url ) {
						continue;
					}
					?>
					<a class="footer-social__link footer-social__link--<?php echo esc_attr( $network ); ?>" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"<?php $color = get_theme_mod( 'suka_news_satu_social_color_' . $network, '' ); echo $color ? ' style="--social-color:' . esc_attr( $color ) . '"' : ''; ?>>
						<span class="screen-reader-text"><?php echo esc_html( $social[0] ); ?></span>
						<svg viewBox="0 0 24 24" aria-hidden="true"><?php echo $social[1]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG ditulis statis oleh tema. ?></svg>
					</a>
					<?php
				}
				?>
			</div>

			<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Menu Sekunder', 'suka-news' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'secondary',
						'container'      => false,
						'fallback_cb'    => false,
						'menu_class'     => 'secondary-menu',
					)
				);
				?>
			</nav>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
