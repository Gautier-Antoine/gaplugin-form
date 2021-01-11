<?php
/**
 * @package GAP-Form
 */
/*
Plugin Name: GAP-Form
Plugin URI: https://github.com/Gautier-Antoine/GAP-form-plugin
Description: Form for the website GAP
Version: 0.00.01
Requires at least: 5.2
Tested up to: 5.6
Requires PHP: 7.2
Author: GAUTIER Antoine
Author URI: gautierantoine.com
Text Domain: form-text
Domain Path: /languages
// License:     GPL v3
// License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
// Form-GA is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or any later version.
// Form-GA is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU General Public License for more details.
// You should have received a copy of the GNU General Public License along with DarkMode-GA.
// If not, see https://www.gnu.org/licenses/gpl-3.0.en.html.
*/

defined('ABSPATH') or die('You cannot enter');
add_filter(
  'rest_authentication_errors',
  function( $result ) {
    if ( true === $result || is_wp_error( $result ) ) {
        return $result;
    }
    if ( ! is_user_logged_in() ) {
        return new WP_Error(
            'rest_not_logged_in',
            __( 'You are not currently logged in', 'form-text' ),
            array( 'status' => 401 )
        );
    }
    return $result;
  }
);

/// change to FormGAP/AutoLoader();
require 'includes/autoloader.php';

if( is_admin() ){
	// Create Admin Panel
  if ( class_exists( 'FormGAP\GAPForm' ) ) {
    $GAPForm = new FormGAP\GAPForm();
    $GAPForm->startup();
  }
}
if ( class_exists( 'FormGAP\GAPFormSC' ) ) {
  // Load the css, js, php files
  $GAPFormSC = new FormGAP\GAPFormSC();
  $GAPFormSC->startup();
}

/**
 * Activation hook
 */
function gapformActivation() {
  if ( class_exists( 'FormGAP\GAPForm' ) ) {
    FormGAP\GAPForm::Activation();
  }
}
register_activation_hook( __FILE__, 'gapformActivation' );

/**
 * Deactivation hook
 */
function gapformDeactivation() {
  if ( class_exists( 'FormGAP\GAPForm' ) ) {
    FormGAP\GAPForm::Deactivation();
  }
}
register_deactivation_hook( __FILE__, 'gapformDeactivation' );
