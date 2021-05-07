<?php
$arr = array( // 2차원 배열을 2개 갖는 3차원 배열 선언과 동시에 초기화
    array(
        array("apple", "korea", 1000),
        array("banana", "philippines", 2000),
        array("orange", "us", 1500)
    ),
    array(
        array("carrot", "vietnam", 500),
        array("cucumber", "korea", 1000),
        array("pumpkin", "china", 2000)
    )
);

echo "<pre>";
var_dump($arr);
