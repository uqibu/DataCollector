<?php

$servername = "localhost";
$username   = "root";
$password   = "11019";
$dbname     = "yii2basic";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$conn->set_charset("utf8");

for ($i=18009730; $i <= 18009740; $i++) {
  $url = "http://music.163.com/user/home?id=$i";
  $urlContent = file_get_contents($url);
  $fileName   = $i.".txt";
  file_put_contents('./user/'.$fileName, $urlContent);
  $transContent = file_get_contents('./user/'.$fileName);

  /******begin匹配用户名******/
  $namePatt  = '/<span class="tit f-ff2 s-fc0 f-thide">.*/';
  preg_match($namePatt, $transContent, $match);
  if (empty($match)) {
      echo "userid=".$i." not exists"."\n";
      unlink('./user/'.$fileName);
      continue;
  }
  $uname = $match[0];
  /******匹配用户名end******/

  /******begin匹配用户level******/
  $levelPatt  = '/<span class="lev u-lev u-icn2 u-icn2-lev">.*/';
  preg_match($levelPatt, $transContent, $match);
  $level = $match[0];
  /******匹配用户level end******/

  /******begin匹配用户省市******/
  $wherePatt  = '/所在地区：.*/';
  preg_match($wherePatt, $transContent, $match);
  $whereInfo = str_replace("所在地区：","",$match[0]);
  $whereAll  = explode(" - ", $whereInfo);
  $province  = isset($whereAll[0])?$whereAll[0]:"";
  $city      = isset($whereAll[1])?$whereAll[1]:"";
  /******匹配用户省市end******/

  /******begin匹配用户年龄******/
  $agePatt   = '/data-age=".*"/';
  preg_match($agePatt, $transContent, $match);
  if (!isset($match)) {
      $age = "";
  }
  $ageInfo = str_replace("data-age=\"","",$match[0]);
  $ageNum  = str_replace("\"","",$ageInfo);
  $age     = date("Y-m-d H:i:s",($ageNum/1000));
  /******匹配用户年龄end******/

  /******begin匹配用户weibo******/
  $weiboPatt   = '/http:\/\/weibo.com\/u\/[1-9]{1}[0-9]{2,}/';
  preg_match($weiboPatt, $transContent, $match);
  if (!isset($match)) {
      $weibo = "";
  }
  $weibo = $match[0];
  /******匹配用户weiboend******/

  /******begin匹配用户douban******/
  $doubanPatt   = '/http:\/\/www.douban.com\/people\/[1-9]{1}[0-9]{2,}/';
  preg_match($doubanPatt, $transContent, $match);
  if (!isset($match)) {
      $douban = "";
  }
  $douban = $match[0];
  /******匹配用户doubanend******/

  /******begin匹配用户简介******/
  $summarizePatt   = '/个人介绍：.*/';
  preg_match($summarizePatt, $transContent, $match);
  if (!isset($match)) {
      $summarize = "";
  }
  $summarize = str_replace("个人介绍：","",$match[0]);
  /******匹配用户简介end******/

  $stmt = $conn->prepare("INSERT INTO 163user(uid,uname,level,province,city,age,weibo,douban,summarize)
                          VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("isissssss", $uid,$uname,$level,$province,$city,$age,$weibo,$douban,$summarize);
  $uid      = $uid;
  $uname    = $uname;
  $level    = $level;
  $province = $province;
  $city     = $city;
  $age      = $age;
  $weibo    = $age;
  $douban   = $douban;
  $summarize= $summarize;
  $userInsert = $stmt->execute();
  if($userInsert) {
     echo "$i info insert success"."\n";
  } else {
     echo "$i info insert failed"."\n";
  }
  unlink('./user/'.$fileName);
  echo "***************"."\n";

}
mysqli_close($conn);

 ?>
