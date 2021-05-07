<?php

$trackNumArr = array(1,2,3);
$tagArr = array("가", "나", "다");
$tagData = array("가가가1", "나나나2", "다다다3");

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
        echo "TrackNum: <input type='text' name='track[][][]' value='{$trackNumArr[$i]}'>";
        echo "Tag: <input type='text' name='track[][][]' value='{$tagArr[$i]}'>";
        echo "TagData: <input type='text' name='track[][][]' value='{$tagData[$i]}'>";
        echo "<br>";
    }
    ?>

    <button>작성</button>
</form>
