<?php
/*
 * Plugin Name: Permission Modal Shortcode
 * Description: Quick & simple permission marketing dialog boxes for Wordpress.
 * Version: 0.1
 * Author: Christopher J. Vogt <mail@chrisvogt.me>
 * Author URI: http://chrisvogt.me
 * License: GPL3
 * */
/**
 * 
 * Permission Marketing Modals
 * by CHR1SV0GT
 *
 * Inspired by the concept of permission
 * marketing, requesting user interaction prior
 * to advancing forward.
 * 
 * Adds a shortcode to Wordpress to easily
 * create feature panes requesting user info
 * prior to proceeding.  
 *
 * @package      Wordpress
 * @subpackage   permission_modal_shortcode
 * @version      0.1
 * @author       Christopher J. Vogt <mail@chrisvogt.me>
 * @copyright    Copyright (c) 2012, Christopher J Vogt
 * @license      http://opensource.org/licenses/gpl-3.0.php GNU Public License
 * 
 * Upcoming Releases:
 * @todo _POST user subscription data on accept
 * @todo Store user subscription data on accept
 */

class Permission_Modal_Shortcode {

	/* Register permission marketing shorcode
	   ================================================================= */

	add_shortcode("pmodal", "permission_modal_shortcode");

	/**
	 * Permission shortcode handler
	 * @param {string|array} $atts 		The attributes passed to the shortcode like [pmodal attr1="value" /].
	 *                               	Empty string if no argument passed.
	 * @param {string}			 $string 	The content between non-self closing [pmodal]...[/pmodal] tags.
	 * @return {string} 							Permission modal HTML.
	 */
	function permission_modal_shortcode($atts, $content = NULL) {

		// Custom shortcode options
		shortcode_options = array_merge(array('url' => trim($content)), is_array($atts) ? $atts : array() );

		// Shortcode option "param" (param=value&param2=value) into array
		$shortcode_params = array();
		if (isset($shortcode_options['params'])) {
			parse_str(html_entity_decode($shortcode_options['params']), $shortcode_params);
		}
		$shortcode_options['params'] = $shortcode_params;

		// Create a reference of the shortcode options function
		$options = &$shortcode_options;

		// The "url" option is required
		if (isset($options['url'])) { return ''; }

	}

	/**
	 * Booleanize a value
	 * @param  {boolean|string} $value
	 * @return {boolean}
	 */
	function permission_booleanize($value) {
		return is_bool($value) ? $value : $value === 'true' ? true : false;
	}

}

$pmodal = new Permission_Modal_Shortcode();