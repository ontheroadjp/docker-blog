<!DOCTYPE html><head><meta charset="UTF-8"><title>AppTag - Alfraed v2 用 workflow</title>

<!-- -------------------- CSS ------------------------ -->
<link rel="stylesheet" type="text/css" href="./style.css" />
<style type="text/css"><!--
	body {

	}
--></style>

<!-- -------------------- JavaScript ------------------------ -->
<!-- JQuery 本体 & JQuery-UI 本体 & JQuery UI のcss-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
<script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/blitzer/jquery-ui.css" rel="stylesheet" type="text/css"/>

<!-- ------------------------- OGP ------------------------- -->
<meta property="og:title" content="AppTag - Alfred v2 用 workflow" />
<meta property="og:type" content="blog" />
<meta property="og:url" content="http://dev.ontheroad.jp/tools/alfred/apptag.php" />
<meta property="og:image" content="http://dev.ontheroad.jp/tools/apple/img/ogp_logo.png" />
<meta property="og:site_name" content="MacBook Air と WordPress でこうなった" />
<meta property="og:description" content="Mac アプリ、iPhone アプリ、iPad アプリ紹介用 HTML タグ自動生成の workflow" />
<meta property="fb:app_id" content="171242856322655" />
<meta property="fb:admins" content="100002003889575" />

<!-- ------------------- Google Analitics ------------------ -->
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
	<a href="http://dev.ontheroad.jp/tools/alfred/apptag.php"><span style="margin-right: 15px;"><img src="./img/icon_42_42.jpg" style="vertical-align:middle"/></span>AppTag - Alfred v2 用 workflow</a><?php include('./inc/social_buttons.php'); ?>
</h1>

<div style="clear:both"></div>

<!-- ----------------- メニューバー ----------------------- -->
<div style="background:#000"><br></div><br />
	

<!-- ----------------- コンテンツ ----------------------- -->
<div id="wrapper">
<div id="content">

<h2>AppTag の説明</h2>
<ul style="line-height:1.8em">

<li>AppTag は、Apple の iTunes Store Search API を利用して iPhone, iPad, Mac 用のアプリ検索し、ブログ紹介用の HTML タグを自動生成するための <a href="http://www.alfredapp.com/" target="_blank">Alfred v2</a>　用の workflow です。</li>

<li>生成できる HTML タグは「テキスト」と「画像付き」の2種類。</li>
<li>「テキスト」タグを使うと、「<a href="http://click.linksynergy.com/fs-bin/stat?cSxHJqdiAjg&offerid=94348&type=3&subid=0&tmpid=2192&RD_PARM1=https://itunes.apple.com/jp/app/evernote/id406056744?mt=12&uo=4" target="_blank">Evernote</a>さいこー！」みたいな感じで使えます。（生成される HTML は、<a href="http://click.linksynergy.com/fs-bin/stat?cSxHJqdiAjg&offerid=94348&type=3&subid=0&tmpid=2192&RD_PARM1=https://itunes.apple.com/jp/app/evernote/id406056744?mt=12&uo=4" target="_blank">Evernote</a>　の部分のみ）<br>
</li>

<li>「画像付き」タグはこんな感じでアプリを紹介する事ができます。<br>
<br>

<div style="border:1px solid #DDDDDD; background:#F7F7F7; padding:10px"><a href="http://click.linksynergy.com/fs-bin/stat?cSxHJqdiAjg&offerid=94348&type=3&subid=0&tmpid=2192&RD_PARM1=https://itunes.apple.com/jp/app/adobe-photoshop-elements-11/id571583293?mt=12&uo=4" target="_blank"><img src=http://a5.mzstatic.com/us/r1000/078/Purple/v4/e3/62/6b/e3626b90-5834-092e-5fb1-f322a36c9f87/ELApp.512x512-75.png  style="float:left; width:80px; margin:0 20px 10px 0;" /></a><div style="float:left;"><a href="http://click.linksynergy.com/fs-bin/stat?cSxHJqdiAjg&offerid=94348&type=3&subid=0&tmpid=2192&RD_PARM1=https://itunes.apple.com/jp/app/adobe-photoshop-elements-11/id571583293?mt=12&uo=4" target="_blank">Adobe Photoshop Elements 11 Editor</a></div><div style="font-size:0.9em"><br>ver. 11 - ¥6,900（ 写真 ）<br>Adobe</div><div style="clear:both"></div></div>

</li><br />


<li>AppTag は、<a href="http://www.alfredapp.com/" target="_blank">Alfred v2</a> の機能拡張として動作するので、別途 <a href="http://www.alfredapp.com/" target="_blank">Alfred 本体</a>（無料） と <a href="http://www.alfredapp.com/powerpack/" target="_blank">Powerpack</a> （有料） が必要です。<br><br>関連記事：<a href="http://dev.ontheroad.jp/archives/10883" target="_blank">Alfred v2 本体と Powerpack をインストールしてみる</a><br>
<br>
<a href="http://www.alfredapp.com/" target="_blank">Alfred</a> とはなんぞや？という人はこちらの記事をご覧ください。<br><br>関連記事：<a href="http://dev.ontheroad.jp/archives/10817" target="_blank">Alfredの基本的な使い方とか設定方法とか　その1</a><br>関連記事：<a href="http://dev.ontheroad.jp/archives/10997" target="_blank">Alfredの基本的な使い方とか設定方法とか　その2</a></li>
</ul>

<h2>ダウンロード</h2>
<p>下記リンクをクリックして AppTag をダウンロードしてください。</p>
<blockquote style="border:1px solid #DDDDDD; background:#F7F7F7; padding:10px">
<a href="http://dev.ontheroad.jp/tools/alfred/download/APPTAG v1.alfredworkflow" onclick="_gaq.push(['_trackEvent', 'Downloads', 'click', 'AppTag_v1,,true']);">AppTag ver. 1 をダウンロードする</a>
<!-- <a href="" onclick="_gaq.push(['_trackEvent', 'Downloads', 'click', 'AppTag_v1,,true']);">AppTag ver.1 をダウンロードする（comming soon…）</a> -->
</blockquote><br />



<h2>インストール</h2>
<ol style="line-height:1.8em">
<li>ダウンロードされたファイルをダブルクリックします。<br><br>
<img src="./img/apptag_install_01.jpg" /></li><br />

<li>Alfred v2 の設定画面が開いてインストール確認のダイアログが出るので「Import」をクリックすればインストール完了。<br><br>
<img src="./img/apptag_install_02.jpg" /></li><br />

<li>インストールが完了したら、ダウンロードしたファイルは削除しても構いません。</li>
</ol><br />


<h2>使い方</h2>
<ol style="line-height:1.8em">

<li>Alfred ウインドウを開きます。<br><img src="./img/alfred_window.jpg" /></li><br />
<li>「apptag」と入力して、HTML タグを生成したいアプリの種類を選択します。<br><img src="./img/apptag_how_to_use_01.jpg" /></li><br />
<li>生成するタグのスタイルを選択します。<br><img src="./img/apptag_how_to_use_02.jpg" /></li><br />
<li>HTML タグを生成したいアプリをアプリ名で検索します。<br><img src="./img/apptag_how_to_use_03.jpg" /></li><br />
<li>検索結果からアプリを選択してリターンキーを押すと、紹介用の HTML　タグがクリップボードに保存されます。この時、⌘（コマンドキー）を押しながらリターンキーを押すと、HTML タグが自動的に入力場所にペーストされます。<br><img src="./img/apptag_how_to_use_05.jpg" /></li>
</ol><br />


<h2>アフィリエイト</h2>
<ul style="line-height:1.8em">
<li>リンクシェアのアフィリエイト ID をお持ちの方は 生成される HTML タグをアフィリエイト対応にすることができます。</li>
</ul>

<ol style="line-height:1.8em">
<li>Alfred 設定画面を開いて、「Workflows」→「APPTAG」を選択して、AppTag の設定画面を開きます。</li>
<li>一番上にある「Script Filter」をダブルクリックして開きます。<br><img src="./img/apptag_aff_01.jpg" /></li><br />
<li>右下の「Open workflow folder」をクリックして workflow フォルダを開きます。<br><img src="./img/apptag_aff_02.jpg" /></li><br />
<li>workflow フォルダ内にある「apptag.php」を開きます。<br><img src="./img/apptag_aff_03.jpg" /></li><br />
<li>「apptag.php」の上から 7行目の 「private $aff_tracking_url = "http://c　・・（省略）・・　2&RD_PARM1=";」の「"」と「"」の間の文字列を自分のリンクシェアトラッキング URL に置き換えます。</li>
<li>「apptag.php」を保存して閉じれば、以後生成される HTML タグは全てアフィリエイト対応となります。</li>
</ol>

<p>
アフィリエイトの設定については、時間が出来たら「setup」とかのコマンドで簡単に設定出来るようにしたいと思います。<br>
<br>
関連記事：<a href="http://dev.ontheroad.jp/archives/1447"　target="_blank">LinkShare のトラッキング URL の確認の方法</a>
</p><br />


<h2>更新履歴</h2>
<ul style="line-height:1.8em">
	<li> 2013年4月17日　ver1 を公開。</li>
</ul><br />


<h2>その他</h2>
<ul style="line-height:1.8em">
	<li>Alfred なんか使ってないもんねーな人は、<a href="http://dev.ontheroad.jp/tools/apple/itunessearch.php" target="_blank">iOS, Mac OS X アプリ検索 & ブログ用タグ生成ツール</a>をご利用ください。</li>
	<li><a href="http://dev.ontheroad.jp/tools/apple/itunessearch_music.php" target="_blank">iTunes ミュージック検索 & ブログ用タグ生成ツール</a>もよろしく。</li>
	<li>開発ブログ「<a href="http://dev.ontheroad.jp/">Mac と Wordpress でこうなった</a>」</li>
</ul>





</div><!-- end of #content -->

<div id="sidebar">
</div><!-- end of #sidebar -->


</div><!-- end of #wrapper -->

<div class="clear"></div>
<?php include('./inc/social_buttons.php'); ?>
<div class="clear"></div>

<div id="footer">
<div class="copyright">Copyright © 2012 - 2013 <a href="http://dev.ontheroad.jp" target="_blank">MacBook Air とWordPressでこうなった</a> All rights reserved</div>
</div><!-- end of #footer -->

</body></html>


