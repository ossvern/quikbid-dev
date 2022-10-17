<?php
//require_once('./smsclient.class.php');
//
////init class with your login/password
//$sms = new SMSclient('380939021680', '120288az', '5008d03f6f30b5a8bebad9e29915e06d78d8f1c0');
//$id = $sms->sendSMS('ossInformer', $uPhone, 'DSON - замовлення в 1 клік');

//send WAP-PUSH message
//$id = $sms->sendSMS('Alpha Name','0931234567', 'Самый классынй сайт!', time(), 'http://alphasms.com.ua/');

//send flash message at certain time
//$id = $sms->sendSMS('80501234567','80931234567', 'Flash message in english letters only!', strtotime('+1 minute'), '', 1);

//just for usage - text can be translierated to use less symbols in sms
//echo SMSclient::translit('Текст сообщения на русском языка в UTF-8 любой длинны');


//if no ID - then message is not sent and you should check errors
if($sms->hasErrors())
	die(var_dump($sms->getErrors()));
else
	var_dump($id);

//doing something interesting...
sleep(20);

//track message status after about 0,5 minute.
$res = $sms->receiveSMS($id);
var_dump($res);
var_dump($sms->getResponse());//full data

//get amount of money in account
var_dump($sms->getBalance());