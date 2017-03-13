DROP table if exists `shop_admin`;

create table if not exists `shop_admin`(
	`adminid` int unsigned not null auto_increment,
	`adminuser` varchar(32) not null default '',
	`adminpass` char(32) not null default '',
	`adminemail` varchar(50) not null default '',
	`logintime` int unsigned not null default '0',
	`loginip` bigint not null default '0',
	`createtime` int unsigned not null default '0',
	primary key(`adminid`),
	unique shop_admin_adminuser_adminpass(`adminuser`,`adminpass`),
	unique shop_admin_adminuser_adminemail(`adminuser`,`adminemail`)
)engine=innodb default charset=utf8;

insert into `shop_admin` (adminuser,adminpass,adminemail,createtime) values ('admin',md5('123'),'shop@imooc.com',unix_timestamp());



source admin.sql //导入数据库文件