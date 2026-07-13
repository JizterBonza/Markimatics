<?php
/**
 * Markimatics Child Theme functions.
 *
 * @package Markimatics_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue parent theme styles (skipped on the landing page template).
 */
function markimatics_child_enqueue_parent_styles() {
	if ( is_page_template( 'page-markimatics.php' ) ) {
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
 * Remove Astra front-end assets on the landing page to avoid style conflicts.
 */
function markimatics_dequeue_astra_on_landing() {
	if ( ! is_page_template( 'page-markimatics.php' ) ) {
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
 * Enqueue Markimatics landing page assets.
 */
function markimatics_enqueue_assets() {
	if ( ! is_page_template( 'page-markimatics.php' ) ) {
		return;
	}

	$base = get_stylesheet_directory_uri() . '/markimatics';
	$ver  = '1.0.0';

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
 * Add mk-body class on the Markimatics landing page template.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function markimatics_body_class( $classes ) {
	if ( is_page_template( 'page-markimatics.php' ) ) {
		$classes[] = 'mk-body';
	}

	return $classes;
}
add_filter( 'body_class', 'markimatics_body_class' );
