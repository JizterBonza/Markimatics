<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dbd5x75yyvgggy' );

/** Database username */
define( 'DB_USER', 'uvxael9xntfrq' );

/** Database password */
define( 'DB_PASSWORD', 'mjblg3trq3km' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '~fLv8{qHR8V%T=$-p[OehyvNrX^G<[C?~.y6gPGefx536<?t/k1yTvGA i|[}4D9' );
define( 'SECURE_AUTH_KEY',   'MpS*,U5hkNfi;ApHB1_}YS2&-Er`Jbi4|@:;tzldOt2w ,T%S]@W5 {i+Mh#WQQe' );
define( 'LOGGED_IN_KEY',     'JsNb[I.=?C4 oUl7PC0%4LN>WP:hu5e<H|*%k!|xwgVY!Y:;r&LIj}J9Rr(1?zY;' );
define( 'NONCE_KEY',         '7aJ?5NYv,WnhO,bT3c&C<z-RZYp,i5^,xHU:5j@AO}f:k7y001hC kP<7=iR|h?@' );
define( 'AUTH_SALT',         '+;od? BgL_7~T+Lm8B}.3!U@pEvzZS?RY<a0=AQb5Vp0U QS]2bJ9dw1(!m3#fqe' );
define( 'SECURE_AUTH_SALT',  'pc+3@G7R-Xtgx[?8.oIE+0/ N>aPN4-zZoVDcEa4GVOk)x&lYMg@u?#dxIJw]yP%' );
define( 'LOGGED_IN_SALT',    'OCf@C,jPymcY4Og9FO@C1,| kzAlrm<+_&YjpD/oh{/L|LI*O+xN*n33J^1sAkS<' );
define( 'NONCE_SALT',        'DV&3da@G:$yYn0e,d(GZL~qcB0,54#PIl?p2KGp3l?@A&OECVaD/qq=KP|tJ!:jG' );
define( 'WP_CACHE_KEY_SALT', 'nn:6;lOU{kX{*L`sbo-v9P%NXr?N2m9d9#sKz2|;R=)MN%+OW UmhOQa*-LT0It,' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ybk_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'SURECART_ENCRYPTION_KEY', 'JsNb[I.=?C4 oUl7PC0%4LN>WP:hu5e<H|*%k!|xwgVY!Y:;r&LIj}J9Rr(1?zY;' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
@include_once('/var/lib/sec/wp-settings-pre.php'); // Added by SiteGround WordPress management system
require_once ABSPATH . 'wp-settings.php';
@include_once('/var/lib/sec/wp-settings.php'); // Added by SiteGround WordPress management system
