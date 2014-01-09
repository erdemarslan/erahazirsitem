# Host: localhost  (Version: 5.1.44-community)
# Date: 2014-01-09 23:23:23
# Generator: MySQL-Front 5.3  (Build 4.75)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "galleries"
#

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` bigint(20) DEFAULT '0',
  `album_name` varchar(255) DEFAULT NULL,
  `album_date` bigint(20) DEFAULT '0',
  `album_desc` longtext,
  `album_cover` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "galleries"
#


#
# Structure for table "gallery_photos"
#

CREATE TABLE `gallery_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` bigint(20) DEFAULT '0',
  `photo_id` bigint(20) DEFAULT '0',
  `photo_url` longtext,
  `photo_thumb` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "gallery_photos"
#


#
# Structure for table "guestbook"
#

CREATE TABLE `guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `date` bigint(20) DEFAULT NULL,
  `webpage` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `photo` longtext,
  `message` longtext,
  `user_agent` varchar(255) DEFAULT NULL,
  `active` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "guestbook"
#


#
# Structure for table "menus"
#

CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `align` tinyint(3) DEFAULT '99',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

#
# Data for table "menus"
#

INSERT INTO `menus` VALUES (1,'Ziyaretçi Defteri','guestbook','_self',9),(2,'Fotoğraf Galerisi','gallery','_self',7),(3,'İletişim','contact','_self',10),(12,'Videolar','video/page/1','_self',8),(15,'Test Sayfası','page/1/Test-Sayfasi.html','_self',99);

#
# Structure for table "news"
#

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` tinyint(3) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `date` bigint(20) DEFAULT '0',
  `picture` varchar(255) DEFAULT NULL,
  `news_intro` longtext,
  `news_content` longtext,
  `hit` int(11) DEFAULT '0',
  `active` tinyint(3) DEFAULT '0',
  `news_writer` varchar(255) DEFAULT NULL,
  `news_writer_facebookid` bigint(20) DEFAULT '0',
  `news_writer_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "news"
#

INSERT INTO `news` VALUES (1,1,'Sitemiz yeniden yayına başladı!',1389301737,'news_image_1.jpg','Web sitemiz yeniden yayına başladı. Halen deneme aşamasında olan sitemiz, sizlerin yardımıyla gelişecektir.<br /><br />Sitede gördüğünüz hataları bizlere mail yoluyla veya ziyaretçi defteri üzerinden belirtirseniz memnun oluruz. Sitemiz halen deneme aşamasında olduğundan eksikleri mutlaka ortaya çıkacaktır.<br /><br /> Mevcut eksiklikleri bizlere ayrıntılı olarak belirtirseniz, çözmemiz daha kolay olacaktır.<br /><br /> Saygılarımızla.<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />','Web sitemiz yeniden yayına başladı. Halen deneme aşamasında olan sitemiz, sizlerin yardımıyla gelişecektir.<br /><br />Sitede gördüğünüz hataları bizlere mail yoluyla veya ziyaretçi defteri üzerinden belirtirseniz memnun oluruz. Sitemiz halen deneme aşamasında olduğundan eksikleri mutlaka ortaya çıkacaktır.<br /><br /> Mevcut eksiklikleri bizlere ayrıntılı olarak belirtirseniz, çözmemiz daha kolay olacaktır.<br /><br /> Saygılarımızla.<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />',2,1,'admin',0,''),(37,2,'Deneme Duyurusu',1389301763,'news_image_2.jpg','Bu bir duyuru metnidir.','Bu bir duyuru metnidir.<br /><br />',2,1,'admin',0,'');

#
# Structure for table "news_category"
#

CREATE TABLE `news_category` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `is_notice` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Data for table "news_category"
#

INSERT INTO `news_category` VALUES (1,'Güncel',0),(2,'Duyurular',1),(3,'Köşe Yazıları',0),(4,'Yeni Doğan',0),(5,'Evlilik',0),(6,'Vefat',0),(9,'Güncel',0);

#
# Structure for table "newsletter"
#

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emails` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "newsletter"
#


#
# Structure for table "pages"
#

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) DEFAULT NULL,
  `page_content` longtext,
  `page_hit` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "pages"
#

INSERT INTO `pages` VALUES (1,'Test Sayfası','<div id=\"lipsum\">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eros massa, suscipit eget tincidunt at, feugiat id ipsum. Nam neque enim, varius vel purus nec, porta ultrices neque. Phasellus at tortor a orci sagittis aliquam vel a arcu. Vivamus sed sem lacus. Donec cursus vel erat ut rhoncus. Praesent libero dolor, blandit porttitor urna vitae, aliquet adipiscing quam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam erat volutpat. Suspendisse vitae vulputate ipsum. Aliquam lacinia dapibus tortor at feugiat. Proin aliquam et nisl porta tristique. Nam id felis sit amet erat viverra imperdiet. Sed feugiat dignissim purus ut condimentum.</p>\r\n<p>Maecenas pellentesque, lectus vel tristique convallis, tellus tortor consequat nisl, vel porta velit eros in tellus. Phasellus aliquam magna id nunc placerat, sit amet cursus ante gravida. Sed at egestas justo. Praesent fermentum metus vulputate, lacinia elit sed, tincidunt felis. Donec elementum magna a interdum faucibus. Fusce nec posuere ante, eget feugiat sapien. Ut ornare risus eget elit semper, sit amet cursus nulla vehicula. Etiam tristique sodales odio ut dictum. Vestibulum rutrum porta justo id molestie. Duis volutpat, ante sed scelerisque auctor, elit elit luctus est, sit amet ultrices est tellus ac risus. Phasellus et dictum mi. Duis vel fringilla diam, porttitor faucibus nibh. Donec ullamcorper dapibus mi, nec facilisis diam aliquet ac. Nam sit amet adipiscing lectus.</p>\r\n<p>Proin malesuada, sapien at bibendum blandit, felis est condimentum ligula, a congue lacus magna in sapien. Pellentesque pellentesque egestas velit iaculis porta. Suspendisse porttitor posuere pellentesque. Sed neque elit, rutrum eget dapibus sed, molestie ac felis. Donec vulputate diam id ligula aliquet condimentum. Mauris vitae molestie diam. Etiam sed erat euismod, venenatis nisi eget, scelerisque erat. Phasellus varius nibh nulla, accumsan interdum dolor consectetur a. Donec placerat in risus auctor cursus. Suspendisse venenatis, mauris rhoncus commodo mattis, tellus augue porttitor lacus, nec cursus arcu nisi id libero. Duis faucibus nibh felis, id luctus nunc iaculis ut. Aliquam velit lacus, tincidunt sed neque sed, facilisis aliquam urna. Praesent non scelerisque sem, nec vehicula ipsum. Nullam venenatis risus et posuere pulvinar.</p>\r\n<p>Curabitur ornare ligula nibh, fringilla scelerisque lacus aliquet vel. Vestibulum eget felis quis turpis interdum tincidunt. Fusce imperdiet eget lorem non venenatis. In luctus et tortor ac placerat. Aenean dignissim quam nec lectus varius, non commodo mauris pulvinar. Proin cursus ut felis adipiscing suscipit. Nullam consectetur mollis lacus eu convallis.</p>\r\n<p>Nunc in convallis ligula. Nulla egestas eget leo eu luctus. Donec et sem sit amet neque iaculis dictum. Nunc ultrices quam eget dui congue, vel hendrerit quam volutpat. Vestibulum vitae massa scelerisque, volutpat magna sed, porttitor nibh. Morbi varius, diam sed placerat sollicitudin, nulla urna egestas ante, id porta magna arcu eu eros. Suspendisse consequat, risus in porta bibendum, velit erat aliquet purus, vitae aliquet tortor justo ac ante. Vivamus eleifend ultrices magna, congue consequat neque convallis eget. Integer vehicula neque dui, non ullamcorper lacus varius pretium. Ut leo felis, sagittis at lorem vitae, dignissim fringilla sem. Nam id massa nec nibh varius tristique. Etiam et tellus eleifend magna varius vulputate. Donec vitae massa at odio dictum tempus. Nunc dapibus justo vitae turpis feugiat accumsan. Aenean sapien ipsum, malesuada a hendrerit faucibus, rutrum quis velit.</p>\r\n</div>\r\n<div id=\"generated\">5 paragraf, 521 sözcük, 3563 karakter <a title=\"Lorem Ipsum\" href=\"http://tr.lipsum.com/\">Lorem Ipsum</a> üretilmiştir</div>',2);

#
# Structure for table "settings"
#

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) DEFAULT NULL,
  `setting_value` longtext,
  `is_array` tinyint(3) DEFAULT '0',
  `module` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

#
# Data for table "settings"
#

INSERT INTO `settings` VALUES (1,'site_title','Era Hazır Sitem v.2',0,'general'),(2,'site_desc','Era Hazır Sitem v.2 tanıtım sitesidir.',0,'general'),(3,'site_keywords','era, hazır, sitem',0,'general'),(4,'site_slogan','Era Hazır Sitem',0,'general'),(5,'site_copyright','Tüm hakları saklıdır',0,'general'),(6,'site_contact_mail','iletisim@sitenizinadi.com',0,'general'),(7,'current_theme','default',0,'general'),(8,'theme_logo','http://www.test.e/themes/default/images/logo.jpg',0,'general'),(9,'admin_username','admin',0,'general'),(10,'admin_password','90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad',0,'general'),(11,'admin_version','v.2.0',0,'general'),(12,'gmail_smtp_user','',0,'gmail'),(13,'gmail_smtp_pass','',0,'gmail'),(14,'site_facebook_appid','',0,'facebook'),(15,'site_facebook_secret','',0,'facebook'),(16,'gallery_facebook_appid','',0,'facebook'),(17,'gallery_facebook_secret','',0,'facebook'),(18,'prayer_active','1',0,'widget'),(19,'prayer_country','TURKIYE',0,'widget'),(20,'prayer_location','CANAKKALE',0,'widget'),(21,'weather_active','1',0,'widget'),(22,'weather_location','TUXX0037',0,'widget');

#
# Structure for table "stat_blacklist"
#

CREATE TABLE `stat_blacklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) DEFAULT NULL,
  `time` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

#
# Data for table "stat_blacklist"
#

INSERT INTO `stat_blacklist` VALUES (2,'85.234.20.141',0),(3,'95.79.72.168',0),(5,'193.107.16.152',0),(6,'94.23.63.212',0),(7,'220.255.2.109',0),(9,'91.237.249.67',0),(10,'173.192.34.95',0),(11,'216.59.22.16',0),(12,'175.42.86.159',0),(13,'188.143.233.196',0),(14,'91.124.74.34',0),(15,'199.15.234.226',0),(16,'109.254.6.14',0),(17,'95.79.174.18',0),(18,'85.234.20.126',0),(19,'188.143.232.198',0),(20,'194.44.89.49',0),(21,'37.112.70.234',0),(22,'176.8.247.229',0),(25,'188.143.233.164',0),(26,'109.205.112.86',0),(28,'41.201.84.116',0),(29,'146.0.74.210',0),(30,'94.23.225.68',0),(31,'180.153.236.59',0),(32,'221.12.154.18',0),(33,'176.9.139.112',0),(34,'77.78.109.73',0),(35,'176.31.122.179',0),(36,'91.207.5.66',0),(37,'46.0.185.76',0),(38,'188.143.234.21',0),(39,'87.98.182.14',0);

#
# Structure for table "stat_crawlers"
#

CREATE TABLE `stat_crawlers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sess_id` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `time` bigint(20) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "stat_crawlers"
#


#
# Structure for table "stat_online"
#

CREATE TABLE `stat_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sess_id` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `time` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# Structure for table "stat_users"
#

CREATE TABLE `stat_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sess_id` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `time` bigint(20) DEFAULT '0',
  `country` varchar(255) DEFAULT NULL,
  `isp` varchar(255) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `pc_mobile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "stat_users"
#

INSERT INTO `stat_users` VALUES (1,'d743be96a291d3c1c1a25183ef2535c1','127.0.0.1',1389298151,'Türkiye','Belirlenemedi','http://envato.erdemarslan.com/codecanyon/vcounter/img/flags/tr.gif','unknown','Default Browser','0.0','PC');

#
# Structure for table "users"
#

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facebook_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birtday` bigint(20) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `visible` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "users"
#


#
# Structure for table "videos"
#

CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` varchar(255) DEFAULT NULL,
  `video_title` varchar(255) DEFAULT NULL,
  `video_desc` longtext,
  `video_thumb` varchar(255) DEFAULT NULL,
  `video_length` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "videos"
#

