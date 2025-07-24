<?php
$db->debug=0;
require('fpdf.php');

class PDF_MySQL_Table extends FPDF
{
var $ProcessingTable=false;
var $aCols=array();
var $TableX;
var $HeaderColor;
var $RowColors;
var $ColorIndex;
/*
function Header()
{
	//Print the table header if necessary
	if($this->ProcessingTable)
		$this->TableHeader();
}*/

function forHeader($query_header)
{ global $db;
	$qr_header= pg_query($query_header) ;
	while($row_header=pg_fetch_array($qr_header))
	$this->HeaderCard(strtoupper($row_header[dapemda_nama]), strtoupper($row_header[dapemda_nm_dati2]), $row_header[dapemda_logo_path]);
	$this->Ln();
}

function TableHeader()
{
	$this->SetFont('Arial','B',12);
	$this->SetX($this->TableX);
	$fill=!empty($this->HeaderColor);
	if($fill)
		$this->SetFillColor($this->HeaderColor[0],$this->HeaderColor[1],$this->HeaderColor[2]);
	foreach($this->aCols as $col)
		$this->Cell($col['w'],6,$col['c'],1,0,'C',$fill);
	$this->Ln();
}
/*
function Row($data)
{
	$this->SetX($this->TableX);
	$ci=$this->ColorIndex;
	$fill=!empty($this->RowColors[$ci]);
	if($fill)
		$this->SetFillColor($this->RowColors[$ci][0],$this->RowColors[$ci][1],$this->RowColors[$ci][2]);
	foreach($this->aCols as $col)
		$this->Cell($col['w'],5,$data[$col['f']],1,0,$col['a'],$fill);
	*/
	#$this->Cell($col['w'],5,$data[$col['f']],1,0,$col['a'],$fill);
	/*$this->Cell(0,1,'Nama 		:'.$data[wp_wr_nama_milik].'',0,0,'L');
	$this->Cell(0,5,'Alamat 	 :'.$data[wp_wr_almt].'',0,0,'L');
	$this->Cell(0,5,'NPWPD 		:'.$data[wp_wr_jenis].'',0,0,'L');
	$this->Ln();
	#$this->ColorIndex=1-$ci;
	$this->Body($data[wp_wr_nama_milik], $data[wp_wr_almt], strtoupper($data[wp_wr_jenis]), $data[wp_wr_gol], $data[wp_wr_no_urut], $data[wp_wr_kd_camat], $data[wp_wr_kd_lurah]);
}*/

function CalcWidths($width,$align)
{
	//Compute the widths of the columns
	$TableWidth=0;
	foreach($this->aCols as $i=>$col)
	{
		$w=$col['w'];
		if($w==-1)
			$w=$width/count($this->aCols);
		elseif(substr($w,-1)=='%')
			$w=$w/100*$width;
		$this->aCols[$i]['w']=$w;
		$TableWidth+=$w;
	}
	//Compute the abscissa of the table
	if($align=='C')
		$this->TableX=max(($this->w-$TableWidth)/2,0);
	elseif($align=='R')
		$this->TableX=max($this->w-$this->rMargin-$TableWidth,0);
	else
		$this->TableX=$this->lMargin;
}

function AddCol($field=-1,$width=-1,$caption='',$align='L')
{
	//Add a column to the table
	if($field==-1)
		$field=count($this->aCols);
	$this->aCols[]=array('f'=>$field,'c'=>$caption,'w'=>$width,'a'=>$align);
}

function Table($query,$prop=array())
{ global $db;
	//Issue query 
	#$res = &$db->GetAll($query) or die('Error: '.mysql_error()."<BR>Query: $query");
	$res =  &$db->GetRow($query); #or die('Error: '.mysql_error()."<BR>Query: $query");
	//Add all columns if none was specified
	if(count($this->aCols)==0)
	{
		$nb=mysql_num_fields($res);
		for($i=0;$i<$nb;$i++)
			$this->AddCol();
	}
	//Retrieve column names when not specified
	foreach($this->aCols as $i=>$col)
	{
		if($col['c']=='')
		{
			if(is_string($col['f']))
				$this->aCols[$i]['c']=ucfirst($col['f']);
			else
				$this->aCols[$i]['c']=ucfirst(mysql_field_name($res,$col['f']));
		}
	}
	//Handle properties
	if(!isset($prop['width']))
		$prop['width']=0;
	if($prop['width']==0)
		$prop['width']=$this->w-$this->lMargin-$this->rMargin;
	if(!isset($prop['align']))
		$prop['align']='C';
	if(!isset($prop['padding']))
		$prop['padding']=$this->cMargin;
	$cMargin=$this->cMargin;
	$this->cMargin=$prop['padding'];
	if(!isset($prop['HeaderColor']))
		$prop['HeaderColor']=array();
	$this->HeaderColor=$prop['HeaderColor'];
	if(!isset($prop['color1']))
		$prop['color1']=array();
	if(!isset($prop['color2']))
		$prop['color2']=array();
	$this->RowColors=array($prop['color1'],$prop['color2']);
	//Compute column widths
	$this->CalcWidths($prop['width'],$prop['align']);
	//Print header
	$this->TableHeader();
	//Print rows
	$this->SetFont('Arial','',11);
	$this->ColorIndex=0;
	$this->ProcessingTable=true;
	while($row=mysql_fetch_array($res))
		$this->Row($row);
	$this->ProcessingTable=false;
	$this->cMargin=$cMargin;
	$this->aCols=array();
}

function forBody($query_body)
{ global $db;
        //die("___ujyvuvtuy____");
	//Issue query
	$qr_body= pg_query($query_body) ;#or die('Error: '.mysql_error()."<BR>Query: $query");
	//Add all columns if none was specified
	#die ($query);

	while($row_body=pg_fetch_array($qr_body))
		$this->Body($row_body[wp_wr_nama_milik], $row_body[wp_wr_almt],$row_body[npwprd], $row_body[wp_wr_no_kartu]);

// 	KONEKSI DG adoDB
	/*while($res= &$db->GetRow($query))
		$this->Row($res);*/
/*
	while($row=mysql_fetch_array($res))
		$this->Row($row);

{
	echo $this->Row($row[code]);
}*/

}

function forFooter($query_footer, $query_footer2)
{ global $db;
	$qr_footer= pg_query($query_footer) ;
	while($row_footer=pg_fetch_array($qr_footer))
	{
	#$this->TTD($row_footer[pejda_nip], $row_footer[pejda_nama]);
	$qr_footer2= pg_query($query_footer2) ;
	while($row_footer2=pg_fetch_array($qr_footer2))
	$this->TTD($row_footer[pejda_nip], $row_footer[pejda_nama], strtoupper($row_footer[ref_japeda_nama]), $row_footer[ref_pangpej_ket],  strtoupper($row_footer2[dapemda_pejabat]), strtoupper($row_footer2[dapemda_nm_dati2]));
	}
}

function forBehind($query_behind, $query_behind2)
{ global $db;
	$qr_behind= pg_query($query_behind) ;
	while($row_behind=pg_fetch_array($qr_behind))
	#while($row_behind=&$db->GetRow($query_behind))
	{
	#$this->TTD($row_footer[pejda_nip], $row_footer[pejda_nama]);
	$qr_behind2= pg_query($query_behind2) ;
	while($row_behind2=pg_fetch_array($qr_behind2))
	#while($row_behind2=&$db->GetRow($query_behind2))
	$this->behind($row_behind[skpd_nama], $row_behind2[dapemda_nama], $row_behind2[dapemda_nm_dati2]);
	}
}
}
?>
