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
if ( !defined( 'ABSPATH' ) ) { die(); }

class CJVModalShortcode {

	// Contents of the template file
	public $template = '';

	/**
	 * Class constructor.
	 * Adds the shortcode and registers it's resources.
	 */
	public function __construct() {

		// Conditionally register and queue the shortcode assets
		$this->pmodal_asset_handler();

		// Register the shortcode
		$this->pmodal_register_shortcode();

    $this->pmodal_settings_handler();

	}

  /* Init
   ================================================================= */

  function pmodal_asset_handler() {

    /* Hook front-end scripts if current screen is a post or page */
    // if ( is_singular() && !is_admin() ) {

      // add script registration to wp_enqueue_scripts hook
      add_action( 'wp_enqueue_scripts', array($this, 'pmodal_register_assets' ) );

      // add asset initialization to wp_enqueue_scripts hook
      add_action( 'wp_enqueue_scripts', array($this, 'pmodal_init_assets' ) );

    // }

  }

  /**
   * Register permission modal scripts and styles.
   *
   * @see http://codex.wordpress.org/Function_Reference/wp_register_script
   * @see http://codex.wordpress.org/Function_Reference/wp_register_style
   * @see &this::pmodal_init_assets()  for the initialization of these scripts.
   */
  function pmodal_register_assets() {

    // front-end stylesheet; defines modal styles
    wp_register_style(
      'pmodal-style',
      plugins_url( '/css/front-end/pmodal.css', __FILE__ ),
      false,
      0.1
    );

    // front-end JavaScript; initializes modal
    wp_register_script(
      'pmodal-init',
      plugins_url( '/js/front-end/pmodal.js', __FILE__ ),
      array( 'jquery', 'jquery-ui-core', 'jquery-ui-dialog' ),
      null,
      true
    );

  }

  /**
   * Initialize the project assets (styles and scripts).
   *
   * @see http://codex.wordpress.org/Function_Reference/wp_enqueue_script
   * @see http://codex.wordpress.org/Function_Reference/wp_enqueue_style
   * @see &this::pmodal_register_assets()  for the registration of queued scripts and styles.
   */
  function pmodal_init_assets() {

    // safely queue the front-end CSS
    wp_enqueue_style( 'pmodal-style' );

    // safely queue the front-end JavaScript
    wp_enqueue_script( 'pmodal-init' );

  }

  function pmodal_register_shortcode() {

    // Register permission marketing shortcode
    add_shortcode( 'pmodal', array( &$this, 'permission_modal_shortcode' ) );

  }

  function pmodal_settings_handler() {

   include("inc/class.my-theme-options.php");

  }

		/* The Shortcode
	   ================================================================= */

	/**
	 * Permission shortcode handler
	 *
	 * @param {string|array} $atts   The attributes passed to the shortcode like [pmodal attr1="value" /].
	 *                                Empty string if no argument passed.
	 * @param {string} $string The content between non-self closing [pmodal]...[/pmodal] tags.
	 * @return {string}   Permission modal HTML.
	 */
	function permission_modal_shortcode( $atts = array(), $content = NULL ) {

		// Store the attribute results in local variables,
		// define shortcode attributes and default settings
		extract( shortcode_atts( array(
					'href'   => 'undefinedHREF',
					'buttontext' => 'undefinedButtonText'
				), $atts ) );

		// $template = file_get_contents( 'README.md' );

		// test!
		//var_dump( $atts );

    include("tpl/pmodal.php");

	}


	/* Helper Functions
	   ================================================================= */

	/**
	 * Booleanize a value
	 *
	 * @param {boolean|string} $value
	 * @return {boolean}
	 */
	function permission_booleanize( $value ) {
		return is_bool( $value ) ? $value : $value === 'true' ? true : false;
	}

	/**
	 * Use file_get_contents to grab the modal template.
	 */
	protected function get_template_file( $file ) {

		// Empty the template property (should already be empty)
		$this->template = '';

		$this->template = file_get_contents( $file );

	}

} // end of CJVModalShortcode

$pmodal = new CJVModalShortcode();
