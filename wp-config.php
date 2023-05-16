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
define( 'DB_NAME', 'american_wp444' );

/** Database username */
define( 'DB_USER', 'american_wp444' );

/** Database password */
define( 'DB_PASSWORD', '-07BU9)ZSp' );

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
define( 'AUTH_KEY',         '8nklkuexs5v2g64ihimm8gssufysr9wuwukq0ovls5sregpyhgdiehlzvak4f0bk' );
define( 'SECURE_AUTH_KEY',  'huayyfbph72drpvfgtjucouustfm1csnefbxhhbiypgsj8icckdrmzfsil7wbkig' );
define( 'LOGGED_IN_KEY',    'ukrqzmnms4ayfwjzp7ewmsfogkmiefijv04no3ienas7stvgdipefimj3piu5qxd' );
define( 'NONCE_KEY',        'ejfmhy3ytpg5sm8i0fqvw03f6ekexx5p9n9wgazxrnq55u2or6ksohx8ld3ua6ar' );
define( 'AUTH_SALT',        'pw2h5imicbiql43m4oci665tesmdaq8pqowlj72wpaokcnmuwakdyuofe33ugftn' );
define( 'SECURE_AUTH_SALT', 'bqlmqwh9rcrzyjliigozp1w3nsbu8cmqnq0hybfuiacrszu0pndratfxseth6zyy' );
define( 'LOGGED_IN_SALT',   '0do9bl29zkeclf12kn6j5zncaaqgm5rei7gra9ituxragx2hes4mvqoojbgkr28v' );
define( 'NONCE_SALT',       'kqp9myknfbhjyei67gz0aydqdixisdwcdzmvvhywd9we9mxpq9ksvmsd0y45xgae' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpye6i_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
define('DISABLE_WP_CRON', true);
