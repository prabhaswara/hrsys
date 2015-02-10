<?php

function cleanstr($str) {
    return ($str == null) ? "" : trim($str);
}
function cleanNumber($str) {
    return ($str == null ||$str=="") ? "0" : trim($str);
}

function isDate($date){//dd/MM/yyyy with leap years 100% integrated Valid years : from 1600 to 9999 
    $date=  str_replace("-", "/", $date);
  return 1 === preg_match(
    '~^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$~',
    $date); 
}

function isDateDB($date){
    return 1 ===( preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date) ) ;  
    
}
function balikTgl($tgl){
    return implode("-", array_reverse(explode("-", $tgl)) );
}
function cleanDate($tgl){
    return in_array($tgl, array("00-00-0000","0000-00-00"))?"":$tgl;
}
function balikTglDate($tgl,$jam=false,$detik=false){
    $pecah=  explode(" ",$tgl);
    
    $waktu="";
    if($jam){
        $waktu=  substr($pecah[1], 0,5);
        if($detik){
            $waktu.=substr($pecah[1], 5,3);
        }
    }
    
    return implode("-", array_reverse(explode("-", $pecah[0])) ).($jam?" ".$waktu:"");
}

function replaceNewLineBr($string)
{
    return str_replace("\n","<br />",$string); 
}
?>