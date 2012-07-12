<?php
class ToraBot {
	var $check_list = array(
			'ちんこ'   => 3,
			'まんこ'   => 3,
			'セックス' => 3,
			'おっぱい' => 3,
			'性交'     => 3,
			'パンツ'   => 2,
			'シコシコ' => 2,
		);

	function getListTweet () {
		$cul = curl_init();
		curl_setopt($cul, CURLOPT_URL, "http://api.twitter.com/1/lists/statuses.json?slug=torabot&owner_screen_name=gong023&per_page=200");
		curl_setopt($cul, CURLOPT_RETURNTRANSFER, true);
		$get = json_decode(curl_exec($cul), true);
		curl_close($cul);
		$get_list = array();
		if (!is_array($get)) {
			die('not array');
		}
		foreach($get as $key => $val) {
			//リプライは取得しない
			if (preg_match('/@/', $val['text'])) {
				continue;
			}
			//とらハッシュタグは消去
			$get_list[] = str_replace('#とら', '', $val['text']);
		}
		return $get_list;
	}

	function checkToraTweet () {
		$get_list = $this->getListTweet();
		$check_key = array_rand($this->check_list, 1);
		$check_val = $this->check_list[$check_key];
		$result = array();
		foreach($get_list as $get) {
			if (preg_match('/' . $check_key . '/', $get)) {
				$result[$get] = $check_val;
			}
		}
		if (!empty($result)) {
			return $result;
		} else {
			return null;
		}
	}

	function tweet_se ($tora_tweet) {
		$se = 'セ';
		$xe = mt_rand(0 , 9);
		$xtu = mt_rand(1 , 3);
		$ku = mt_rand(0 , 9);
		$exclamation = mt_rand(0 , 9);
		$kusyami = mt_rand(0 , 9);
		$not_se = mt_rand(0 , 9);

		if (!is_null($tora_tweet)) {
			foreach($tora_tweet as $tweet => $rand) {
				if ($not_se <= $rand) {
					return $tweet;
				}
			}
		}
		for($i=0; $i<$xe; $i++) {
			if ($xe <= 4) {
				$se = $se . 'ェ';
			}
		}
		for($i=0; $i<$xtu; $i++) {
			$se = $se . 'ッ';
		}
		for($i=0; $i<$ku; $i++) {
			if ($ku <= 2) {
				$se = $se . 'ク';
			}
		}
		for($i=0; $i<$exclamation; $i++) {
			if ($exclamation <= 5) {
				$se = $se . '!';
			}
		}
		if ($kusyami <= 2) {
			$se = $se . '( >д<),;*.';
		}

		return $se;
	}
}
