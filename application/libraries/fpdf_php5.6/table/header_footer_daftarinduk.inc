<?php

/**
 * Class extention for Header and Footer Definitions
 *
 */
class pdf_usage extends fpdf_table
{
	
	public function Header()
	{
		$this->SetY(10);
	    $this->SetFont('Arial','B',14);
	    $this->SetTextColor(0,0,0);
	    $this->MultiCell(0, 4, "", 0, 'C');
	}	
	
	public function Footer()
	{
	    $this->SetY(-15);
	    $this->SetFont('Arial','I',10);
	    $this->SetTextColor(0,0,0);
	    $this->MultiCell(0, 4, "Halaman {$this->PageNo()} / {nb}", 0, 'C');
	}
} 

?>