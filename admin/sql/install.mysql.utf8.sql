DROP TABLE IF EXISTS `#__totalsurv_format`;
        
CREATE TABLE `#__totalsurv_format`(
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`code` varchar(11) NOT NULL,
`version` double(11,1) NOT NULL,
`name` varchar(100) NOT NULL,
`comented` char(1) DEFAULT '0',
`published` char(1) DEFAULT '0',
`min_value` int(11) DEFAULT 1,
`max_value` int(11) DEFAULT 5,
`date_create` date NOT NULL,
`text_info_value` varchar(200) NOT NULL,
`enable_send_info` char(1) DEFAULT '0',
`range_low` int(11) NOT NULL,
`range_medium` int(11) NOT NULL,
`range_high` int(11) NOT NULL,
`range_very_high` int(11) NOT NULL,
`order` int(11) DEFAULT 0,
CONSTRAINT PK_FORMAT PRIMARY KEY(`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=UTF8;
