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

define('DB_NAME', 'joepowerlatest');

/** MySQL database username */
define('DB_USER', 'joepowerlatest');

/** MySQL database password */
define('DB_PASSWORD', 'S9vrXmmXsTUpX959');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'mV=v9a|xc:+vMVgI(&HF~p#fv<KAcDx}#$amxpF4HG+ju(Iof~+Pq e`~:`dgBI?');
define('SECURE_AUTH_KEY',  '-K4/F$fnJ|t%=eVN}~w? X-CF+.0mNSmMB|.}=$S:bJ^{9%`!95OI-);E-+<bb?_');
define('LOGGED_IN_KEY',    'C;:;s{x49&WB iS-Vp:Xc3TY8GO&N`(6k6vMEi$SB&VpeghY#Hi[W:)I_%<$|P~I');
define('NONCE_KEY',        'NobhkE=F|QBSpBam.ay(i+Pbq`nRH;BF>zibpd7tV<0UpH.YPHt0 {eJU-!8`6L>');
define('AUTH_SALT',        '=Pt^y,G^>k~JNEWLi=Gg(1lk`#0Mh4lP={3=3:|$s`]V=tu>Jy03tjQ?v?>T|xv=');
define('SECURE_AUTH_SALT', '>7o{|.^ldo+fvff>aox4l+`v;~bxtss=)]D`k`~{j{xxtx?3K9k.Z#n+{YbNa4{]');
define('LOGGED_IN_SALT',   '3lW_5VpX67Q+)+WyGS=eTMWj0ofBUPA-;yIvZ!#BScSQ@?[Hgj)CdrHflu6H1G&h');
define('NONCE_SALT',       'l2k1v&Dl2=kw2%d1vk8BF|kdo!ehGX>9_orchr0Hpeq_/YpwlFXpyB9MOn(<!OkR');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
 
if($_SERVER['REMOTE_ADDR']=="157.37.132.79"){
	define('WP_DEBUG', 0);
}else{
	define('WP_DEBUG', 0);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
