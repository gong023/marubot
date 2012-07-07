<html>
<head>
<meta http-equiv="Content-Type" content= "text/html; charset=UTF-8" />
<meta http-equiv="Content-Script-Type" content= "text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js" /></script>
<script src="js/jquery.activity-indicator-1.0.0.js" /></script>
<script type="text/javascript" src="js/apprise-1.5.full.js"></script>
<link rel="stylesheet" href="css/apprise.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
<script type="text/javascript">
$(function() {
	$("#want").click(function() {
		$('#busy1').activity();
		$.get("./goji_marubot.php", {index:"fushinsha ja naiyo"},
			function (data) {
				$('#busy1').activity(false);
				apprise(data);
			})
	})
	$("#cook").click(function() {
		var menu = document.menu.textbox.value;
		if (menu == "") {
			apprise('いや貴様メニュー教えろや');
		} else {
			$('#busy1').activity();
			$.get("./goji_marubot.php", {today_menu:menu},
				function (data) {
					$('#busy1').activity(false);
					apprise('メニューをツイートしたよ');
				})
		}
	})
})
</script>
</head>
<body>
<div class="container">
<div class="hero-unit">
<h2 style="text-align:center">ギークハウス高円寺のやねうら</h2>
	<br/><div id="busy1">
	<p style="text-align:center">今日ご飯食べたい人を再計算します。</p>
	<button style="margin-left:360px; margin-right:auto;"
	 type="button" class="btn-info btn-large" id="want">
	最計算する
	</button><br/><br/>
	<p style="text-align:center">家に食べ物がある場合はここから教えてください</p>
	<div style="margin-left:170px; margin-right:0 auto;">
	<form name="menu" >
		今日は家に
		<input style="height:41px; padding:9px; margin:11px;"
		 type="text" name="textbox" size="20" value=""/>
		があるよ！
		<button style="margin-right:auto;"
		 type="button" class="btn-info btn-large" id="cook">
		みんなに教える
		</button><br/>
	</form>
	</div>
	</div>
</dl>
</div>
</div>
</body>
<html>
