<?php
/**
 * Template Name: Markimatics Subject
 *
 * Subject hub page: hero + grade-level cards (child pages).
 *
 * Optional custom fields on the subject page:
 * - mk_subtitle  — e.g. "Kinder thru Grade 8"
 *
 * Child pages become grade cards (title, excerpt, featured image, permalink).
 *
 * @package Markimatics_Child
 */

defined( 'ABSPATH' ) || exit;

$mk_assets = get_stylesheet_directory_uri() . '/markimatics';
$mk_home   = home_url( '/' );

// Prefer the Markimatics landing page for "back" and logo links.
$mk_landing = get_pages(
	array(
		'meta_key'   => '_wp_page_template',
		'meta_value' => 'page-markimatics.php',
		'number'     => 1,
	)
);
if ( ! empty( $mk_landing ) ) {
	$mk_home = get_permalink( $mk_landing[0] );
}

$subject_id    = get_the_ID();
$subject_post  = get_post( $subject_id );
$subject_title = get_the_title( $subject_id );
$subject_slug  = $subject_post instanceof WP_Post ? $subject_post->post_name : '';
$subtitle      = get_post_meta( $subject_id, 'mk_subtitle', true );
$description   = '';

if ( $subject_post instanceof WP_Post ) {
	$description = $subject_post->post_excerpt
		? $subject_post->post_excerpt
		: wp_trim_words( wp_strip_all_tags( $subject_post->post_content ), 40 );
}

// Science uses a full-bleed CSS banner; other subjects may show a side illustration.
$hero_image = null;
if ( 'science' !== $subject_slug ) {
	$hero_fallbacks = array(
		'ela'   => $mk_assets . '/images/ELA_bg.png',
		'math'  => $mk_assets . '/images/Math_bg.png',
		'nclex' => $mk_assets . '/images/NCLEX_bg.png',
	);

	$hero_image = get_the_post_thumbnail_url( $subject_id, 'large' );
	if ( ! $hero_image && isset( $hero_fallbacks[ $subject_slug ] ) ) {
		$hero_image = $hero_fallbacks[ $subject_slug ];
	}
}

$grade_colors = array(
	'#f1c40f',
	'#e67e22',
	'#e74c3c',
	'#e91e8c',
	'#9b59b6',
	'#5c6bc0',
	'#42a5f5',
	'#26a69a',
);

// Prefer predefined subject grades (e.g. Science); fall back to child pages.
$grade_cards = markimatics_get_subject_grades( $subject_slug );

if ( empty( $grade_cards ) ) {
	$child_pages = get_pages(
		array(
			'parent'      => $subject_id,
			'sort_column' => 'menu_order,post_title',
			'sort_order'  => 'ASC',
		)
	);

	foreach ( $child_pages as $index => $grade ) {
		$grade_cards[] = array(
			'label' => $grade->post_title,
			'slug'  => $grade->post_name,
			'color' => $grade_colors[ $index % count( $grade_colors ) ],
			'url'   => get_permalink( $grade->ID ),
			'image' => get_the_post_thumbnail_url( $grade->ID, 'medium_large' ),
		);
	}
} else {
	foreach ( $grade_cards as $index => $grade ) {
		$grade_cards[ $index ]['url']   = markimatics_get_grade_url( $subject_id, $grade['slug'] );
		$grade_cards[ $index ]['image'] = markimatics_get_grade_card_image(
			$subject_slug,
			$grade['slug'],
			$subject_title,
			$grade['label']
		);
	}
}

$subject_modifier = sanitize_html_class( $subject_slug );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'mk-body mk-body--subject' ); ?>>
<?php wp_body_open(); ?>

	<main>
		<section class="mk-subject-hero mk-subject-hero--<?php echo esc_attr( $subject_modifier ); ?>" aria-label="<?php echo esc_attr( $subject_title ); ?>">
			<div class="mk-subject-hero__stars" aria-hidden="true"></div>
			<div class="mk-container mk-subject-hero__inner">
				<div class="mk-subject-hero__text">
					<a href="<?php echo esc_url( $mk_home ); ?>" class="mk-subject-hero__back">
						<span class="mk-subject-hero__back-arrow" aria-hidden="true">←</span>
						<?php echo esc_html( $subject_title ); ?>
					</a>

					<h1 class="mk-subject-hero__title"><?php echo esc_html( $subject_title ); ?></h1>

					<?php if ( $subtitle ) : ?>
						<p class="mk-subject-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
					<?php endif; ?>

					<?php if ( $description ) : ?>
						<p class="mk-subject-hero__desc"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( $hero_image ) : ?>
					<div class="mk-subject-hero__media">
						<img
							src="<?php echo esc_url( $hero_image ); ?>"
							alt=""
							class="mk-subject-hero__img"
							width="480"
							height="360"
						>
					</div>
				<?php endif; ?>
			</div>
		</section>

		<section class="mk-section mk-grades" aria-label="<?php esc_attr_e( 'Grade levels', 'markimatics-child' ); ?>">
			<div class="mk-container">
				<header class="mk-grades__header">
					<img
						src="<?php echo esc_url( $mk_assets . '/images/icon-books.svg' ); ?>"
						alt=""
						class="mk-grades__icon"
						width="40"
						height="40"
					>
					<h2 class="mk-grades__title" style="margin-bottom: 0px;"><?php esc_html_e( 'Select a Grade Level', 'markimatics-child' ); ?></h2>
				</header>

				<?php if ( ! empty( $grade_cards ) ) : ?>
					<div class="mk-grades__grid">
						<?php foreach ( $grade_cards as $grade ) : ?>
							<?php
							$color       = isset( $grade['color'] ) ? $grade['color'] : '#9b8572';
							$grade_label = $grade['label'];
							$grade_slug  = isset( $grade['slug'] ) ? $grade['slug'] : sanitize_title( $grade_label );
							$grade_url   = ! empty( $grade['url'] ) ? $grade['url'] : '#';
							$grade_img   = ! empty( $grade['image'] ) ? $grade['image'] : null;
							$card_mod    = sanitize_html_class( $subject_modifier . '-' . $grade_slug );
							?>
							<article
								class="mk-grade-card mk-grade-card--<?php echo esc_attr( $card_mod ); ?><?php echo $grade_img ? ' mk-grade-card--has-art' : ''; ?>"
								style="--mk-grade-color: <?php echo esc_attr( $color ); ?>;"
							>
								<div class="mk-grade-card__header">
									<h3 class="mk-grade-card__title"><?php echo esc_html( $grade_label ); ?></h3>
								</div>

								<div
									class="mk-grade-card__body"
									<?php if ( $grade_img ) : ?>
										style="--mk-grade-body-bg: url('<?php echo esc_url( $grade_img ); ?>');"
									<?php endif; ?>
								>
									<?php if ( ! $grade_img ) : ?>
										<div class="mk-grade-card__img mk-grade-card__img--placeholder" aria-hidden="true"></div>
									<?php else : ?>
										<div class="mk-grade-card__art" aria-hidden="true"></div>
									<?php endif; ?>

									<a href="<?php echo esc_url( $grade_url ); ?>" class="mk-grade-card__btn">
										<?php esc_html_e( 'View Lessons', 'markimatics-child' ); ?>
									</a>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<p class="mk-grades__empty">
						<?php esc_html_e( 'Grade levels coming soon. Add child pages under this subject to list them here.', 'markimatics-child' ); ?>
					</p>
				<?php endif; ?>
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
