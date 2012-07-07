<?php
if (!$_POST && !$_GET) {
	die('不正なアクセスです');
} else if (isset($_GET['today_menu']) && $_GET['today_menu']) {
	$menu = $_GET['today_menu'];
	prepare();
	tweetMenu($menu);
} else {
	$want_member = prepare();
	culculateAgain ($want_member);
}

function prepare () {
	//usr/share/php
	require_once('tweet_maru.php');
	require_once('mongo_maru.php');
	define('CON_KEY', 'iA6syG3GpvAksccRUmoAUg');
	define('CON_SEC', '9kTijp0gabxwIPlJZrWSzZUYvbvtMrDvLrhplZbc');
	define('A_TOKEN', '400941481-EB8ImJjBPNu81MMkheLnSxhWS9MOz9vANJkhCzm6');
	define('A_TOKEN_SECRET', 'oQ6TvwpqrcsQaicMc8wbzVp4X5cskREQcovSoxW3E');
	$mongo = MongoMaru::getInstance();
	$tweet = TweetMaru::getInstance(CON_KEY, CON_SEC, A_TOKEN, A_TOKEN_SECRET);
	$mentios = $tweet->getMentions();
	$last_update = $mongo->getLastUpdate();
	$want = array ('いる', 'ほしい', 'たべる', '食べる', 'はい');
	$cook = array ('つくる', '作る');
	$want_member = array();
	$cook_member = array();
	foreach ($mentios as $mention) {
		if (strtotime($mention['created_at']) < $last_update) {
			continue;
		}
		foreach ($want as $w) {
			if (preg_match('/' . $w . '/', $mention['text'])) {
				if (!in_array($mention['user']['screen_name'], $want_member)) {
					$want_member[] = $mention['user']['screen_name'];
				}
			}
		}
		foreach ($cook as $c) {
			if (preg_match('/' . $c . '/', $mention['text'])) {
				if (!in_array($mention['user']['screen_name'], $cook_member)) {
					$cook_member[] = $mention['user']['screen_name'];
				}
			}
		}
	}
	$mongo->updateWantMember($want_member);
	return $want_member;
}
function culculateAgain ($want_member) {
	$message = '';
	if (!empty($want_member)) {
		$message = '今日たべたい人は ';
		foreach ($want_member as $member) {
			$message = $message . '@' . $member . ' ';
		}
		$message = $message . 'の' . count($want_member) . '人だよ！';
	}
	if (!empty($cook_member)) {
		$message = $message . 'ご飯は ';
		foreach ($cook_member as $member) {
			$message = $message . '@' . $member . ' ';
		}
		$message = $message . 'が作ってくれるよ！ありがとう！';
	}
	//indicator試したいだけ
	sleep(1);
	if (!empty($message)) {
		echo $message;
	} else {
		echo '今日はたべたい人も作りたい人もいないよ';
	}
}
function tweetMenu ($menu) {
	require_once('tweet_maru.php');
	require_once('mongo_maru.php');
	define('CON_KEY', 'iA6syG3GpvAksccRUmoAUg');
	define('CON_SEC', '9kTijp0gabxwIPlJZrWSzZUYvbvtMrDvLrhplZbc');
	define('A_TOKEN', '400941481-EB8ImJjBPNu81MMkheLnSxhWS9MOz9vANJkhCzm6');
	define('A_TOKEN_SECRET', 'oQ6TvwpqrcsQaicMc8wbzVp4X5cskREQcovSoxW3E');
	$tweet = TweetMaru::getInstance(CON_KEY, CON_SEC, A_TOKEN, A_TOKEN_SECRET);
	$mongo = MongoMaru::getInstance();
	$member = $mongo->getWantMember();
	$tweet_member = '';
	foreach ($member as $m) {
		$tweet_member = $tweet_member . '@' . $m . ' ';
	}
	$menu = $tweet_member . '今日は家に'. $menu . 'があるよ！';
	$tweet->tweetResult($menu);
}


