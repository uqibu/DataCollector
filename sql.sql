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


512247 | 笨蛋(剧场版)                  |   5258168 |
512247 | 聆听世界                      |   5258156 |
511932 | 唱响世界                      |   5252709 |
511176 | 梦想的翅膀                    |   5239683 |
510848 | 跨越新世界                    |   5234563 |
24803  | 被风吹过的夏天                |    247579 |
24803  | 不可思议                      |    247577 |
24803  | 笨蛋                          |    247585 |
10777  | 发现爱                        |    108576 |
10770  | 期待爱                        |    108503 |

SELECT artistsong.songName,artist.artistname,artistalbum.albumName,artistalbum.albumId FROM artistsong,artist,artistalbum
where artistsong.artistId=artist.artistid
and artistsong.artistId=artistalbum.artistId
and artistsong.albumId=artistalbum.albumId
and artistsong.artistId=7760 order by artistsong.albumId desc;