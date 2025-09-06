<?php
/**
 * Display license features on plugin settings page.
 *
 * @since   2.4
 * @package ForGravity\Fillable_PDFs
 */

namespace ForGravity\Fillable_PDFs\Settings\Fields;

use Exception;
use Gravity_Forms\Gravity_Forms\Settings\Fields\Base;

defined( 'ABSPATH' ) || die();

/**
 * Display license features on plugin settings page.
 *
 * @package ForGravity\Fillable_PDFs
 */
class License_Features extends Base {

	/**
	 * Field type.
	 *
	 * @since 2.4
	 *
	 * @var string
	 */
	public $type = 'fg_fillablepdfs_license_features';





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

		// Prepare feature collection.
		$features = [
			[
				'icon'          => fg_fillablepdfs()->get_base_url() . '/dist/images/features/import.svg',
				'label'         => esc_html__( 'Convert PDFs to Forms', 'forgravity_fillablepdfs' ),
				'description'   => esc_html__( 'Save time by importing an existing PDF to be created as a form.', 'forgravity_fillablepdfs' ),
				'documentation' => fg_fillablepdfs()->get_documentation_url( 'import' ),
				'has_access'    => rgars( $license, 'supports/import', false ),
				'upgrade_url'   => rgars( $license, 'upgrade_urls/professional' ),
			],
		];

		// Display features.
		$html = '';
		foreach ( $features as $feature ) {

			// Get class.
			$class = $feature['has_access'] ? 'fillablepdfs-license-feature--unlocked' : 'fillablepdfs-license-feature--locked';

			// Prepare footer.
			if ( $feature['has_access'] ) {
				$footer = sprintf(
					'<div class="fillablepdfs-license-feature-footer"><a href="%s">%s</a></div>',
					esc_url( $feature['documentation'] ),
					esc_html__( 'Documentation', 'forgravity_fillablepdfs' )
				);
			} else {
				$footer = sprintf(
					'<a href="%s" class="fillablepdfs-license-feature-upgrade">%s</a>',
					esc_url( $feature['upgrade_url'] ),
					esc_html__( 'Upgrade License', 'forgravity_fillablepdfs' )
				);
			}

			$html .= sprintf(
				'<div class="fillablepdfs-license-feature %5$s">
					<div class="fillablepdfs-license-feature-container">
						<img src="%1$s" alt="%2$s" />
						<div class="fillablepdfs-license-feature-meta">
							<div class="fillablepdfs-license-feature-meta__label">%2$s</div>
							<p class="fillablepdfs-license-feature-meta__description">%3$s</p>
						</div>
					</div>
					%4$s
				</div>',
				$feature['icon'],
				$feature['label'],
				$feature['description'],
				$footer,
				$class
			);

		}

		return $html;

	}

}
