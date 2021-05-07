<?php

$trackNumArr = array(1,2,3);
$tagArr = array("가", "나", "다", "라", "마", "바", "사", "아", "자");
$tagData = array("가가가1", "가가가2", "가가가3", "나나나", "나나나", "나나나", "다다다", "다다다", "다다다", "라라라", "라라라", "라라라", "마마마", "마마마", "마마마", "바바바", "바바바", "바바바", "사사사", "사사사", "사사사", "아아아", "아아아", "아아아", "자자자", "자자자", "자자자");

$trackCount = count($trackNumArr);
$tagCount = count($tagArr);

?>

<style>
    input{display: block;}
    form{width: 50%;float: left;}
</style>

<form action="input_confirm.php" method="post">
    Form1<br>
    <?php
        for($i = 0; $i < $trackCount; $i++){
            echo "TrackNum: <input type='text' name='track[{$i}][]' value='{$trackNumArr[$i]}'>";
            $jCnt = 1;
            for($j = $i*$trackCount; $j < $i*$trackCount+$trackCount; $j++){
                echo "Tag: <input type='text' name='track[{$i}][{$jCnt}][]' value='{$tagArr[$j]}'>";
                $kCnt = 1;
                for($k = $j*$trackCount; $k < $j*$trackCount+$trackCount; $k++){
                    echo "TagData: <input type='text' name='track[{$i}][{$jCnt}][1][{$kCnt}]' value='{$tagData[$k]}'>";
                    $kCnt++;
                }
                $jCnt++;
                echo "<br>";
            }
            echo "<br>";
        }
    ?>

    <button>작성</button>
</form>
