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
	$ver  = '1.1.0';

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
