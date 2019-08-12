
<?php

class DBConnection {

	private $_handle = null;

	public static function get() {
		static $db = null;
		if ( $db == null ) $db = new DBConnection();
		return $db;
	}
	private function __construct() {
		echo 'start constructor of class DBConnection';
		try {
			echo ' - create DB Connection!!<br>\n';
		    $this->_handle =& new PDO("mysql:host=mysql9.xserver.jp; dbname=xiaozhe_rsstest", "xiaozhe_rsstest", "bunnta0421");
//		    $this->_handle =& new PDO( $db_sttr );
		} catch(PDOException $e){
			echo $e->getMessage().'<br>\n';
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


/*
	public static function add( $db ) {
		try {
			echo 'START FeedList::insert_db()';
			$stmt = $db->prepare( "INSERT INTO rss_feeds(url, name, last_update) VALUES(:url, :name, :last_update)");
	        $stmt->bindValue(':url', $values['rss_feed_id']);
	        $stmt->bindValue(':name', $values['link']);
	        $stmt->bindValue(':last_update', $values['title']);

			if( $stmt->execute() ) {
				echo '　　OK<br>\n';
			} else {
				echo '　　NG<br>\n';
			}
		} catch (PDOException $e){
			var_dump($e->getMessage());
		}
	}
*/

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
		$sql = 'SELECT * FROM `'.$this->table_name.'` WHERE `rss_feed_id` = :id ORDER BY `post_time`';
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

$db = DBConnection::get()->handle();
$feedlist = new FeedList($db);
$feedlist->fetch( $db );
$db = null;

?>







