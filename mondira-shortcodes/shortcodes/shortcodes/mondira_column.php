<?php
/*
* Add-on Name: Mondira Column
* Add-on URI: http://mondira.com
*/
if ( !class_exists( 'Mondira_Column' ) ) {
	class Mondira_Column extends Mondira_Shortcode {
	
		function __construct() {
			parent::__construct();
			add_shortcode( 'mondira_a_whole_row', array( $this, 'mondira_a_whole_row_shortcode' ) );
			add_shortcode( 'mondira_one_whole', array( $this, 'mondira_one_whole_shortcode' ) );
			add_shortcode( 'mondira_one_half', array( $this, 'mondira_one_half_shortcode' ) );
			add_shortcode( 'mondira_one_third', array( $this, 'mondira_one_third_shortcode' ) );
			add_shortcode( 'mondira_two_thirds', array( $this, 'mondira_two_thirds_shortcode' ) );
			add_shortcode( 'mondira_one_fourth', array( $this, 'mondira_one_fourth_shortcode' ) );
			add_shortcode( 'mondira_three_fourths', array( $this, 'mondira_three_fourths_shortcode' ) );
		}
		
		function mondira_a_whole_row_shortcode( $atts, $content ) {
			$output = $el_class = '';
			extract( shortcode_atts( array(
				'el_class' => ''
			), $atts ) );
			
			$output .= '<div class="row ' . $el_class . '">';
				$output .= do_shortcode( $content );
			$output .= '</div>';

			return $output;
		}
		
		function mondira_one_whole_shortcode( $atts, $content ) {
			$output = $el_class = '';
			extract( shortcode_atts( array(
				'el_class' => ''
			), $atts ) );
			
			$output .= '<div class="col-lg-12 mondira_col ' . $el_class . '">';
				$output .= do_shortcode( $content );
			$output .= '</div>';
		
			return $output;
		}
		
		function mondira_one_half_shortcode( $atts, $content ) {
			$output = $el_class = '';
			extract( shortcode_atts( array(
				'el_class' => ''
			), $atts ) );
			
			$output .= '<div class="col-sm-6 col-md-6 col-lg-6 mondira_col ' . $el_class . '">';
				$output .= do_shortcode( $content );
			$output .= '</div>';

			return $output;
		}
		
		function mondira_one_third_shortcode( $atts, $content ) {
			$output = $el_class = '';
			extract( shortcode_atts( array(
				'el_class' => ''
			), $atts ) );
			
			$output .= '<div class="col-md-4 col-lg-4 mondira_col ' . $el_class . '">';
				$output .= do_shortcode( $content );
			$output .= '</div>';

			return $output;
		}
		
		function mondira_two_thirds_shortcode( $atts, $content ) {
			$output = $el_class = '';
			extract( shortcode_atts( array(
				'el_class' => ''
			), $atts ) );
			
			$output .= '<div class="col-md-8 col-lg-8 mondira_col ' . $el_class . '">';
				$output .= do_shortcode( $content );
			$output .= '</div>';

			return $output;
		}
		
		function mondira_one_fourth_shortcode( $atts, $content ) {
			$output = $el_class = '';
			extract( shortcode_atts( array(
				'el_class' => ''
			), $atts ) );
			
			$output .= '<div class="col-sm-6 col-md-6 col-lg-3 mondira_col ' . $el_class . '">';
				$output .= do_shortcode( $content );
			$output .= '</div>';

			return $output;
		}
		
		function mondira_three_fourths_shortcode( $atts, $content ) {
			$output = $el_class = '';
			extract( shortcode_atts( array(
				'el_class' => ''
			), $atts ) );
			
			$output .= '<div class="col-md-6 col-lg-9 mondira_col ' . $el_class . '">';
				$output .= do_shortcode( $content );
			$output .= '</div>';

			return $output;
		}
		
	}
	new Mondira_Column;
}