<?php


function scaleTest($unscaledNum, $minAllowed, $maxAllowed, $min, $max) {
  return ($maxAllowed - $minAllowed) * ($unscaledNum - $min) / ($max - $min) + $minAllowed;
}
$num = $_GET['d'];
$br = 0;
echo floor($num/30).'<hr/>';
$list = array();
for($i=0;$i<30;$i=$i++) {
		echo $i.'. -- '.scaleTest($i,0,$num,0,$num).'<br/>';
		$br++;
}

