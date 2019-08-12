<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RSS TEST</title>


<script type="text/javascript" src="lib/smoothscroll.js"></script>
<script type="text/javascript" src="lib/calendar.js"></script>
<link rel="stylesheet" type="text/css" media="screen,print" href="style.css" />

</head>
<body>

<?php

class DBConnection {

	private $_handle = null;

	public static function get() {
		static $db = null;
		if ( $db == null ) $db = new DBConnection();
		return $db;
	}
	private function __construct() {
//		echo 'start constructor of class DBConnection';
		try {
//			echo ' - create DB Connection!!<br>\n';
		    $this->_handle =& new PDO("mysql:host=mysql9.xserver.jp; dbname=xiaozhe_rsstest", "xiaozhe_rsstest", "bunnta0421");
//		    $this->_handle =& new PDO( $db_sttr );
		} catch(PDOException $e){
			echo $e->getMessage().'<br>'."\n";
		    var_dump($e->getMessage());
		}
	}
	public function handle() {
		return $this->_handle;
	}
}

// --------------------------------------------------------------
// class FeedList
// --------------------------------------------------------------
class FeedList {

	public function FeedList( $db ) {

		try {
			$stmt = $db->prepare( "SELECT * FROM rss_feeds" );
			$stmt->execute();
			$feeds = $stmt->fetchAll();
			foreach( $feeds as $feed ) {
				$this->feeds[] = new Feed(	$db, 
											$feed['rss_feed_id'],
											$feed['url'],
											$feed['name'],
											$feed['last_update']
								 );
			}
		} catch ( PDOException $e ){
			var_dump( $e->getMessage() );
		}
	}

	public function get_feeds() {
		return $this->feeds;
	}

	public function fetch( $db ) {
		foreach( $this->feeds as $feed ) {
			$last_post_date = $feed->fetch( $db );
			if( $last_post_date != '' && strtotime( $last_post_date ) > strtotime( $last_update ) ) {
//				echo 'START FeedList::UPDATE_last_update()';
					$stmt = $db->prepare( "UPDATE `rss_feeds` SET `last_update` = :time WHERE `rss_feed_id` = :rss_feed_id" );
			        $stmt->bindValue(':time', date('Y-m-d H:i:s', strtotime($last_post_date) ) );
			        $stmt->bindValue(':rss_feed_id', $feed->get_value('rss_feed_id') );
					$stmt->execute();
//				echo '　　OK<br>\n';
			}
		}
	}
}

// --------------------------------------------------------------
// class Feed
// --------------------------------------------------------------
class Feed {

	function Feed( $db, $id, $url, $name, $last_update ) {

		if( !isset($db) || !isset($id) || !isset($name) || !isset($last_update) ) {
			echo 'err';
			die;
		}

		$this->table_name = 'rss_articles';
		$this->articles = null;

		$this->columns = array(
			'rss_feed_id' => $id
			, 'url' => $url
			, 'name' => $name
			, 'last_update' => $last_update
		);

		// Article の取得
		$sql = 'SELECT * FROM `'.$this->table_name.'` WHERE `rss_feed_id` = :id ORDER BY `post_time` DESC';
		try {
			$stmt = $db->prepare( $sql );
	        $stmt->bindValue(':id', $id);
			$stmt->execute();
			$this->articles = $stmt->fetchAll();
		} catch ( PDOException $e ){
			var_dump( $e->getMessage() );
		}
	}

	public function get_value($key) {
		return $this->columns[$key];
	}

	public function get_articles() {
		return $this->articles;
	}

	public function fetch( $db ) {

		$rss_feed_id = $this->columns['rss_feed_id'];
		$url = $this->columns['url'];
		$last_update = $this->columns['last_update'];
		echo '$rss_fetch_url = '.$url.'<br>\n';

		$rss = simplexml_load_file( $url );

		if( !empty( $rss ) || $rss <> '' ) {
			$channel = $rss->channel;
			$last_post_date = '';

			foreach ($channel->item as $item) {
				$article = null;
				$article['rss_feed_id']	= $rss_feed_id;
				$article['link']	= mb_convert_encoding( $item->link, "UTF-8", "auto" );
				$article['title']	= mb_convert_encoding( $item->title, "UTF-8", "auto" );
				$article['desc']	= mb_convert_encoding( $item->description, "UTF-8", "auto" );
				$article['post_time']	= get_formatted_time($item->pubDate);

				if( $debug == 1 ) {
					echo '=====================================================<br>\n';
					echo '$article[\'rss_feed_id\']	= '.$rss_feed_id.'<br>\n';
					echo '$article[\'link\']	= '.$item->link.'<br>\n';
					echo '$article[\'title\']	= '.$item->title.'<br>\n';
					echo '$article[\'date\']	= '.$item->pubDate.'<br>\n';
					echo '$article[\'desc\']	= '.$item->description.'<br>\n';
					echo '$article[\'post_time\']	= '.get_formatted_time($item->pubDate).'<br>\n';
					echo '-----------------------------------------------------<br>\n';
					echo 'posted_time = '.$article['post_time'].'('.strtotime($article['post_time']).')<br>\n';
				}

				if( strtotime($last_update) < strtotime($article['post_time']) ) {
					if( $this->insert_db( $db, $article ) ) {
						if( $last_post_date == '' || strtotime($last_post_date) < strtotime($article['post_time']) ) {
							$last_post_date = $article['post_time'];
						}
					} else {
						echo 'DB Article の insert に失敗しました。';
					}
				} else {
					echo 'doesn\'t insert_db()<br>\n';
				}
			}
			return $last_post_date;

		} else {
			echo 'RSS の取得に失敗しました。<br>\n';
			echo 'RSS URL = '.$url.'<br>\n';
			return;
		}
	}

	private function insert_db( $db, $article ) {
		try {
			echo 'START FeedArticle::insert_db()';
				$stmt = $db->prepare("INSERT INTO rss_articles(rss_feed_id, link, title, description, post_time) VALUES(:rss_feed_id, :link, :title, :desc, :post_time)");
		        $stmt->bindValue(':rss_feed_id', $article['rss_feed_id']);
		        $stmt->bindValue(':link', $article['link']);
		        $stmt->bindValue(':title', $article['title']);
		        $stmt->bindValue(':desc', $article['desc']);
		        $stmt->bindValue(':post_time', $article['post_time']);
				$stmt->execute();
			echo '　　OK<br>\n';
		} catch (PDOException $e){
			var_dump($e->getMessage());
		}
		return true;
	}

}


// --------------------------------------------------------------
// functions()
// --------------------------------------------------------------
function get_formatted_time($target) {

	$debug	= 0;
	$date	= array(
		"Jan"=>1
		, "Feb"=>2
		, "Mar"=>3
		, "Apr"=>4
		, "May"=>5
		, "Jun"=>6
		, "Jul"=>7
		, "Aug"=>8
		, "Sep"=>9
		, "Oct"=>10
		, "Nov"=>11
		, "Dec"=>12
	);

	$array = explode(' ', $target);
	$time = explode(':', $array[4]);

	$year	= $array[3];
	$month	= $date[$array[2]];
	$day	= $array[1];
	$hour	= $time[0];
	$minute	= $time[1];
	$sec	= $time[2];

	if( $debug == 1 ) {
		for( $n=0; $n<count($array); $n++ ) {
			echo '$array['.$n.']= '.$array[$n].'<br>\n';
		}
		echo '年：'.$year.'<br>\n';
		echo '月：'.$month.'<br>\n';
		echo '日：'.$day.'<br>\n';
		echo '時：'.$hour.'<br>\n';
		echo '分：'.$minute.'<br>\n';
		echo '秒：'.$sec.'<br>\n';
		echo 'unixtime = '.date('Y-m-d H:i:s', mktime( $hour, $minute, $sec, $month, $day, $year ) ).'<br>\n';
		echo 'formatted_time = '.date('Y-m-d H:i:s', mktime( $hour, $minute, $sec, $month, $day, $year ) ).'<br>\n';
	}

	return date('Y-m-d H:i:s', mktime( $hour, $minute, $sec, $month, $day, $year ) );
}

/*
$db = DBConnection::get()->handle();
$feedlist = new FeedList($db);
$feedlist->fetch( $db );
$db = null;
*/

?>



<!-- <h3>DB から取得して表示</h3> -->
<?
$db = DBConnection::get()->handle();
$app = new FeedList( $db );
$feeds = $app->get_feeds();
?>

<a name="top"></a><br />



<div id="wrapper">

<?php
foreach($feeds as $feed) {

	$feed_name		= $feed->get_value('name');
	$last_update	= strtotime( $feed->get_value('last_update') );
	$articles		= $feed->get_articles(); ?>

	<div class="header">
		<h3><?php echo $feed_name ?></h3>
		<p>（最終更新日：<?php echo date( 'Y年m月d日 H時i分', $last_update ) ?>)</p>
		<?php $target_date = date( 'm月d日', $last_update ); ?>
	</div>

	<div id="content">
	<div class="news"><ul>

	<?php foreach( $articles as $article ) {
		$link		= $article['link'];
		$title		= $article['title'];
		$post_time	= $article['post_time'];
		$desc		= $article['description'];

		$post_time_unix = strtotime( $post_time );

		if( $target_date != substr( $post_time, 5, 5 ) ) { ?>

			</ul></div> <!-- end of .news -->
			<div><a href="#top"><img src="image/to_top.gif" /></a></div>
			<?php $w = get_date( date( 'w', $post_time_unix ) ); ?>
			<a name="<?php echo date( 'mj', $post_time_unix ) ?>"></a>
			<div class="news">
			<h3><?php echo date( 'n月j日（'.$w.'）', $post_time_unix ) ?></h3>
			<ul>
			<?php $target_date = substr( $post_time, 5, 5 ) ?>

		<?php } ?>

		<li><?php echo date( 'H:i', $post_time_unix )."\t" ?><a href="<?= $link ?>" title="<?= $title ?>"><?= $title ?></a><p><?= $desc ?></p></li>

	<?php } ?>

<?php
	echo '</ul></div> <!-- end of .news -->';
	echo '<div><a href="#top"><img src="image/to_top.gif" /></a></div>';
//	echo '-->';
}

$db = null;

function get_date( $w ) {
	if( $w == 0 ) {
		return '日';
	} else if( $w == 1 ) {
		return '月';
	} else if( $w == 2 ) {
		return '火';
	} else if( $w == 3 ) {
		return '水';
	} else if( $w == 4 ) {
		return '木';
	} else if( $w == 5 ) {
		return '金';
	} else if( $w == 6 ) {
		return '土';
	}
	return null;
}

?>


<br />
<hr size="1">
<br />


<h3>直接 RSS から取得して直接表示</h3>
<?php
$url = "http://rss.dailynews.yahoo.co.jp/fc/rss.xml";

$xmlstr = file_get_contents($url);
mb_convert_encoding($xmlstr,"UTF-8");
$rss = simplexml_load_string($xmlstr);

//$rss = simplexml_load_file( $url );
//var_dump($rss);


$channel = $rss->channel;
$feed_title = $channel->title;
echo '<h3>'.$feed_title.'</h3>';
echo '<ol>';
	foreach ($channel->item as $item) {
		$link = $item->link;
		$title = $item->title;
		$date = $item->pubDate;
		$desc = $item->description;
		echo "<li><a href=\"$link\" title=\"$title\">$title</a>$date</li>\n";
	}

	foreach ($rss->item as $item) {
		$link = $item->link;
		$title = $item->title;
		$date = $dc->date;
		$desc =$item->description;
		echo "<li><a href=\"$link\" title=\"$title\">$title</a>$date<p>$desc</p></li>\n";
	}
echo '</ol>';
?>

<div class="clear"></div>
</div><!-- end of #content -->

<div id="sidebar">
	<div id="calendar"></div>
</div>

</div><!-- end of #wrapper -->


</body>
</html>
