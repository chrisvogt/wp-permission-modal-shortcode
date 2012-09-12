<?php
/*
 * Plugin Name: Permission Modal Shortcode
 * Description: Quick & simple permission marketing dialog boxes for Wordpress.
 * Version: 0.0.1
 * Author: Christopher J. Vogt <mail@chrisvogt.me>
 * Author URI: http://chrisvogt.me
 * License: GNU General Public License v2
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
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
 * @version      0.0.1
 * @author       Christopher J. Vogt <mail@chrisvogt.me>
 * @copyright    Copyright (c) 2012, Christopher J Vogt
 * @licenses 		 GNU General Public License v2
 * 
 * Upcoming Releases:
 * @todo _POST user subscription data on accept
 * @todo Store user subscription data on accept
 */

// Check this is within the context of Wordpress
if ( !defined('ABSPATH') ) { die(); }

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

	/* Init
   ================================================================= */

	/**
	 * Register permission modal scripts and styles.
	 * @see http://codex.wordpress.org/Function_Reference/wp_register_script
	 * @see http://codex.wordpress.org/Function_Reference/wp_register_style
	 * @see &this::pmodal_init_assets() 		for the initialization of these scripts. 
	 */
	function pmodal_register_assets() {

		// front-end stylesheet; defines modal styles 
		wp_register_style(
						'pmodal-style',
						plugins_url('/css/front-end/pmodal.css', __FILE__),
						false,
						0.1
			);

		// front-end JavaScript; initializes modal
		wp_register_script(
						'pmodal-init',
						plugins_url('/js/front-end/pmodal.js', __FILE__),
						array('jquery')
			);

	}

	// add script registration to wp_enqueue_scripts hook
	add_action('wp_enqueue_scripts', 'pmodal_register_assets')

	/**
	 * Initialize the project assets (styles and scripts).
	 * @see http://codex.wordpress.org/Function_Reference/wp_enqueue_script
	 * @see http://codex.wordpress.org/Function_Reference/wp_enqueue_style
	 * @see &this::pmodal_register_assets() 		for the registration of queued scripts and styles. 
	 */
function pmodal_init_assets() {

	// safely queue the front-end CSS
	wp_enqueue_style('pmodal-style');

	// safely queue the front-end JavaScript
	wp_enqueue_script('pmodal-init');

}

/* Hook front-end scripts if current screen is a post or page */ 
if ( is_singular() && !is_admin() ) {

	// add asset initialization to wp_enqueue_scripts hook 
	add_action('wp_enqueue_scripts', 'pmodal_init_assets');

}

	/* Helper Functions
	   ================================================================= */

	/**
	 * Booleanize a value
	 * @param  {boolean|string} $value
	 * @return {boolean}
	 */
	function permission_booleanize($value) {
		return is_bool($value) ? $value : $value === 'true' ? true : false;
	}

} // end of Permission_Modal_Shortcode

$pmodal = new Permission_Modal_Shortcode();