#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	bullets_type tinyint(3) unsigned DEFAULT '0' NOT NULL,
	table_caption varchar(255) DEFAULT NULL,
	table_delimiter smallint(6) unsigned DEFAULT '0' NOT NULL,
	table_enclosure smallint(6) unsigned DEFAULT '0' NOT NULL,
	table_header_position tinyint(3) unsigned DEFAULT '0' NOT NULL,
	table_tfoot tinyint(1) unsigned DEFAULT '0' NOT NULL,
	uploads_description tinyint(1) unsigned DEFAULT '0' NOT NULL,
	uploads_type tinyint(3) unsigned DEFAULT '0' NOT NULL,
);