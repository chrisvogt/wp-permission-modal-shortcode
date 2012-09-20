<?php
/**
 * Plugin settings and options.
 *
 */

add_action( 'admin_menu', 'pmodal_add_menu' );

function pmodal_add_menu() {
  $cjvpmodal_settings_page = add_theme_page(__('Permission Modal Options'), __('Permission Modal'), 'manage_options', 'pmodal-settings', 'pmodal_settings_page_fn');
}