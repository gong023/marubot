<?php
require_once('tweet_maru.php');
require_once('mongo_maru.php');
define('CON_KEY', 'iA6syG3GpvAksccRUmoAUg');
define('CON_SEC', '9kTijp0gabxwIPlJZrWSzZUYvbvtMrDvLrhplZbc');
define('A_TOKEN', '400941481-EB8ImJjBPNu81MMkheLnSxhWS9MOz9vANJkhCzm6');
define('A_TOKEN_SECRET', 'oQ6TvwpqrcsQaicMc8wbzVp4X5cskREQcovSoxW3E');
$tweet = TweetMaru::getInstance(CON_KEY, CON_SEC, A_TOKEN, A_TOKEN_SECRET);
$member = $tweet->getListMember();
$message = '';
foreach ($member as $m) {
	$message = $message . '@' . $m . ' ';
}
$message = $message . 'ご飯いる？';
$req = $tweet->tweetResult($message);

$mongo = MongoMaru::getInstance();
$member = array();
$mongo->updateWantMember($member);
$mongo->updateNow();
