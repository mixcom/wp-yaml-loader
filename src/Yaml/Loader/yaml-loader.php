<?php

namespace KevinKiel\Yaml\Loader;

use Symfony\Component\Yaml\Parser;

class Yaml_Loader {

	private $config_path = '/../config';

	public function __construct() {
	}

	public function set_path( $config_path = '/../config' ) {
		$this->config_path = $config_path;
	}

	public function load() {

		if ( file_exists( $this->config_path . '/config.yml' ) ) {

			$yaml = new Parser();

			global $config;
			$config = $yaml->parse( file_get_contents( $this->config_path . '/config.yml' ) );

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
