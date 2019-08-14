
<?php
/*
	// 初期設定
	if ( isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on' ) {
	    $protocol = 'https://';  
	} else {
	    $protocol = 'http://';  
	}
	$selfUrl	= $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	// 例：http://dev.ontheroad.jp/special/blackjack/index.php?n=0&epi=5&lang=ja
	// アンカー（#）は取れない

	$baseUrl	= str_replace( '/index.php', '', $protocol.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'] );
	// 例：http://dev.ontheroad.jp/special/blackjack

	$rootUrl	= $protocol.$_SERVER['HTTP_HOST'];
	// 例：http://dev.ontheroad.jp

	$contentsUrl	= $rootUrl.'/special/blackjack/contents';

	// パラメーターの取得
	$lang	= $_GET['lang'];
	$n 		= $_GET['n'];
	$epi	= $_GET['epi'];

	if( !isset( $lang ) || $lang == '' || $lang <> 'ja' && $lang <> 'en' ) {
		$lang = 'ja';
	}

	if( $n <> '' && $epi == '' ) {
		$epi = key( $episodes[$lang][$n] );
		$_GET['epi'] = $epi;
	}


	if( !isset($n) ) {
		$mode = "HOME";
	} else {
		$mode = "CONTENT";
	}
*/


	$comic_title		= array(
		'ja' => 'ブラックジャックによろしく'
		, 'en' => 'Give My Regards to Black Jack'
	);

	$sitename			= array(
		'ja' => '漫画「'.$comic_title["ja"].'」全13巻（127話）無料配信中！'
		, 'en' => 'JAPANESE MANGA "'.$comic_title['en'].'" ALL FREE!!'
	);

	$sitedescription	= array(
		'ja' => '1,400万部を売り上げた名作「'.$comic_title["ja"].'」を無料で全巻読むことができます。'
		, 'en' => 'Free! JAPANESE MANGA「'.$comic_title['en'].'」All 13 Titles（127 Episods）Free!'
	);

	$site_keywords		= array(
		'ja' => 'ブラックジャックによろしく, ブラよろ, 全巻, 無料, 配信, 漫画, マンガ'
		, 'en' => 'Give My Regards to Black Jack, manga, comic, japanrse manga, japanese comic'
	);

	$episodes = array(
		'ja' => array()
		, 'en' => array()
	);

	$episodes['ja'][0] = array(
		"1" => "研修医の夜"
		, "2" => "ウナギとゴッドハンド"
		, "3" => "75才の値段"
		, "4" => "夏雲"
		, "5" => "外科と内科と医局と斎藤"
		, "6" => "最初のウソ"
		, "7" => "一流のワナ"
	);

	$episodes['ja'][1] = array(
		"8" => "告白"
		, "9" => "北　三郎"
		, "10" => "最後の一滴"
		, "11" => "無法の塔"
		, "12" => "弁明"
		, "13" => "執刀医"
		, "14" => "信頼"
		, "15" => "身勝手"
		, "16" => "笑顔"
	);

	$episodes['ja'][2] = array(
		"17" => "代償"
		, "18" => "馬鹿と貧乏人"
		, "19" => "徳ちゃんと先生"
		, "20" => "町の医者、という仕事"
		, "21" => "新しい研修先"
		, "22" => "戦場の生"
		, "23" => "父親と母親"
		, "24" => "不妊治療"
		, "25" => "医師・高砂"
		, "26" => "予想と結果"
	);

	$episodes['ja'][3] = array(
		"27" => "告知"
		, "28" => "共犯者たち"
		, "29" => "力なき者たち"
		, "30" => "正義を手にして"
		, "31" => "見守る者"
		, "32" => "矛盾の積み木"
		, "33" => "すべてに背いて"
		, "34" => "迷子の大人たち"
		, "35" => "反逆はいつも一人"
		, "36" => "クソッタレ"
		, "37" => "夕日"
	);

	$episodes['ja'][4] = array(
		"38" => "貴重な休日の使い方"
		, "39" => "小児科の算数"
		, "40" => "大人になるには"
		, "41" => "普通の医者"
		, "42" => "しがみつきたい"
		, "43" => "嫌らわれ者、人気者"
		, "44" => "ありふれた病気、がん"
		, "45" => "告知のセオリー"
		, "46" => "笑顔の裏側"
		, "47" => "手術は、成功です"
		, "48" => "どこにでもある風景"
	);

	$episodes['ja'][5] = array(
		"49" => "正常な反応"
		, "50" => "日本で一番の薬"
		, "51" => "当然の成り行き"
		, "52" => "薄れていく感覚"
		, "53" => "医者のお仕事"
		, "54" => "もう一人の斎藤"
		, "55" => "最初の患者"
		, "56" => "本当の望みは何だ！？"
		, "57" => "見落とされるもの"
		, "58" => "二人称、三人称"
	);

	$episodes['ja'][6] = array(
		"59" => "プロポーズ"
		, "60" => "分かれ道"
		, "61" => "ご家族の方は、こちらへ"
		, "62" => "青年は荒野を行く"
		, "63" => "だましちゃいけない！"
		, "64" => "交渉"
		, "65" => "真実の告知"
		, "66" => "正直さの代償"
		, "67" => "この輝ける世界"
		, "68" => "いい加減にして"
	);

	$episodes['ja'][7] = array(
		"69" => "答えを下さい"
		, "70" => "死神に生を説く"
		, "71" => "進み出した時間"
		, "72" => "誰もしない「仕事」"
		, "73" => "あなたが教えてくれた事"
		, "74" => "普通の最期"
		, "75" => "命果てる日まで"
		, "76" => "大きな樹の下で"
		, "77" => "約束"
		, "78" => "心のすべて"
		, "79" => "若者たち"
	);

	$episodes['ja'][8] = array(
		"80" => "密約の始まり"
		, "81" => "宣戦布告"
		, "82" => "脱出！"
		, "83" => "待った女、待つ男"
		, "84" => "罪状「無意識」"
		, "85" => "無駄だよ、耳をふさいでも"
		, "86" => "スイッチオン"
		, "87" => "汚名"
		, "88" => "ごくありがちな主張"
		, "89" => "新聞の作法"
		, "90" => "商売と理想"
	);

	$episodes['ja'][9] = array(
		"91" => "ネバーランドじゃない"
		, "92" => "となりのヒーロー"
		, "93" => "粘土製の希望"
		, "94" => "恋にすべてを"
		, "95" => "雪の日の出来事"
		, "96" => "知られざること、見たくないもの"
		, "97" => "新聞の作り方"
		, "98" => "止まらない、止められない"
		, "99" => "差別の生まれるところ"
		, "100" => "1億2千万分の1の反論"
	);

	$episodes['ja'][10] = array(
		"101" => "飲むか飲まざるか"
		, "102" => "そして患者は作られる"
		, "103" => "新聞の需要と供給"
		, "104" => "怖いけど、怖くない"
		, "105" => "ピーターパンを待ちながら"
		, "106" => "今ここにいる理由"
		, "107" => "未来は、檻の中に"
		, "108" => "無抵抗という抵抗"
		, "109" => "僕と彼女と居場所"
	);

	$episodes['ja'][11] = array(
		"110" => "もう、妖精は来ない"
		, "111" => "約束の場所"
		, "112" => "退院の日"
		, "113" => "拒絶する世界"
		, "114" => "月夜"
		, "115" => "自殺者の本音"
		, "116" => "報道のデクレッシェンド"
		, "117" => "暴挙だとしても"
		, "118" => "母と恋人"
	);

	$episodes['ja'][12] = array(
		"119" => "疲れた大人"
		, "120" => "プレゼンテーション"
		, "121" => "点火"
		, "122" => "ただ我を知る"
		, "123" => "受容の時"
		, "124" => "屋上の戦士"
		, "125" => "ピーターの帰還"
		, "126" => "生きていたい"
		, "127" => "坂道を登る"
	);


/* ---------------------------------------- */

	$episodes['en'][0] = array(
		"1" => "Night of the Intern"
		, "2" => "Eels and Godhands"
		, "3" => "The Price of Being 75"
		, "4" => "Summer Clouds"
		, "5" => "Surgery, Internists, Departments, and Saito"
		, "6" => "The First Lie"
		, "7" => "The Top-Tier Trap"
	);

	$episodes['en'][1] = array(
		"8" => "The Confession"
		, "9" => "Saburo Kita"
		, "10" => "Tha Last Drop"
		, "11" => "The Tower of Anarchy"
		, "12" => "Justification"
		, "13" => "Surgery"
		, "14" => "Trust"
		, "15" => "Self-Centered"
		, "16" => "That Smile"
	);

	$episodes['en'][2] = array(
		"17" => "Restitution"
		, "18" => "The Fool and The Poor Man"
		, "19" => "Toku and The Doctor"
		, "20" => "Work as a Local"
		, "21" => "Change of Pace"
		, "22" => "Birth of a Battleground"
		, "23" => "Father and Mother"
		, "24" => "Fertility Treatments"
		, "25" => "Doctor Takasago"
		, "26" => "Prediction and Results"
	);

	$episodes['en'][3] = array(
		"27" => "The Announcement"
		, "28" => "Accomplices"
		, "29" => "The Powerless"
		, "30" => "Justice Won"
		, "31" => "The Protectors"
		, "32" => "Contradiction upon Contradiction"
		, "33" => "Defiance Definance"
		, "34" => "Little Lost Grownups"
		, "35" => "It Starts with One"
		, "36" => "Son of a Bitch"
		, "37" => "Sunset"
	);

	$episodes['en'][4] = array(
		"38" => "Spending a Precious Day"
		, "39" => "Pediarithmetic"
		, "40" => "Becoming a Grown-up"
		, "41" => "An ordinary Doctor"
		, "42" => "Clinging to Hope"
		, "43" => "The Despised and The Beloved"
		, "44" => "Cancer, Cancer Everywhere"
		, "45" => "Disclosure Theory"
		, "46" => "Behind the Smile"
		, "47" => "The Operation Was a Success"
		, "48" => "An All-Too-Familiar Scene"
	);

	$episodes['en'][5] = array(
		"49" => "Normal Response"
		, "50" => "Japan's No.1 Drug"
		, "51" => "The Inevitable Outcome"
		, "52" => "Weakening Sensation"
		, "53" => "A Doctor's Job"
		, "54" => "The other Saito"
		, "55" => "The First Patient"
		, "56" => "What Do You Really Want?"
		, "57" => "Something Overlooked"
		, "58" => "Second-Person, Third-Person"
	);

	$episodes['en'][6] = array(
		"59" => "The Proposal"
		, "60" => "Two Roads Diverged"
		, "61" => "Family? Right This Way"
		, "62" => "To The Wilderness"
		, "63" => "Fool Me Twice"
		, "64" => "Negotiations"
		, "65" => "Telling The Truth"
		, "66" => "The Price of Honesty"
		, "67" => "This Shining World"
		, "68" => "Enough's Enough"
	);

	$episodes['en'][7] = array(
		"69" => "Give Me an Answer"
		, "70" => "Explaining Life To The Reaper"
		, "71" => "Time Moves Forward"
		, "72" => "Nobody's Work"
		, "73" => "What You Taught Me"
		, "74" => "A Normal Death"
		, "75" => "Until The Day I Die"
		, "76" => "Beneath The Great Tree"
		, "77" => "A Promise"
		, "78" => "My Whole Heart"
		, "79" => "The Young Ones"
	);

	$episodes['en'][8] = array(
		"80" => "The Secret Agreement"
		, "81" => "Declaration Of War"
		, "82" => "Escape!"
		, "83" => "Woman Wantted, Waiting Man"
		, "84" => "The Involuntary Crime"
		, "85" => "Cover Your Ears All You Like"
		, "86" => "Switched On"
		, "87" => "Stigma"
		, "88" => "A Likely Story"
		, "89" => "Media Manners"
		, "90" => "Deals And Ideals"
	);

	$episodes['en'][9] = array(
		"91" => "This Is No Neverland"
		, "92" => "The Hero Next Door"
		, "93" => "Dreams Of Clay"
		, "94" => "Everything For Love"
		, "95" => "Snow Day Event"
		, "96" => "The Unknown, Better Left Unseen"
		, "97" => "How To Make a Newspaper"
		, "98" => "Not Stopping, Unstoppable"
		, "99" => "Where Discrimination Is Born"
		, "100" => "One In 120 Million"
	);

	$episodes['en'][10] = array(
		"101" => "To Drink Or Not To Drink"
		, "102" => "Thus A Patient Is Made"
		, "103" => "Newspaper Supply And Demand"
		, "104" => "Afraid, Yet Unafraid"
		, "105" => "Waiting For Peter Pan"
		, "106" => "The Reason You Are Here"
		, "107" => "A Future In Captivity"
		, "108" => "The Resistance Of NonResistance"
		, "109" => "A Place for Me and My Girl"
	);

	$episodes['en'][11] = array(
		"110" => "Farewell To The Fairies"
		, "111" => "The Promised Land"
		, "112" => "Independence Day"
		, "113" => "World Of Rejection"
		, "114" => "Moonlit Night"
		, "115" => "The Suicide's True Intent"
		, "116" => "Media Decrescendo"
		, "117" => "Even If By Violence"
		, "118" => "Mothers And Lovers"
	);

	$episodes['en'][12] = array(
		"119" => "Exhausted Adults"
		, "120" => "Presentation"
		, "121" => "Ignittion"
		, "122" => "Know Thyself"
		, "123" => "A Time For Acceptance"
		, "124" => "Rooftop Warriors"
		, "125" => "Peter Returns"
		, "126" => "I Want To Love"
		, "127" => "Climbing The Hill"
	);


?>
