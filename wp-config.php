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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_little_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '_XtF/5I`FbGXS+]+WskN$d9}wsHkjyw1Bt3,(sz0:3Q-H]vMKK&t$)q.pSM^0OX-' );
define( 'SECURE_AUTH_KEY',  '4u$G}= Gl{T8=_eO#alhQE4+klV%W#2&+_L9Wl~^4bhN_d%n=#^=l1Cg;UbLJqfj' );
define( 'LOGGED_IN_KEY',    'pM3Zs=4&xE?8MAPyBUUqGc-m%`^lj1*!-FvfuQ<~=1>+;rRd]I#/?K8kS`-`?~]f' );
define( 'NONCE_KEY',        'j-|,_Z (C5)6(0$;V5@ya*x5>*K|YOlXWH_%9^R-e:z9|#P{STUb$e(U4)bRrAz-' );
define( 'AUTH_SALT',        ' a3vikzpj9t/W1r#)qgPZb]TOs.]-[[Y-dbD$N&^fP8)HYovi=!g(iGf;Pw-WVtU' );
define( 'SECURE_AUTH_SALT', 'bB=Q8^U@-Z(|SNLoGf0j7FNkQA.M9Nw/09Y]:/@I4t/9!K8R{mXCJiF)0mv/P[=8' );
define( 'LOGGED_IN_SALT',   '=(vH8)T15y.M1~BT4H#Ask#P4}ohF>5<]re;Oao%QL0-O%?6&>? cmS*,S]>`8Dt' );
define( 'NONCE_SALT',       'Lt/M[$ yiyViZp1xG^ktISb@Ivp.=QJC6T(RHT9/IQf6at~fkouT 0/Ne7AN]OM&' );

/**#@-*/

/**
 * WordPress database table prefix.
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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define('WP_DEBUG_DISPLAY', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

/** SMTP Email Config */

define('SMTP_Host', 'smtp.gmail.com');
define('SMTP_Secure', 'ssl');
define('SMTP_Port', '465');
define('SMTP_Auth', 'true');