<?php

$tweets = get_tweets( 1 );

//HTMLのヘッダーを出力
echo '<meta name="charset" content="utf-8"><h1>ユーザータイムライン</h1>';

foreach( $tweets as $tweet ) {
	$icon = $tweet['icon'];
	$screen_name = $tweet['screen_name'];
	$name = $tweet['name'];
	$text = $tweet['text'];
	$date = date( 'Y年m月d日', $tweet['date'] );
//	echo '<img src="'.$icon.'" width="50" height="50"> @'.$screen_name.'('.$name.') '.$text.' ('.$date.')<hr>';
//	echo '<img src="'.$icon.'" width="25" height="25">'.$date.'<br>'.$text.'<hr>';
	echo $text;
}
?>

<?php

function get_tweets( $count = 10 ) {

	$results = array();

	//[API Key]と[API Secret] ([API Secret]はついでにURLエンコード)
	$api_key = 'CSqiki8387cN10J7RG6iggck6';
	$api_secret = rawurlencode('RJ4HGAIW5QjuW4T9sd0jmOK4mzDCFEPYrcvcAxY9WMKm24s9QG');
	
	//[アクセストークン]と[アクセストークンシークレット] ([アクセストークンシークレット]はついでにURLエンコード)
	$access_token = '95329606-JwMe31OVL50RwLU3XTtOkp381Gc9OX0ghj0ijeyTQ';
	$access_token_secret = 'GELeKV99XVzgMFHDfyV3RJTl3MePCvnHvIp1gRTkAuDUy';
	
	//リクエストURLとリクエストメソッド
	$request_method = 'GET';
	$request_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	
	//データ取得用のパラメータ(連想配列形式で指定)
	$params_a = array(
		'count' => $count,
	);
	
	//キーを作成する
	$signature_key = "{$api_secret}&{$access_token_secret}";
	
	//OAuth1.0認証用のパラメータ(連想配列形式)
	$params_b = array(
		'oauth_consumer_key'	=> $api_key,
		'oauth_token'				=> $access_token,
		'oauth_nonce'				=> microtime(),
		'oauth_signature_method'	=> 'HMAC-SHA1',
		'oauth_timestamp'			=> time(),
		'oauth_version'				=> '1.0'
	);
	
	//データを作成する
	$params_c = array_merge($params_a,$params_b);
	ksort($params_c);
	$signature_params = rawurlencode(str_replace(array('+','%7E'),array('%20','~'),http_build_query($params_c,'','&')));
	$encoded_request_method = rawurlencode($request_method);
	$encoded_request_url = rawurlencode($request_url);
	$signature_data = "{$encoded_request_method}&{$encoded_request_url}&{$signature_params}";
	
	//署名を作成する
	$hash = hash_hmac('sha1',$signature_data,$signature_key,TRUE);
	$signature = base64_encode($hash);
	
	//GETリクエストの準備
	$params_c['oauth_signature'] = $signature;
	$header_params = http_build_query($params_c,'',',');
	$tail = '?'.http_build_query($params_a,'','&');
	
	//リクエストを実行する
	$response = @file_get_contents(
		$request_url.$tail         //[第1引数：リクエストURL($request_url)とクエリー($tail)を合体]
		, false                      //[第2引数：リクエストURLは相対パスか？(違うのでfalse)]
		, stream_context_create(      //[第3引数：stream_context_create()でメソッドとヘッダーを指定]
			array(
				'http' => array(
					'method' => $request_method //リクエストメソッド
					, 'header' => array(          //カスタムヘッダー
						'Authorization: OAuth '.$header_params,
					),
				)
			)
		)
	);
	
	//配列[$data]を作成する
	$data = array();
	$data[0] = $response;             //JSONデータ
	$data[1] = $http_response_header; //レスポンスヘッダー
	
	//JSONデータを出力する(確認のため)
	// echo $data[0];
	
	// --------------------------
	
	//取得したJSONデータ[$data[0]]をオブジェクト形式に変換
	$object = json_decode($data[0]);
	
	//つぶやきデータの配列をループ処理
	$counter = 0;
	foreach( $object as $item ) {
	
		//通常のつぶやきか、公式リツイートで取り扱うデータなどを振り分ける
		if( isset( $item->retweeted_status) && !empty( $item->retweeted_status ) ) {
			$obj = $item->retweeted_status;
			$head = '[@'.$obj->user->screen_name.'さんがRT]';
		} else {
			$obj = $item;
			$head = '';
		}
		
		
		//返信の場合、冒頭に元記事へのリンクを付ける
		if( isset($obj->in_reply_to_status_id)  
						&& !empty( $obj->in_reply_to_status_id ) 
						&& isset( $obj->in_reply_to_screen_name ) 
						&& !empty( $obj->in_reply_to_screen_name )
					) {
			$head .= ' [<a href="https://twitter.com/'.$item->in_reply_to_screen_name.'/status/'.$item->in_reply_to_status_id.'" target="_blank">@'.$item->in_reply_to_screen_name.'さんへの返信</a>] ';
		}
	
		//名前・スクリーンネーム・アイコン画像
		$name = $obj->user->name;
		$screen_name = $obj->user->screen_name;
		$icon = $obj->user->profile_image_url;
	
		//つぶやき・投稿日時(整形)
		$text = $head.twoh10_en_scr( $obj->text, $obj->entities );
//		$text = $obj->text;

/*		var_dump($obj->text);
		echo '<br><br><br>';
		var_dump($obj->entities);
		echo '<br><br><br>';
*/		
		$date = date( 'Y/m/d H:i:s',strtotime( $obj->created_at ) );
		
		//位置情報を付けている場合、リンクを追加
		if(isset($obj->place->full_name) && !empty($obj->place->full_name)){
			//場所名
			$place_name = $obj->place->full_name;
			
			//座標情報があればGoogle Mapsへのリンクを付ける
			if(isset($obj->geo->coordinates[1]) && !empty($obj->geo->coordinates[1])){
				$place_name = '<a href="https://www.google.co.jp/maps/place/'.$obj->geo->coordinates[0].','.$obj->geo->coordinates[1].'" target="_blank">'.$place_name.'</a>';
			}
	
			//つぶやきに追加
			$text .= ' ['.$place_name.']';
		}
	
		//添付ファイルがある時はサムネイル画像を表示させる
		if(isset($obj->extended_entities->media) && !empty($obj->extended_entities->media)){
			$text .= '<br>';
			foreach($obj->extended_entities->media as $media){
				$text .= '<a href="'.$media->media_url.'" target="_blank"><img src="'.$media->media_url.':thumb" width="150" height="150"></a>';
			}
		}
	
	//	echo '$icon = '.$icon.'<br>';
	//	echo '$screen_name = '.$screen_name.'<br>';
	//	echo '$text = '.$text.'<br>';
	//	echo '$date = '.$date.'<br>';
	
		//出力
//		echo '<img src="'.$icon.'" width="50" height="50"> @'.$screen_name.'('.$name.') '.$text.' ('.$date.')<hr>';

		$result = array( 
			'icon' => $icon
			, 'screen_name' => $screen_name
			, 'name' => $name
			, 'text' => $text
			, 'date' => $date
		 );
		
		$results[$counter] = $result;
		$counter++;
	
	} // end of foreach	
	return $results;

} // end of function


// ------------------------------------


// $data = twoh10_en_scr($text,$entities)
// 第1引数:つぶやきのテキスト
// 第2引数:エンティティオブジェクト
// 返り値:リンクを付けたつぶやき
 
function twoh10_en_scr( $text, $entities ){
	//エンティティ内の調査対象のキー名
	$check_list = array('hashtags','symbols','urls','user_mentions','media');
	
	//エンティティの各項目を1つの配列[$entities]にまとめる
	$entities_list = array();
	foreach($check_list as $check){
		foreach($entities->{$check} as $item){
			$entities_list[] = array(
				'type' => $check,        //キー名
				'offset' => $item->indices[0],  //開始までのオフセット
				'end' => $item->indices[1],   //終了位置
				'value' => $item,          //内容
			);
		}
	}
	
	//配列[$entities]を[$entities[offset]]が高い順に並び替える
	foreach( $entities_list as $key => $value ){ $offset[$key] = $value['offset']; }
	array_multisort( $offset,SORT_DESC,$entities_list );
	
	//変換処理を実行
	foreach($entities_list as $item){
		//該当箇所の直前・直後を保存
		$left = mb_substr($text,0,$item['offset']);
		$right = mb_substr($text,$item['end'],null);
		
		//リッチテキストの用意
		switch( $item['type'] ) {

			//ハッシュタグの場合
			case($check_list[0]):
				$richtext = '<a href="https://twitter.com/search?q=%23'.$item['value']->text.'" target="_blank">#'.$item['value']->text.'</a>';
			break;
			
			//シンボルタグの場合
			case($check_list[1]):
				$richtext = '<a href="https://twitter.com/search?q=%24'.$item['value']->text.'" target="_blank">$'.$item['value']->text.'</a>';
			break;
			
			//URLアドレスの場合
			case($check_list[2]):
				$richtext = '<a href="'.$item['value']->expanded_url.'" target="_blank">'.$item['value']->display_url.'</a>';
			break;
			
			//メンションの場合
			case($check_list[3]):
				$richtext = '<a href="https://twitter.com/'.$item['value']->screen_name.'" title="'.$item['value']->name.'" target="_blank">@'.$item['value']->screen_name.'</a>';
			break;
			
			//メディア(添付ファイル)の場合
			case($check_list[4]):
				$richtext = '<a href="'.$item['value']->expanded_url.'" target="_blank">'.$item['value']->display_url.'</a>';
			break;

		} // end of switch

		//つぶやきの内容を更新
		$text = $left.$richtext.$right;
	}
	//リンクを付けたつぶやきを返却
	return $text;
}

?>
