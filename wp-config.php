<?php

@ini_set( 'display_errors', 0 );

require_once __DIR__ . '/vendor/autoload.php';

try {
	$env = new Clearcode\Config\v1\Env( __DIR__ );
	$env->load();
} catch ( Exception $exception ) {
	error_log( $exception->getMessage() );
	exit;
}

$table_prefix = defined( 'DB_PREFIX' ) ? DB_PREFIX : 'wp_';

if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) $_SERVER['HTTPS'] = 'on';

if ( ! defined( 'ABSPATH' ) ) define( 'ABSPATH', __DIR__ . '/' );
require_once( ABSPATH . 'wp-settings.php' );
