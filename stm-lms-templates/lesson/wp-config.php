<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'itstar' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'it@stars@2021#UZ' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );



/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ']~c#3Q/|@|KJZA4%[iY7?=KU!)}Ra_5LrLT@JpCT^yB<cO`?S!){|5Fq<LV`%J0 ' );
define( 'SECURE_AUTH_KEY',  '^Jym*2f,*8xK:uzM^`<Rxf>6Kz_DK-WEx^]7Ke#hxzf*H2aYV72Bd$OTa:]BI1mJ' );
define( 'LOGGED_IN_KEY',    ']3~%-D]P7r]joA<Q.-<aSj>$}Z%7~t6%K&i)GAV|N`jVJnNo.M}u7>z|CI!d@~7x' );
define( 'NONCE_KEY',        'Mv[?;wF|$=b;vIi+^kJ]4O.SLIbiIZwEc j-V=_KBVSp#*gJ],ET#`dM|,uYY^LK' );
define( 'AUTH_SALT',        'wDU1m(eORDRz#|0MRHj9(C;,D6^Jak@9Z!^3P&~-^L$mqCgzsO3Y>i>fK)fvTZ&*' );
define( 'SECURE_AUTH_SALT', 'yukkF(7VV>KRK6A,A)E{*Lh:nFz!zK+3q2mx9FN&_u+[J1W}vY:H+b>IrHV#/OCB' );
define( 'LOGGED_IN_SALT',   'BU&$^J,(njlTTD,+Hz`4y$L%eg&Jmo6NnCfb%-}{@0wQV+dst%4=;HuVi1>A+Y4Y' );
define( 'NONCE_SALT',       'jJsZ:o]sFc%(ZB@Kk}J8Z{I7rTx|^4sza4 ,Ah1x{Mtka(<3G)Az?5U*tlRCaS6n' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

define( 'WP_MEMORY_LIMIT', '2000M' );

@ini_set( 'upload_max_size' , '2000M' );
@ini_set( 'post_max_size', '2000M');


set_time_limit(1000);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
