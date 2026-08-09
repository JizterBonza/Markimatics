<?php
/**
 * Markimatics Child Theme functions.
 *
 * @package Markimatics_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Markimatics full-page templates that use the custom design system.
 *
 * @return string[]
 */
function markimatics_page_templates() {
	return array( 'page-markimatics.php', 'page-subject.php', 'page-grade.php' );
}

/**
 * Whether the current view uses a Markimatics page template.
 *
 * @return bool
 */
function markimatics_is_template() {
	foreach ( markimatics_page_templates() as $template ) {
		if ( is_page_template( $template ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Resolve the permalink for a subject page by slug.
 *
 * Looks for a published page with the given slug that uses the Subject template.
 * Falls back to any page with that slug, then to a pretty URL path.
 *
 * @param string $slug Subject page slug (e.g. science, ela, math, nclex).
 * @return string
 */
function markimatics_get_subject_url( $slug ) {
	$slug = sanitize_title( $slug );

	$pages = get_posts(
		array(
			'name'           => $slug,
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-subject.php',
		)
	);

	if ( ! empty( $pages ) ) {
		return get_permalink( $pages[0] );
	}

	$page = get_page_by_path( $slug );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}

	return home_url( '/' . $slug . '/' );
}

/**
 * Grade-level card definitions for a subject.
 *
 * Optional store_url keeps the TeachersPayTeachers category for later use.
 * "View Lessons" uses markimatics_get_grade_url() (grade page), not store_url.
 *
 * @param string $subject_slug Subject page slug.
 * @return array<int, array{label: string, slug: string, color: string, store_url?: string}>
 */
function markimatics_get_subject_grades( $subject_slug ) {
	$catalog = array(
		'science' => array(
			array( 'label' => 'Kinder', 'slug' => 'kinder', 'color' => '#7cb342', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1496930' ),
			array( 'label' => 'Grade 1', 'slug' => 'grade-1', 'color' => '#9b8572', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1385095' ),
			array( 'label' => 'Grade 2', 'slug' => 'grade-2', 'color' => '#e67e22', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1376161' ),
			array( 'label' => 'Grade 3', 'slug' => 'grade-3', 'color' => '#e74c3c', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1375944' ),
			array( 'label' => 'Grade 4', 'slug' => 'grade-4', 'color' => '#e91e8c', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1378670' ),
			array( 'label' => 'Grade 5', 'slug' => 'grade-5', 'color' => '#9b59b6', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-__________________________-1375569' ),
			array( 'label' => 'Grade 6', 'slug' => 'grade-6', 'color' => '#5c6bc0', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1304684' ),
			array( 'label' => 'Grade 7', 'slug' => 'grade-7', 'color' => '#42a5f5', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1326376' ),
			array( 'label' => 'Grade 8', 'slug' => 'grade-8', 'color' => '#26a69a', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-__________________________-1326377' ),
			array( 'label' => 'HS Astronomy', 'slug' => 'hs-astronomy', 'color' => '#3949ab', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1394982' ),
			array( 'label' => 'HS Biology', 'slug' => 'hs-biology', 'color' => '#43a047', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1391063' ),
			array( 'label' => 'HS Chemistry', 'slug' => 'hs-chemistry', 'color' => '#fb8c00', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1391060' ),
			array( 'label' => 'HS Earth Science', 'slug' => 'hs-earth-science', 'color' => '#8d6e63', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-amp-1287791' ),
			array( 'label' => 'HS Physics', 'slug' => 'hs-physics', 'color' => '#5e35b1' ),
		),
		'math'    => array(
			array( 'label' => 'Pre-Kinder', 'slug' => 'pre-kinder', 'color' => '#26c6da' ),
			array( 'label' => 'Kinder', 'slug' => 'kinder', 'color' => '#7cb342', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1534845' ),
			array( 'label' => 'Grade 1', 'slug' => 'grade-1', 'color' => '#f1c40f', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1517573' ),
			array( 'label' => 'Grade 2', 'slug' => 'grade-2', 'color' => '#e67e22', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1434612' ),
			array( 'label' => 'Grade 3', 'slug' => 'grade-3', 'color' => '#e74c3c', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1564823' ),
			array( 'label' => 'Grade 4', 'slug' => 'grade-4', 'color' => '#e91e8c', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1557684' ),
			array( 'label' => 'Grade 5', 'slug' => 'grade-5', 'color' => '#9b59b6', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-__________________________-1434644' ),
			array( 'label' => 'Grade 6', 'slug' => 'grade-6', 'color' => '#5c6bc0', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1386221' ),
			array( 'label' => 'Grade 7', 'slug' => 'grade-7', 'color' => '#42a5f5', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1386220' ),
			array( 'label' => 'Grade 8', 'slug' => 'grade-8', 'color' => '#0072ce', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-__________________________-1386222' ),
			array( 'label' => 'Algebra I', 'slug' => 'algebra-i', 'color' => '#1565c0', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1386225' ),
			array( 'label' => 'Algebra II', 'slug' => 'algebra-ii', 'color' => '#283593', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1430134' ),
			array( 'label' => 'Geometry', 'slug' => 'geometry', 'color' => '#00897b', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1386224' ),
			array( 'label' => 'Statistics', 'slug' => 'statistics', 'color' => '#6a1b9a', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-1445485' ),
			array( 'label' => 'Trigonometry', 'slug' => 'trigonometry', 'color' => '#ad1457', 'store_url' => 'https://www.teacherspayteachers.com/store/markimatics/category-__________________________-1445484' ),
		),
	);

	$subject_slug = sanitize_title( $subject_slug );

	return isset( $catalog[ $subject_slug ] ) ? $catalog[ $subject_slug ] : array();
}

/**
 * Lesson (task card) definitions for a subject + grade.
 *
 * Add lessons here as images and product links become available.
 *
 * Keys per lesson:
 * - title        Full lesson title (shown on composed card / image alt)
 * - label        Blue bar text under the card
 * - slug         Unique lesson slug (used for image filename lookup)
 * - url          Product / lesson link (optional until provided)
 * - image        Full cover image URL (optional; falls back to asset lookup)
 * - badge        Corner ribbon text (default: TASK CARD)
 * - count        e.g. "24 Task Cards"
 * - action       e.g. "Print, Cut, Laminate"
 * - difficulties Array of: easy, moderate, challenging, hard
 *
 * @param string $subject_slug Subject slug (e.g. science).
 * @param string $grade_slug   Grade slug (e.g. grade-5).
 * @return array<int, array<string, mixed>>
 */
function markimatics_get_grade_lessons( $subject_slug, $grade_slug ) {
	$images = get_stylesheet_directory_uri() . '/markimatics/images/';

	$catalog = array(
		'science' => array(
			'kinder' => array(
				array(
					'title'        => 'Sorting & Describing Objects',
					'label'        => 'Task Card TEKS K-6 Sorting and Describing Objects',
					'slug'         => 'sorting-and-describing-objects',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-6 Sorting and Describing Objects.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K6-Sorting-and-Describing-Objects-14967136',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Understanding What Magnets Can Do',
					'label'        => 'Task Card TEKS K-7 Understanding What Magnets Can Do',
					'slug'         => 'understanding-what-magnets-can-do',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-7 Understanding What Magnets Can Do.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K7-Understanding-What-Magnets-Can-Do-14967190',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Seeing Things With Light',
					'label'        => 'Task Card TEKS K-8A Seeing Things With Light',
					'slug'         => 'seeing-things-with-light',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-8A Seeing Things With Light.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K8A-Seeing-Things-With-Light-14967261',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Understanding Light\'s Travel',
					'label'        => 'Task Card TEKS K-8B Understanding Light\'s Travel',
					'slug'         => 'understanding-light-s-travel',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-8B Understanding Light\'s Travel.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K8B-Understanding-Lights-Travel-14967339',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Day and Night Patterns',
					'label'        => 'Task Card TEKS K-9A Day and Night Patterns',
					'slug'         => 'day-and-night-patterns',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-9A Day and Night Patterns.png' ),
					'url'          => '',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
				array(
					'title'        => 'Things We See in the Sky Sun, Moon, Stars, and Clouds',
					'label'        => 'Task Card TEKS K-9B Things We See in the Sky Sun, Moon, Stars, and Clouds',
					'slug'         => 'things-we-see-in-the-sky-sun-moon-stars-and-clouds',
					'badge'        => 'TASK CARD',
					'count'        => '24 Task Cards',
					'action'       => 'Print, Cut, Laminate',
					'image'        => $images . rawurlencode( 'Task Card TEKS K-9B Things We See in the Sky Sun, Moon, Stars, and Clouds.png' ),
					'url'          => 'https://www.teacherspayteachers.com/Product/Task-Card-TEKS-K9B-Things-We-See-in-the-Sky-Sun-Moon-Stars-and-Clouds-14967600',
					'difficulties' => array( 'easy', 'moderate', 'challenging', 'hard' ),
				),
			),
		),
		'math'    => array(),
	);

	$subject_slug = sanitize_title( $subject_slug );
	$grade_slug   = sanitize_title( $grade_slug );

	if ( empty( $catalog[ $subject_slug ][ $grade_slug ] ) ) {
		return array();
	}

	return $catalog[ $subject_slug ][ $grade_slug ];
}

/**
 * URL for a lesson cover image, if the asset exists.
 *
 * Prefers: markimatics/images/{subject}-{grade}-{lesson}-card.png
 *
 * @param string $subject_slug Subject slug.
 * @param string $grade_slug   Grade slug.
 * @param string $lesson_slug  Lesson slug.
 * @return string|null
 */
function markimatics_get_lesson_card_image( $subject_slug, $grade_slug, $lesson_slug ) {
	if ( ! $lesson_slug ) {
		return null;
	}

	$dir  = get_stylesheet_directory() . '/markimatics/images/';
	$base = get_stylesheet_directory_uri() . '/markimatics/images/';

	$filename = sprintf(
		'%s-%s-%s-card.png',
		sanitize_title( $subject_slug ),
		sanitize_title( $grade_slug ),
		sanitize_title( $lesson_slug )
	);

	if ( file_exists( $dir . $filename ) ) {
		return $base . rawurlencode( $filename );
	}

	return null;
}

/**
 * URL for a grade card body image, if the asset exists.
 *
 * Prefers: markimatics/images/{subject}-{grade}-card.png
 * Fallback: markimatics/images/{Subject} - {Label} - final.png
 *
 * @param string $subject_slug  Subject slug (e.g. science).
 * @param string $grade_slug    Grade slug (e.g. grade-1).
 * @param string $subject_title Subject title (e.g. Science).
 * @param string $grade_label   Grade label (e.g. Grade 1).
 * @return string|null
 */
function markimatics_get_grade_card_image( $subject_slug, $grade_slug, $subject_title = '', $grade_label = '' ) {
	$dir  = get_stylesheet_directory() . '/markimatics/images/';
	$base = get_stylesheet_directory_uri() . '/markimatics/images/';

	$candidates = array(
		sprintf( '%s-%s-card.png', sanitize_title( $subject_slug ), sanitize_title( $grade_slug ) ),
	);

	if ( $subject_title && $grade_label ) {
		$candidates[] = sprintf( '%s - %s - final.png', $subject_title, $grade_label );
	}

	foreach ( $candidates as $filename ) {
		if ( file_exists( $dir . $filename ) ) {
			return $base . rawurlencode( $filename );
		}
	}

	return null;
}

/**
 * Link for a grade level under a subject page (lessons hub).
 *
 * Prefers a published child page using the Markimatics Grade template,
 * then any child / path match for the grade slug.
 *
 * @param int    $subject_id Subject page ID.
 * @param string $grade_slug Grade slug (e.g. grade-1).
 * @return string
 */
function markimatics_get_grade_url( $subject_id, $grade_slug ) {
	$grade_slug = sanitize_title( $grade_slug );
	$subject_id = (int) $subject_id;

	$children = get_pages(
		array(
			'parent'      => $subject_id,
			'sort_column' => 'menu_order',
		)
	);

	foreach ( $children as $child ) {
		if ( $child->post_name !== $grade_slug ) {
			continue;
		}

		$template = get_page_template_slug( $child->ID );
		if ( 'page-grade.php' === $template || '' === $template ) {
			return get_permalink( $child );
		}
	}

	$subject_path = get_page_uri( $subject_id );
	if ( $subject_path ) {
		$page = get_page_by_path( trailingslashit( $subject_path ) . $grade_slug );
		if ( $page instanceof WP_Post ) {
			return get_permalink( $page );
		}
	}

	foreach ( $children as $child ) {
		$child_grade = get_post_meta( $child->ID, 'mk_grade_slug', true );
		if ( $child_grade && sanitize_title( $child_grade ) === $grade_slug ) {
			return get_permalink( $child );
		}
	}

	return '#';
}

/**
 * Enqueue parent theme styles (skipped on Markimatics templates).
 */
function markimatics_child_enqueue_parent_styles() {
	if ( markimatics_is_template() ) {
		return;
	}

	wp_enqueue_style(
		'astra-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'astra' )->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'markimatics_child_enqueue_parent_styles' );

/**
 * Remove Astra front-end assets on Markimatics templates to avoid style conflicts.
 */
function markimatics_dequeue_astra_on_landing() {
	if ( ! markimatics_is_template() ) {
		return;
	}

	$astra_styles = array(
		'astra-theme-css',
		'astra-theme-dynamic',
		'astra-addon-css',
		'astra-menu-animation',
	);

	foreach ( $astra_styles as $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
	}
}
add_action( 'wp_enqueue_scripts', 'markimatics_dequeue_astra_on_landing', 99 );

/**
 * Enqueue Markimatics template assets.
 */
function markimatics_enqueue_assets() {
	if ( ! markimatics_is_template() ) {
		return;
	}

	$base = get_stylesheet_directory_uri() . '/markimatics';
	$ver  = '1.3.0';

	wp_enqueue_style(
		'markimatics-variables',
		$base . '/css/variables.css',
		array(),
		$ver
	);

	wp_enqueue_style(
		'markimatics-main',
		$base . '/css/main.css',
		array( 'markimatics-variables' ),
		$ver
	);

	wp_enqueue_script(
		'markimatics-main',
		$base . '/js/main.js',
		array(),
		$ver,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'markimatics_enqueue_assets' );

/**
 * Add mk-body class on Markimatics templates.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function markimatics_body_class( $classes ) {
	if ( markimatics_is_template() ) {
		$classes[] = 'mk-body';
	}

	return $classes;
}
add_filter( 'body_class', 'markimatics_body_class' );
