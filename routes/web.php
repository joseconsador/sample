<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
/*    echo domino("1-1"); // 1
echo  domino("1-2,1-2"); // 1
echo domino("3-2,2-1,1-4,4-4,5-4,4-2,2-1");// 4
echo domino("5-5,5-5,4-4,5-5,5-5,5-5,5-5,5-5,5-5,5-5"); // 7
echo domino("1-1,3-5,5-5,5-4,4-2,1-3"); // 4
echo domino("1-2,2-2,3-3,3-4,4-5,1-1,1-2") ;// 3*/
/*
    $cases = [
        ["I>N","A>I","P>A","S>P"],
        ["P>E","E>R","R>U"],
        ["U>N", "G>A", "R>Y", "H>U", "N>G", "A>R"],
        ["I>F", "W>I", "S>W", "F>T"],
        ["R>T", "A>L", "P>O", "O>R", "G>A", "T>U", "U>G"],
        ["W>I", "R>L", "T>Z", "Z>E", "S>W", "E>R", "L>A", "A>N", "N>D", "I>T"]
    ];

    foreach ($cases as $case) {
        echo findWord($case) . "\n";
    }*/
echo count_change(4, array(1,2));
});
function count_change ($money,$coins) {
    return can_change($money, $coins, 0);
}

function can_change($money, $coins, $increment = 0) {
    if ($money < 0) {
        return 0;
    }

    if ($money == 0) {
        return 1;
    }

    if (count($coins) == $increment && $money > 0) {
        return 0;
    }
    var_dump($money);
    return can_change($money - $coins[$increment], $coins, $increment) + can_change($money, $coins, $increment + 1);
}
function findWord($s) {
    $splits = array_map(function($v) {
        return explode(">", $v);
    }, $s);

    usort($splits, function($x, $y) {
        return ($x[1] != $y[0]);
    });

    usort($splits, function($x, $y) {
        return ($x[1] != $y[0]);
    });

    usort($splits, function($x, $y) {
        return ($x[1] != $y[0]);
    });

    usort($splits, function($x, $y) {
        return ($x[1] != $y[0]);
    });

    $word = "";

    foreach ($splits as $split) {
        $word .= $split[0];
    }

    $word .= $split[1];

    return $word;
}


function domino($s) {
    // split by comma
    $commas = explode(",", $s);

    // split by -
    $tiles = [];
    foreach ($commas as $tile) {
        $tiles[] = explode("-", $tile);
        // can do it here ....
    }

    $total = 0;
    $groups = [];
    $inGroup = false;
    $groupIndex = 0;
    foreach ($tiles as $key => $x) {
        if (!$inGroup) {
            $total = 0;
            $groupIndex++;
        } else {
            $groups[$groupIndex] = $total;
        }
        // $x
        if ($key+1 >= count($tiles))
            break;

        $inGroup = false;
        if ($x[1] == $tiles[$key+1][0]) {
            $inGroup = true;
            $total++;
        }
    }

    sort($groups);

    return end($groups)+1;
}
