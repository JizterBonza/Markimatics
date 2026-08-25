<?php
/**
 * Template Name: Markimatics Grade
 *
 * Grade hub page: hero + lesson (task card) grid for a subject grade level.
 *
 * Expected page setup:
 * - Parent page uses the Markimatics Subject template (e.g. Science).
 * - This page slug matches the grade slug (e.g. grade-5, kinder).
 *
 * Optional custom fields:
 * - mk_subject_slug — override subject slug if parent is not the subject page
 * - mk_grade_slug   — override grade slug if the page slug differs
 * - mk_subtitle     — optional hero subtitle
 *
 * @package Markimatics_Child
 */

defined( 'ABSPATH' ) || exit;

$mk_assets = get_stylesheet_directory_uri() . '/markimatics';
$mk_home   = home_url( '/' );

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

$grade_id   = get_the_ID();
$grade_post = get_post( $grade_id );
$parent_id  = $grade_post instanceof WP_Post ? (int) $grade_post->post_parent : 0;
$parent     = $parent_id ? get_post( $parent_id ) : null;

$subject_slug = get_post_meta( $grade_id, 'mk_subject_slug', true );
if ( ! $subject_slug && $parent instanceof WP_Post ) {
	$subject_slug = $parent->post_name;
}
$subject_slug = sanitize_title( (string) $subject_slug );

$grade_slug = get_post_meta( $grade_id, 'mk_grade_slug', true );
if ( ! $grade_slug && $grade_post instanceof WP_Post ) {
	$grade_slug = $grade_post->post_name;
}
$grade_slug = sanitize_title( (string) $grade_slug );

$subject_title = $parent instanceof WP_Post ? get_the_title( $parent ) : ucwords( str_replace( '-', ' ', $subject_slug ) );
$subject_url   = $parent instanceof WP_Post ? get_permalink( $parent ) : markimatics_get_subject_url( $subject_slug );

$grade_label = get_the_title( $grade_id );
$grade_meta  = null;
foreach ( markimatics_get_subject_grades( $subject_slug ) as $grade ) {
	if ( sanitize_title( $grade['slug'] ) === $grade_slug ) {
		$grade_meta  = $grade;
		$grade_label = $grade['label'];
		break;
	}
}

$subtitle    = get_post_meta( $grade_id, 'mk_subtitle', true );
$description = '';
if ( $grade_post instanceof WP_Post ) {
	$description = $grade_post->post_excerpt
		? $grade_post->post_excerpt
		: wp_trim_words( wp_strip_all_tags( $grade_post->post_content ), 40 );
}

if ( ! $subtitle ) {
	$subtitle = sprintf(
		/* translators: 1: subject title, 2: grade label */
		__( '%1$s · %2$s', 'markimatics-child' ),
		$subject_title,
		$grade_label
	);
}

$hero_modifier = sanitize_html_class( $subject_slug );
$grade_color   = isset( $grade_meta['color'] ) ? $grade_meta['color'] : '#004a99';

$lesson_cards = markimatics_get_grade_lessons( $subject_slug, $grade_slug );

if ( empty( $lesson_cards ) ) {
	$child_pages = get_pages(
		array(
			'parent'      => $grade_id,
			'sort_column' => 'menu_order,post_title',
			'sort_order'  => 'ASC',
		)
	);

	foreach ( $child_pages as $lesson ) {
		$lesson_cards[] = array(
			'title' => $lesson->post_title,
			'label' => $lesson->post_title,
			'slug'  => $lesson->post_name,
			'url'   => get_permalink( $lesson->ID ),
			'image' => get_the_post_thumbnail_url( $lesson->ID, 'large' ),
		);
	}
} else {
	foreach ( $lesson_cards as $index => $lesson ) {
		if ( empty( $lesson['image'] ) ) {
			$lesson_cards[ $index ]['image'] = markimatics_get_lesson_card_image(
				$subject_slug,
				$grade_slug,
				isset( $lesson['slug'] ) ? $lesson['slug'] : ''
			);
		}
	}
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'mk-body mk-body--grade' ); ?>>
<?php wp_body_open(); ?>

	<main>
		<section
			class="mk-subject-hero mk-subject-hero--<?php echo esc_attr( $hero_modifier ); ?> mk-grade-hero"
			aria-label="<?php echo esc_attr( $grade_label ); ?>"
			style="--mk-grade-color: <?php echo esc_attr( $grade_color ); ?>;"
		>
			<div class="mk-subject-hero__stars" aria-hidden="true"></div>
			<div class="mk-container mk-subject-hero__inner">
				<div class="mk-subject-hero__text">
					<a href="<?php echo esc_url( $subject_url ); ?>" class="mk-subject-hero__back">
						<span class="mk-subject-hero__back-arrow" aria-hidden="true">←</span>
						<?php echo esc_html( $subject_title ); ?>
					</a>

					<h1 class="mk-subject-hero__title"><?php echo esc_html( $grade_label ); ?></h1>

					<?php if ( $subtitle ) : ?>
						<p class="mk-subject-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
					<?php endif; ?>

					<?php if ( $description ) : ?>
						<p class="mk-subject-hero__desc"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="mk-section mk-lessons" aria-label="<?php esc_attr_e( 'Lessons', 'markimatics-child' ); ?>">
			<div class="mk-container">
				<header class="mk-lessons__header">
					<img
						src="<?php echo esc_url( $mk_assets . '/images/icon-books.svg' ); ?>"
						alt=""
						class="mk-lessons__icon"
						width="40"
						height="40"
					>
					<h2 class="mk-lessons__title" style="margin-bottom: 0px;"><?php esc_html_e( 'Select a Lesson', 'markimatics-child' ); ?></h2>
				</header>

				<span class="mk-lesson-card__label">Task Cards</span> <br>

				<?php if ( ! empty( $lesson_cards ) ) : ?>
					<div class="mk-lessons__grid">
						<?php foreach ( $lesson_cards as $lesson ) : ?>
							<?php
							$lesson_title  = isset( $lesson['title'] ) ? $lesson['title'] : '';
							$lesson_label  = ! empty( $lesson['label'] ) ? $lesson['label'] : $lesson_title;
							$lesson_url    = ! empty( $lesson['url'] ) ? $lesson['url'] : '';
							$lesson_image  = ! empty( $lesson['image'] ) ? $lesson['image'] : '';
							$lesson_badge  = ! empty( $lesson['badge'] ) ? $lesson['badge'] : __( 'TASK CARD', 'markimatics-child' );
							$lesson_count  = isset( $lesson['count'] ) ? $lesson['count'] : '';
							$lesson_action = isset( $lesson['action'] ) ? $lesson['action'] : __( 'Print, Cut, Laminate', 'markimatics-child' );
							$difficulties  = ! empty( $lesson['difficulties'] ) && is_array( $lesson['difficulties'] )
								? $lesson['difficulties']
								: array( 'easy', 'moderate', 'challenging', 'hard' );
							$has_cover     = (bool) $lesson_image;
							$is_external   = $lesson_url && ( 0 === strpos( $lesson_url, 'http://' ) || 0 === strpos( $lesson_url, 'https://' ) );
							$difficulty_labels = array(
								'easy'        => __( 'EASY', 'markimatics-child' ),
								'moderate'    => __( 'MODERATE', 'markimatics-child' ),
								'challenging' => __( 'CHALLENGING', 'markimatics-child' ),
								'hard'        => __( 'HARD', 'markimatics-child' ),
							);
							?>
							<article class="mk-lesson-card<?php echo $has_cover ? ' mk-lesson-card--has-cover' : ''; ?>">
								<?php if ( $lesson_url ) : ?>
									<a
										href="<?php echo esc_url( $lesson_url ); ?>"
										class="mk-lesson-card__link"
										<?php if ( $is_external ) : ?>
											target="_blank"
											rel="noopener noreferrer"
										<?php endif; ?>
									>
								<?php else : ?>
									<div class="mk-lesson-card__link mk-lesson-card__link--disabled">
								<?php endif; ?>

									<div class="mk-lesson-card__visual">
										<?php if ( $has_cover ) : ?>
											<img
												src="<?php echo esc_url( $lesson_image ); ?>"
												alt="<?php echo esc_attr( $lesson_title ); ?>"
												class="mk-lesson-card__cover"
												loading="lazy"
											>
										<?php else : ?>
											<div class="mk-lesson-card__composed" aria-hidden="false">
												<span class="mk-lesson-card__ribbon"><?php echo esc_html( $lesson_badge ); ?></span>

												<div class="mk-lesson-card__title-bar">
													<h3 class="mk-lesson-card__title"><?php echo esc_html( $lesson_title ); ?></h3>
												</div>

												<div class="mk-lesson-card__meta">
													<?php if ( $lesson_count ) : ?>
														<span class="mk-lesson-card__count"><?php echo esc_html( $lesson_count ); ?></span>
													<?php endif; ?>
													<span class="mk-lesson-card__action"><?php echo esc_html( $lesson_action ); ?></span>
												</div>

												<div class="mk-lesson-card__preview">
													<span class="mk-lesson-card__preview-card mk-lesson-card__preview-card--1"></span>
													<span class="mk-lesson-card__preview-card mk-lesson-card__preview-card--2"></span>
													<span class="mk-lesson-card__preview-card mk-lesson-card__preview-card--3"></span>
													<span class="mk-lesson-card__preview-card mk-lesson-card__preview-card--4"></span>
												</div>

												<ul class="mk-lesson-card__levels">
													<?php foreach ( $difficulties as $level ) : ?>
														<?php
														$level_key = sanitize_title( $level );
														$level_text = isset( $difficulty_labels[ $level_key ] )
															? $difficulty_labels[ $level_key ]
															: strtoupper( $level );
														?>
														<li class="mk-lesson-card__level mk-lesson-card__level--<?php echo esc_attr( $level_key ); ?>">
															<span class="mk-lesson-card__level-check" aria-hidden="true">✓</span>
															<span class="mk-lesson-card__level-label"><?php echo esc_html( $level_text ); ?></span>
														</li>
													<?php endforeach; ?>
												</ul>
											</div>
										<?php endif; ?>
									</div>

									<span class="mk-lesson-card__label"><?php echo esc_html( $lesson_label ); ?></span>

								<?php if ( $lesson_url ) : ?>
									</a>
								<?php else : ?>
									</div>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<p class="mk-lessons__empty">
						<?php esc_html_e( 'Lessons coming soon. Add lesson entries for this grade, or create child pages under this grade page.', 'markimatics-child' ); ?>
					</p>
				<?php endif; ?>
				<span class="mk-lesson-card__label">Exit Tickets</span> <br
			</div>
		</section>
	</main>

	<?php get_template_part( 'markimatics-footer', null, array( 'home_url' => $mk_home ) ); ?>

	<?php wp_footer(); ?>
</body>
</html>
