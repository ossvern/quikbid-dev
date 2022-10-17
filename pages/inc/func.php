<?php

function getRealIpAddr()
{ //===================================  тирим іп для визначення країни
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}


function showTTH($id, $art, $brandLogo)
{
	global $db, $langPrefix;
	$ret = '';
	$resOpt = $db->query("SELECT * FROM `cat_tth` WHERE `productId` LIKE '$id' ORDER BY `cat_tth`.`parentId` ASC");
	while ($q = $resOpt->fetch_array()) {

		$parentTitle = RETURN_FROM_BD($q['parentId'], 'id', 'cat_tth', 'title' . $langPrefix);

		if (($q['titleUk']) != NULL) {
			if (strlen($q['title' . $langPrefix]) == 0)
				$title = ($q['titleUk']);
			else
				$title = ($q['title' . $langPrefix]);

		} else {
			$title = (RETURN_FROM_BD($q['valId'], 'id', 'cat_tth', 'title' . $langPrefix));
			if (strlen($title) == 0) $title = (RETURN_FROM_BD($q['valId'], 'id', 'cat_tth', 'titleUk'));


		}


//		$val = str_replace(' ', '&nbsp;', $val);
		$ret .= "<tr><td>$parentTitle:</td><td>$title</td></tr>";


	}
	$ret .= "<tr><td>Brand:</td><td>$brandLogo</td></tr>";

	if ($ret) return "<table class='-tth'><tr><td>" . TranslateMe('Артикул') . ":</td><td>$art</td></tr>$ret</table>";
}


function catalogThumb($id, $webP = false)
{
	global $db, $url;

	include_once '../ad/js/thumb/index.php';
	include_once '../ad/js/thumb/control.php';

	if (file_exists("./upload/th/$id.jpg") != true)
		$imgTh = "undefined";
	else
		$imgTh = "$url/upload/th/$id.jpg";

	$sql = "SELECT * FROM `gallery` WHERE `productId` = '$id' ORDER by gallery.added ASC LIMIT 1";

	$result = $db->query($sql);
	while ($q = $result->fetch_array()) {
		if (file_exists(ROOT . "/upload/th/$id.jpg") == false) {

			$options = array('request' => 'get', 'method' => 1, 'width' => 330, 'height' => 220);
			Thumbnail::output("./upload/gallery/$id/{$q['imageName']}", "./upload/th/$id.jpg", $options);
			$options = array('request' => 'get', 'method' => 1, 'width' => 1200, 'height' => 627);
			Thumbnail::output("./upload/gallery/$id/{$q['imageName']}", "./upload/og/$id.jpg", $options);
		}




		if (file_exists(ROOT . "/upload/th/$id.webp") == false) {
			$options = array('request' => 'get', 'method' => 1, 'width' => 560, 'height' => 370);
			Thumbnail::output("./upload/gallery/$id/{$q['imageName']}", "./upload/th/w$id.jpg", $options);
			exec("cwebp -q 100 ./upload/th/w$id.jpg -o ./upload/th/$id.webp");
			unlink("./upload/th/w$id.jpg");
		}
	}





	if ($webP)
		return "$url/upload/th/$id.webp?x=c";
	else
		return $imgTh;
}


function Redirect($url)
{

	echo "<script>window.location.replace(\"$url\");</script>";
//	exit();
}


function TranslateMe($inword, $lang_origin = false)
{ // сторінки // BEGIN function
	global $lang, $db;

	if (strlen($inword) > 0) {
		if ($lang != 'uk') {
			$sql = "SELECT * FROM `lang` WHERE `uk` LIKE '$inword' LIMIT 1";
			$result = $db->query($sql);
			$kvo = mysqli_num_rows($result);
			if ($kvo == 0) {
				$db->query("INSERT INTO `lang` (`en`, `uk`) VALUES ('0', '$inword');");
				return $inword;
			} else if ($kvo == 1) {
				while ($row = $result->fetch_array()) {
					return htmlspecialchars_decode($row[en]);
				}
			}
		} else {
			return $inword;
		}
	}
}


function encode($unencoded, $key)
{//Шифруем
	$string = base64_encode($unencoded);//Переводим в base64

	$arr = array();//Это массив
	$x = 0;
	while ($x++ < strlen($string)) {//Цикл
		$arr[$x - 1] = md5(md5($key . $string[$x - 1]) . $key);//Почти чистый md5
		$newstr = $newstr . $arr[$x - 1][3] . $arr[$x - 1][6] . $arr[$x - 1][1] . $arr[$x - 1][2];//Склеиваем символы
	}
	return $newstr;//Вертаем строку
}

function decode($encoded, $key)
{//расшифровываем
	$strofsym = "qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM=";//Символы, с которых состоит base64-ключ
	$x = 0;
	while ($x++ <= strlen($strofsym)) {//Цикл
		$tmp = md5(md5($key . $strofsym[$x - 1]) . $key);//Хеш, который соответствует символу, на который его заменят.
		$encoded = str_replace($tmp[3] . $tmp[6] . $tmp[1] . $tmp[2], $strofsym[$x - 1], $encoded);//Заменяем №3,6,1,2 из хеша на символ
	}
	return base64_decode($encoded);//Вертаем расшифрованную строку
}


function del_from_array($needle, &$array, $all = true)
{
	if (!$all) {
		if (FALSE !== $key = array_search($needle, $array)) unset($array[$key]);
		return;
	}
	foreach (array_keys($array, $needle) as $key) {
		unset($array[$key]);
	}
}

function generateUrl($str)
{

	$str = str_replace('«Біхелсі»', 'behealthy', $str);
	$str = CropTxt($str, 90);
	$translit = array(
		"А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
		"Д" => "D", "Е" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
		"Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
		"О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
		"У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
		"Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
		"Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
		"в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
		"з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
		"м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
		"с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
		"ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
		"ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
		" " => "_", '/' => '-', "Є" => "e", "є" => "e", "І" => "I", "і" => "i", "&" => "",
		"(" => "", ")" => "", "+" => "", "." => "", "," => "", ";" => "", "'" => "", "`" => "", "*" => "", "%" => "", "№" => "", '"' => "", 'ё' => "e", '#' => "", 'ї' => "", '-' => "_", '�' => "", '?' => "", '!' => "", '»' => "", '«' => "", ':' => "", '®' => '', '’' => '', '-' => '', '%E2%80%93' => '', '—' => "_",
	);

	$str = trim($str);
	$ret = strtr($str, $translit);
	$ret = str_replace('_____', '_', $ret);
	$ret = str_replace('____', '_', $ret);
	$ret = str_replace('___', '_', $ret);
	$ret = str_replace('__', '_', $ret);
	$ret = str_replace('_-_', '_', $ret);
	$ret = strtolower($ret);
	return ($ret);

}

function CropTxt($text, $kvo)
{
	$text = strip_tags($text, '');
	if (strlen($text) > $kvo) {
		$end = strpos($text, " ", $kvo);
		$n_text = substr($text, 0, $end);
		if ($n_text == '...') {
			$n_text = $text;
		}
	} else {
		$n_text = $text;
	}
	return $n_text;
}

function ProtectStr($str, $length = false, $default = false)
{
	$str = htmlspecialchars(trim($str));
	$str = str_replace("'", "\'", $str);
	if ($length != '') {
		$str = substr($str, 0, $length);
	}
	if (strlen($str) == 0) {
		$str = '';
		if (strlen($default) > 0) {
			$str = $default;
		}
	}
	return $str;
}


function RETURN_FROM_BD($id, $row, $mtable, $mrow)
{
	global $db;
	$result = $db->query("SELECT $mrow FROM `$mtable` WHERE `$row` LIKE '$id'");
//	echo  "<li>SELECT $mrow FROM `$mtable` WHERE `$row` LIKE '$id'";
	while ($row = $result->fetch_array()) {
		return $row[$mrow];
	}

}

function RETURN_FROM_BD_SQL($sql, $go)
{
	global $db;
	$ret = 0;
	$result = $db->query($sql);
	while ($row = $result->fetch_array()) {
		$ret = $row[$go];
	}
	return $ret;
}


function img_resize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 95)
{
	if (!file_exists($src))
		return false;

	$size = getimagesize($src);

	if ($size === false)
		return false;

	$format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
	$icfunc = "imagecreatefrom" . $format;
	if (!function_exists($icfunc))
		return false;

	$x_ratio = $width / $size[0];
	$y_ratio = $height / $size[1];

	$ratio = min($x_ratio, $y_ratio);
	$use_x_ratio = ($x_ratio == $ratio);

	$new_width = $use_x_ratio ? $width : floor($size[0] * $ratio);
	$new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
	$new_left = $use_x_ratio ? 0 : floor(($width - $new_width) / 2);
	$new_top = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

	$isrc = $icfunc($src);
	$idest = imagecreatetruecolor($width, $height);

	imagefill($idest, 0, 0, $rgb);
	imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);

	imagejpeg($idest, $dest, $quality);

	imagedestroy($isrc);
	imagedestroy($idest);

	return true;
}

function dateFormat($date, $is_time = false)
{
	global $lang;
	// получаем значение даты и времени
	list($day, $time) = explode(' ', $date);

	switch ($day) {
		// Если дата совпадает с сегодняшней
		case date('Y-m-d'):
			$result = 'Сьогодні';
			break;

		//Если дата совпадает со вчерашней
		case date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"))):
			$result = 'Вчора';
			break;

		case date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"))):
			$result = 'Завтра';
			break;

		default:
			{
				// Разделяем отображение даты на составляющие
				list($y, $m, $d) = explode('-', $day);


				if ($lang == 'uk')
					$month_str = array(
						'cічня', 'лютого', 'березня', 'квітня', 'травня', 'червня', 'липня', 'серпня', 'вересня', 'жовтня', 'листопада', 'грудня'
					);
				elseif ($lang == 'ru')
					$month_str = array(
						'cічня', 'лютого', 'березня', 'квітня', 'травня', 'червня', 'липня', 'серпня', 'вересня', 'жовтня', 'листопада', 'грудня'
					);


				$month_int = array(
					'01', '02', '03',
					'04', '05', '06',
					'07', '08', '09',
					'10', '11', '12'
				);

				// Замена числового обозначения месяца на словесное (склоненное в падеже)
				$m = str_replace($month_int, $month_str, $m);
				// Формирование окончательного результата
				$result = $d . ' ' . TranslateMe($m) . ' ' . $y;
			}
	}
	if ($is_time) {
		// Получаем отдельные составляющие времени
		// Секунды нас не интересуют
		list($h, $m, $s) = explode(':', $time);
		$result .= ' о ' . $h . ':' . $m;
	}
	return $result;
}


function If_Admin()
{
	global $a_pass;
	if ($a_pass == $_SESSION['admin']) {
		return 1;
	} else {
		return 0;
	}
}

function If_Not_Admin_Exit()
{
	global $a_pass;
	if (If_Admin() != 1) {
		//   echo'<script type="text/javascript">window.location = "http://dson.com.ua/"</script>';
		// break;
		die();

		//  header('Location: http://dson.com.ua/');
		//  sleep(5555555);
		//  echo'<script type="text/javascript">window.location = "?go=/"</script>';
	}
}


function canonical_URL()
{
	$url = @($_SERVER["HTTPS"] != 'on') ? 'http://' . $_SERVER["SERVER_NAME"] : 'https://' . $_SERVER["SERVER_NAME"];
	$url .= ($_SERVER["SERVER_PORT"] != 80) ? ":" . $_SERVER["SERVER_PORT"] : "";
	$url .= $_SERVER["REQUEST_URI"];
	$url = str_replace(':443', '', $url);


	return strtolower($url);
}
