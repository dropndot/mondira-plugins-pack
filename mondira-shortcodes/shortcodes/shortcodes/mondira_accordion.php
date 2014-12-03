<?php
/*
* Add-on Name: Mondira Accordion
* Add-on URI: http://mondira.com
*/
if ( !class_exists( 'Mondira_Accordion' ) ) {
	class Mondira_Accordion extends Mondira_Shortcode {
	
		function __construct() {
			parent::__construct();
			add_shortcode( 'mondira_accordion', array( $this, 'mondira_accordion_shortcode' ) );
			add_shortcode( 'mondira_accordion_section', array( $this, 'mondira_accordion_section_shortcode' ) );
		}
		
		function mondira_accordion_section_shortcode( $atts, $content ) {
			$output = $title = '';
			extract( shortcode_atts( array(
				'title' => __( 'Tab', 'mondira' )
			), $atts ) );
			
			$css_class = apply_filters( 'mondira_accordion_section_shortcode_classes', 'mondira_accordion_section mondira_content_element', $atts );
			$output .= "\n\t\t\t" . '<div class="'.$css_class.'">';
				$output .= "\n\t\t\t\t" . '<h3><a href="#' . sanitize_title( $title ) . '">' . $title . '</a><span></span></h3>';
				$output .= "\n\t\t\t\t" . '<div class="mondira_accordion_content">';
					$output .= ($content=='' || $content==' ') ? __( 'Empty tab. Edit page to add content here.', 'mondira' ) : "\n\t\t\t\t" . do_shortcode( $content );
					$output .= "\n\t\t\t\t" . '</div>';
				$output .= "\n\t\t\t" . '</div>' . "\n";

			return $output;
		}
		
		function mondira_accordion_shortcode( $atts, $content ) {
			$output = $title = $interval = $el_class = $collapsible = $active_section = '';
			extract( shortcode_atts( array(
				'title' => '',
				'el_class' => '',
				'active_section' => '1'
			), $atts ) );
			
			$css_class = apply_filters( 'mondira_accordion_shortcode_classes', 'mondira_accordion mondira_content_element ' . $el_class, $atts );
			$output .= "\n\t" . '<div class="'.$css_class.'" data-active-tab="'.$active_section.'">';
			$output .= "\n\t\t" . '<div class="mondira_wrapper mondira_accordion_wrapper">';
			if ( !empty( $title ) ) {
				$output .= "\n\t\t\t" . '<h3>' . $title . '</h3>';
			}
			$output .= "\n\t\t\t" . do_shortcode($content);
			$output .= "\n\t\t" . '</div>';
			$output .= "\n\t" . '</div>';

			return $output;
		}
		
	}
	new Mondira_Accordion;
}