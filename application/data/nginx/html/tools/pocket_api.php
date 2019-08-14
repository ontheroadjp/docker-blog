<?php
/*
//アプリ登録で取得したコンシューマーキー
$consumer_key = '31858-95baa9432060a9359821b1fe';
 
//このプログラムのURL
$redirect_uri = 'http://dev.ontheroad.jp/tools/pocket_api.php';
 
//セッションスタート
session_start();
 
//アプリ認証から帰ってきた時([return=1]があるアクセス)の場合はアクセストークンを取得
//[手順3] ユーザーがアプリを許可して、アプリがアクセストークンを受け取る、の部分
if(isset($_GET['return']) && is_string($_GET['return']) && $_GET['return'] == "1"){
 
  //セッションにリクエストトークンがない場合は不正と判断してエラー
  if(!isset($_SESSION['code']) || empty($_SESSION['code'])){ error_pk_syncer('セッションが上手く機能してないか、手動で[return=1]を付けてアクセスしてます…。'); }
 
  //セッションにCSRF対策用の[state]がない場合は不正と判断してエラー
  if(!isset($_SESSION['state']) || empty($_SESSION['state'])){ error_pk_syncer('セッションが上手く機能してないかもしれません。'); }
 
  //リクエストトークンをアクセストークンと交換する
  $data = @file_get_contents(
    'https://getpocket.com/v3/oauth/authorize',
    false,
    stream_context_create(
      array('http' => array(
        'method' => 'POST',
        'content' => http_build_query(array(
          'consumer_key' => $consumer_key,
          'code' => $_SESSION['code'],
        )),
      ))
    )
  );
 
  //関数[get_query_syncer]を使って、GETパラメータ形式の文字列を配列に変換
  $query = get_query_syncer($data);
 
  //CSRF対策
  if(!isset($query['state']) || empty($query['state']) || $query['state'] != $_SESSION['state']){ error_pk_syncer('セッションに保存してあるstateと、返ってきたstateの値が違います…。'); }
 
  //アクセストークンが取得できない場合はエラー
  if(!isset($query['access_token']) || empty($query['access_token'])){ error_pk_syncer('アクセストークンを取得できませんでした…。'); }
 
  //アクセストークンを変数に格納
  $access_token = $query['access_token'];
 
  //セッション終了
  session_finish_pk_syncer();
 
  //アクセストークンをブラウザに出力
  echo $header."あなた({$query['username']})のアクセストークンは<mark>{$access_token}</mark>です！";
 
//[return=1]がないアクセス(初回アクセス)の場合
//[手順1] pocketからリクエストトークンを取得する、の部分
}else{
 
  //CSRF対策
  session_regenerate_id(true);
  $state = sha1(uniqid(mt_rand(),true));
  $_SESSION['state'] = $state;
 
  //リダイレクトURLにパラメータを追加
  $redirect_uri .= "?return=1";
 
  //リクエストトークンを取得
  $data = @file_get_contents(
    'https://getpocket.com/v3/oauth/request',
    false,
    stream_context_create(
      array('http' => array(
        'method' => 'POST',
        'content' => http_build_query(array(
          'consumer_key' => $consumer_key,
          'redirect_uri' => $redirect_uri,
          'state' => $state,
        )),
      ))
    )
  );
 
  //関数[get_query_syncer]を使って、GETパラメータ形式の文字列を配列に変換
  $query = get_query_syncer($data);
 
  //リクエストトークンを取得できなければエラー
  if(!isset($query['code']) || empty($query['code'])){ error_pk_syncer('リクエストトークンが取得できませんでした。多分コンシューマーキーの設定が間違っています。'); }
 
  //セッションに保存したstateの値と、返って来たstateの値が違ったらエラー
  if(!isset($query['state']) || empty($query['state']) || $_SESSION['state'] != $query['state']){ error_pk_syncer('セッションが上手く機能してないかもしれません…。'); }
 
  //セッションにリクエストトークンの値を格納しておく
  $_SESSION['code'] = $query['code'];
 
  //ユーザーをアプリ認証画面へアクセス(リダイレクト)させる
  //[手順2] ユーザーがそのリクエストトークンを持って、pocketの「アプリ認証画面」にアクセスする、の部分
  header("Location: https://getpocket.com/auth/authorize?request_token={$query['code']}&redirect_uri={$redirect_uri}");
}
 
//文字化けさせないための最低限のヘッダー
//$header = '<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>';
 
//エラー処理をする関数
function error_pk_syncer($message){
  session_finish_pk_syncer();
  echo $header.$message;
  exit;
}
 
//セッションを終了する関数
function session_finish_pk_syncer(){
  $_SESSION = array();
  session_destroy();
}
 
//GETパラメータ形式の文字列(例：a=b&c=d...)を配列(例：$query['a']=b、$query['c']=d...)に変換する関数
function get_query_syncer($data){
  $ary = explode("&",$data);
  foreach($ary as $items){
    $item = explode("=",$items);
    $query[$item[0]] = $item[1];
  }
  return $query;
}

*/

// --------------------------------------------

//設定項目
$consumer_key = "31858-95baa9432060a9359821b1fe"; //コンシューマーキー
$access_token = "96ffd43b-5a46-33e5-cdcc-62bead"; //アクセストークン
 
//パラメーター
$params = array(
	"state" => "unread", //未読の記事のみ
	"count" => "10", //記事10件
	"sort" => "newest",  //新しい順
	"since" => strtotime( '2013/1/1' ),  //2013/1/1以降
	"detailType" => "complete",  //詳しいデータ
);
 
//パラメーターにコンシューマーキーとアクセストークンを追加
$params = array_merge( $params,array( 
												"consumer_key" => $consumer_key
												,"access_token" => $access_token )
										);
 
//アイテムデータをJSON形式で取得する
$json = @file_get_contents(
	"https://getpocket.com/v3/get"
	, false
	,stream_context_create( 
				array( 
						'http' => array(
									'method' => 'POST'
									, 'content' => http_build_query( $params ) 
							)
					)
		)
);
 
//JSONデータをオブジェクト形式に変換する
$obj = json_decode( $json );
 
//個々のアイテムを出力する
foreach( $obj->list as $item ) {

	//アイテムのID
	$id = $item->item_id;
	
	//アイテムのタイトル
	$title = $item->resolved_title;
	
	//アイテムのURL
	$url = $item->resolved_url;
	
	//お気に入りにしているか？
	$fav = ( $item->favorite == 1 ) ? '★' : '';
	
	//pocketした日付(ついでに整形)
	$date = date( 'Y/m/d H:i', $item->time_added );
	
	//ブラウザに出力
	echo "<p>アイテムID：{$id}<br/><a href=\"{$url}\">{$fav}{$title}</a>({$date}にpocket)</p>";
}


?>