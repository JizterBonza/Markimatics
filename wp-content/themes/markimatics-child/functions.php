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
	return array( 'page-markimatics.php', 'page-subject.php' );
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
 * @param string $subject_slug Subject page slug.
 * @return array<int, array{label: string, slug: string, color: string}>
 */
function markimatics_get_subject_grades( $subject_slug ) {
	$catalog = array(
		'science' => array(
			array( 'label' => 'Kinder', 'slug' => 'kinder', 'color' => '#7cb342' ),
			array( 'label' => 'Grade 1', 'slug' => 'grade-1', 'color' => '#9b8572' ),
			array( 'label' => 'Grade 2', 'slug' => 'grade-2', 'color' => '#e67e22' ),
			array( 'label' => 'Grade 3', 'slug' => 'grade-3', 'color' => '#e74c3c' ),
			array( 'label' => 'Grade 4', 'slug' => 'grade-4', 'color' => '#e91e8c' ),
			array( 'label' => 'Grade 5', 'slug' => 'grade-5', 'color' => '#9b59b6' ),
			array( 'label' => 'Grade 6', 'slug' => 'grade-6', 'color' => '#5c6bc0' ),
			array( 'label' => 'Grade 7', 'slug' => 'grade-7', 'color' => '#42a5f5' ),
			array( 'label' => 'Grade 8', 'slug' => 'grade-8', 'color' => '#26a69a' ),
			array( 'label' => 'HS Astronomy', 'slug' => 'hs-astronomy', 'color' => '#3949ab' ),
			array( 'label' => 'HS Biology', 'slug' => 'hs-biology', 'color' => '#43a047' ),
			array( 'label' => 'HS Chemistry', 'slug' => 'hs-chemistry', 'color' => '#fb8c00' ),
			array( 'label' => 'HS Earth Science', 'slug' => 'hs-earth-science', 'color' => '#8d6e63' ),
			array( 'label' => 'HS Physics', 'slug' => 'hs-physics', 'color' => '#5e35b1' ),
		),
		'math'    => array(
			array( 'label' => 'Pre-Kinder', 'slug' => 'pre-kinder', 'color' => '#26c6da' ),
			array( 'label' => 'Kinder', 'slug' => 'kinder', 'color' => '#7cb342' ),
			array( 'label' => 'Grade 1', 'slug' => 'grade-1', 'color' => '#f1c40f' ),
			array( 'label' => 'Grade 2', 'slug' => 'grade-2', 'color' => '#e67e22' ),
			array( 'label' => 'Grade 3', 'slug' => 'grade-3', 'color' => '#e74c3c' ),
			array( 'label' => 'Grade 4', 'slug' => 'grade-4', 'color' => '#e91e8c' ),
			array( 'label' => 'Grade 5', 'slug' => 'grade-5', 'color' => '#9b59b6' ),
			array( 'label' => 'Grade 6', 'slug' => 'grade-6', 'color' => '#5c6bc0' ),
			array( 'label' => 'Grade 7', 'slug' => 'grade-7', 'color' => '#42a5f5' ),
			array( 'label' => 'Grade 8', 'slug' => 'grade-8', 'color' => '#0072ce' ),
			array( 'label' => 'Algebra I', 'slug' => 'algebra-i', 'color' => '#1565c0' ),
			array( 'label' => 'Algebra II', 'slug' => 'algebra-ii', 'color' => '#283593' ),
			array( 'label' => 'Geometry', 'slug' => 'geometry', 'color' => '#00897b' ),
			array( 'label' => 'Statistics', 'slug' => 'statistics', 'color' => '#6a1b9a' ),
			array( 'label' => 'Trigonometry', 'slug' => 'trigonometry', 'color' => '#ad1457' ),
		),
	);

	$subject_slug = sanitize_title( $subject_slug );

	return isset( $catalog[ $subject_slug ] ) ? $catalog[ $subject_slug ] : array();
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
 * Permalink for a grade level under a subject page.
 *
 * Prefers a published child page matching the grade slug.
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
		if ( $child->post_name === $grade_slug ) {
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
	$ver  = '1.2.5';

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
