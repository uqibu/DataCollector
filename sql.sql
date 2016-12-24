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
