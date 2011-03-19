if ( isset($pdf) ) {
	$font = Font_Metrics::get_font("arial", "bold");

	$header = $pdf->open_object();
	$w = $pdf->get_width();
	$h = $pdf->get_height();

	$img_w = 2 * 72; // 2 inches, in points
	$img_h = 28; // 1 inch, in points -- change these as required

	$pdf->page_text(72, 10, "communautic Ebenbichler KG", $font, 7, array(0.4,0.4,0.4));
	$pdf->page_text(72, 20, "Mühlenweg 9, A - 6068 Mils", $font, 7, array(0.4,0.4,0.4));
	$pdf->page_text(72, 40, "Fon +43 (676) 5700-506", $font, 7, array(0.4,0.4,0.4));
	$pdf->page_text(72, 50, "Fax +43 (676) 5700-505", $font, 7, array(0.4,0.4,0.4));
	$pdf->page_text(72, 70, "office@communautic.com", $font, 7, array(0.4,0.4,0.4));
	$pdf->page_text(72, 80, "www.communautic.com", $font, 7, array(0.4,0.4,0.4));

	$pdf->image(CO_PATH_BASE . "/data/logo_print.jpg", "jpg", $w-60-$img_w, 10, $img_w, $img_h);
    
	// Close the object (stop capture)
	$pdf->close_object();
	$pdf->add_object($header, "all");

	$footer = $pdf->open_object();
	// Draw a line along the bottom
	$y = $h - 40;
  	$pdf->line(72, $y, $w-72, $y,array(0.4,0.4,0.4), 1);

	$pdf->page_text($w-90, $h-30, "{PAGE_NUM} / {PAGE_COUNT}", $font, 8, array(0.4,0.4,0.4));
	$pdf->image(CO_FILES . "/img/print/co.png", "png", 72, $h-30, 91, 8);
	$pdf->close_object();
	$pdf->add_object($footer, "all");
}