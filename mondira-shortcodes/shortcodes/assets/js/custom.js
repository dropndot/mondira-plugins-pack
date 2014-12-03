/*
---------------------------------------------------------------------------------------
    Mondira Shortcode related all JS custom functions                           
    @Since Version 1.0
---------------------------------------------------------------------------------------
*/

jQuery(document).ready(function() {
    "use strict";
    var $ = jQuery;
	
	/*
	---------------------------------------------------------------------------------------
		Mondira Accordion Initialization
	---------------------------------------------------------------------------------------
	*/
	var AccordionAllPanels = $( '.mondira_accordion .mondira_accordion_content' ).hide();
	$( '.mondira_accordion .mondira_accordion_section > h3 > a' ).click(function() {
		$( '.mondira_accordion .mondira_accordion_section h3' ).removeClass( 'mondira_accordion_active' );
		AccordionAllPanels.slideUp();
		$(this).parent().next().slideDown();
		$(this).parent().addClass( 'mondira_accordion_active' );
		return false;
	});
	$( '.mondira_accordion' ).each(function( index ) {
		var $active_index = parseInt( $( this ).data( 'active-tab' ) );
		$( this ).find( '.mondira_accordion_section > h3' ).eq( $active_index ).addClass( 'mondira_accordion_active' );
		$( this ).find( '.mondira_accordion_section > .mondira_accordion_content' ).eq( $active_index ).css( 'display', 'block' );
	});
	
	/*
	---------------------------------------------------------------------------------------
		Mondira Toggle Initialization
	---------------------------------------------------------------------------------------
	*/
	var ToggleAllPanels = $( '.mondira_toggle .mondira_toggle_content' ).hide();
	$( '.mondira_toggle .mondira_toggle_section > h3 > a' ).click(function() {
		var $display = $(this).parent().next().css( 'display' );
		if ( $display == 'none' ) {
			$(this).parent().next().slideDown();
			$(this).parent().addClass( 'mondira_toggle_active' );
		} else {
			$(this).parent().next().slideUp();
			$(this).parent().removeClass( 'mondira_toggle_active' );
		}
		return false;
	});
	$( '.mondira_toggle' ).each(function( index ) {
		var $active_index = parseInt( $( this ).data( 'active-tab' ) );
		$( this ).find( '.mondira_toggle_section > h3' ).eq( $active_index ).addClass( 'mondira_toggle_active' );
		$( this ).find( '.mondira_toggle_section > .mondira_toggle_content' ).eq( $active_index ).css( 'display', 'block' );
	});
});