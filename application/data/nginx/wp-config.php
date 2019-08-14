<?php
if( $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ){
    define('FORCE_SSL_ADMIN', true);
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}


/**

 * The base configurations of the WordPress.

 *

 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、言語、ABSPATH の設定を含みます。

 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86

 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。

 *

 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。

 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を

 * 入力してもかまいません。

 *

 * @package WordPress

 */



// 注意:

// Windows の "メモ帳" でこのファイルを編集しないでください !

// 問題なく使えるテキストエディタ

// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)

// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。



// ** MySQL 設定 - こちらの情報はホスティング先から入手してください。 ** //

/** WordPress のためのデータベース名 */



define('DB_NAME', 'toybox_wordpress');



/** MySQL データベースのユーザー名 */

define('DB_USER', 'toybox');



/** MySQL データベースのパスワード */

define('DB_PASSWORD', 'toybox');



/** MySQL のホスト名 */

define('DB_HOST', 'mysql');



/** データベースのテーブルを作成する際のデータベースのキャラクターセット */

define('DB_CHARSET', 'utf8');



/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */

define('DB_COLLATE', '');



/**#@+

 * 認証用ユニークキー

 *

 * それぞれを異なるユニーク (一意) な文字列に変更してください。

 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。

 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。

 *

 * @since 2.6.0

 */

define('AUTH_KEY',         ']i(tiKpUa0-p!4@%P)ARt]ycct.e8Se}/~|?#?4Aiy4FRO+s(2J((+4: K>}JF 5');

define('SECURE_AUTH_KEY',  '0G(T?>SGN7:P<{bh~ToFL?yQS)aH($opP_ 5lQdmB6+tN-A/=L{EjjOW/!??k+6I');

define('LOGGED_IN_KEY',    'xUvPv}bdbnFy8B>a?swZ[0-wK4mKH1Bo|J.g,s8=kCFwnt4:$s@M-Zwc|LooMXE2');

define('NONCE_KEY',        '^G>b+Tej#_a-TRm_.rZlVL^_nJD%z`PG^M?-tl?3b!@+O*;FZctq=xCSZ]@#$Q)i');

define('AUTH_SALT',        'CZGZmT-sUgAZ`!s5LNX*RMjaQ8HlVGh;#^aL~4r7#})ZHVAnHkt%7{w^!7:/vmu|');

define('SECURE_AUTH_SALT', 'CvZM@,jAJ!z|S=3zzze+pZeBgxp-,bI~ 3;a.:],QvTa(R$_<Tuva$?Y}|+&c|eB');

define('LOGGED_IN_SALT',   '!H.Y0shneg^G_,-hap#ikr48=A$pK&|6;QWCj|/1hps2>]Y-;FZ)AUlr^{qjd2],');

define('NONCE_SALT',       '3:|qxBB.}1}Wo$nNlT0=75q@Ct~mqkSlNjCWTwRW*AuII-g-FC v`Oj2]x+Di<JO');



/**#@-*/



/**

 * WordPress データベーステーブルの接頭辞

 *

 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を

 * インストールすることができます。半角英数字と下線のみを使用してください。

 */

$table_prefix  = 'wp_dev_';



/**

 * ローカル言語 - このパッケージでは初期値として 'ja' (日本語 UTF-8) が設定されています。

 *

 * WordPress のローカル言語を設定します。設定した言語に対応する MO ファイルが

 * wp-content/languages にインストールされている必要があります。例えば de_DE.mo を

 * wp-content/languages にインストールし WPLANG を 'de_DE' に設定することでドイツ語がサポートされます。

 */

define('WPLANG', 'ja');



/**

 * 開発者へ: WordPress デバッグモード

 *

 * この値を true にすると、開発中に注意 (notice) を表示します。

 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。

 */

define('WP_DEBUG', false);



/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */



/** Absolute path to the WordPress directory. */

if ( !defined('ABSPATH') )

	define('ABSPATH', dirname(__FILE__) . '/');



/** Sets up WordPress vars and included files. */

require_once(ABSPATH . 'wp-settings.php');

