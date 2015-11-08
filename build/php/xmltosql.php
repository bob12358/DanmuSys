<meta charset="UTF-8"/>
<?php
/**
 * Created by PhpStorm.
 * User: Chao
 * Date: 2015/11/8
 * Time: 17:45
 */

include_once "lib.php";

$danmuArray = readDanmuXML("../comment-science_nop.xml");

//print_r($danmuArray);

$db = DB::getInstance();

$sql = "insert into danmu(second , mode , size , color ,timestamp,pool, userid ,msg) values(";

for ($i = 0; $i < count($danmuArray); $i++) {
    $danmu = $danmuArray[$i];
    for ($j = 0; $j < count($danmu); $j++) {
        if(count($danmu)-$j <=2) {
            $danmu[$j] = "'".$danmu[$j]."'";
        }


        if(($j+1)<count($danmu))
            $sql .= $danmu[$j].",";
        else
            $sql .=$danmu[$j];
    }
    if(($i+1) <count($danmuArray)) {
        $sql .= '),(';
    } else {
        $sql .=')';
    }

}
echo $sql;
$db->sqlExecute($sql);