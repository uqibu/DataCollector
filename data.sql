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

select username,psw,gname,tel from (t1 left join t2 on t1.t1_id=t2.t1_id) left join t3 on t1.t1_id=t3.t1_id

select * from a left join b on a.id=b.id left join c on b.id=c.id

SELECT artistsong.songName,artist.artistname,artistalbum.albumName FROM artistsong 
left join artist on artistsong.artistId=artist.artistid
left join artistalbum on artistsong.artistId=artistalbum.artistId
where artistsong.artistId=2116;

SELECT artistsong.songName,artist.artistname,artistalbum.albumName FROM artistsong 
left join artist on artistsong.artistId=artist.artistid
left join artistalbum on artistsong.artistId=artistalbum.artistId 
where artistsong.artistId=2116;

SELECT artistsong.songName,artist.artistname,artistalbum.albumName FROM artistsong,artist,artistalbum
where artistsong.artistId=artist.artistid
and artistsong.artistId=artistalbum.artistId
and artistsong.albumId=artistalbum.albumId
and artistsong.artistId=8259 order by artistsong.albumId desc;

SELECT artistsong.songName,artist.artistname,artistalbum.albumName FROM artistsong,artist,artistalbum
where artistsong.artistId=artist.artistid
and artistsong.artistId=artistalbum.artistId
and artistsong.albumId=artistalbum.albumId
and artistsong.artistId=8259 order by artistsong.albumId desc;
