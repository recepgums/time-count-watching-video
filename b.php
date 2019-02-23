<?php
$ip_gelen=$_POST['ip'];
$ip_yaz=$ip_gelen."\r\n";
$dosya=fopen("depo.txt","a+");
$dizi=denetle()
function yazdir($dosya,$ip_yaz)
{
    fwrite($dosya, "$ip_yaz");
}
function denetle($dosya,$ip_gelen){
    $oku=fread("depo.txt",$dosya);

}
fclose($dosya);

?>