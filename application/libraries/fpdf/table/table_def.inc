<?php

/*****************************************************
TABLE DEFAULT DEFINES
*****************************************************/

	$table_default_header_type = array(
			'WIDTH' => 6,				    	//cell width
			'T_COLOR' => array(220,230,240),	//text color
			'T_SIZE' => 8,						//font size
			'T_FONT' => 'Arial',				//font family
			'T_ALIGN' => 'C',					//horizontal alignment, possible values: LRC (left, right, center)
			'V_ALIGN' => 'M',					//vertical alignment, possible values: TMB(top, middle, bottom)
			'T_TYPE' => 'B',					//font type
			'LN_SIZE' => 4,						//line size for one row
			'BG_COLOR' => array(41, 80, 132),	//background color
			'BRD_COLOR' => array(0,92,177),		//border color
			'BRD_SIZE' => 0.2,					//border size
			'BRD_TYPE' => '1',					//border type, can be: 0, 1 or a combination of: "LRTB"
			'TEXT' => '',						//text
					);
					
	$table_default_data_type = array(
			'T_COLOR' => array(0,0,0),			//text color
			'T_SIZE' => 6,						//font size
			'T_FONT' => 'Arial',				//font family
			'T_ALIGN' => 'C',					//horizontal alignment, possible values: LRC (left, right, center)
			'V_ALIGN' => 'M',					//vertical alignment, possible values: TMB(top, middle, bottom)
			'T_TYPE' => '',						//font type
			'LN_SIZE' => 4,						//line size for one row
			'BG_COLOR' => array(255,255,255),	//background color
			'BRD_COLOR' => array(0,92,177),		//border color
			'BRD_SIZE' => 0.1,					//border size
			'BRD_TYPE' => '1',					//border type, can be: 0, 1 or a combination of: "LRTB"
					);
					
	$table_default_table_type = array(
			'TB_ALIGN' => 'L',					//table align on page
			'L_MARGIN' => 5,					//space to the left margin
			'BRD_COLOR' => array(0,92,177),		//border color
			'BRD_SIZE' => '0.3',				//border size
					);
	
	//customize
	$table_default_tbl_type = array(
		'TB_ALIGN' => 'L',
		'L_MARGIN' => 0,
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0,
	);
	
	$table_default_headerx_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 10,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'C',
		'V_ALIGN' => 'M',
		'LN_SIZE' => 4,
		'BG_COLOR' => array(255,255,255),
		'BRD_SIZE' => 0.2,
	);
	
	$table_default_datax_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 11,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'L',
		'V_ALIGN' => 'M',
		'LN_SIZE' => 5,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_default_tblheader_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 10,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'C',
		'V_ALIGN' => 'M',
		'LN_SIZE' => 6,
		'BRD_SIZE' => 0.2,
		'BG_COLOR' => array(255,255,255),
	);
	
	$table_default_tblheader2_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 8,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'C',
		'V_ALIGN' => 'M',
		'LN_SIZE' => 5,
		'BRD_SIZE' => 0.2,
		'BG_COLOR' => array(255,255,255),
	);
	
	$table_default_tbldata_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 10,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'L',
		'V_ALIGN' => 'T',
		'LN_SIZE' => 5,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_default_tbldata_type_ln_6 = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 7.5,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'L',
		'V_ALIGN' => 'T',
		'LN_SIZE' => 5.5,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_default_tbldata2_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 10,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'L',
		'V_ALIGN' => 'T',
		'LN_SIZE' => 6,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_default_ttd_type = array(
		'T_COLOR' => array(0,0,0),
		'T_ALIGN' => 'C',
		'T_SIZE' => 9,
		'V_ALIGN' => 'M',
		'LN_SIZE' => 5,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_default_kartu_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 8,                     //font size
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'L',
		'V_ALIGN' => 'T',
		'LN_SIZE' => 4,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.3,
	);
	
	$table_sptpd_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 9,                     //font size
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'L',
		'V_ALIGN' => 'T',
		'LN_SIZE' => 3,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.3,
	);
	
	$table_kartu_npwp_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 8,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'L',
		'V_ALIGN' => 'M',
		'T_TYPE' => 'B',
		'LN_SIZE' => 3,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_data_ketetapan_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 9,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'L',
		'V_ALIGN' => 'M',
		'LN_SIZE' => 4,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_data_ketetapan_ttd_type = array(
		'T_COLOR' => array(0,0,0),
		'T_ALIGN' => 'C',
		'T_SIZE' => 9,
		'V_ALIGN' => 'M',
		'LN_SIZE' => 3.5,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_data_small = array(
		'T_COLOR' => array(0,0,0),
		'T_ALIGN' => 'L',
		'T_SIZE' => 6,
		'V_ALIGN' => 'M',
		'LN_SIZE' => 3.5,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_data_sts = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 10,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'L',
		'LN_SIZE' => 5,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_data_skpd = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 10,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'L',
		'V_ALIGN' => 'T',
		'LN_SIZE' => 6,
		'BG_COLOR' => array(255,255,255),
		'BRD_COLOR' => array(0,0,0),
		'BRD_SIZE' => 0.2,
	);
	
	$table_header = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 10,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'C',
		'V_ALIGN' => 'M',
		'LN_SIZE' => 5,
		'BG_COLOR' => array(255,255,255),
		'BRD_SIZE' => 0.2,
	);
/*****************************************************
TABLE DEFAULT DEFINES --- END
*****************************************************/
?>
