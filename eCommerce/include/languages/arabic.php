<?php

function lang($phrase){
static $lang = array (
    'HOME_ADMIN' => "الرئيسية",
    'profile' => "تعديل الملف الشخصي",
    'sittings' => "الاعدادات",
    'log_out' => "تسجيل الخروج" ,
    'CATAGOREIS' => 'الفئات'
    
);
return $lang[$phrase];

}

// $lang = array ( 
//     'osama' => "zero"
// );
//echo $lang['osama'];