if ( isset($pdf) ) {
	$font = Font_Metrics::get_font("arial", "bold");

if($GLOBALS['STATIONARY'] == 1) {

	$footer = $pdf->open_object();
	// Draw a line along the bottom
	$y = $h - 40;
  	//$pdf->line(57, $y, $w-58, $y,array(0.4,0.4,0.4), 1);
	
    // page numbering
   // $lang_page = $GLOBALS['PAGE'];
    //$lang_of = $GLOBALS['OF'];
	//$pdf->page_text($w-95, $h-55, "$lang_page {PAGE_NUM} / {PAGE_COUNT}", $font, 7, array(0.4,0.4,0.4));
	
    // powered by
    //$pdf->image(CO_FILES . "/img/print/".$GLOBALS["APPLICATION_LOGO_PRINT"]."", "png", 57, $h-22, 135, 9);
    //$banking = $GLOBALS['BANKING_LINE_1'];
    //$pdf->page_text(57, $h-34, $banking, $font, 7, array(0.4,0.4,0.4));
    //$banking2 = $GLOBALS['BANKING_LINE_2'];
    //$pdf->page_text(57, $h-22, $banking2, $font, 7, array(0.4,0.4,0.4));
    
    // section image
    //$section = $GLOBALS['SECTION'];
    //$pdf->image(CO_FILES . "/img/print/".$section, "png", $w-48, $h-339, 34, 300);
	
    $pdf->close_object();
	$pdf->add_object($footer, "all");
    }
}