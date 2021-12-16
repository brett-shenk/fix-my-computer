<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Random Functions
**/

// Debug
function v_dump( $element ){
	echo "<pre>";
	var_dump( $element );
	echo "</pre>";
}

// Module Spacing
function SpacingFunction($spacing){
    $output = '';

    $margin_top = $spacing['top_margin'];
    $padding_top = $spacing['top_padding'];
    $margin_bottom = $spacing['bottom_margin'];
    $padding_bottom = $spacing['bottom_padding'];

    if ($margin_top >= 0 && $margin_top != '') {
        $output .= 'margin-top: ' . $margin_top . 'px; ';
    }

    if ($padding_top >= 0 && $padding_top != '') {
        $output .= 'padding-top: ' . $padding_top . 'px; ';
    }

    if ($margin_bottom >= 0 && $margin_bottom != '') {
        $output .= 'margin-bottom: ' . $margin_bottom . 'px; ';
    }
    
    if ($padding_bottom >= 0 && $padding_bottom != '') {
        $output .= 'padding-bottom: ' . $padding_bottom . 'px; ';
    }

    return $output;
}
