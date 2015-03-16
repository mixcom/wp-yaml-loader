# wp-yaml-loader

Simple YAML config Loader for WordPress

## Security

Make sure that you place the config map outside the web root.
If you discover any security related issues, please use the issue tracker.

## Install

Via Composer

```
$ composer require kevinkiel/wp-yaml-loader
```

## Usage wp-config.php (PHP)

```
use KevinKiel\Yaml\Loader\YamlLoader;

$yaml = new YamlLoader;
$yaml->set_path( __DIR__ . '/../config' );
$yaml->load();
```

## Config files

Place the config files outside the web root so nobody can read your yml files.
Single string's int's and boolean will be defined ```define( 'DB_NAME', 'databasename' );```.

##### config/config.yml

```
WP_ENV: development
#WP_ENV: acceptance
#WP_ENV: production
DB_NAME: databasename
DB_USER: username
DB_PASSWORD: password
DB_HOST: localhost
DB_PREFIX: wp_
DB_CHARSET: utf8
DB_COLLATE: ''
WP_DEBUG: false
WP_DEFAULT_THEME: thema
FS_METHOD: ssh2
DISALLOW_FILE_EDIT: true
```

**(SALT) https://api.wordpress.org/secret-key/1.1/salt**


```
AUTH_KEY: 
SECURE_AUTH_KEY: 
LOGGED_IN_KEY: 
NONCE_KEY: 
AUTH_SALT: 
SECURE_AUTH_SALT: 
LOGGED_IN_SALT: 
NONCE_SALT: 
```

#### Custom config

If you're using custom config the data will be available as a global variable.

**Custom example (YAML).**

```
twitter:
    oauth_access_token: [key]
    oauth_access_token_secret: [key]
    consumer_key: [key]
    consumer_secret: [key]    
```

**Retrieve the custom config (PHP).**

```
global $config;
$twitter_auth = $config['twitter'];

/* oauth_access_token */
$oauth_access_token = $config['twitter']['oauth_access_token'];
```

## OTAP

If you're using more then one environment. You can import / overwrite your config settings with your environment setting. Make sure you set your environment in config.yml with the 'WP_ENV' parameter.

##### config/config_development.yml

```
DB_NAME: development_databasename
DB_USER: development_username
DB_PASSWORD: development_password
WP_DEBUG: true
SAVEQUERIES: true
CONCATENATE_SCRIPTS: false
FS_METHOD: direct
EMPTY_TRASH_DAYS: 0
```

##### config/config_acceptance.yml
```
DB_NAME: acceptance_databasename
DB_USER: acceptance_username
DB_PASSWORD: acceptance_password
```

##### config/config_production.yml

```
DB_NAME: production_databasename
DB_USER: production_username
DB_PASSWORD: production_password
```

## Credits

- [Kevin Kiel](https://github.com/kevinkiel)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
