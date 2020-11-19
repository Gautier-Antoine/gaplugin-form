<?php
/*
Plugin Name: YLC-Form
Plugin URI: https://github.com/Pepite61/gaplugin-form
Description: Form for the website
Version: 0.00.01
Requires at least: 5.2
Requires PHP: 7.2
Author: GAUTIER Antoine
Author URI: gautierantoine.com
Text Domain: form-text
Domain Path: /languages
License:     GPL v3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
Form-GA is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or any later version.
Form-GA is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with DarkMode-GA.
If not, see https://www.gnu.org/licenses/gpl-3.0.en.html.
*/
if( is_admin() ){
	require 'includes/Form-YLC.php';
	new YLCForm();
}

require 'includes/Form-YLC-ShortCode.php';
new YLCFormSC();







//
//
// make if !class_exists(page admin){
// 	create page admin
// }
//
// Check sanitization
//
// See activate_plugin && deactivate
//
// See add row, add form
//
