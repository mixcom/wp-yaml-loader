<?php

namespace KevinKiel\Yaml\Loader;

use Symfony\Component\Yaml\Parser;

/**
 * Class YamlLoader
 *
 * @package KevinKiel\Yaml\Loader
 */
class YamlLoader {

	private $config_path = '/../config';
	private $config_file = 'config.yml';

	public function __construct() {
	}

	/**
	 * Set the config path
	 *
	 * @param string $config_path
	 */
	public function set_path( $config_path = '/../config' ) {
		$this->config_path = $config_path;
	}

	/**
	 * Load the YAML config's
	 */
	public function load() {

		if ( file_exists( $this->config_path . '/' . $this->config_file ) ) {

			$yaml = new Parser();

			global $config;
			$config = (array) $yaml->parse( file_get_contents( $this->config_path . '/' . $this->config_file ) );

			if ( ! empty( $config['WP_ENV'] ) && file_exists( $this->config_path . '/config_' . $config['WP_ENV'] . '.yml' ) ) {
				$env = $yaml->parse( file_get_contents( $this->config_path . '/config_' . $config['WP_ENV'] . '.yml' ) );
				if ( ! empty( $env ) ) {
					$config = array_merge( $config, $env );
				}
			}

			if ( ! empty( $config['imports'] ) ) {
				foreach ( $config['imports'] as $import ) {
					if ( ! empty( $import['resource'] ) && file_exists( $this->config_path . '/' . $import['resource'] ) ) {
						$import = $yaml->parse( file_get_contents( $this->config_path . '/' . $import['resource'] ) );
						$config = array_merge( $config, $import );
					}
				}
				unset( $config['imports'] );
			}

			foreach ( $config as $key => $value ) {
				if ( ! is_array( $value ) ) {
					define( $key, $value );
					unset( $config[ $key ] );
				}
			}

		}

	}

}
