<?php

function lang($phrase){
static $lang = array (
'HOME_ADMIN' => "HOME",
'profile' => "EDIT PROFILE",
'sittings' => "SITTINGS",
'log_out' => "LOG OUT" ,
'CATAGOREIS' => 'CATAGOREIS',
'members' => 'MEMBERS',
'ITEMS' => 'ITEMS'

);
return $lang[$phrase];

}

// $lang = array ( 
//     'osama' => "zero"
// );
//echo $lang['osama'];