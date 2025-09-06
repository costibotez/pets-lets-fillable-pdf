<?php
/**
 * Display license details on plugin settings page.
 *
 * @since   2.4
 * @package ForGravity\Fillable_PDFs
 */

namespace ForGravity\Fillable_PDFs\Settings\Fields;

use Exception;
use Gravity_Forms\Gravity_Forms\Settings\Fields\Base;

defined( 'ABSPATH' ) || die();

/**
 * Display license details on plugin settings page.
 *
 * @package ForGravity\Fillable_PDFs
 */
class License_Meta extends Base {

	/**
	 * Field type.
	 *
	 * @since 2.4
	 *
	 * @var string
	 */
	public $type = 'fg_fillablepdfs_license_meta';





	// # RENDER METHODS ------------------------------------------------------------------------------------------------

	/**
	 * Render field.
	 *
	 * @since 2.4
	 *
	 * @return string
	 */
	public function markup() {

		// If API is not initialized, return.
		if ( ! fg_pdfs_api() ) {
			return '';
		}

		try {

			// Get license info.
			$license = fg_pdfs_api()->get_license_info();

		} catch ( Exception $e ) {

			// Log that license info could not be retrieved.
			fg_fillablepdfs()->log_error( __METHOD__ . '(): Unable to retrieve license info; ' . $e->getMessage() );

			return '';

		}

		// Prepare info collection.
		$info = [
			[
				'label' => esc_html__( 'Templates Created', 'forgravity_fillablepdfs' ),
				'value' => sprintf( '%d / %d', (int) rgars( $license, 'templates/created' ), (int) rgars( $license, 'templates/limit' ) ),
			],
		];

		// Prepare renewal date.
		if ( rgar( $license, 'reset_date' ) && is_string( $license['reset_date'] ) ) {
			$renewal = strtotime( $license['reset_date'] );
			$renewal = date( get_option( 'date_format' ), $renewal );
		} elseif ( is_numeric( $license['expires'] ) ) {
			$renewal = date( get_option( 'date_format' ), $license['expires'] );
		} else {
			$renewal = ucwords( $license['expires'] );
		}

		// Add renewal date.
		$info[] = [
			'label' => esc_html__( 'Subscription Renewal', 'forgravity_fillablepdfs' ),
			'value' => esc_html( $renewal ),
		];

		// Prepare output.
		$html = '';
		foreach ( $info as $item ) {
			$html .= sprintf(
				'<div class="fillablepdfs-license-meta"><div class="fillablepdfs-license-meta__label">%s</div><div class="fillablepdfs-license-meta__value">%s</div></div>',
				$item['label'],
				$item['value']
			);
		}

		return $html;

	}

}
