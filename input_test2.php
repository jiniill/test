<?php

$array = array(
    array(
        array(1, "가", "가가가1"),
        array(2, "나", "나나나2"),
        array(3, "다", "다다다3")
    ),
    array(
        array(4, "라", "라라라4"),
        array(5, "마", "마마마5"),
        array(6, "바", "바바바6")
    ),
);

?>

<style>
    input{display: block;}
    form{width: 50%;float: left;}
</style>

<form action="input_confirm.php" method="post">
    Form1<br>
    <?php
    for($i = 0; $i < count($array); $i++){
        for($j = 0; $j < count($array[$i]); $j++){
            for($k = 0; $k < count($array[$i][$j]); $k++){
                echo "<input type='text' name='track[$i][$j][$k]' value='{$array[$i][$j][$k]}'>";
            }
        }
        echo "<br>";
    }
    ?>

    <button>작성</button>
</form>
