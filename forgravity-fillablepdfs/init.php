<?php
/**
 * The init file that holds constants and helper methods.
 *
 * @since 3.3
 *
 * @package ForGravity/FillablePDFs
 */

use ForGravity\Fillable_PDFs\API;

if ( ! defined( 'FG_FILLABLEPDFS_VERSION' ) ) {

	define( 'FG_FILLABLEPDFS_VERSION', '5.0.2' );
	define( 'FG_FILLABLEPDFS_EDD_ITEM_ID', 169 );
	define( 'FG_FILLABLEPDFS_DIR', __DIR__ );

	if ( ! defined( 'FG_EDD_STORE_URL' ) ) {
		define( 'FG_EDD_STORE_URL', 'https://cosmicgiant.com' );
	}

	if ( ! defined( 'FG_FILLABLEPDFS_PATH_CHECK_ACTION' ) ) {
		define( 'FG_FILLABLEPDFS_PATH_CHECK_ACTION', 'forgravity_fillablepdfs_check_base_pdf_path_public' );
	}

	if ( ! defined( 'CG_FILLABLEPDFS_API_REGIONS' ) ) {
		define(
			'CG_FILLABLEPDFS_API_REGIONS',
			[
				'us-nyc' => [
					'name' => 'United States',
					'url'  => 'https://us-nyc.cosmicpdfs.com/',
				],
				'eu-de'   => [
					'name' => 'Europe',
					'url'  => 'https://eu-de.cosmicpdfs.com/',
				],
			]
		);
	}

	/**
	 * Returns an instance of the Fillable PDfs API.
	 *
	 * @since 3.4
	 * @since 4.7.1 Remove the license key param.
	 *
	 * @return API|false|null
	 */
	function fg_pdfs_api() {

		static $instance;

		if ( ! is_null( $instance ) ) {
			return $instance;
		}

		if ( ! function_exists( 'fg_fillablepdfs' ) || ! fg_fillablepdfs() ) {
			return false;
		}

		$license_key = fg_fillablepdfs()->get_license_key();

		// If the license key is empty, do not run a validation check.
		if ( rgblank( $license_key ) ) {
			return null;
		}

		// Log validation step.
		fg_fillablepdfs()->log_debug( __METHOD__ . '(): Validating API Info.' );

		$region   = fg_fillablepdfs()->get_current_region();
		$instance = new API( $license_key, $region, fg_fillablepdfs()->get_edd_item_id() );

		try {

			if ( ! $instance->get_license_info() ) {
				$instance = false;
			} else {
				// Log that authentication test passed.
				fg_fillablepdfs()->log_debug( __METHOD__ . '(): API credentials are valid.' );
			}

		} catch ( Exception $e ) {

			// Log that authentication test failed.
			fg_fillablepdfs()->log_error( __METHOD__ . '(): API credentials are invalid; ' . $e->getMessage() );

			$instance = false;

		}

		return $instance;

	}

	/**
	 * Returns an instance of the Import class
	 *
	 * @esince 1.0
	 *
	 * @return ForGravity\Fillable_PDFs\Import
	 */
	function fg_fillablepdfs_import() {
		return ForGravity\Fillable_PDFs\Import::get_instance();
	}

	/**
	 * Returns an instance of the Server class
	 *
	 * @since      1.0
	 * @deprecated 4.4
	 *
	 * @return ForGravity\Fillable_PDFs\Server
	 */
	function fg_fillablepdfs_server() {
		return fg_fillablepdfs()->get_server();
	}

	/**
	 * Returns an instance of the Templates class
	 *
	 * @since 1.0
	 *
	 * @return ForGravity\Fillable_PDFs\Templates
	 */
	function fg_fillablepdfs_templates() {
		return ForGravity\Fillable_PDFs\Templates::get_instance();
	}

}
