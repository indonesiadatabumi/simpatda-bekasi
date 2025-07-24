<div id="toolbar-box">
   		<div class="t"> <div class="t"> <div class="t"> </div>	</div> </div>
                <div class="m">
                    <div class="toolbar" id="toolbar">
                    </div>
                    <div class="header icon-48-user"> Cetak Laporan Pendapatan Daerah</div>
                    <div class="clr"></div>
                </div>
		<div class="b"> <div class="b"> <div class="b"> </div> </div> </div>
            </div>
            <div class="clr"></div>
            <div id="element-box">
                <div class="t"> <div class="t"> <div class="t"> </div> </div> </div>
                <div class="m"  >
                    <table class="admintable" border=0 cellspacing="3">
                        <tr>
                            <td class="key" width="150">  Tanggal Proses  </td>
                            <td>
                                <input type="text" name="tgl_proses" id="tgl_proses" size="11"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" width="150">  Tanggal Cetak  </td>
                            <td>
                                <input type="text" name="tgl_cetak" id="tgl_cetak" size="11"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">   Mengetahui    </td>
                            <td>
								<?php
									$attributes = 'id="mengetahui"';
									echo form_dropdown('mengetahui', $pejabat_daerah, '', $attributes);
								?>
                                <input type="button" name="btn_cetak" id="btn_cetak" value="Cetak" class="button"/> </td>
                            </td>
                        </tr>
                    </table>
		<div class="clr"></div>
		</div>
		<div class="b"><div class="b"><div class="b"></div>
		</div>
		</div>
   		</div>
		<div class="clr"></div>
	</div>

<script type="text/javascript" src="modules/pembukuan/scripts/form_pendapatan_daerah.js"></script>