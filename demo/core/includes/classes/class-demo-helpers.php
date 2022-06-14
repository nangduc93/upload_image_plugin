<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Demo_Helpers
 *
 * This class contains repetitive functions that
 * are used globally within the plugin.
 *
 * @package		DEMO
 * @subpackage	Classes/Demo_Helpers
 * @author		Đức Nguyễn Năng
 * @since		1.0.0
 */
class Demo_Helpers{

	/**
	 * Determines if the old or new filter for WP Webhooks should be used
	 *
	 * @access	private
	 * @since	1.0.0
	 * @var		mixed
	 */
	private $wp_webhooks_use_new_filter = null;

	/**
	 * ######################
	 * ###
	 * #### CALLABLE FUNCTIONS
	 * ###
	 * ######################
	 */

	/**
	 * HELPER COMMENT START
	 *
	 * Within this class, you can define common functions that you are 
	 * going to use throughout the whole plugin. 
	 * 
	 * Down below you will find a demo function called output_text()
	 * To access this function from any other class, you can call it as followed:
	 * 
	 * DEMO()->helpers->output_text( 'my text' );
	 * 
	 */
	 
	/**
	 * Output some text
	 *
	 * @param	string	$text	The text to output
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	 public function output_text( $text = '' ){
		 echo $text;
	 }

	 /**
	  * HELPER COMMENT END
	  */

	/**
	 * Helper function to determine if the old notation for 
	 * WP Webhooks should be used, or the new one
	 *
	 * @since	1.0.0
	 *
	 * @return	bool
	 */
	public function wp_webhooks_use_new_action_filter(){

		if( $this->wp_webhooks_use_new_filter !== null ){
			return $this->wp_webhooks_use_new_filter;
		}

		$return = false;
		$version_current = '0';
		$version_needed = '0';

		if( defined( 'WPWHPRO_VERSION' ) ){
			$version_current = WPWHPRO_VERSION;
			$version_needed = '4.1.0';
		}

		if( defined( 'WPWH_VERSION' ) ){
			$version_current = WPWH_VERSION;
			$version_needed = '3.1.0';
		}

		if( version_compare( (string) $version_current, (string) $version_needed, '>=') ){
			$return = true;
		}

		$this->wp_webhooks_use_new_filter = $return;

		return $return;
	}

}
