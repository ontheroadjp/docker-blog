
<div class="social_buttons">

	<!-- いいねボタン -->
	<div class="facebook_button">
		<div class="fb-like" data-href="<?php echo $baseUrl.'/index.php?lang='.$lang ?>" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false"></div>
	</div>

	<!-- はてなボタン -->
	<div class="hatena_button">
		<a href="http://b.hatena.ne.jp/entry/<?php echo $baseUrl.'/index.php?lang='.$lang ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="<?= $sitename[$lang] ?>" data-hatena-bookmark-layout="standard" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
	</div>

	<!-- ツイッターボタン -->
	<div class="twitter_button">
		<a href="https://twitter.com/share" class="twitter-share-button" data-via="ontheroad_jp" data-hashtags="Mac">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>

</div>
