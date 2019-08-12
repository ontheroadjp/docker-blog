<?php
// 基本設定
$page_title = 'アンカータグ（&lt;a>&lt;/a>）自動生成ツール';
$rootUrl = 'http://dev.ontheroad.jp/tools/blog/atag.php';
$description = '指定した URL のアンカータグ（&lt;a>&lt;/a>)を自動生成するツールです';

//タイトルを取得したいURL
$url = null;
$url = $_POST['target_url'];
 
if( $url <> null ) {
	//ソースの取得
	$source = @file_get_contents( 'http://'.$url );
	
	//文字コードをUTF-8に変換し、正規表現でタイトルを抽出
	if ( preg_match( '/<title>(.*?)<\/title>/i', mb_convert_encoding($source, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS'), $result)) {
	    $title = $result[1];
	} else {
	    //TITLEタグが存在しない場合
	    $title = $url;
	}
} 
?>

<!-- ------------------ HTMLここから ------------------------ -->
<!DOCTYPE html><head><meta charset="UTF-8"><title><?= $page_title ?></title>

<!-- ----------------------- CSS ---------------------------- -->
<style type="text/css"><!--
	body {

	}
--></style>

<!-- ------------------------- OGP ------------------------- -->
<meta property="og:title" content="<?= $page_title ?>" />
<meta property="og:type" content="blog" />
<meta property="og:url" content="<?= $rootUrl ?>" />
<meta property="og:image" content="http://dev.ontheroad.jp/tools/apple/img/ogp_logo.png" />
<meta property="og:site_name" content="アンカータグ自動生成ツール" />
<meta property="og:description" content="<?= $description ?>" />
<meta property="fb:app_id" content="171242856322655" />
<meta property="fb:admins" content="100002003889575" />

<!-- ------------------- Google Analytics ------------------ -->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29132526-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

<!-- ------------------- HTML（Body） ---------------------- -->
</head><body>

<!-- -------------------- ヘッダ --------------------------- -->
<h1 style="margin:0; padding:0;font-size:18px">
	<a href="<?= $rootUrl ?>">
		<span><img src="img/logo_app.png" style="vertical-align:middle"/></span><?= $page_title ?>
	</a>

	<div style="margin:10px 0;float:right;">
	
	<!-- いいねボタン -->
	<iframe src="//www.facebook.com/plugins/like.php?href=<?= $rootUrl ?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=171242856322655" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px;" allowTransparency="true"></iframe>


	<!-- はてなボタン -->
	<a href="http://b.hatena.ne.jp/entry/<?= $rootUrl ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="<?= $page_title ?>" data-hatena-bookmark-layout="standard" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>


	<!-- ツイッターボタン -->
	<a href="https://twitter.com/share" class="twitter-share-button" data-via="ontheroad_jp" data-hashtags="Mac">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


	</div>
</h1>

<div style="clear:both"></div>

<!-- ----------------- メニューバー ----------------------- -->
<form method="POST" action="atag.php">
	<div style="background:#000; padding:2px; padding-left:10px;" >
		<span style="color:#ffffff">http://</span>
		<input type="text" name="target_url" value="<?= $url ?>" size="60" />
		<input type="submit" value="&lt;a>タグ生成"/>	
	</div><br />
</form><br />

<!-- ----------------- コンテンツ ----------------------- -->
<div id="wrapper">
<div id="content">

<?php if( $url != null ) { ?>

<p>アンカータグを生成しました。</p><br />

<!-- テキストリンク -->
<p><a href="http://<?= $url ?>" target="_blank"><?= $title ?></a></p>
<textarea cols="82" rows="5" readonly onclick="this.select()">&lt;a href="<?= $url ?>" target="_blank"><?= $title ?>&lt;/a></textarea><br /><br />

<!-- はてブカウント付き -->
<p><a href="http://<?= $url ?>" target="_blank" style="margin-right:5px;"><?= $title ?></a><a href="http://b.hatena.ne.jp/entry/<?= $url ?>" target="_blank"><img border="0" src="http://b.hatena.ne.jp/entry/image/http://<?= $url ?>" alt="<?= $title ?>のはてブカウント" /></a></p>
<textarea cols="82" rows="5" readonly onclick="this.select()">&lt;a href="<?= $url ?>" target="_blank" style="margin-right:5px;"><?= $title ?>&lt;/a>&lt;a href="http://b.hatena.ne.jp/entry/http://<?= $url ?>" target="_blank">&lt;img border="0" src="http://b.hatena.ne.jp/entry/image/<?= $url ?>" alt="<?= $title ?>のはてブカウント" />&lt;/a></textarea><br /><br />

<?php } else { ?>

<p>上記検索バーに アンカータグを作成したい URL を入力してください。</p>

<?php } ?>

</div><!-- end of #content -->
</div><!-- end of #wrapper -->
</body>
</html>
