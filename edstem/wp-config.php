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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'aeplitcm_edstem' );

/** Database username */
define( 'DB_USER', 'aeplitcm_edstem' );

/** Database password */
define( 'DB_PASSWORD', '4T*.;F?p~(Hd' );

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
define( 'AUTH_KEY',         'EYNacVcx9m|q[nV~08m/$#S5A)x~BgJo31 }==rX<Z#X(=z,MhwPEe5rU!)D(VyQ' );
define( 'SECURE_AUTH_KEY',  '5=+U(<*E.7~5_6{IR5[,<+y_k#^~Hb4?b2^2,Z#^o7P`)r#Fh6GAaayTMtOaFa!I' );
define( 'LOGGED_IN_KEY',    '&.6&#^@|8l4/np::7t{eN>S|_^7a$Q<&CF!f,&**x0C;0aP`Yasy3QDb}sQWHqc&' );
define( 'NONCE_KEY',        '^vA$#IZ^mT=M(r@:#`R[x3|IlOBgQy/;h0Aox53t.At13BRzK{#&lhoe spZ$TvA' );
define( 'AUTH_SALT',        'eI$W10]mY>K rkyufn/`6|:U/gRKvcc,HT|T;oDq[ujep)N9&U5y^(wlb]}LbqHj' );
define( 'SECURE_AUTH_SALT', 'uX*zZ0O:5[kE[e,#OYW3H4^Z2>u39!5C d470{T&%MzLfg]ck%Jpmgh`Xmuv_6x*' );
define( 'LOGGED_IN_SALT',   'mqn,fha2X^I.D$|.v[W!~#A8H1dNR4dC]2w9F/uV|[o6Jc`]Z=ui2.1Q!hLkBil:' );
define( 'NONCE_SALT',       'Iwe#<p9))2jD|hK8wh,.LTgF,[Fazujqc,Umnx_,l0m-Db-nJL?9poB2l(*,s`_c' );

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
