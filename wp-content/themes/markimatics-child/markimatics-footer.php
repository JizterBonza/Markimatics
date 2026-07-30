<?php
/**
 * Shared footer for the Markimatics custom templates.
 *
 * @package Markimatics_Child
 */

defined( 'ABSPATH' ) || exit;

$mk_footer_home = isset( $args['home_url'] ) ? $args['home_url'] : home_url( '/' );
$mk_footer_assets = get_stylesheet_directory_uri() . '/markimatics';
$mk_footer_courses = array(
	'ELA'     => markimatics_get_subject_url( 'ela' ),
	'Science' => markimatics_get_subject_url( 'science' ),
	'Math'    => markimatics_get_subject_url( 'math' ),
	'NCLEX'   => markimatics_get_subject_url( 'nclex' ),
);
$mk_footer_socials = array(
	'facebook'  => array(
		'label' => __( 'Facebook', 'markimatics-child' ),
		'url'   => 'https://www.facebook.com/markimatics/',
	),
	'instagram' => array(
		'label' => __( 'Instagram', 'markimatics-child' ),
		'url'   => 'https://www.instagram.com/markimatics/',
	),
	'pinterest' => array(
		'label' => __( 'Pinterest', 'markimatics-child' ),
		'url'   => 'https://www.pinterest.com/markimatics/',
	),
);
?>
<footer class="mk-footer" id="contact">
	<div class="mk-container">
		<div class="mk-footer__grid">
			<div class="mk-footer__brand">
				<a href="<?php echo esc_url( $mk_footer_home ); ?>" class="mk-footer__logo">
					<img src="<?php echo esc_url( $mk_footer_assets . '/images/logo-icon.svg' ); ?>" alt="" width="42" height="42">
					<span><?php bloginfo( 'name' ); ?></span>
				</a>
				<p><?php esc_html_e( 'High-yield study resources for students and future nurses.', 'markimatics-child' ); ?></p>

				<div class="mk-footer__socials">
					<?php foreach ( $mk_footer_socials as $network => $social ) : ?>
						<a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
							<?php if ( 'facebook' === $network ) : ?>
								<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4.5A15 15 0 0 0 14.4 4C11.8 4 10 5.6 10 8.6V11H7v4h3v7h4v-7h3l.5-4H14V8.8c0-.6.2-.8 1-.8Z"/></svg>
							<?php elseif ( 'instagram' === $network ) : ?>
								<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7Zm10.5 1.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/></svg>
							<?php else : ?>
								<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.2 2C6.7 2 4 6 4 9.3c0 2.5 1 4.8 3 5.6.3.1.5 0 .6-.3l.2-1.3c.1-.4.1-.5-.2-.8-.6-.7-1-1.7-1-3 0-3.8 2.8-7.2 7.4-7.2 4 0 6.3 2.5 6.3 5.8 0 4.3-1.9 8-4.8 8-1.6 0-2.7-1.3-2.4-2.9.5-1.9 1.3-3.9 1.3-5.2 0-1.2-.6-2.2-2-2.2-1.5 0-2.8 1.6-2.8 3.8 0 1.4.5 2.3.5 2.3L8.2 20c-.5 2.3-.1 5.1 0 5.4l.3.1c.2-.2 2.3-2.9 3-5.5l.9-3.4c.5.8 1.8 1.5 3.3 1.5 4.4 0 7.3-4 7.3-9.3C23 4.8 19.6 2 12.2 2Z"/></svg>
							<?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>

			<nav class="mk-footer__nav" aria-label="<?php esc_attr_e( 'Course links', 'markimatics-child' ); ?>">
				<h2><?php esc_html_e( 'Courses', 'markimatics-child' ); ?></h2>
				<ul>
					<?php foreach ( $mk_footer_courses as $label => $url ) : ?>
						<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<nav class="mk-footer__nav" aria-label="<?php esc_attr_e( 'Company links', 'markimatics-child' ); ?>">
				<h2><?php esc_html_e( 'Company', 'markimatics-child' ); ?></h2>
				<ul>
					<li><a href="<?php echo esc_url( $mk_footer_home . '#about' ); ?>"><?php esc_html_e( 'About', 'markimatics-child' ); ?></a></li>
					<li><a href="<?php echo esc_url( $mk_footer_home . '#contact' ); ?>"><?php esc_html_e( 'Contact', 'markimatics-child' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'markimatics-child' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/help-center/' ) ); ?>"><?php esc_html_e( 'Help Center', 'markimatics-child' ); ?></a></li>
				</ul>
			</nav>

			<nav class="mk-footer__nav" aria-label="<?php esc_attr_e( 'Legal links', 'markimatics-child' ); ?>">
				<h2><?php esc_html_e( 'Legal', 'markimatics-child' ); ?></h2>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/terms-of-use/' ) ); ?>"><?php esc_html_e( 'Terms of Use', 'markimatics-child' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_privacy_policy_url() ?: home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'markimatics-child' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/refund-policy/' ) ); ?>"><?php esc_html_e( 'Refund Policy', 'markimatics-child' ); ?></a></li>
				</ul>
			</nav>

		</div>

		<p class="mk-footer__copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'markimatics-child' ); ?></p>
	</div>
</footer>
