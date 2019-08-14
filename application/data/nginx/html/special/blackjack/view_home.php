

<h2><?php echo $comic_title[$lang] ?></h2>


<?php if( $lang === 'ja' ) { ?>
	<p>
		すべてのコンテンツを無料で読むことができます。<br>
		<br>
		これらコンテンツは<a href="http://mangaonweb.com/creatorDiarypage.do?cn=1&dn=34417" target="_blank">こちらのライセンス</a>に基づいて配信されています。<br>
		<br>
		各巻の画像をクリックすると読むことができます。
	</p>
<?php } else if( $lang === 'en' ) { ?>

<?php } ?>


<!-- <div class="js-masonry"> -->
<div class="panels">
<?php
	for( $n=0; $n < count( $episodes[$lang] ); $n++ ) {
		$temp = $n + 1;
		$episode_titles = $episodes[$lang][$n];
	?>
		<!-- <div class="box"> -->
		<!-- <div class="item"> -->
		<div class="panel">

		<!--	<div style="text-align: center;"> -->
				<a href="<?php echo $baseUrl ?>/index.php?n=<?php echo $n ?>&lang=<?php echo $lang?>">
					<img src="<?php echo $contentsUrl?>/<?php echo $temp ?>/cover_<?php echo $temp  ?>.jpg" /><br>
				</a>
				<?php echo get_volume_presentation( $lang, $n ) ?>（全<?php echo count( $episode_titles ) ?>話）
			<!-- </div> -->
		</div>
		<!-- </div> -->
	<?php } ?>
</div>

<div class="clear"></div>
<br />

<?php echo include( './include/copyrights.php' ); ?>


<?php if( $lang === 'ja' ) { ?>
	<h2>関連ブログ記事</h2>
	<p>
		2015年06月08日　<a href="http://dev.ontheroad.jp/archives/13478" target="_blank">Masonry + imagesLoaded でタイル状に要素を整列して並べる</a><br>
<br>
		2012年10月25日　<a href="http://dev.ontheroad.jp/archives/8700" target="_blank">漫画「ブラックジャックによろしく」全13巻の無料配信を始めてみた</a><br>
		<br>
		2012年10月 5日　<a href="http://dev.ontheroad.jp/archives/7478" target="_blank">太っ腹！マンガ「ブラックジャックによろしく」が全巻無料配信中！！</a><br>
	</p>
<?php } else if( $lang === 'en' ) { ?>

<?php } ?>


<?php if( $lang === 'ja' ) { ?>
	<h2>更新履歴</h2>
	<p>
		2015年06月07日　モバイル対応しました。<br>
		<br>
		2012年11月 5日　英語版を公開しました。<br>
		<br>
		2012年10月24日　日本語版を公開しました。
	</p>
<?php } else if( $lang === 'en' ) { ?>

<?php } ?>


<!--

<h2>「ブラックジャックによろしく」について</h2>
<p>
『ブラックジャックによろしく』は、佐藤秀峰による日本の漫画作品、またそれを原作とした同名のテレビドラマ。研修医が目にする日本の大学病院や医療現場の現状を描く。医療監修は長屋憲。（<a href="http://ja.wikipedia.org/wiki/%E3%83%96%E3%83%A9%E3%83%83%E3%82%AF%E3%82%B8%E3%83%A3%E3%83%83%E3%82%AF%E3%81%AB%E3%82%88%E3%82%8D%E3%81%97%E3%81%8F#.E7.AC.AC.E4.B8.80.E5.A4.96.E7.A7.91.E7.B7.A8.EF.BC.88.E3.83.96.E3.83.A9.E3.83.83.E3.82.AF.E3.82.B8.E3.83.A3.E3.83.83.E3.82.AF.E3.81.AB.E3.82.88.E3.82.8D.E3.81.97.E3.81.8F.E7.AC.AC1.E5.B7.BB.EF.BC.89" target="_blank">wikipedia</a> より）
</p>

-->


<!--
<h3>第一外科編（第1巻）</h3>
<ul style="line-height:1.5em">
	<li>第1巻（全7話）</li>
</ul>

<h3>循環器内科編（第2巻）</h3>
<ul style="line-height:1.5em">
	<li>第2巻（全9話）</li>
</ul>

<h3>NICU（新生児集中治療室）編（第3巻～第4巻）</h3>
<ul style="line-height:1.5em">
	<li>第3巻～第4巻（全22話）</li>
</ul>

<h3>がん医療編（第5巻～第8巻）</h3>
<ul style="line-height:1.5em">
	<li>第5巻～第8巻（全42話）</li>
</ul>

<h3>精神科編（第9巻～第13巻）</h3>
<ul style="line-height:1.5em">
	<li>第9巻～第13巻（全48話）</li>
</ul>


<h2>このサイトの更新履歴</h2>
<ul style="line-height:1.5em">
	<li> 2012年10月25日　公開しました。</li>
</ul>

-->


<!--
<h2>その他</h2>
<ul style="line-height:1.5em">
	<li><a href="http://dev.ontheroad.jp/tools/apple/itunessearch_music.php">iTunes ミュージック検索 & ブログ用タグ生成ツール</a>もよろしく。</li>
	<li>開発ブログ「<a href="http://dev.ontheroad.jp/">Mac と Wordpress と Web API でこうなった</a>」</li>
</ul>
-->