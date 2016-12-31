create table ruser(
  id int auto_increment primary key,
  uid int not null,
  uname varchar(32) not null,
  addressHead varchar(32) not null,
  addressFoot varchar(32) not null,
  age bigint not null,
  addtime datetime not null default now()
)default character set utf8;

create table alluser(
  id int auto_increment primary key,
  uid int not null,
  uname varchar(32) not null,
  addressHead varchar(32) not null,
  addressFoot varchar(32) not null,
  age bigint not null,
  addtime datetime not null default now()
)default character set utf8;


512247 | ����(�糡��)                  |   5258168 |
512247 | ��������                      |   5258156 |
511932 | ��������                      |   5252709 |
511176 | ����ĳ��                    |   5239683 |
510848 | ��Խ������                    |   5234563 |
24803  | ���紵��������                |    247579 |
24803  | ����˼��                      |    247577 |
24803  | ����                          |    247585 |
10777  | ���ְ�                        |    108576 |
10770  | �ڴ���                        |    108503 |

SELECT artistsong.songName,artist.artistname,artistalbum.albumName,artistalbum.albumId FROM artistsong,artist,artistalbum
where artistsong.artistId=artist.artistid
and artistsong.artistId=artistalbum.artistId
and artistsong.albumId=artistalbum.albumId
and artistsong.artistId=7760 order by artistsong.albumId desc;