
<?php
//	require_once('info.php');
//	require_once('function.php');

	$temp = $n + 1;
?>


<!-- Content メニュー -->
<h2><?php echo $comic_title[$lang] ?>　<?php echo get_volume_presentation($lang, $n) ?></h2>
<div class="content_img">
	<img width="100%" src="<?php echo $contentsUrl ?>/<?php echo $temp ?>/cover_<?php echo $temp ?>_300.jpg" />
</div>

<div class="contents_menu">
	<ul>
	<?php
		foreach( $episodes[$lang][$n] as $key => $val ) {
			echo '<li>'.get_episode_link( $baseUrl, $lang, $n, $key, $val ).'</li>';
		}
	?>
	</ul>
</div><div class="clear"></div>
<!-- Content メニュー ここまで -->

<?php include('./include/page_navi.php'); ?><br />

<div id="page_0"></div><br />

<h2>#<?php echo $epi ?>（<?php echo $episodes[$lang][$n][$epi] ?>）</h2>

<?php if( $lang === 'ja' ) { ?>
	<p class="center">ページをクリックすると次のページへ移動します。<br>ブラウザのブックマークに登録すると続きから読むことができます。</p>
<?php } else if( $lang === 'en' ) { ?>
	<p class="center">Click a page of content to move the next page.<br>You can continue to read contents by bookmarking of the web browser\'s future.</p>
<?php } ?>

<?php
$contents_path = 'contents/'.$lang.'/'.$temp.'/'.$epi;
$files = scandir( $contents_path );
$page = 0;

foreach( $files as $file ) {
	if( strtolower( substr(strrchr($file, '.'), 1) ) === 'jpg' ) {
		$page++;
	?>

		<div id="page_<?php echo $page ?>"></div>
		<div class="article_content">
			<a href="#page_<?php echo $page + 1 ?>">
				<img width="100%" border="1" src="<?php echo $contents_path ?>/<?php echo $file ?>" />
			</a><br><br>

			<span>
				<?php echo $page ?> page</span><a href="#pagetop">
				<img src="<?php echo $rootUrl ?>/special/blackjack/img/pagetop.gif" alt="<?php echo $comic_title[$lang] ?> - <?php echo get_volume_presentation($lang, $n) ?>（#<?php echo $epi  ?>）- <?php echo $page ?> page" style="float:right" />
			</span>
			</a><br>
		</div>
<?php
	}
}
?>


<br /><br />

<center><?php include('./include/copyrights.php'); ?></center>

<br />
	<div id="page_<?php echo $page + 1 ?>"></div>
<br />


<!-- Content メニュー -->
<h2><?php echo $comic_title[$lang] ?>　<?php echo get_volume_presentation($lang, $n) ?></h2>
<div class="content_img">
	<img width="100%" src="<?php echo $contentsUrl ?>/<?php echo $temp ?>/cover_back_<?php echo $temp ?>_300.jpg" />
</div>
<div class="contents_menu">
	<ul>
	<?php
		foreach( $episodes[$lang][$n] as $key => $val ) {
			echo '<li>'.get_episode_link( $baseUrl, $lang, $n, $key, $val ).'</li>';
		}
	?>
	</ul>
</div><div class="clear"></div>
<!-- Content メニュー ここまで -->

<?php include('./include/page_navi.php'); ?>

<br />

<a href="#pagetop"><img src="./img/pagetop.gif" style="float:right" /></a><br>

<br />

