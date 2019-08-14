
DROP TABLE IF EXISTS rss_feeds;
DROP TABLE IF EXISTS rss_articles;

CREATE TABLE rss_feeds (
	rss_feed_id MEDIUMINT NOT NULL AUTO_INCREMENT,
	url TEXT NOT NULL,
	name TEXT NOT NULL,
	last_update TIMESTAMP NOT NULL,
	PRIMARY KEY ( rss_feed_id )
);

CREATE TABLE rss_articles (
	rss_feed_id MEDIUMINT NOT NULL,
	link TEXT NOT NULL,
	title TEXT NOT NULL,
	description TEXT NOT NULL,
	post_time TIMESTAMP NOT NULL
);

INSERT INTO rss_feeds( 
				url,
				name,
				last_update
			) VALUES (
				"http://rss.dailynews.yahoo.co.jp/fc/rss.xml", 
				"Yahoo!ニュース・トピックス - トップ", 
				""
			);


