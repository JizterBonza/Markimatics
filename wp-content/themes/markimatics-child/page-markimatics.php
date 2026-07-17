<?php
/**
 * Template Name: Markimatics Landing
 *
 * Full-page landing template using the Markimatics design system.
 *
 * @package Markimatics_Child
 */

defined( 'ABSPATH' ) || exit;

$mk_assets = get_stylesheet_directory_uri() . '/markimatics';
$mk_home   = get_permalink();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'mk-body' ); ?>>
<?php wp_body_open(); ?>

	<header class="mk-header" id="mk-header">
		<div class="mk-container mk-header__inner">
			<a href="<?php echo esc_url( $mk_home ); ?>" class="mk-logo">
				<img src="<?php echo esc_url( $mk_assets . '/images/logo-icon.svg' ); ?>" alt="" class="mk-logo__icon" width="36" height="36">
				<span class="mk-logo__text"><?php bloginfo( 'name' ); ?></span>
			</a>

			<button class="mk-nav-toggle" id="mk-nav-toggle" aria-label="<?php esc_attr_e( 'Toggle navigation', 'markimatics-child' ); ?>" aria-expanded="false">
				<span></span>
				<span></span>
				<span></span>
			</button>

			<nav class="mk-nav" id="mk-nav" aria-label="<?php esc_attr_e( 'Main navigation', 'markimatics-child' ); ?>">
				<a href="<?php echo esc_url( $mk_home . '#home' ); ?>" class="mk-nav__link mk-nav__link--active"><?php esc_html_e( 'Home', 'markimatics-child' ); ?></a>
				<a href="<?php echo esc_url( $mk_home . '#about' ); ?>" class="mk-nav__link"><?php esc_html_e( 'About', 'markimatics-child' ); ?></a>
				<a href="<?php echo esc_url( $mk_home . '#courses' ); ?>" class="mk-nav__link"><?php esc_html_e( 'Courses', 'markimatics-child' ); ?></a>
				<!-- <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="mk-nav__link"><?php esc_html_e( 'Blog', 'markimatics-child' ); ?></a> -->
				<a href="<?php echo esc_url( $mk_home . '#contact' ); ?>" class="mk-nav__link"><?php esc_html_e( 'Contact', 'markimatics-child' ); ?></a>
			</nav>

			<a href="<?php echo esc_url( $mk_home . '#courses' ); ?>" class="mk-btn mk-btn--accent mk-header__cta"><?php esc_html_e( 'Get Started', 'markimatics-child' ); ?></a>
		</div>
	</header>

	<main>
		<section class="mk-hero" id="home" aria-label="<?php esc_attr_e( 'Hero', 'markimatics-child' ); ?>">
			<div class="mk-container">
				<div class="mk-hero__content">
					<h1 class="mk-hero__title">
						<?php esc_html_e( 'Unlock Your Potential.', 'markimatics-child' ); ?><br>
						<span class="mk-hero__title-accent"><?php esc_html_e( 'Master Your Future.', 'markimatics-child' ); ?></span>
					</h1>
					<p class="mk-hero__subtitle"><?php esc_html_e( 'Expert Learning for Every Student', 'markimatics-child' ); ?></p>
					<a href="<?php echo esc_url( $mk_home . '#courses' ); ?>" class="mk-btn mk-btn--primary"><?php esc_html_e( 'Explore Courses', 'markimatics-child' ); ?></a>
				</div>
			</div>
		</section>

		<section class="mk-section" id="courses" aria-label="<?php esc_attr_e( 'Course categories', 'markimatics-child' ); ?>">
			<div class="mk-container">
				<div class="mk-courses__grid">

					<article class="mk-course-card mk-course-card--ela">
						<div class="mk-course-card__content">
							<h2 class="mk-course-card__title"><?php esc_html_e( 'ELA', 'markimatics-child' ); ?></h2>
							<p class="mk-course-card__desc"><?php esc_html_e( 'English Language Arts', 'markimatics-child' ); ?></p>
							<a href="#" class="mk-btn mk-btn--primary mk-btn--sm"><?php esc_html_e( 'Learn More', 'markimatics-child' ); ?></a>
						</div>
					</article>

					<article class="mk-course-card mk-course-card--science">
						<div class="mk-course-card__content">
							<h2 class="mk-course-card__title"><?php esc_html_e( 'Science', 'markimatics-child' ); ?></h2>
							<p class="mk-course-card__desc"><?php esc_html_e( 'Explore the World of Science', 'markimatics-child' ); ?></p>
							<a href="#" class="mk-btn mk-btn--primary mk-btn--sm"><?php esc_html_e( 'Learn More', 'markimatics-child' ); ?></a>
						</div>
					</article>

					<article class="mk-course-card mk-course-card--math">
						<div class="mk-course-card__content">
							<h2 class="mk-course-card__title"><?php esc_html_e( 'Math', 'markimatics-child' ); ?></h2>
							<p class="mk-course-card__desc"><?php esc_html_e( 'Mathematics Made Easy', 'markimatics-child' ); ?></p>
							<a href="#" class="mk-btn mk-btn--primary mk-btn--sm"><?php esc_html_e( 'Learn More', 'markimatics-child' ); ?></a>
						</div>
					</article>

					<article class="mk-course-card mk-course-card--nclex">
						<div class="mk-course-card__content">
							<h2 class="mk-course-card__title"><?php esc_html_e( 'NCLEX', 'markimatics-child' ); ?></h2>
							<p class="mk-course-card__desc"><?php esc_html_e( 'Nursing Exam Prep', 'markimatics-child' ); ?></p>
							<a href="#" class="mk-btn mk-btn--primary mk-btn--sm"><?php esc_html_e( 'Learn More', 'markimatics-child' ); ?></a>
						</div>
					</article>

				</div>
			</div>
		</section>

		<section class="mk-section mk-section--light" id="about" aria-label="<?php esc_attr_e( 'Why Markimatics', 'markimatics-child' ); ?>">
			<div class="mk-container">
				<header class="mk-section__header">
					<h2 class="mk-section__title"><?php esc_html_e( 'Empowering Your Learning Journey.', 'markimatics-child' ); ?></h2>
					<p class="mk-section__subtitle"><?php esc_html_e( 'Achieve Success with Markimatics!', 'markimatics-child' ); ?></p>
				</header>

				<div class="mk-features__grid">
					<article class="mk-feature-card">
						<img src="<?php echo esc_url( $mk_assets . '/images/icon-graduation.svg' ); ?>" alt="" class="mk-feature-card__icon" width="64" height="64">
						<h3 class="mk-feature-card__title"><?php esc_html_e( 'Expert Instructors', 'markimatics-child' ); ?></h3>
					</article>

					<article class="mk-feature-card">
						<img src="<?php echo esc_url( $mk_assets . '/images/icon-chart.svg' ); ?>" alt="" class="mk-feature-card__icon" width="64" height="64">
						<h3 class="mk-feature-card__title"><?php esc_html_e( 'Comprehensive Courses', 'markimatics-child' ); ?></h3>
					</article>

					<article class="mk-feature-card">
						<img src="<?php echo esc_url( $mk_assets . '/images/icon-calendar.svg' ); ?>" alt="" class="mk-feature-card__icon" width="64" height="64">
						<h3 class="mk-feature-card__title"><?php esc_html_e( 'Flexible Learning', 'markimatics-child' ); ?></h3>
					</article>
				</div>
			</div>
		</section>
	</main>

	<footer class="mk-footer" id="contact">
		<div class="mk-container">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'markimatics-child' ); ?></p>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
