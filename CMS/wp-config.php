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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'huynhnhutlinh' );

/** MySQL database username */
define( 'DB_USER', 'huynhnhutlinh' );

/** MySQL database password */
define( 'DB_PASSWORD', 'admin' );

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
define( 'AUTH_KEY',         '79nv!oqX0p9T`2(Z!ROHi*gG|_rb5hWtyMy9/O^oMNeWjdu[l&Z69rh+OM8zM@Wv' );
define( 'SECURE_AUTH_KEY',  'f0/hLsYaLK4<FbdG %UC%#vaN0J8K+IV)9ex~a!&=b`jh XTo/eav5`t_8cMKA63' );
define( 'LOGGED_IN_KEY',    'Ta(Wp=wK9BuPLFc^zuG*v:env[cVkGPHT?E,rLvNe GA<`-fle$^ssQ5-XeSt!%.' );
define( 'NONCE_KEY',        'B-XJwpOFGy8uG]6rRFH}+nIP6HIhP>{,{H?zgA}MkcWnk7H_x.0.QMi09P0;:b<F' );
define( 'AUTH_SALT',        'h8&qW}QXp,])[.j_jsU9`Wh},U6jO.AAE(}];ds08_du;#ijMo}!SAbE(h@l@E#P' );
define( 'SECURE_AUTH_SALT', 'uwX=9AkJghr9yO%qR[!W2_()H4i/8C, `x&t~5iwD~TFgZ:4#ci)[L&>u1D[n()_' );
define( 'LOGGED_IN_SALT',   'mP6=ijGpQesA3OV!y~c1v3pN>0Z|/R6/7U[N!l$&~6*):tT|j(kxngP!*HIb;^No' );
define( 'NONCE_SALT',       '^19cs.uO:?qNtD Q5Iel -Nj]4h~xXx&Aq?OfffyU+%6 1lrq(h&6PBV<Ka/4yFN' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
