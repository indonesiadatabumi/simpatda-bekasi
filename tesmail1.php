<?php
$nama = "Wenx";
$to = "uen_jh@yahoo.com";
$subject = "Tes krm mail";
$messages = "Tes kirim mail aja";
    
$headers .= 'From: <sipdah.bekasikota.go.id@gmail.com>' . "tess"; //bagian ini diganti sesuai dengan email dari pengirim
mail($to, $subject, $messages, $headers);
if(mail) 
{
    echo "pengiriman berhasil";
}
else 
{
    echo "pengiriman gagal";
}
?>