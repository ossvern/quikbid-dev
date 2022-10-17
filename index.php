<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ERROR);
define('ROOT', dirname(__FILE__));


//$url = 'https://landos.ddev.site';
$url = 'https://landos.ddev.site';
$urlGo = $url;

//define('ROOT', dirname(__FILE__));
//require_once(ROOT . '/pages/inc/components/Db.php');
//$db = Db::getConnection();
require_once(ROOT . "/pages/inc/option.php");
//require_once(ROOT . "/pages/inc/func.php");

$lang = 'en';





?>
<!doctype html>
<html lang="<?= $lang ?>">
<head>
    <? //include 'pages/layouts/seo.php'; ?>

    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>


    <link rel="stylesheet"
          href="<?= $url ?>/css/bootstrap.css?s=<?= filemtime(ROOT . '/css/bootstrap.css') ?>">

    <link rel="stylesheet"
          href="<?= $url ?>/css/style.css?v=<?= filemtime(ROOT . '/css/style.css') ?>">
</head>
<body>
<main>
  <?
  include $l;
  ?>
</main>
<script src="<?= $url ?>/js/bundle.js?v=f<?= filemtime(ROOT . '/js/bundle.js') ?>"></script>
</body>
</html>

