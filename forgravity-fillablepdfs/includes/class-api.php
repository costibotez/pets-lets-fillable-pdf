<?php
/**
 * Fillable PDFs API library.
 *
 * @since     1.0
 * @package   FillablePDFs
 * @author    ForGravity
 * @copyright Copyright (c) 2017, ForGravity
 */

namespace ForGravity\Fillable_PDFs;

use GFCache;

use Exception;

/**
 * Fillable PDFs API library.
 *
 * @since     1.0
 * @package   FillablePDFs
 * @author    ForGravity
 * @copyright Copyright (c) 2017, ForGravity
 */
class API {

	/**
	 * License key.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $license_key;

	/**
	 * Site home URL.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $site_url;

	/**
	 * API region.
	 *
	 * @since 5.0
	 * @var   string
	 */
	protected $api_region;

	/**
	 * Cache of previously requested templates.
	 *
	 * @since 3.4
	 * @var   array
	 */
	private $templates = [];

	/**
	 * EDD Product ID.
	 *
	 * @since 3.4
	 * @var   int
	 */
	private $product_id;

	/**
	 * License information.
	 *
	 * @since 4.7.1
	 *
	 * @var null|array
	 */
	private $license_info;

	/**
	 * Initialize Fillable PDFs API library.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @param string $license_key License key.
	 * @param string $api_region  API region to connect to.
	 * @param int    $product_id  EDD Product ID for this plugin.
	 */
	public function __construct( $license_key, $api_region = 'us-nyc', $product_id = FG_FILLABLEPDFS_EDD_ITEM_ID ) {

		$this->license_key = $license_key;
		$this->site_url    = home_url();

		$this->api_region = $api_region;
		$this->product_id = $product_id;

	}





	// # FILES ---------------------------------------------------------------------------------------------------------

	/**
	 * Get PDF file fields.
	 *
	 * @since  2.0
	 *
	 * @param array $file       Temporary file details.
	 * @param bool  $has_fields Check if file has fields.
	 *
	 * @return array
	 * @throws Exception Throws exception if file fields cannot be retrieved.
	 */
	public function get_file_meta( $file, $has_fields = false ) {

		return $this->make_binary_request(
			'files/meta' . ( $has_fields ? '?has_fields=true' : '' ),
			[
				[
					'name'      => 'pdf_file',
					'file_name' => $file['name'],
					'file_path' => $file['tmp_name'],
				],
			]
		);

	}





	// # TEMPLATES -----------------------------------------------------------------------------------------------------

	/**
	 * Create template.
	 *
	 * @since  1.0
	 *
	 * @param string $name      Template name.
	 * @param array  $file      Temporary file details.
	 *
	 * @return array
	 * @throws Exception Throws exception if template cannot be created.
	 */
	public function create_template( $name = '', $file = [] ) {

		return $this->make_binary_request(
			'templates',
			[
				[
					'name'  => 'name',
					'value' => $name,
				],
				[
					'name'      => 'pdf_file',
					'file_name' => $file['name'],
					'file_path' => $file['tmp_name'],
				],
			]
		);

	}

	/**
	 * Delete template.
	 *
	 * @since  1.0
	 *
	 * @param string $template_id Template ID.
	 *
	 * @return array
	 * @throws Exception Throws exception if template cannot be deleted.
	 */
	public function delete_template( $template_id = '' ) {

		return $this->make_request( 'templates/' . $template_id, [], 'DELETE' );

	}

	/**
	 * Get specific template.
	 *
	 * @since  1.0
	 *
	 * @param string $template_id Template ID.
	 *
	 * @return array
	 * @throws Exception Throws exception if template cannot be retrieved.
	 */
	public function get_template( $template_id = '' ) {

		if ( rgar( $this->templates, $template_id ) ) {
			return $this->templates[ $template_id ];
		}

		try {

			$template = $this->make_request( 'templates/' . $template_id );

			if ( ! is_wp_error( $template ) ) {
				$this->templates[ $template_id ] = $template;
			}

			return $template;

		} catch ( Exception $e ) {

			throw $e;

		}

	}

	/**
	 * Get number of templates registered to license.
	 *
	 * @since  3.0
	 *
	 * @return array
	 * @throws Exception Throws exception if template count cannot be retrieved.
	 */
	public function get_template_count() {

		return $this->make_request( 'templates/_count' );

	}

	/**
	 * Get templates for license.
	 *
	 * @since  3.0 Added $page, $per_page parameters.
	 * @since  1.0
	 *
	 * @param int $page     Page number.
	 * @param int $per_page Templates per page.
	 *
	 * @return array
	 * @throws Exception Throws exception if templates cannot be retrieved.
	 */
	public function get_templates( $page = 1, $per_page = 20 ) {

		$params = [
			'page'     => $page,
			'per_page' => $per_page,
		];

		/**
		 * Determine whether to show all templates for license or templates registered to site.
		 *
		 * @since 3.0
		 *
		 * @param bool $display_all_templates Display all templates for license.
		 */
		if ( ! fg_pdfs_apply_filters( 'display_all_templates', true ) ) {
			$params['current_site'] = true;
		}

		$templates = $this->make_request( 'templates', $params );

		if ( ! is_wp_error( $templates ) ) {
			foreach ( $templates as $template ) {
				if ( ! isset( $this->templates[ $template['template_id'] ] ) ) {
					$this->templates[ $template['template_id'] ] = $template;
				}
			}
		}

		return $templates;

	}

	/**
	 * Get original file for template.
	 *
	 * @since  1.0
	 *
	 * @param string $template_id Template ID.
	 *
	 * @return array
	 * @throws Exception Throws exception if template file cannot be retrieved.
	 */
	public function get_template_file( $template_id = '' ) {

		return $this->make_request( 'templates/' . $template_id . '/file' );

	}

	/**
	 * Create template.
	 *
	 * @since  1.0
	 *
	 * @param string     $template_id Template ID.
	 * @param string     $name        Template name.
	 * @param array|null $file        Temporary file details.
	 *
	 * @return array
	 * @throws Exception Throws exception if template cannot be saved.
	 */
	public function save_template( $template_id, $name, $file = null ) {

		// If no file is provided, use default method.
		if ( ! is_array( $file ) ) {
			return $this->make_request( 'templates/' . $template_id, [ 'name' => $name ], 'PUT' );
		}

		return $this->make_binary_request(
			'templates/' . $template_id,
			[
				[
					'name'  => 'name',
					'value' => $name,
				],
				[
					'name'      => 'pdf_file',
					'file_name' => $file['name'],
					'file_path' => $file['tmp_name'],
				],
			]
		);

	}

	/**
	 * Generate PDF.
	 *
	 * @since  1.0
	 *
	 * @param string $template_id Template ID.
	 * @param array  $meta        PDF meta.
	 *
	 * @return string
	 * @throws Exception Throws exception if PDF cannot be generated.
	 */
	public function generate( $template_id = '', $meta = [] ) {

		return $this->make_request( 'templates/' . $template_id . '/generate', $meta, 'POST' );

	}





	// # LICENSE -------------------------------------------------------------------------------------------------------

	/**
	 * Get information about current license.
	 *
	 * @since  1.0
	 * @since  4.7.1 Added caching.
	 *
	 * @return array|bool
	 *
	 * @throws Exception  Throws exception if license information cannot be retrieved.
	 */
	public function get_license_info() {

		$cache_key = $this->get_cache_key();

		// Get cached license info.
		if ( $cached_license_info = GFCache::get( $cache_key ) ) {
			$this->license_info = $cached_license_info;
			return $this->license_info;
		}

		try {
			$this->license_info = $this->make_request( 'license' );
		} catch ( Exception $e ) {
			$this->license_info = false;
		}

		if ( isset( $this->license_info['status'] ) && in_array( $this->license_info['status'], [ 'active', 'inactive', 'site_inactive' ] ) ) {
			GFCache::set( $cache_key, $this->license_info, true, MINUTE_IN_SECONDS );
		}

		return $this->license_info;

	}

	/**
	 * Change license API region.
	 *
	 * @since  5.0
	 *
	 * @param string $region New API region.
	 *
	 * @return array
	 *
	 * @throws Exception Throws exception if region cannot be updated.
	 */
	public function set_license_region( $region = 'us-nyc' ) {

		return $this->make_request( 'license', [ 'region' => $region ], 'PUT' );

	}





	// # REQUEST METHODS -----------------------------------------------------------------------------------------------

	/**
	 * Make API request.
	 *
	 * @since  1.0
	 *
	 * @param string $path         Request path.
	 * @param array  $options      Request options.
	 * @param string $method       Request method. Defaults to GET.
	 * @param string $content_type Request content type.
	 *
	 * @return array|string
	 * @throws Exception Throws exception if request fails.
	 */
	private function make_request( $path, $options = [], $method = 'GET', $content_type = 'application/json' ) {

		// Build request URL.
		$request_url = $this->get_api_url() . $path;

		// Add options if this is a GET request.
		if ( 'GET' === $method ) {
			$request_url = add_query_arg( $options, $request_url );
		}

		if ( $method !== 'GET' ) {
			if ( $content_type === 'application/json' ) {
				$body = wp_json_encode( $options );
			} elseif ( strpos( $content_type, 'multipart/form-data' ) === 0 ) {
				$body = $options;
			}
		} else {
			$body = null;
		}

		// Execute request.
		$response = wp_remote_request(
			$request_url,
			$this->request_args(
				$body,
				$method,
				$content_type
			)
		);

		// If request attempt threw a WordPress error, throw exception.
		if ( is_wp_error( $response ) ) {
			throw new Exception( esc_html( $response->get_error_message() ) );
		}

		// Decode response.
		$response_code = wp_remote_retrieve_response_code( $response );
		$response_body = fg_fillablepdfs()->maybe_decode_json( $response['body'] );

		// If error response was received, throw exception.
		if ( isset( $response_body['error'] ) || $response_code >= 400 ) {

			// Update API region.
			if ( $method !== 'PUT' && rgar( $response_body, 'error' ) === 'incorrect_region' ) {
				$this->update_region( $response_body['region']['expected'] );
				return $this->make_request( $path, $options, $method, $content_type );
			}

			throw new Exception( esc_html( rgar( $response_body, 'message', $response_body ) ), esc_html( wp_remote_retrieve_response_code( $response ) ) );
		}

		return $response_body;

	}

	/**
	 * Make API request using binary data.
	 *
	 * @since 5.0
	 *
	 * @param string $path Request path.
	 * @param array  $data Request data.
	 *
	 * @return array|string
	 * @throws Exception Throws exception if request fails.
	 */
	private function make_binary_request( $path, $data ) {

		// Generate boundary.
		$boundary           = wp_generate_password( 24 );
		$boundary_separator = '--' . $boundary . "\r\n";
		$body               = $boundary_separator;

		foreach ( $data as $data_meta ) {

			$data_string = sprintf( 'Content-Disposition: form-data; name="%1$s"', $data_meta['name'] );

			if ( isset( $data_meta['value'] ) ) {
				$data_string .= "\r\n\r\n" . $data_meta['value'] . "\r\n";
			} elseif ( isset( $data_meta['file_name'] ) ) {
				$data_string .= '; filename="' . $data_meta['file_name'] . '"' . "\r\n\r\n";
			}

			if ( isset( $data_meta['file_path'] ) ) {
				$data_string .= file_get_contents( $data_meta['file_path'] ) . "\r\n";
			}

			$body .= $data_string . $boundary_separator;

		}

		return $this->make_request( $path, $body, 'POST', 'multipart/form-data; boundary=' . $boundary );

	}

	/**
	 * Returns the default set of request arguments.
	 *
	 * @since 3.4
	 *
	 * @param string $body         Request body.
	 * @param string $method       Request method. Defaults to GET.
	 * @param string $content_type Request content type.
	 *
	 * @return array
	 */
	private function request_args( $body = null, $method = 'GET', $content_type = 'application/json' ) {

		return [
			'body'    => $body,
			'method'  => $method,
			'timeout' => 30,
			'headers' => [
				'Authorization' => 'Basic ' . base64_encode( $this->site_url . ':' . $this->license_key ), // phpcs:ignore
				'Content-Type'  => $content_type,
				'Product-ID'    => $this->product_id,
				'user-agent'    => sprintf( 'Fillable PDFs/%1$s; %2$s', fg_fillablepdfs()->get_version(), get_bloginfo( 'url' ) ),
			],
		];

	}

	/**
	 * Returns the base API URL based on the current API region.
	 *
	 * @since 5.0
	 *
	 * @return string
	 */
	public function get_api_url() {

		return $this->get_region_url( 'wp-json/pdf/v2/' );

	}

	/**
	 * Get API regions.
	 *
	 * @since 5.0
	 *
	 * @return array
	 */
	public function get_regions() {
		// Regions data is exposed in the EDD license response.
		$license = fg_fillablepdfs()->check_license();

		if ( $license && isset( $license->pdf->region ) ) {
			// The region data is an object, convert it to an array.
			return json_decode( json_encode( $license->pdf->region->available ), true );
		}

		return CG_FILLABLEPDFS_API_REGIONS;
	}

	/**
	 * Get region URL.
	 *
	 * @since 5.0
	 *
	 * @param string $path Path to append to URL.
	 *
	 * @return string
	 */
	public function get_region_url( $path = '' ) {
		$regions = $this->get_regions();

		if ( ! isset( $regions[ $this->api_region ] ) ) {
			fg_fillablepdfs()->log_error( __METHOD__ . '(): Error getting the URL for the API region ' . $this->api_region );

			return '';
		}

		return trailingslashit( $regions[ $this->api_region ]['url'] ) . $path;
	}





	// # HELPER METHODS ------------------------------------------------------------------------------------------------

	/**
	 * Returns the cache key for a license.
	 *
	 * @since 5.0
	 *
	 * @return string
	 */
	public function get_cache_key() {

		return sprintf( '%1$s_api_license_info_%2$s', fg_fillablepdfs()->get_slug(), $this->license_key );

	}

	/**
	 * This method has two usages:
	 *
	 * - When making requests to the API, and we found out that the API region is incorrect, we use it to update the region setting in the add-on.
	 * - However, if the request was making with a save postback (e.g., updating the license settings), we use it to fix the API region to the posted region.
	 *
	 * @since 5.0
	 *
	 * @param string $expected_api_region The API's expected region.
	 */
	private function update_region( $expected_api_region ) {

		// Validate that this is a real API region.
		if ( ! array_key_exists( $expected_api_region, $this->get_regions() ) ) {
			return;
		}

		// Flush license cache.
		GFCache::delete( $this->get_cache_key() );

		if ( fg_fillablepdfs()->is_save_postback() ) {
			// For a save postback, we know the user has the intention to update the region.
			// Change the API's expected region to match our request.
			$expected_api_region = $this->api_region;

			try {
				$this->set_license_region( $expected_api_region );
				GFCache::delete( $this->get_cache_key() );
			} catch ( Exception $e ) {
				fg_fillablepdfs()->log_error( __METHOD__ . '(): Error updating the API region to ' . $expected_api_region . '. ' . $e->getMessage() );
			}
		} else {
			// If it's not a save postback, we would like to fix the API region to the expected region.
			$this->api_region = $expected_api_region;
		}

		// Update plugin settings.
		$settings           = fg_fillablepdfs()->get_plugin_settings();
		$settings['region'] = $expected_api_region;
		update_option( 'gravityformsaddon_' . fg_fillablepdfs()->get_slug() . '_settings', $settings );

		// Update POST variable for UI.
		if ( rgpost( '_gform_setting_region' ) !== $expected_api_region ) {
			$_POST['_gform_setting_region'] = $expected_api_region;  // phpcs:ignore.
		}

	}

}
