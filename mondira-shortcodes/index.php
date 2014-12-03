<?php
/*
Plugin Name: Mondira Shortcodes
Plugin URI: http://mondira.com
Description: Adds some most useful shortcodes to your theme which is builded by mondira framework
Author: Jewel Ahmed - Mondira
Author URI: http://mondira.com
Version: 1.0
License: GNU General Public License version 3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

define( 'MONDIRA_SHORTCODE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MONDIRA_SHORTCODE_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

require_once( dirname( __FILE__ ) . '/shortcodes/index.php' );

