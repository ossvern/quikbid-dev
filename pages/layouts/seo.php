<?

switch ($go) {
//	case '-':
//		$ret_title = " ";
//		break;
//	case '/about':
//		$ret_title = "Про TABOO";
//		break;
//	case '/price':
//		$ret_title="Ціни на основні послуги - TABOO";
//		break;
	case '/kydex_sheaths':
		$ret_title = "Виготовлення ножен з кайдексу на замовлення";
		break;
//	case '/contact':
//		$ret_title = "Контактна інформація - TABOO";
//		break;
//	case '/portfolio-inc':
//		$ret_title = "Портфоліо - TABOO";
//		break;
	case '/blog-inc':
		$ret_title = TranslateMe("LIVE - новини з майстерні, фото від клієнтів");
		break;
}



//if ($go == '/portfolio-one') {
//	$sql = "SELECT * FROM `portfolio` where `url` like '$id' limit 1";
//	$result = $db->query($sql);
//	while ($row = $result->fetch_array()) {
//		$ret_title = $row['title'];
//		$ret_description = CropTxt( $row['info'],200);
////		$ogImg = "$url/upload/catalog/{$row['id']}/header.jpg";
//	}
//}

if ($go == '/catalog/inc' && strlen($cat)>0) {
	$ret_title = $catTitle;
	if (strlen($cat2)>0) $ret_title.=' - '.$cat2Title;
}
//echo $go.$ret_title;


if ($go == '/catalog/one') {
	$sql = "SELECT `id`,`title{$langPrefix}`,`info{$langPrefix}` FROM `cat_products` where `url` like '$id' limit 1";
	$result = $db->query($sql);
	while ($row = $result->fetch_array()) {
		$ret_title = $row['title'.$langPrefix].' - '.$cat2Title.' - '.$catTitle;
		$ogImg= $url.'/upload/og/'. $row['id'].'.jpg';
		$ret_description = CropTxt($row['info'.$langPrefix],200);


		$ret_description = htmlspecialchars_decode($ret_description);
		$ret_description = strip_tags($ret_description);
		$ret_description = str_replace('&nbsp;', '', $ret_description);
		$ret_description = str_replace("\r\n", "", $ret_description);

	}
}



if (strlen($ret_description) < 10) {
	$ret_description = ' ';
}
if (strlen($ret_keywords) < 10) {
	$ret_keywords =  TranslateMe('ножі ручної роботи, oss knives, knives');
}
if (strlen($ret_title) < 10) {
	$ret_title = 'TABOO - '. TranslateMe('ексклюзивні, робочі ножі ручної роботи. Тільки оригінальні ковані вироби');
}
if (strlen($ogImg) < 10) {
	$ogImg = "$url/img/og.jpg";
}

//TODO
// FAVICON
// BLOG PORTFOLIO

?>
<title><?= $ret_title ?></title>
<meta name="description" content="<?= $ret_description ?>">
<meta name="keywords" content="<?= $ret_keywords ?>"/>
<link rel="canonical" href="<?= canonical_URL() ?>"/>

<meta property="og:title" content="<?= $ret_title ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="<?=  canonical_URL() ?>"/>


<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Cache-control" content="public">

<link rel="apple-touch-icon" sizes="180x180" href="<?=$url?>/img/fav/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?=$url?>/img/fav/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?=$url?>/img/fav/favicon-16x16.png">
<link rel="manifest" href="<?=$url?>/img/fav/site.webmanifest">


<meta property=og:image content="<?= $ogImg ?>"/>



<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?= $url ?>/img/fav/apple-touch-icon.png">
<meta name="theme-color" content="#950C1D">




<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Q0NCVPW654"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-Q0NCVPW654');
</script>