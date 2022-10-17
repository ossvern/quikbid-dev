<?php
require_once(ROOT . "/pages/inc/func.php");

$go = ProtectStr($_GET['go'], 30);
$id = ProtectStr($_GET['id'], 150, '');
$page = ProtectStr($_GET['page'], 2, 1);
if (!$_GET['page'] || !$page)$page=1;
//$size = ProtectStr($_GET['size'], 10, '');
//if ($size) $size = str_replace('_', ' ', $size);
//$color = ProtectStr($_GET['color'], 10, '');  // if($color)$color = str_replace('_',' ',$color);
//$sort = ProtectStr($_GET['sort'], 10, '');
$search = ProtectStr($_GET['search'], 100, '');

//$currency = ProtectStr($_GET['currency'], 3, '');
//if (!$currency) $currency = 'pln';


//===========================================
$cntext = '.php';
$cntdir = '.-pages-';
if (!$_GET['go']) {
	$go = '-';
}
$l = $cntdir . preg_replace('/-$/', '-include', $go) . $cntext;
$l = str_replace('-', '/', $l);


$pos = substr($go, 1, strlen($go) - 2);
$l = addslashes($l);
$l = str_replace('//', '/', $l);

if (file_exists($l) != 1) {
	$l = $cntdir . $go . '/inc' . $cntext;
	$l = str_replace('-', '/', $l);
}
if (file_exists($l) != 1) {
	//  header('Location: ' . $url . '/error/404');
}
//===========================================

$arrLang = array('uk', 'en'); // 'en','de', 'ru',
//$langOtherName = array('PL', 'RU', 'EN');


if (isset($_GET['lang'])) {
	$_SESSION['lang'] = htmlspecialchars($_GET['lang']);
}
if (!$_SESSION['lang']) {
	$_SESSION['lang'] = 'uk';
}
$lang = $_SESSION['lang'];
if ($lang != 'ru' AND $lang != 'uk' AND $lang != 'en' AND $lang != 'de')
	$lang = 'uk';
if (!$_GET['go']) {
	$go = '-';
}
if ($lang == 'uk') {
	$langOtherName = 'UK';
	$langPrefix = 'Uk';
}
if ($lang == 'ru') {
	$langOtherName = 'RU';
	$langPrefix = 'Ru';
}
if ($lang == 'pl') {
	$langOtherName = 'PL';
	$langPrefix = 'Pl';
}
if ($lang == 'en') {
	$langOtherName = 'EN';
	$langPrefix = 'En';
}
if ($lang == 'de') {
	$langOtherName = 'DE';
	$langPrefix = 'De';
}

//$urlGo = "{$url}/{$lang}_{$currency}";
if ($lang == 'uk') $urlGo = "{$url}"; else $urlGo = "{$url}/{$lang}";

$i = -1;
$langOther = '';
while ($i++ < count($arrLang) - 1) {
	if ($arrLang[$i] != $lang)
		//	$langOther .= '<li><a href="' . $url . '/' . $arrLang[$i] . '/" class="-act">' . $arrLang[$i] . '</a></li>';


		$langOther .= '<li><a href="' . $url . '/' . $arrLang[$i] . '/" class="">' . $arrLang[$i] . '</a></li>';
}
unset($i);


$langOther = '<ul class="o-dropList -lang"><li><a href="#">' . $lang . '</a><ul>' . $langOther . '</ul></li></ul>';

$cat = ProtectStr($_GET['cat'], 80);
if (strlen($cat) > 0) {
	$catUrl = $cat;
	$cat = RETURN_FROM_BD($cat, 'url', 'cat_category', 'id');
	$catTitle = RETURN_FROM_BD($cat, 'url', 'cat_category', 'title' . $langPrefix);
}
$cat2 = ProtectStr($_GET['cat2'], 80);
if (strlen($cat2) > 0) {
	$cat2Url = $cat2;
	$cat2 = RETURN_FROM_BD($cat2, 'url', 'cat_category', 'id');
	$result = $db->query("SELECT id FROM `cat_category` WHERE `url` LIKE '$cat2Url' AND `parent_id` = '$cat' limit 1");
//	echo  "<li>SELECT $mrow FROM `$mtable` WHERE `$row` LIKE '$id'";
	while ($row = $result->fetch_array()) {
		$cat2 = $row['id'];
		$cat2Title = RETURN_FROM_BD($cat2, 'url', 'cat_category', 'title' . $langPrefix);
	}
}
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$actual_link = str_replace($actual_link,'&&');
//$actual_link = str_replace($actual_link,'&&&');

$arrBad = array('?&','&&','&&&');
$actual_link = str_replace($arrBad,'',$actual_link);
if (strpos($actual_link,'?') == strlen($actual_link)-1) {

	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".str_replace('?', '', $actual_link));


}

//	$actual_link = str_replace('?','',$actual_link);


//======================================= TODO SORT BY
$sortBy = 'last';
if ($_GET['sortBy']) {
	$_SESSION['sortBy'] = htmlspecialchars($_GET['sortBy']);
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".substr($actual_link,0,strpos($actual_link,'sortBy')));
}
if ($_SESSION['sortBy']) $sortBy = $_SESSION['sortBy'];
$arrSortBy__link = array('last','priceASC', 'priceDESC', 'nameASC', 'nameDESC');
$arrSortBy__title = array('по даті додавання','за ціною - від меншої', 'за ціною - від більшої', 'по імені - від A до Я', 'по імені - від Я до A',);
$arrSortBy__sql = array('`id` DESC','`priceUSD` ASC', '`priceUSD` DESC', '`titleUk` ASC', '`titleUk` DESC');
$i = -1;
while ($i++ <= count($arrSortBy__link) - 1) {
	if (strlen($arrSortBy__title[$i]) > 0) {
		if ($sortBy == $arrSortBy__link[$i]) {
			$select_sortBy .= "<option value='$arrSortBy__link[$i]' selected>".TranslateMe($arrSortBy__title[$i])."</option>";
			$sqlSortBy = $arrSortBy__sql[$i];
		} else {
			$select_sortBy .= "<option value='$arrSortBy__link[$i]'>".TranslateMe($arrSortBy__title[$i])."</option>";
		}
	}
}
$sqlSortBy = "ORDER BY $sqlSortBy ";
//if (!$_SESSION['sortBy']) $sqlSortBy = "ORDER BY `id` DESC ";


//======================================= TODO LIMIT MAX
$productsOnPage = '9';
if ($_GET['quantity']){
	$_SESSION['quantity'] = htmlspecialchars($_GET['quantity']);
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".substr($actual_link,0,strpos($actual_link,'quantity')));

}
//echo "<h1>".substr($actual_link,0,999).'</h1>';



if ($_SESSION['quantity']) $productsOnPage = $_SESSION['quantity'];
$arrQuantity = array('3','6','9','12', '15',);
$i = -1;
while ($i++ <= count($arrQuantity) - 1) {
	if (strlen($arrQuantity[$i]) > 0) {
		if ($productsOnPage == $arrQuantity[$i]) {
			$select_quantity .= "<option value='$arrQuantity[$i]' selected>{$arrQuantity[$i]}</option>";
			$productsOnPage = $arrQuantity[$i];

		} else {
			$select_quantity .= "<option value='$arrQuantity[$i]'>{$arrQuantity[$i]}</option>";
		}
	}
}





$catalogBlockTop = "
<div class='-topBlock'>
	<span><b>".TranslateMe('Сортування')."</b><select name='sortBy' id='js-sortBy'>$select_sortBy</select></span>
	<span><b>".TranslateMe('Позицій на сторінці')."</b><select name='quantity' id='js-quantity'>$select_quantity</select></span>
</div>";







header("Cache-control: public");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 60*60*24) . " GMT");