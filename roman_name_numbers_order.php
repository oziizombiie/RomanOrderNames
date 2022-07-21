<?php

/*
 * Complete the 'sortRoman' function below.
 *
 * The function is expected to return a STRING_ARRAY.
 * The function accepts STRING_ARRAY names as parameter.
 */

define("ROMANTABLE" , ['M' => 1000, 'CM'=> 900, 'D' =>500, 'CD'=> 400, 'C'=> 100, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V'=>5, 'IV' => 4, 'I' => 1]);

function onlyNumbers($name){
    if(!is_numeric($name)){
        return $name;    
    }
    return;
}

function sortRoman($names) {
    $names_filter = array_filter($names, 'onlyNumbers');
    $ordinary_name_number = [];
    $roman_names = [];
    for($i = 0; $i < sizeof($names_filter); $i++){
        $roman_number = explode(' ', $names_filter[$i]);
        $arabic_number = replaceRomanToArabic($roman_number[1]);
        $ordinary_name_number[] = $roman_number[0].' '.$arabic_number;
    }
    sort($ordinary_name_number, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
    for($j = 0; $j < sizeof($ordinary_name_number); $j++){
        $arabic_number = explode(' ', $ordinary_name_number[$j]);
        $roman_number = replaceArabicToRoman($arabic_number[1]);
        $roman_names[] = $arabic_number[0].' '.$roman_number;
    }
    return $roman_names;
}

function replaceArabicToRoman($arabic_number){
    $roman_equivalent = '';
    while($arabic_number > 0){
        foreach(ROMANTABLE as $roman_number => $value){
            if($arabic_number >= $value){
                $arabic_number -= $value;
                $roman_equivalent .= $roman_number;
                break;
            }
        }
    }
    return $roman_equivalent;
}
    
function replaceRomanToArabic($roman_number){
    $previous_value = 0;
    $idx = 0;
    // foreach(count_chars($roman_number, 1) as $i => $times_used){
    //     var_dump(chr($i));
    //     var_dump(($times_used));
    //     // var_dump($times_used);
    //     $previous_value = addOrSubs($idx, $roman_number, $times_used, ROMANTABLE[$roman_number[$idx]], $previous_value);
    //     $idx++;
    // }
    $iterator = str_split($roman_number);
    foreach($iterator as $letter){
            $previous_value = addOrSubs($idx, $roman_number, 1, ROMANTABLE[$roman_number[$idx]], $previous_value);
            $idx++;
        }
    return abs($previous_value);
}

function addOrSubs($idx, $roman_number, $times_used, $arabic_value, $previous_value){
    //si el numero romano a la derecha del primer numero es mayor se resta, si el numero no se repite más de una vez
    if(($idx+1) != strlen($roman_number) && ROMANTABLE[$roman_number[$idx]] < ROMANTABLE[$roman_number[$idx + 1]]){
        $previous_value -= $times_used * $arabic_value;
    }else{
        $previous_value += $times_used * $arabic_value;
    }
    return $previous_value;
}


$names =  array(
    'Bill IV',
    'Anthony LXVII',
'Bill L',
'Bill IX',
'Anthony V',
'Anthony LXI',
'Bill V',
'Yazbek MCMXXVII',
'Yazbek II',
'Bill XXI',
'Bill XIX',
'Anthony X',
'Bill X',
'Anthony II',
);

$result = sortRoman($names);
var_dump($result);