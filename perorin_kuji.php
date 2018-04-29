<?php

define('ATARI_NUM', 3);
define('USER_LIST_PATH', './list.csv');
define('TEST_NUM', 10000);

$user = [];
$kuji = [];

$file = new SplFileObject(USER_LIST_PATH);
$file->setFlags(SplFileObject::READ_CSV);

foreach($file as $key => $line) {
    if($key == 0 || is_null($line[0])) {
        
    } else {
        $name = $line[0];
        $weight = intval($line[1]);
        
        $user[] = [
            "name" => $name,
            "weight" => $weight,
        ];
        
        for($i = 0; $i < $weight; $i++) {
            $kuji[] = $key - 1;
            
        }
        
    }
    
}

//test($kuji, $user);

decide_member($kuji, $user);


function test($kuji, $user) {
    $sum_atari = [];
    $user_num = count($user);
    $sum_weight = 0;
    
    for($i = 0; $i < $user_num; $i++) {
        $sum_atari[] = 0;
        $sum_weight += $user[$i]['weight'];
        
    }
    
    for($i = 0; $i < TEST_NUM; $i++) {
        $atari = pick_kuji($kuji);
        
        for($j = 0; $j < ATARI_NUM; $j++) {
            $sum_atari[$atari[$j]]++;
            
        }
        
    }
    
    
    for($i = 0; $i < $user_num; $i++) {
        echo ($i + 1) . ':' . $user[$i]['name'] . "\n";
        echo '理論値:' . ($user[$i]['weight'] / $sum_weight). "\n";
        echo '計算値:' . ($sum_atari[$i] / (TEST_NUM * ATARI_NUM)) . "\n";
        echo "\n";
        
    }
    
}

function decide_member($kuji, $user) {
    $atari = pick_kuji($kuji);
    
    echo "\n";
    
    for($i = 0; $i < ATARI_NUM; $i++) {
        echo ($i + 1) . '人目の同行者を発表します...[push enter!]';
        $stdin = trim(fgets(STDIN));
        echo "\n";
        echo $user[$atari[$i]]['name'] . 'です！   [push enter!]';
        $stdin = trim(fgets(STDIN));
        echo "\n";
        echo "\n";
        
    }
    
    echo 'おめでとうございます！よろしくお願いします！' . "\n" . "\n";
    
}

function pick_kuji($kuji) {
    $atari = [];
    
    for($i = 0; $i < ATARI_NUM; $i++) {
        shuffle($kuji);
        $tmp = $kuji[0];
        $atari[] = $tmp;
        $kuji = array_diff($kuji, [$tmp]);
        $kuji = array_values($kuji);
        
    }
    
    return $atari;
    
}
