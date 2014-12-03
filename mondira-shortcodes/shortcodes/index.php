<?php 
/*
*
* Mondira shortcodes definition file
* Author: Jewel Ahmed
* Author URI: https://mondira.com
* Version: 1.0
*/
if ( !class_exists( 'Mondira_Shortcode' ) ) {
	class Mondira_Shortcode {
		var $shortcodes_dir;
		var $assets_js;
		var $assets_css;
		
		function __construct() {
			$this->base_uri   = MONDIRA_SHORTCODE_PLUGIN_URI;
			$this->shortcodes_dir   = MONDIRA_SHORTCODE_PLUGIN_DIR . '/shortcodes/shortcodes/';
			$this->assets_js        = MONDIRA_SHORTCODE_PLUGIN_URI . '/shortcodes/assets/js/';
			$this->assets_css       = MONDIRA_SHORTCODE_PLUGIN_URI . '/shortcodes/assets/css/';
		}
	}
}

if ( !class_exists( 'Mondira_Addons' ) ) {
	class Mondira_Addons extends Mondira_Shortcode {
		
		function __construct() {
			parent::__construct();
			add_action( 'wp_enqueue_scripts', array( $this, 'mondira_shortcode_scripts' ) );
		}
		
		function mondira_shortcode_scripts() {
			global $post;
			
			wp_enqueue_script( 'mondira-shortcode-custom-js', $this->assets_js . 'custom.js', array( 'jquery' ), '1.5', true );
			wp_enqueue_style( 'mondira-shortcode-style-css', $this->assets_css . 'style.css', array(), '1.0', 'all' );
		}
		
		function mondira_atomic_init() {
			global $mondira_shortcode_this;
			$mondira_shortcode_this = $this;
			
			$mondira_shortcode_files = glob( $this->shortcodes_dir . "*.php" );
			
			$mondira_shortcodes[] = 'mondira_column';
			$mondira_shortcodes[] = 'mondira_accordion';
			$mondira_shortcodes[] = 'mondira_toggle';
			
			$mondira_shortcodes[] = 'mondira_icons';
			$mondira_shortcodes[] = 'mondira_audio';
			$mondira_shortcodes[] = 'mondira_button';
			$mondira_shortcodes[] = 'mondira_divider';
			$mondira_shortcodes[] = 'mondira_dropcap';
			$mondira_shortcodes[] = 'mondira_gmaps';
			$mondira_shortcodes[] = 'mondira_message';
			$mondira_shortcodes[] = 'mondira_empty_space';
			$mondira_shortcodes[] = 'mondira_text_separator';
			$mondira_shortcodes[] = 'mondira_single_image';
			$mondira_shortcodes[] = 'mondira_milestone';
			$mondira_shortcodes[] = 'mondira_progress_bar';
			$mondira_shortcodes[] = 'mondira_video';
			$mondira_shortcodes[] = 'mondira_vimeo';
			$mondira_shortcodes[] = 'mondira_whighlight';
			$mondira_shortcodes[] = 'mondira_youtube';
			
			foreach( $mondira_shortcode_files as $shortcode ) {
				$mondira_shortcode_file = basename($shortcode);
				$mondira_shortcode_file_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $mondira_shortcode_file);
				
				if ( !empty( $mondira_shortcodes ) && is_array( $mondira_shortcodes ) ) { 
					if ( in_array( strtolower( $mondira_shortcode_file_name ), $mondira_shortcodes ) ) {
						require_once( $shortcode );
					}
				}
			}
		}
		
	}
	$Mondira_Addons = new Mondira_Addons;
	$Mondira_Addons->mondira_atomic_init();
}


/*
---------------------------------------------------------------------------------------
    Return attachment id by url
	@param image_src attachment url
	@return attachment id
    @Author: Jewel Ahmed
    @Author Web: http://www.codeatomic.com
---------------------------------------------------------------------------------------
*/
if ( !function_exists( 'mondira_get_the_attachments_id_by_url' ) ) {
    function mondira_get_the_attachments_id_by_url( $image_src ) {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
        $id = $wpdb->get_var( $query );
        return $id;
    }
}