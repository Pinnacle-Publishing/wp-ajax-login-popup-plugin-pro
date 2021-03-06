<?php

/**
 * WooCommerce API Manager API Key Class
 *
 * @package Update API Manager/Key Handler
 * @author Todd Lahman LLC
 * @copyright   Copyright (c) Todd Lahman LLC
 * @since 1.3
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LRM_Api_Manager_Key {

    /**
     * @var The single instance of the class
     */
    protected static $_instance = null;

    public static function instance() {

        if ( is_null( self::$_instance ) ) {
        	self::$_instance = new self();
        }

        return self::$_instance;
    }

	// API Key URL
	public function create_software_api_url( $args ) {

    	$server_url = LRM_API_Manager()->upgrade_url;
    	if ( isset($args['alternative_server']) && $args['alternative_server'] ) {
		    $server_url = LRM_API_Manager()->upgrade_url_alt;
	    }
		$api_url = add_query_arg( 'wc-api', 'wc-am-api', $server_url );

		//lrm_log( "LRM API query", $api_url . '&' . http_build_query( $args ) );

		return $api_url . '&' . http_build_query( $args );
	}

	public function activate( $args ) {

		$defaults = array(
			'request' 			=> 'activation',
			'product_id' 		=> LRM_API_Manager()->ame_product_id,
			'instance' 			=> LRM_API_Manager()->ame_instance_id,
			'platform' 			=> LRM_API_Manager()->ame_domain,
			'software_version' 	=> LRM_API_Manager()->ame_software_version
        );

		$args = wp_parse_args( $defaults, $args );

		$target_url = esc_url_raw( $this->create_software_api_url( $args ) );

		// safe_
		$request = wp_remote_get( $target_url );

		// $request = wp_remote_post( LRM_API_Manager()->upgrade_url . 'wc-api/am-software-api/', array( 'body' => $args ) );

		if( is_wp_error( $request ) || !in_array(wp_remote_retrieve_response_code( $request ), [100, 200]) ) {
		    // Request failed
			return [
			    'activated'=>false,
                'body' => wp_remote_retrieve_body( $request ),
                'response_code' => wp_remote_retrieve_response_code( $request ),
                'server_ip' => $_SERVER['SERVER_ADDR'],
				'requested_url' => $target_url,
				'request' => $request,
            ];
		}

		$response = wp_remote_retrieve_body( $request );

		return $response;
	}

	public function deactivate( $args ) {

		$defaults = array(
			'request' 		=> 'deactivation',
			'product_id' 	=> LRM_API_Manager()->ame_product_id,
			'instance' 		=> LRM_API_Manager()->ame_instance_id,
			'platform' 		=> LRM_API_Manager()->ame_domain
        );

		$args = wp_parse_args( $defaults, $args );

		$target_url = esc_url_raw( $this->create_software_api_url( $args ) );

		$request = wp_safe_remote_get( $target_url );

		// $request = wp_remote_post( LRM_API_Manager()->upgrade_url . 'wc-api/am-software-api/', array( 'body' => $args ) );

		if( is_wp_error( $request ) || !in_array(wp_remote_retrieve_response_code( $request ), [100, 200]) ) {
		// Request failed
			return false;
		}

		$response = wp_remote_retrieve_body( $request );

		return $response;
	}

	/**
	 * Checks if the software is activated or deactivated
	 * @param  array $args
	 * @return array
	 */
	public function status( $args ) {

		$defaults = array(
			'request' 		=> 'status',
			'product_id' 	=> LRM_API_Manager()->ame_product_id,
			'instance' 		=> LRM_API_Manager()->ame_instance_id,
			'platform' 		=> LRM_API_Manager()->ame_domain
			);

		$args = wp_parse_args( $defaults, $args );

		$target_url = esc_url_raw( $this->create_software_api_url( $args ) );

		$request = wp_safe_remote_get( $target_url );

		// $request = wp_remote_post( LRM_API_Manager()->upgrade_url . 'wc-api/am-software-api/', array( 'body' => $args ) );

		if( is_wp_error( $request ) || !in_array(wp_remote_retrieve_response_code( $request ), [100, 200]) ) {
		// Request failed
			return false;
		}

		$response = wp_remote_retrieve_body( $request );
//var_dump($response);die;
		return $response;
	}

}

// Class is instantiated as an object by other classes on-demand
