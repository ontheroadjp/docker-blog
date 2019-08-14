<?php
/*
Plugin Name: ex_tt
Plugin URI: http://dev.ontheroad.jp
Description: Extend Twitter Tools Plug-in.
Version: 0.5
Author: （ひ）
Author URI: http://dev.ontheroad.jp
License: GPL2

	Copyright 2012 (H) (email : dev@ontheroad.jp)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('EX_TT_VERSION', '0.5');
define('DEFAULT_DIGEST_POST_TITLE', '(TEST)Tweet ダイジェスト投稿');


function ex_tt_init() {
	global $ex_tt;
	$ex_tt = new ex_tt;
	$ex_tt->ex_tt_get_db_settings();
}
add_action( 'init', 'ex_tt_init' );


class ex_tt {
	function ex_tt() {
		$this->options = array(
			'add_header'
			, 'add_footer'
			, 'add_date'
			, 'add_time'
			, 'add_excerpt'
			, 'header'
			, 'footer'
			, 'excerpt'
			, 'post_status'
		);
		$this->add_header	= '1';
		$this->add_date		= '1';
		$this->add_time		= '1';
		$this->add_footer	= '1';
		$this->add_excerpt	= '1';
		$this->header		= '';
		$this->footer		= '';
		$this->excerpt		= '';
		$this->post_status	= '';

		$this->digest_options = array(
			'from_y'
			, 'from_m'
			, 'from_d'
			, 'to_y'
			, 'to_m'
			, 'to_d'
		);
		$this->from_y		= date('Y');
		$this->from_m		= date('n');
		$this->from_d		= date('j') - 1;
		$this->to_y			= date('Y');
		$this->to_m			= date('n');
		$this->to_d			= date('j') - 1;

		$this->install_date	= '';
		$this->version		= EX_TT_VERSION;
	}

	function ex_tt_upgrade() {
	}

	function ex_tt_get_db_settings(){
		foreach ( $this->options as $option ) {
			$value = get_option( 'ex_tt_'.$option );
			$this->$option = $value;
		}
	}

	function ex_tt_fetch_http_request() {
		foreach ( $this->options as $option ) {
			$value = stripslashes( $_POST[ 'ex_tt_'.$option ] );
			$this->$option = $value;
		}
	}

	function ex_tt_fetch_http_request_for_digest() {
		foreach( $this->digest_options as $option ) {
			$value = stripslashes( $_POST[ 'ex_tt_'.$option ] );
			$this->$option = $value;
		}
	}

	function ex_tt_update_db_settings() {
		if(current_user_can( 'manage_options' ) ) {
			foreach( $this->options as $option ) {
				update_option('ex_tt_'.$option, $this->$option);
			}
			if( empty( $this->install_date ) ) {
				update_option( 'ex_tt_install_date', current_time( 'mysql' ) );
			}
			update_option( 'ex_tt_installed_version', EX_TT_VERSION );
		}
	}
} // end of class ex_tt()


function ex_tt_request_handler() {
	global $ex_tt, $aktt;

	if ( !empty( $_POST[ 'ex_tt_action' ] ) ) {
		switch( $_POST[ 'ex_tt_action' ] ) {
			case 'options_update':

				$ex_tt->ex_tt_fetch_http_request();
				$ex_tt->ex_tt_update_db_settings();

				wp_redirect(admin_url('options-general.php?page=ex_tt/ex_tt.php&updated=true'));

				die();
				break;

			case 'ex_do_digest_post':

				$title = DEFAULT_DIGEST_POST_TITLE;
				$ex_tt->ex_tt_fetch_http_request_for_digest();
				
				$err_input_date = 0;

				if( empty( $ex_tt->from_y ) || !preg_match("/^[0-9]{1,4}$/", $ex_tt->from_y) ) $err_input_date = 1;
				if( empty( $ex_tt->from_m ) || !preg_match("/^[0-9]{1,2}$/", $ex_tt->from_m) ) $err_input_date = 1;
				if( empty( $ex_tt->from_d ) || !preg_match("/^[0-9]{1,2}$/", $ex_tt->from_d) ) $err_input_date = 1;

				if( empty( $ex_tt->to_y ) || !preg_match("/^[0-9]{1,4}$/", $ex_tt->to_y) ) $err_input_date = 1;
				if( empty( $ex_tt->to_m ) || !preg_match("/^[0-9]{1,2}$/", $ex_tt->to_m) ) $err_input_date = 1;
				if( empty( $ex_tt->to_d ) || !preg_match("/^[0-9]{1,2}$/", $ex_tt->to_d) ) $err_input_date = 1;

				//UNIX TIME STAMP で指定： exp. "2012-06-21 00:00:00"
				$start = mktime( 0, 0, 0, $ex_tt->from_m, $ex_tt->from_d, $ex_tt->from_y ) - 60 * 60 * 9;
				$end = mktime( 23, 59, 59, $ex_tt->to_m, $ex_tt->to_d, $ex_tt->to_y ) - 60 * 60 * 9;
				
				if( $start > $end ) $err_input_date = 1;
				
				if( $err_input_date != 1 ) {
					if( $aktt->do_digest_post( $start, $end, $title ) ) {
						wp_redirect( admin_url( 'options-general.php?page=ex_tt/ex_tt.php&do_digest_post=true' ) );
					} else {
						wp_redirect( admin_url( 'options-general.php?page=ex_tt/ex_tt.php&do_digest_post_NG=true' ) );
					}
				} else {
					wp_redirect( admin_url( 'options-general.php?page=ex_tt/ex_tt.php&input_date_error=true' ) );
				}

				die();
				break;

			default:
					wp_redirect( admin_url( 'options-general.php?page=ex_tt/ex_tt.php&dispatch_error=true' ) );

		} // end of CASE();
	} // end of if();
} // end of function ex_tt_request_handler()
add_action( 'admin_init', 'ex_tt_request_handler', 10 );



function ex_tt_plugin_menu() {
	if( current_user_can( 'manage_options' ) ) {
		add_options_page( 'ex TT プラグインの設定', 'ex TT', 8, __FILE__, 'ex_tt_option_form' );
	}
}
add_action( 'admin_menu', 'ex_tt_plugin_menu' );


function ex_tt_option_form() {

	global $ex_tt;

	if( $_GET['updated'] ) {
//		echo '<div id="message" class="updated"><p><strong>設定を保存しました</strong></p></div>';
	}
	if( $_GET['do_digest_post'] ) {
		echo '<div id="message" class="updated"><p><strong>テスト投稿しました</strong></p></div>';
	}
	if( $_GET['do_digest_post_NG'] ) {	
		echo '<div id="message" class="updated"><p><strong>テスト投稿に失敗しました</strong></p></div>';
	} 
	if( $_GET['input_date_error'] ) {
		echo '<div id="message" class="updated"><p><strong>日付を正しく入力してください</strong></p></div>';
	}
	if( $_GET['dispatch_error'] ) {
		echo '<div id="message" class="updated"><p><strong>ディスパッチエラー</strong></p></div>';
	}


?>
	<div class="wrap columns-2">

	<h2>Twitter Tools プラグインの拡張</h2>
	<div id="poststuff" class="metabox-holder has-right-sidebar">

		<!-- サイドバー -->
		<div id="side-info-column" class="inner-sidebar">
			<div id="side-sortables" class="meta-box-sortables">

			<!-- テスト投稿 -->
			<!-- <form name="test_do_digest_post" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>"> -->
				<!-- <input type="hidden" name="is_do_test_digest" value="Y"> -->
			<form name="test_do_digest_post" method="post" action="<?php  echo admin_url( 'options-general.php' ); ?>">
				<input type="hidden" name="ex_tt_action" value="ex_do_digest_post">
				<div class="postbox">
				<h3 class="hndle"><span>テスト投稿</span></h3>
				<div class="inside">

	                <!-- <p>テスト記事タイトル</p> -->
					<!-- <input type="text" name="test_post_title" size="30" maxlength="20"> -->
					<input type="text" name="ex_tt_from_y" size="6" value="<?= $ex_tt->from_y ?>" />年
					<input type="text" name="ex_tt_from_m" size="3" value="<?= $ex_tt->from_m ?>" />月
					<input type="text" name="ex_tt_from_d" size="3" value="<?= $ex_tt->from_d ?>" />日 から<br>

					<input type="text" name="ex_tt_to_y" size="6" value="<?= $ex_tt->to_y ?>" />年
					<input type="text" name="ex_tt_to_m" size="3" value="<?= $ex_tt->to_m ?>" />月
					<input type="text" name="ex_tt_to_d" size="3" value="<?= $ex_tt->to_d ?>" />日 まで
					<input type="submit" name="Submit" class="button-primary" value="テスト投稿" />
					<br class="clear">

				</div><!-- end of .inside -->
				</div><!-- end of .postbox -->
			</form>

			</div><!-- end of #normal-sortables -->
		</div><!-- end #side-info-column -->

		<!-- ボディー -->
		<div id="post-body">
		<div id="post-body-content">
		<div id="normal-sortables" class="meta-box-sortables ui-sortable">

		<!-- <form name="update" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>"> -->
		<!-- <input type="hidden" name="options_update" value="Y"> -->
		<form name="update" method="post" action="<?php echo admin_url( 'options-general.php' ); ?>">
		<input type="hidden" name="ex_tt_action" value="options_update">

			<div class="postbox">
			<h3 class="hndle">ダイジェスト投稿</h3>
			<div class="inside">

				<div id="postexcerpt">
					<p>抜粋</p>
						<?php if( $ex_tt->add_excerpt == 1 ) { ?>
							<input type="checkbox" name="ex_tt_add_excerpt" value="1" checked>抜粋を追加する
						<?php } else { ?>
							<input type="checkbox" name="ex_tt_add_excerpt" value="1">抜粋を追加する
						<?php } ?>
						<textarea name="ex_tt_excerpt" style="height: 15em;"><?php echo $ex_tt->excerpt; ?></textarea>

					<p>ヘッダ</p>
						<?php if( $ex_tt->add_header == 1 ) { ?>
							<input type="checkbox" name="ex_tt_add_header" value="1" checked>ヘッダを追加する
						<?php } else { ?>
							<input type="checkbox" name="ex_tt_add_header" value="1">ヘッダを追加する
						<?php } ?>
						<textarea name="ex_tt_header" style="height: 15em;"><?php echo $ex_tt->header; ?></textarea>

					<p>本文</p>
						<?php if( $ex_tt->add_date == 1 ) { ?>
							<input type="checkbox" name="ex_tt_add_date" value="1" checked>日付を追加する<br>
						<?php } else { ?>
							<input type="checkbox" name="ex_tt_add_date" value="1">日付を追加する<br>
						<?php } ?>

						<?php if( $ex_tt->add_time == 1 ) { ?>
							<input type="checkbox" name="ex_tt_add_time" value="1" checked>時刻を追加する
						<?php } else { ?>
							<input type="checkbox" name="ex_tt_add_time" value="1">時刻を追加する
						<?php } ?>

					<p>フッタ</p>
						<?php if( $ex_tt->add_footer == 1 ) { ?>
							<input type="checkbox" name="ex_tt_add_footer" value="1" checked>フッターを追加する
						<?php } else { ?>
							<input type="checkbox" name="ex_tt_add_footer" value="1">フッターを追加する
						<?php } ?>
						<textarea name="ex_tt_footer" style="height: 15em;"><?php echo $ex_tt->footer; ?></textarea>
				</div>

                <select name="ex_tt_post_status">
				<?php if( $ex_tt->post_status == 'publish' ) { ?>
					<option value="publish" selected>公開状態で投稿</option>
					<option value="draft">下書きとして投稿</option>
				<?php } elseif( $ex_tt->post_status == 'draft' ) { ?>
					<option value="publish">公開状態で投稿</option>
					<option value="draft" selected>下書きとして投稿</option>
				<?php } else { ?>
					<option value="publish">公開状態で投稿</option>
					<option value="draft">下書きとして投稿</option>
				<?php } ?>
				</select>

			<p class="submit"><input class="button-primary" type="submit" name="Submit" value="Twitter Tools プラグインの拡張設定を保存する" /></p>

			</div><!-- end of .inside -->
			</div><!-- end of .postbox -->

        </form>

		</div><!-- end of #normal-sortables -->
		</div><!-- end of #post-body-content -->
		</div><!-- end of #post-body -->
		<br class="clear">
	
	</div><!-- #poststuff -->
	</div><!-- wrap columns-2 -->

<?php } // end:function option_page()


// ----------------------------------------------------
// The filter on Twitter Tools
// ----------------------------------------------------
function ex_tweets_to_digest_post($tweets_to_post) {

	global $ex_tt;

	if( $ex_tt->add_date == 1 ) {

		$temp_ttp = $tweets_to_post;
		$current = get_date_from_gmt( $temp_ttp[0]->tw_created_at, "d" );
		$offset = 0;


		// Tweet の間に日付挿入
		for( $n=0; $n<count( $temp_ttp ); $n++ ) {
			$next = get_date_from_gmt( $temp_ttp[$n+1]->tw_created_at, "d" );

			if( $current != $next && $n+1<count($temp_ttp) ) {
				$new_tweet = new aktt_tweet;
				$new_tweet->tw_text = 'DATE_VIEW_<h3>'.get_date_from_gmt( $temp_ttp[$n+1]->tw_created_at, 'Y年m月d日（'.get_day_of_the_week($temp_ttp[$n+1]).'）').'</h3>';

				array_splice( $tweets_to_post, $n+1+$offset, 0, array( $new_tweet ) );

				$current = $next;
				$offset++;
			}
		}

		// Tweet の先頭に日付挿入
		$new_tweet = new aktt_tweet;
		$new_tweet->tw_text = 'DATE_VIEW_<h3>'.get_date_from_gmt( $tweets_to_post[0]->tw_created_at, 'Y年m月d日（'.get_day_of_the_week($temp_ttp[$n+1]).'）' ).'</h3>';
		array_unshift($tweets_to_post, $new_tweet );
	}

	return $tweets_to_post;
}
add_filter( 'aktt_tweets_to_digest_post', 'ex_tweets_to_digest_post' );


function get_day_of_the_week($tweet) {
	$day_of_the_week = array('日','月','火','水','木','金','土');
	return $day_of_the_week[get_date_from_gmt( $tweet->tw_created_at, 'w')];
}


// ----------------------------------------------------
// The filter on Twitter Tools
// ----------------------------------------------------
function ex_digest_post_data( $post_data ) {

	global $ex_tt;

	$content = $post_data['post_content'];

	if( $ex_tt->add_header == 1 ) {
		$post_data['post_content'] = get_option('ex_tt_header')."\n".$content;
		$content = $post_data['post_content'];
	}
	if( $ex_tt->add_footer == 1 ) {
		$post_data['post_content'] = $content."\n".get_option('ex_tt_footer');
	}
	if( $ex_tt->add_excerpt == 1 ) {
		$post_data['post_excerpt']	= get_option('ex_tt_excerpt');
	}

	$post_data['post_status'] = $ex_tt->post_status;
	$post_data['post_date'] = date();

//		$post_data['post_date'] = gmdate("Y-m-d H:i:s", get_option('aktt_next_daily_digest'));
//		$temp = $post_data['post_date'];
//		$post_data['post_date'] = $temp + 60 * 60 * 8;

    return $post_data;
}
add_filter( 'aktt_digest_post_data', 'ex_digest_post_data' );


// ----------------------------------------------------
// The filter on Twitter Tools
// ----------------------------------------------------
function ex_tweet_display( $output, $tweet ) {

	global $ex_tt;

	if( stristr( $tweet->tw_text, 'DATE_VIEW_' ) ) {
		$output = '<span class="ex_tt_tweets_date">'.str_replace( 'DATE_VIEW_', '', $tweet->tw_text ).'</span>';
	} else if( $ex_tt->add_time == 1 ) {
		$temp = $output;
		$output = '<span class="ex_tt_tweets">'.get_date_from_gmt($tweet->tw_created_at, 'H:i').'</span> '.$temp;
//		$output = '<span class="ex_tt_tweets">'.get_date_from_gmt($tweet->tw_created_at, 'Y/m/d H:i').'</span> '.$temp;
	}

	return $output;
}
add_filter( 'aktt_tweet_display', 'ex_tweet_display', 10, 2 );


?>