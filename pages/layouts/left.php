<?php
$result = $db->query("SELECT `id`,`url`,`title{$langPrefix}`  FROM `cat_category` where `parent_id`= 0 AND `showHome`=1");
while ($row = $result->fetch_array()) {
	$titleCat = $row["title$langPrefix"];
//	$titleCat = $row["titleRu"];
	if ($cat == $row[id]) {
		$retCat .= "<a href='$urlGo/catalog/$row[url]/' class='-head -act'>$titleCat</a>";
		$retCat .= "<div class='-sub -act'>";
	} else {
		$retCat .= "<a href='$urlGo/catalog/$row[url]/' class='-head'>$titleCat</a>";
		$retCat .= "<div class='-sub'>";
	}
	$result2 = $db->query("SELECT `kvo`,`id`,`url`,`title{$langPrefix}` FROM `cat_category` where `parent_id`= {$row[id]} AND `kvo`>0");
	while ($row2 = $result2->fetch_array()) {
		$titleCat = $row2["title$langPrefix"];
		if ($cat2 == $row2[id] && $cat2)
			$retCat .= "<a href='$urlGo/catalog/$row[url]/$row2[url]/' class='-act'>$titleCat <span>$row2[kvo]</span></a>";
		else
			$retCat .= "<a href='$urlGo/catalog/$row[url]/$row2[url]/' class=''>$titleCat<span>$row2[kvo]</span></a>";
	}
	$retCat .= "</div>";
}
unset($titleCat, $row);




if ($go == '/instock') $linkInStock = "<a href='$urlGo/instock' class='-link -act'>".TranslateMe('В наявності')."</a>"; else  $linkInStock = "<a href='$urlGo/instock' class='-link' >".TranslateMe('В наявності')."</a>";


if ($go == '/achive') $linkArchive = "<a href='$urlGo/achive' class='-link -act'>".TranslateMe('Архівні роботи')."</a>"; else  $linkArchive = "<a href='$urlGo/achive' class='-link' >".TranslateMe('Архівні роботи')."</a>";

if ($go == '/kydex_sheaths') $linkKydex = "<a href='$urlGo/kydex_sheaths' class='-link -act'>Kydex</a>"; else  $linkKydex = "<a href='$urlGo/kydex_sheaths' class='-link' >Kydex</a>";


echo <<<EOF
<div>
<a href="#" class="o-close"></a>
	<a href="$urlGo" class="o-logo"><img src="$url/img/logo.png" alt=""></a>
	<nav>

<a href="$urlGo/blog"  class="-link hiddenMd">Live</a>
<hr class="hiddenMd">
$retCat<hr>$linkKydex $linkInStock</nav>
</div>
<div class="text-center">&copy TABOO 2015-2022</div>
EOF;
