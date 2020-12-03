<?php

/*
	Copyright (C) 2020 by Clearcode <https://clearcode.cc>
	and associates (see AUTHORS.txt file).
	This file is part of clearcode/wordpress-config.
	clearcode/wordpress-config is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	clearcode/wordpress-config is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	You should have received a copy of the GNU General Public License
	along with clearcode/wordpress-config; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

@ini_set( 'display_errors', 0 );

require_once __DIR__ . '/vendor/autoload.php';

try {
	$env = new Clearcode\Config\Env( __DIR__ );
	$env->load();
} catch ( Exception $exception ) {
	error_log( $exception->getMessage() );
	exit;
}

$table_prefix = defined( 'DB_PREFIX' ) ? DB_PREFIX : 'wp_';

if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) $_SERVER['HTTPS'] = 'on';

if ( ! defined( 'ABSPATH' ) ) define( 'ABSPATH', __DIR__ . '/' );
require_once( ABSPATH . 'wp-settings.php' );
