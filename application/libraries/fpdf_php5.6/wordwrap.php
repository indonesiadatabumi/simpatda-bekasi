<?php
define('FPDF_FONTPATH','font/');
require('fpdf.php');

class PDF extends FPDF
{
function WordWrap(&$text, $maxwidth)
{
	$text = trim($text);
	if ($text==='')
		return 0;
	$space = $this->GetStringWidth(' ');
	$lines = explode("\n", $text);
	$text = '';
	$count = 0;

	foreach ($lines as $line)
	{
		$words = preg_split('/ +/', $line);
		$width = 0;

		foreach ($words as $word)
		{
			$wordwidth = $this->GetStringWidth($word);
			if ($wordwidth > $maxwidth)
			{
				// Word is too long, we cut it
				for($i=0; $i<strlen($word); $i++)
				{
					$wordwidth = $this->GetStringWidth(substr($word, $i, 1));
					if($width + $wordwidth <= $maxwidth)
					{
						$width += $wordwidth;
						$text .= substr($word, $i, 1);
					}
					else
					{
						$width = $wordwidth;
						$text = rtrim($text)."\n".substr($word, $i, 1);
						$count++;
					}
				}
			}
			elseif($width + $wordwidth <= $maxwidth)
			{
				$width += $wordwidth + $space;
				$text .= $word.' ';
			}
			else
			{
				$width = $wordwidth + $space;
				$text = rtrim($text)."\n".$word.' ';
				$count++;
			}
		}
		$text = rtrim($text)."\n";
		$count++;
	}
	$text = rtrim($text);
	return $count;
}
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$text=str_repeat('this is a word wrap test ',20);
$nb=$pdf->WordWrap($text,11);
$pdf->Write(5,"This paragraph has $nb lines:\n\n");
$pdf->Write(5,$text);
$pdf->Output();
?>
