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

namespace Clearcode\Config;

use Dotenv\Dotenv;

class Env {
	protected $vars = [
		'WP_ENVIRONMENT_TYPE',

		'WP_SITEURL',
		'WP_HOME',

		'DB_NAME',
		'DB_USER',
		'DB_PASSWORD',
		'DB_HOST',
		'DB_PREFIX',
		'DB_CHARSET',
		'DB_COLLATE',

		'CUSTOM_USER_TABLE',
		'CUSTOM_USER_META_TABLE',

		'AUTH_KEY',
		'SECURE_AUTH_KEY',
		'LOGGED_IN_KEY',
		'NONCE_KEY',
		'AUTH_SALT',
		'SECURE_AUTH_SALT',
		'LOGGED_IN_SALT',
		'NONCE_SALT',

		'WP_DEBUG',
		'WP_DEBUG_LOG',
		'WP_DEBUG_DISPLAY',
		'SAVEQUERIES',
		'SCRIPT_DEBUG',
		'CONCATENATE_SCRIPTS',

		'FORCE_SSL_LOGIN',
		'FORCE_SSL_ADMIN',

		'WP_HTTP_BLOCK_EXTERNAL',
		'WP_ACCESSIBLE_HOSTS',

		'AUTOMATIC_UPDATER_DISABLED',
		'WP_AUTO_UPDATE_CORE',
		'WP_ALLOW_REPAIR',
		'DO_NOT_UPGRADE_GLOBAL_TABLES',

		'WP_CONTENT_DIR',
		'WP_PLUGIN_DIR',
		'WP_PLUGIN_URL',
		'PLUGINDIR',
		'WPMU_PLUGIN_DIR',
		'WPMU_PLUGIN_URL',
		'MUPLUGINDIR',
		'UPLOADS',
		'ABSPATH',

		'DISALLOW_FILE_EDIT',
		'DISALLOW_FILE_MODS',
		'DISALLOW_UNFILTERED_HTML',
		'IMAGE_EDIT_OVERWRITE',
		'MEDIA_TRASH',
		'WP_DEFAULT_THEME',

		'AUTOSAVE_INTERVAL',
		'WP_POST_REVISIONS',
		'EMPTY_TRASH_DAYS',

		'COOKIE_DOMAIN',
		'COOKIEPATH',
		'SITECOOKIEPATH',
		'ADMIN_COOKIE_PATH',
		'PLUGINS_COOKIE_PATH',
		'COOKIEHASH',
		'USER_COOKIE',
		'PASS_COOKIE',
		'AUTH_COOKIE',
		'SECURE_AUTH_COOKIE',
		'LOGGED_IN_COOKIE',
		'TEST_COOKIE',

		'WPLANG',
		'WP_LANG_DIR',

		'WP_ALLOW_MULTISITE',
		'MULTISITE',
		'SUBDOMAIN_INSTALL',
		'DOMAIN_CURRENT_SITE',
		'PATH_CURRENT_SITE',
		'SITE_ID_CURRENT_SITE',
		'BLOG_ID_CURRENT_SITE',
		'NOBLOGREDIRECT',

		'FS_METHOD',
		'FS_CHMOD_DIR',
		'FS_CHMOD_FILE',

		'FTP_BASE',
		'FTP_CONTENT_DIR',
		'FTP_PLUGIN_DIR',
		'FTP_PUBKEY',
		'FTP_PRIKEY',
		'FTP_USER',
		'FTP_PASS',
		'FTP_HOST',
		'FTP_SSL',

		'WP_MEMORY_LIMIT',
		'WP_MAX_MEMORY_LIMIT',

		'DISABLE_WP_CRON',
		'ALTERNATE_WP_CRON',
		'WP_CRON_LOCK_TIMEOUT',

		'SHORTINIT',
		'WP_FEATURE_BETTER_PASSWORDS'
	];

	public function __construct( $path = __DIR__, $file = '.env' ) {
		if ( defined( 'ABSPATH' ) ) self::set( 'ABSPATH', ABSPATH );

		$dotenv = Dotenv::createImmutable( $path, $file );
		$dotenv->load();

		if ( self::isset( 'WP_VARS' ) ) {
			$vars = explode( ',', self::get( 'WP_VARS' ) );
			$this->vars = array_merge( $this->vars, $vars );
			self::unset( 'WP_VARS' );
		}
	}

	public static function get( $name ) {
		if ( ! self::isset( $name ) ) return;

		elseif ( isset( $_ENV[$name]    ) ) $value = $_ENV[$name];
		elseif ( isset( $_SERVER[$name] ) ) $value = $_SERVER[$name];
		elseif ( function_exists( 'getenv'        ) and getenv( $name        ) ) $value = getenv( $name );
		elseif ( function_exists( 'apache_getenv' ) and apache_getenv( $name ) ) $value = apache_getenv( $name );

		return self::convert( $value );
	}

	public static function set( $name, $value ) {
		if ( ! isset( $_ENV[$name]    ) ) $_ENV[$name]    = $value;
		if ( ! isset( $_SERVER[$name] ) ) $_SERVER[$name] = $value;
		if ( function_exists( 'getenv' ) and ! getenv( $name ) and
			function_exists( 'putenv' ) ) putenv( "$name=$value" );
		if ( function_exists( 'apache_getenv' ) and ! apache_getenv( $name ) and
			function_exists( 'apache_setenv' ) ) apache_setenv( $name, $value );
	}

	public static function isset( $name ) {
		if ( isset( $_ENV[$name]    ) ) return true;
		if ( isset( $_SERVER[$name] ) ) return true;
		if ( function_exists( 'getenv'        ) and getenv( $name        ) ) return true;
		if ( function_exists( 'apache_getenv' ) and apache_getenv( $name ) ) return true;

		return false;
	}

	public static function unset( $name ) {
		if ( isset( $_ENV[$name]    ) ) unset( $_ENV[$name]    );
		if ( isset( $_SERVER[$name] ) ) unset( $_SERVER[$name] );
	}

	public static function convert( $value ) {
		switch ( trim( strtolower( $value ) ) ) {
			case 'true'  : return true;
			case 'false' : return false;
			case 'null'  : return null;
			case ''      : return '';
		}

		if ( ctype_digit( trim( $value ) ) ) return (int)$value;

		if ( ( $value[0] === '"' and substr( $value, -1 ) === '"' ) ||
			 ( $value[0] === "'" and substr( $value, -1 ) === "'" ) )
			return substr( $value, 1, -1 );

		return $value;
	}

	public function load() {
		foreach ( $this->vars as $name )
			if ( ! defined( $name ) and self::isset( $name ) )
				define( $name, self::get( $name ) );
	}
}
