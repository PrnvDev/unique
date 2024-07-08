<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'uniquestatuary' );

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
define( 'AUTH_KEY',         'IE DOMZa&qC)k3OFYg]i}E_Q!h9D{pvx469UH:X~,egy5supnL%@[Rm0YbP|3I%L' );
define( 'SECURE_AUTH_KEY',  'mPjI~}*y4m_[!oz9H?7 !AB#tTEOa&>@6{.|Y)1&byYm@#]_:Okc,;3r)[O5=HIt' );
define( 'LOGGED_IN_KEY',    'z3RtDe5t>Ll%PVD;n~+ F3}.w%j2fw<o%+Q};R2$`+C &8N$P$9?pfH)!N}Qen>g' );
define( 'NONCE_KEY',        't(T@20ylZE=vd(>&yXiR;O%NXodar*YlL:;S~}60xn`r2Pdqti.)i/Ck#Nl&pv/?' );
define( 'AUTH_SALT',        'pmKF@$(oP,7e;3~TycmnS aK%pf;@o:|{,wq=kjlI,%C/e9g#h!QH#3r[u<A2;$8' );
define( 'SECURE_AUTH_SALT', '|U/,mOU^6r*Y-87;>JAm2N 2+<KkzgA1sw+npb%b@8mVE0Z$gR^W>iSl-5wOAZ$w' );
define( 'LOGGED_IN_SALT',   'GLrGago2CFX~gO%^aViSed{Lq3fIR0CwB2{,&.vJ5*),S3+)qI.%3uwd3!d/8rw:' );
define( 'NONCE_SALT',       'i~%|KIAtHk+0P>6mRvIJR3p E|y2B I[Y@$Y/haOYvce$`.XbW6 <^ry$meP(5F.' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
