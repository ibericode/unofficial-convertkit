<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\enqueue_script;

class Gutenberg_Hooks implements Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue the scripts for the gutenberg editor
	 *
	 * @internal
	 */
	public function enqueue_assets() {
		//Development scripts
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG && $this->enqueue_dev_assets() ) {
			return;
		}

		enqueue_script( 'js/block-form.js' );
	}

	/**
	 * @return bool
	 */
	private function enqueue_dev_assets(): bool {
		$manifest = UNOFFICIAL_CONVERKIT_ASSETS_DIR . '/asset-manifest.json';

		if ( ! file_exists( $manifest ) ) {
			return false;
		}

		$assets = (array) json_decode( file_get_contents( $manifest ), true );

		if ( empty( $assets ) ) {
			return false;
		}

		foreach ( $assets as $asset => $asset_uri ) {
			$is_js = preg_match( '/\.js$/', $asset_uri );
			//ToDo: load css if we has any.
			//          $is_css   = preg_match( '/\.css$/', $asset_uri );
			//          $is_chunk = preg_match( '/\.chunk\./', $asset_uri );

			if ( ! $is_js ) {
				continue;
			}

			if ( $is_js ) {
				$asset_json = array_search( str_replace( '.js', '.json', $asset ), array_keys( $assets ), true );

				$this->enqueue_script( $asset_uri, array_values( $assets )[ $asset_json ] ?? '' );

				continue;
			}
		}

		return true;
	}

	/**
	 * @param string $asset_uri
	 * @param string $asset_json
	 */
	private function enqueue_script( string $asset_uri, string $asset_json = null ) {
		$options = array();

		if ( ! empty( $asset_json ) ) {
			$contents = file_get_contents( $asset_json );

			if ( is_string( $contents ) ) {
				//The json contains all the dependencies and the version
				$options = (array) json_decode( $contents, true );
				unset( $options['version'] );
			}
		}

		enqueue_script( $asset_uri, $options );
	}
}
