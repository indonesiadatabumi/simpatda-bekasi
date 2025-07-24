
				<div id="toolbar-box">
   			<div class="t"><div class="t"><div class="t"></div>
				</div>
			</div>
			<div class="m">
				<div class="toolbar" id="toolbar">
<table class="toolbar"><tr>
<td class="button" id="toolbar-new">
<a href="#" onclick="javascript:hideMainMenu();  submitbutton('new')" class="toolbar">
<span class="icon-32-new" title="New">
</span>
Baru
</a>
</td>

<td class="button" id="toolbar-edit">
<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Tentukan Pilihan Anda terlebih dahulu');}else{  submitbutton('edit')}" class="toolbar">
<span class="icon-32-edit" title="Edit">
</span>
Edit
</a>
</td>

<td class="button" id="toolbar-delete">
<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Tentukan Pilihan Anda Terlebih Dahulu');}else{  konfirm('delete')}" class="toolbar">
<span class="icon-32-delete" title="Hapus">
</span>
Hapus
</a>
</td>

</tr></table>
</div>
<?
/*
$lnk_root = "<a href=\"".$myself.$XFA['dsp_mstr_reklame_nilai_strategis']."\">Nilai strategis</a>";
$pic_vl = " <img src=\"images/arrow.png\" alt=\"lnkpic\"  align=\"absmiddle\" /> ";

                                $fid = "ref_nsr_id";    $fhead="";  $fdet = "ref_nsr_dt_id_header";
                                $f1  = "ref_nsr_nama";            $theadcol1 = "Nama";
                                $f2  = "ref_nsr_bobot_persen";    $theadcol2 = "Bobot (%)";
                                $f3  = "ref_nsr_ket";             $theadcol3 = "Keterangan";
                                $filterchoice = array("Nama","Bobot","Keterangan");
                                $fieldonchoice = array($f1,$f2,$f3);   $fldsort = array($f2,"desc");
                                $lnk_pintas = 'Nilai strategis';
                                $havedetail = 'yes';

*/
?>
                          
<?//=$lnk_now;// print(selfURL()); ?>  
<div class="header icon-48-master">
        Referensi Reklame   </br>
        <small> <small><img src="images/bg.jpg" alt="picmastr" align="absmiddle" />  <?//= $lnk_pintas ?> </small></small>
</div>
<div class="clr">  </div>   
			</div> 
			<div class="b"><div class="b"> <div class="b"></div></div></div>
  		</div>
   		<div class="clr"></div>      <?//= "lnk_now__>".$lnk_now ?>
		<div id="element-box">
			<div class="t"><div class="t"><div class="t"></div></div></div>
			<div class="m">
<form name="adminForm" action="<?php //echo $myself.$XFA['act_mstr_reklame_nilai_strategis']; ?>" method="post">
<table id="flex1" style="display:none"></table>

        <!--
          ref_nilai_strategis_reklame       ===>   ref_nsr_id | ref_nsr_nama | ref_nsr_bobot_persen | ref_nsr_ket
          ref_nilai_strategis_reklame_detail ===>  ref_nsr_dt_id | ref_nsr_dt_id_header | ref_nsr_dt_nama | ref_nsr_dt_skor | ref_nsr_dt_ket
          ref_aturan_jalur_jalan            ===>   ref_ajj_id | ref_ajj_id_jalur | ref_ajj_nama_jalan | ref_ajj_ket

        -->
<span id="saveBar"></span>
        <input type="hidden" name="nd" value="0" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="subtl"   value="<?//=$jdul2?>" />
                <input type="hidden" name="vl"      value="<?//=$vl?>" />
                <input type="hidden" name="fid"     value="<?//=$fid?>" />
                <input type="hidden" name="fhead"   value="<?//=$fhead?>" />
                <input type="hidden" name="idhead"  value="<?//=$idhead?>" />
                <input type="hidden" name="fdet"    value="<?//=$fdet?>" />
                <input type="hidden" name="lnk_now" size=200 value="<?//=$lnk_now?>"/> </br>
                <input type="hidden" name="lnk_prev"  size=200 value="<?//=$lnk_prev?>"/>

        </form>

				<div class="clr"></div>
			</div>
			<div class="b"> <div class="b"> <div class="b"> </div> </div> </div>
   		</div>
		<noscript>
			Warning! JavaScript must be enabled for proper operation of the Administrator Back-end		</noscript>
		<div class="clr"></div>
	</div>
