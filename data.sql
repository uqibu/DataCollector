create table artist(
  artistid int not null primary key,
  artistname varchar(64) not null,
  aliasname varchar(64),
  password varchar(128) not null,
  addtime datetime not null default now()
)engine=innodb default character set utf8;

insert into artist values(8259,'金莎','蓝菲琳','123456');
insert into artist values(918054,'刘珂矣','','123456');
insert into artist values(10142,'玄觞','','123456');

create table artistSong(
  songId int not null primary key,
  songName varchar(64) not null,
  albumId int not null,
  artistId int not null,
  score    smallint not null,
  mvid int,
  addtime datetime not null default now()
)engine=innodb default character set utf8;

create table artistAlbum(
  albumId int not null primary key,
  albumName varchar(64) not null,
  artistId int not null,
  addtime datetime not null default now()
)engine=innodb default character set utf8;
