# Clearcode WordPress Config

Automagically define WordPress [configuration constants](https://codex.wordpress.org/Editing_wp-config.php) from [environment variables](http://php.net/manual/en/reserved.variables.environment.php) and `.env` file.

# Installation

```shell
$ composer require clearcode/wordpress-config
```

# Usage

Replace `wp-config.php` file content with:

```php
<?php

@ini_set( 'display_errors', 0 );

require_once __DIR__ . '/vendor/autoload.php';

try {
	$env = new Clearcode\Config\v1\Env( __DIR__ );
	$env->load();
} catch ( Exception $exception ) {
	error_log( $exception->getMessage() );
}

$table_prefix = defined( 'DB_PREFIX' ) ? DB_PREFIX : 'wp_';

if ( ! defined( 'ABSPATH' ) ) define( 'ABSPATH', __DIR__ . '/' );
require_once( ABSPATH . 'wp-settings.php' );

```

Create `.env` file and fill in the missing content:

```shell
DB_NAME=''
DB_USER=''
DB_PASSWORD=''
DB_HOST='localhost'
DB_PREFIX='wp_'

AUTH_KEY=''
SECURE_AUTH_KEY=''
LOGGED_IN_KEY=''
NONCE_KEY=''
AUTH_SALT=''
SECURE_AUTH_SALT=''
LOGGED_IN_SALT=''
NONCE_SALT=''

WP_ENV='prod'
WP_VARS=''
```

You can also use environment variables that you have set in your `.env` file via a command line script, by using `source` it into your local shell session:

```shell
$ source .env
```

Instead of `.env` file you can use environment variables e.g. defined in you Apache server vhost configuration file:

```shell
<VirtualHost *:80>
...
	SetEnv DB_NAME ''
	SetEnv DB_USER ''
	SetEnv DB_PASSWORD ''
	SetEnv DB_HOST 'localhost'
	SetEnv DB_PREFIX 'wp_'

	SetEnv AUTH_KEY ''
	SetEnv SECURE_AUTH_KEY ''
	SetEnv LOGGED_IN_KEY ''
	SetEnv NONCE_KEY ''
	SetEnv AUTH_SALT ''
	SetEnv SECURE_AUTH_SALT ''
	SetEnv LOGGED_IN_SALT ''
	SetEnv NONCE_SALT ''

	SetEnv WP_ENV 'prod'
	SetEnv WP_VARS ''
...	
</VirtualHost>
```

You can use all WordPress configuration constants, optionally you can add your own variables, but if you want to convert them from environment variables to PHP constants, you need to add them to `WP_VARS` environment variable, separated by coma.

# License

GPL3.0+ see LICENSE.txt and AUTHORS.txt