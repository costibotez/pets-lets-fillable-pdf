<?php
/**
 * The helper functions that allows overriding.
 *
 * @since 3.3
 *
 * @package ForGravity/FillablePDFs
 */

/**
 * Returns an instance of the Fillable_PDFs class
 *
 * @since 1.0
 *
 * @return ForGravity\Fillable_PDFs\Fillable_PDFs
 */
function fg_fillablepdfs() {

	return ForGravity\Fillable_PDFs\Fillable_PDFs::get_instance();

}

/**
 * Fillable PDFS pre-processing for apply_filters().
 *
 * Prepends the filter name with the Fillable PDFs prefix.
 * Allows additional filters based on form and field ID to be defined easily.
 *
 * @since 3.4
 *
 * @param string|array $filter The name of the filter and optional modifiers.
 * @param mixed        $value  The value to filter.
 *
 * @return mixed The filtered value.
 */
function fg_pdfs_apply_filters( $filter, $value ) {

	$modifiers = [];
	$args      = array_slice( func_get_args(), 2 );

	if ( is_array( $filter ) ) {
		$modifiers = array_splice( $filter, 1, count( $filter ) );
		$filter    = $filter[0];
	}

	// Prefix filter name.
	$filter = 'fg_fillablepdfs_' . $filter;

	// Add an empty modifier so the base filter will be applied as well.
	array_unshift( $modifiers, '' );

	$args = array_pad( $args, 10, null );

	foreach ( $modifiers as $modifier ) {
		$modifier = rgblank( $modifier ) ? '' : sprintf( '_%s', $modifier );
		$filter  .= $modifier;
		$value    = apply_filters( $filter, $value, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8], $args[9] );
	}

	return $value;

}

/**
 * Fillable PDFs pre-processing for do_action().
 *
 * Prepends the action name with the Fillable PDFs prefix.
 * Allows additional actions based on form and field ID to be defined easily.
 *
 * @since 3.4
 *
 * @param string|array $action The action and optional modifiers.
 */
function fg_pdfs_do_action( $action ) {

	$modifiers = [];
	$args      = array_slice( func_get_args(), 1 );

	if ( is_array( $action ) ) {
		$modifiers = array_splice( $action, 1, count( $action ) );
		$action    = $action[0];
	}

	// Prefix action name.
	$action = 'fg_fillablepdfs_' . $action;

	// Add an empty modifier so the base filter will be applied as well.
	array_unshift( $modifiers, '' );

	$args = array_pad( $args, 10, null );

	foreach ( $modifiers as $modifier ) {
		$modifier = rgblank( $modifier ) ? '' : sprintf( '_%s', $modifier );
		$action  .= $modifier;
		do_action( $action, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8], $args[9] );
	}

}
