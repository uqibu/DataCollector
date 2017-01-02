create table 163user(
  uid int primary key,
  uname varchar(64) not null,
  level int not null,
  province varchar(32) not null,
  city varchar(32) not null,
  age varchar(32) default null,
  weibo varchar(64) default null,
  douban varchar(64) default null,
  summarize varchar(256) default null,
  addtime datetime not null default now()
)engine=innodb default character set utf8;
