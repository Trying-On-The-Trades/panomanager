CREATE TABLE `wp_pano_terms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `word` char(50) NOT NULL,
  `hint` varchar(225) NOT NULL,
  `trade_id` int(11),
  PRIMARY KEY (`id`),
  FOREIGN KEY (trades_id) REFERENCES wp_pano_trade_type(id)
 )ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `wp_pano_trade_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `profession` char(30) NOT NULL,
  PRIMARY KEY(`id`)
  )ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `wp_pano_trade_type` (`id`, `image`, `profession`)
VALUES
	(1, '/images/hair_style.png', 'Hairstyler');

INSERT INTO `wp_pano_terms` (`id`, `word`, `hint`, `trade_id`)
VALUES
    (1,'bangs','a fringe in your hair', 1),
    (2,'dreadlocks','twisted lengths of hair that hang down to someone’s shoulders, worn especially by Rastafarians', 1),
    (3,'haircut','the style that your hair has been cut in', 1),
    (4,'mullet','a style of hair that is long at the back and short at the front and sides', 1),
    (7,'pageboy','a fairly short hairstyle for women in which the ends of the hair are turned under', 1),
    (6,'ponytail','long hair that is tied at the back of the head and hangs down', 1);