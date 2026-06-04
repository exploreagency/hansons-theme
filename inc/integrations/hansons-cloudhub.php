<?php
/**
 * Hansons Cloudhub API Proxy.
 */

add_action( 'rest_api_init', function () {
  register_rest_route( 'hansons/v1', '/schedule', [
    'methods'             => 'GET',
    'callback'            => 'hansons_get_schedule_availability',
    'permission_callback' => '__return_true',
    'args'                => [
      'zipCodeID' => [
        'required'          => true,
        'sanitize_callback' => 'sanitize_text_field',
      ],
    ],
  ] );
} );

function hansons_get_schedule_availability( WP_REST_Request $request ) {
  $zip_code = $request->get_param( 'zipCodeID' );

  if ( !preg_match( '/^\d{5}$/', $zip_code ) ) {
    return new WP_REST_Response( [
      'success' => false,
      'message' => 'Invalid ZIP code.',
    ], 400 );
  }

  if (
    !defined( 'CLOUDHUB_CLIENT_ID' ) ||
    !defined( 'CLOUDHUB_CLIENT_SECRET' )
  ) {
    return new WP_REST_Response( [
      'success' => false,
      'message' => 'Schedule API credentials are not configured.',
    ], 500 );
  }

  $api_url = add_query_arg(
    'zipCodeID',
    rawurlencode( $zip_code ),
    'https://hansons-prospect-api.us-e2.cloudhub.io/api/schedule'
  );

  $response = wp_remote_get( $api_url, [
    'timeout' => 15,
    'headers' => [
      'Accept'        => 'application/json',

      // Confirm exact header names with the API provider.
      'client_id'     => CLOUDHUB_CLIENT_ID,
      'client_secret' => CLOUDHUB_CLIENT_SECRET,
    ],
  ] );

  if ( is_wp_error( $response ) ) {
    return new WP_REST_Response( [
      'success' => false,
      'message' => $response->get_error_message(),
    ], 500 );
  }

  $status_code = wp_remote_retrieve_response_code( $response );
  $body        = wp_remote_retrieve_body( $response );
  $data        = json_decode( $body, true );

  if ( $status_code < 200 || $status_code >= 300 ) {
    return new WP_REST_Response( [
      'success' => false,
      'message' => 'Schedule API returned an error.',
      'status'  => $status_code,
    ], $status_code );
  }

  return new WP_REST_Response( [
    'success' => true,
    'data'    => $data,
  ], 200 );
}