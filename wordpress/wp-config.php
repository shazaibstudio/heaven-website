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
define( 'DB_NAME', 'heavenho_wp_fbqip' );

/** Database username */
define( 'DB_USER', 'heavenho_wp_zlgzt' );

/** Database password */
define( 'DB_PASSWORD', 'lAwZ?9JXz1u54^CN' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

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
define('AUTH_KEY', '#K-aC2%+#Z2i91-k8)@|hkQq)1|r4n5&Wl!K41q)/dh_vhV&6Y/WnSy7ZgojR0]a');
define('SECURE_AUTH_KEY', '~1)6@_reSi3f(KwHL0pTo2NTs;0232_h47Ga_O84*c!31K0hX!ZZa1KT~oFo4W3A');
define('LOGGED_IN_KEY', 'lg3VGQ60&8cCBK7zlEAKqX-s8ckl5c|:]*((:6G4:eP3ca:kOr8u~9[4sW5-/N8)');
define('NONCE_KEY', 'n/!rpjQXKSMvfi(ehC#09YtE24n3689Im~9/]ue2-Z7M)#Q|%0j8!x5#+Xo02zPG');
define('AUTH_SALT', '+C9*Z3CVi4%NJDmVN4LRb+wCZL0:CN7w01j]1s9VWf&6J-w_81]&uA0w3*d:1c6@');
define('SECURE_AUTH_SALT', 'pZ7#0*b2(X23R|&0LBa(1E]4@Nv6pu-+5h&7Gbe6#1sR+7wp:7adjG2[T6|&28i1');
define('LOGGED_IN_SALT', '3RfeI*)x2d;+7~rf22!O]Uz0:40_H94|M9M2&9p18|VU8/cyOC5K2~W90X*1Ar9O');
define('NONCE_SALT', 'mPP7)7H5226w32_~1MmZ(12Zhk9I[Sa3:q26!1HM~9OQi/Pj[21IU9*%HmJ_H07h');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'AToo6Sms_';


/* Add any custom values between this line and the "stop editing" line. */

define('WP_ALLOW_MULTISITE', true);
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
