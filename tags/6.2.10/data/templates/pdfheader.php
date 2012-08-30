if ( isset($pdf) ) {
	$font = Font_Metrics::get_font("arial", "bold");
	
    if($GLOBALS['STATIONARY'] == 1) {
	$header = $pdf->open_object();
	$w = $pdf->get_width();
	$h = $pdf->get_height();

	$img_w = 482; // 2 inches, in points
	$img_h = 24; // 1 inch, in points -- change these as required

    $pdf->image(CO_PATH_BASE . "/data/logo_print.png", "png", 57, 26, $img_w, $img_h);
    
	// Close the object (stop capture)
	$pdf->close_object();
	$pdf->add_object($header, "all");


	$footer = $pdf->open_object();
	// Draw a line along the bottom
	$y = $h - 46;
  	$pdf->line(57, $y, $w-58, $y,array(0.4,0.4,0.4), 1);
	
    // page numbering
    $lang_page = $GLOBALS['PAGE'];
    $lang_of = $GLOBALS['OF'];
	$pdf->page_text($w-104, $h-38, "$lang_page {PAGE_NUM} $lang_of {PAGE_COUNT}", $font, 8, array(0.4,0.4,0.4));
	
    // powered by
    $pdf->image(CO_FILES . "/img/print/poweredbyco.png", "png", 57, $h-38, 135, 9);
    
    // section image
    $section = $GLOBALS['SECTION'];
    $pdf->image(CO_FILES . "/img/print/".$section, "png", $w-48, $h-346, 34, 300);
	
    $pdf->close_object();
	$pdf->add_object($footer, "all");
    }
    
}