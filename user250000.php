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
try {
  for ($i=200001; $i <= 250000; $i++) {
    $url = "http://music.163.com/user/home?id=$i";
    $urlContent = file_get_contents($url);
    $fileName   = $i.".txt";
    file_put_contents('./user/'.$fileName, $urlContent);
    $transContent = file_get_contents('./user/'.$fileName);

    /******begin匹配用户名******/
    $namePatt  = '/<span class="tit f-ff2 s-fc0 f-thide">.*/';
    preg_match($namePatt, $transContent, $match);
    if (count($match)<1) {
        echo "userid=".$i." not exists"."\n";
        unlink('./user/'.$fileName);
        continue;
    }
    $uname1 = str_replace("<span class=\"tit f-ff2 s-fc0 f-thide\">","",$match[0]);
    $uname  = str_replace("</span>","",$uname1);

    /******匹配用户名end******/

    /******begin匹配用户level******/
    $levelPatt  = '/<span class="lev u-lev u-icn2 u-icn2-lev">.*/';
    preg_match($levelPatt, $transContent, $match);
    $level = $match[0];
    $level = str_replace("<span class=\"lev u-lev u-icn2 u-icn2-lev\">","",$level);
    $level = str_replace("<i class=\"right u-icn2 u-icn2-levr\"></i></span>","",$level);

    /******匹配用户level end******/

    /******begin匹配用户省市******/
    $wherePatt  = '/所在地区：.*/';
    preg_match($wherePatt, $transContent, $match);
    $whereInfo = str_replace("所在地区：","",$match[0]);
    $whereAll  = explode(" - ", $whereInfo);
    $province  = isset($whereAll[0])?$whereAll[0]:"";
    $city      = isset($whereAll[1])?str_replace("</span>","",$whereAll[1]):"";
    /******匹配用户省市end******/

    /******begin匹配用户年龄******/
    $agePatt   = '/data-age=".*"/';
    preg_match($agePatt, $transContent, $match);
    if (count($match)<1) {
        $age = "";
    } else {
      $ageInfo = str_replace("data-age=\"","",$match[0]);
      $ageNum  = str_replace("\"","",$ageInfo);
      $age     = date("Y-m-d H:i:s",($ageNum/1000));
    }
    /******匹配用户年龄end******/

    /******begin匹配用户weibo******/
    $weiboPatt   = '/http:\/\/weibo.com\/u\/[1-9]{1}[0-9]{2,}/';
    preg_match($weiboPatt, $transContent, $match);
    if (count($match)<1) {
        $weibo = "";
    } else {
        $weibo = $match[0];
    }

    /******匹配用户weiboend******/

    /******begin匹配用户douban******/
    $doubanPatt   = '/http:\/\/www.douban.com\/people\/[1-9]{1}[0-9]{2,}/';
    preg_match($doubanPatt, $transContent, $match);
    if (count($match)<1) {
        $douban = "";
    } else {
        $douban = $match[0];
    }

    /******匹配用户doubanend******/

    /******begin匹配用户简介******/
    $summarizePatt   = '/个人介绍：.*/';
    preg_match($summarizePatt, $transContent, $match);
    if (count($match)<1) {
        $summarize = "";
    } else {
      $summarize = str_replace("个人介绍：","",$match[0]);
      $summarize = str_replace("</div>","",$summarize);
    }
    /******匹配用户简介end******/
    // echo $i,$uname,$level,$province,$city,$age,$weibo,$douban,$summarize;
    // exit;
    // echo $level;
    // exit;
    $stmt = $conn->prepare("INSERT INTO 163user(uid,uname,level,province,city,age,weibo,douban,summarize)
                            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isissssss", $uid,$uname,$level,$province,$city,$age,$weibo,$douban,$summarize);
    $uid      = $i;
    $uname    = $uname;
    $level    = $level;
    $province = $province;
    $city     = $city;
    $age      = $age;
    $weibo    = $weibo;
    $douban   = $douban;
    $summarize= $summarize;
    $userInsert = $stmt->execute();

    if($userInsert) {
       echo "$i info insert success"."\n";
    } else {
       echo "$i info insert failed ".$stmt->error."\n";
    }
    unlink('./user/'.$fileName);
    echo "***************"."\n";

  }
} catch (Exception $e) {

}


mysqli_close($conn);

 ?>
