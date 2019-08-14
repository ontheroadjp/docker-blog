
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>WEB サイト</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
</head><body>

<?php
$url = "http://itunes.apple.com/jp/rss/newapplications/limit=10/xml";			// 新着 iOS App
$url = "http://itunes.apple.com/jp/rss/topfreeapplications/limit=3/xml";		// 無料 iOS App（総合）
$url = "http://itunes.apple.com/jp/rss/toppaidapplications/limit=3/xml";		// 有料 iOS App（総合）
$url = "http://itunes.apple.com/jp/rss/topfreeipadapplications/limit=10/xml";	// 無料 iPad App（総合）
$url = "http://itunes.apple.com/jp/rss/toppaidipadapplications/limit=10/xml";	// 有料 iPad App（総合）
$url = "http://itunes.apple.com/jp/rss/topfreemacapps/limit=10/xml";			// 無料 Mac App（総合）
$url = "http://itunes.apple.com/jp/rss/toppaidmacapps/limit=10/xml";			// 有料 Mac App（総合）

$results =  get_item_list_html( $url );
for( $n=0; $n<count( $results ); $n++ ) {
	echo '<hr size=\'1\'>';
	foreach( $results[$n] as $key => $val ) {
		echo "<font color='red'>".$key."</font>".':'.$val.'<br>'."\n";
	}
}
?>
</body></html>

<?php
function get_item_list_html( $url ) {
//	$xmlstr = file_get_contents( $url );
//	$rss = simplexml_load_string( $xmlstr );
	
	$rss = simplexml_load_file( $url );
	$feed = $rss->feed;
	
	$results = array();
	foreach ( $rss->entry as $entry ) {

		$res = array(
			'updated'				=>	(String)$entry->updated
			, 'id'					=>	(String)$entry->id->attributes( "im", true )->id
			, 'bundleId'			=>	(String)$entry->id->attributes( "im", true )->bundleId
			, 'title'				=>	(String)$entry->title
			, 'summary'			=>	(String)$entry->summary
			, 'name'				=>	(String)$entry->children( "im", true )->name
			, 'link_href'			=>	(String)$entry->link['href']
			, 'contentType'			=>	(String)$entry->children( "im", true )->contentType->attributes()->term
			, 'contentType_label'	=>	(String)$entry->children( "im", true )->contentType->attributes()->label
			, 'artist'				=>	(String)$entry->children( "im", true )->artist
			, 'artist_href'			=>	(String)$entry->children( "im", true )->artist->attributes()->href
						
			, 'price_amount'		=>	(String)$entry->children( "im", true )->price->attributes()->amount
			, 'price_currency'		=>	(String)$entry->children( "im", true )->price->attributes()->currency
			, 'image_53_53'		=>	(String)$entry->children( "im", true )->image[0]
			, 'image_75_75'		=>	(String)$entry->children( "im", true )->image[1]
			, 'image_100_100'		=>	(String)$entry->children( "im", true )->image[2]

			, 'rights'				=>	(String)$entry->rights
			, 'releaseDate'			=>	(String)$entry->children( "im", true )->releaseDate
			, 'content_html'		=>	(String)$entry->children( "im", true )->content

			, 'category'			=>	(String)$entry->category['term']		
			, 'category_id'			=>	(String)$entry->category->attributes("im", true ) ->id
			, 'category_label'		=>	(String)$entry->category['label']
		);
		$results[] = $res;
	}
	return $results;
}
?>

