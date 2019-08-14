<?php
	
	require_once('info.php');

	// ---------------------------------------------
	// プルダウンメニューの構築
	// ---------------------------------------------
	function getSelectValue( $n, $val, $label ) {
		if( $n == $val ) {
			return '<option value="'.$val.'" selected>'.$label.'</option>';
		} else {
			return '<option value="'.$val.'">'.$label.'</option>';
		}
	}

	// ---------------------------------------------
	// エピソードの取得
	// ---------------------------------------------
	function get_episode_link( $baseUrl, $lang, $n, $epi, $label ) {

		if( $epi == $_GET['epi'] ) {
//			return '<strong>#'.$epi.'（<a href="'.$baseUrl.'/index.php?n='.$n.'&epi='.$epi.'">'.$label.'</a>）</strong>';
			return '<span class="current_epi">#'.$epi.'（<a href="#page_0">'.$label.'</a>）</span>';
		} else {
			return '#'.$epi.'（<a href="'.$baseUrl.'/index.php?n='.$n.'&epi='.$epi.'&lang='.$lang.'">'.$label.'</a>）';
//			return '#'.$epi.'（<a href="'.$baseUrl.'/'.$lang.'/'.$n.'/'.$epi.'/index.html">'.$label.'</a>）';			
		}
	}

	// ---------------------------------------------
	// 最初のエピソード　No の取得
	// ---------------------------------------------
	function get_first_epi( $lang, $n ) {
		$first_epi = null;
		$keys = array_keys($episodes[$lang][$n]);
		foreach( $keys as $key ) {
				$first_epi[] = $key;
		}
		return $first_epi[0];
	}

	// ---------------------------------------------
	// ボリューム（巻）の表示用文字列の取得
	// ---------------------------------------------
	function get_volume_presentation( $lang, $n ) {
		$temp = $n + 1;
		if( $lang === 'ja' ) {
			return '第'.$temp.'巻';
		} else if( $lang === 'en' ) {
			return 'Val. '.$temp;
		}
	}


	// ---------------------------------------------
	// RSS の表示
	// ---------------------------------------------
	function get_item_list_html( $url, $entity ) {
		$xmlstr = file_get_contents( $url );
		$rss = simplexml_load_string( $xmlstr );
		$feed = $rss->feed;
		$last_updated = $rss->updated;

//		$output .= '<h4>（更新日：'.$last_update.'）</h4>';
		$output .= '<div class="item_list">'."\n";
			foreach ($rss->entry as $entry) {

				$title = $entry->title;
				$summary = $entry->summary;
				$price = $entry->children( "im", true )->price;
				$image = $entry->children( "im", true )->image;
				$release_date = $entry->children( "im", true )->releaseDate;
				$category = $entry->category['label'];

				$output .= '<div style="float:left; margin:0 0 25px 0;">';
				$output .= '<img src="'.$image.'" style="margin:0 10px 0 0" /></div>';

				$output .= '<div class="info">';
				$output .= '（'.$category.'）';
				$output .= '<br>'.$title;
				$output .= '<br>'.$price;
				$output .= ' - <a href="http://dev.ontheroad.jp/tools/apple/itunessearch.php?country=jp&entity='.$entity.'&kw='.str_replace('"', '',$title).'&lstrackingUrl=">タグ生成</a>';
				$output .= '</div>'."\n";
				$output .= '<div style="clear:both"></div>';
			}
		$output .= '</div>'."\n";
		return $output;
	}


?>
