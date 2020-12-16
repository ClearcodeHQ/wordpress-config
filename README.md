# Clearcode WordPress Config

Automagically define WordPress [configuration constants](https://codex.wordpress.org/Editing_wp-config.php) from [environment variables](http://php.net/manual/en/reserved.variables.environment.php) and `.env` file.

# Installation

```shell
$ composer require clearcode/wordpress-config
```

# Usage

Copy `wp-config.php` file to WordPress' root directory.

Create `.env` file and fill in the missing content:

```shell
DB_NAME=''
DB_USER=''
DB_PASSWORD=''
DB_HOST='localhost'
DB_CHARSET='utf8mb4'
DB_COLLATE=''
DB_PREFIX='wp_'

AUTH_KEY=''
SECURE_AUTH_KEY=''
LOGGED_IN_KEY=''
NONCE_KEY=''
AUTH_SALT=''
SECURE_AUTH_SALT=''
LOGGED_IN_SALT=''
NONCE_SALT=''

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
	SetEnv DB_CHARSET 'utf8mb4'
	SetEnv DB_COLLATE ''
	SetEnv DB_PREFIX 'wp_'

	SetEnv AUTH_KEY ''
	SetEnv SECURE_AUTH_KEY ''
	SetEnv LOGGED_IN_KEY ''
	SetEnv NONCE_KEY ''
	SetEnv AUTH_SALT ''
	SetEnv SECURE_AUTH_SALT ''
	SetEnv LOGGED_IN_SALT ''
	SetEnv NONCE_SALT ''

	SetEnv WP_VARS ''
...
</VirtualHost>
```

You can use all WordPress configuration constants, optionally you can add your own variables, but if you want to convert them from environment variables to PHP constants, you need to add them to `WP_VARS` environment variable, separated by coma.

# License

GPL3.0+ see [LICENSE.txt](LICENSE.txt) and [AUTHORS.txt](AUTHORS.txt)