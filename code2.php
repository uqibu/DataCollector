<?php

$servername = "localhost";
$username   = "root";
$password   = "dongdong";
$dbname     = "music163";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$conn->set_charset("utf8");
//105万到110万
for ($i=1067168; $i < 1100000; $i++) {
  $origin = "http://music.163.com/#/user/home?id=$i";
  $url    = str_replace("/#", "", $origin);

  $urlContent = file_get_contents($url);
  $userInfos  = explode("=", $url);
  $fileName   = $userInfos[1].".txt";
  file_put_contents('./code2/'.$fileName, $urlContent);

  $transContent = file_get_contents('./code2/'.$fileName);
  //<span class="tit f-ff2 s-fc0 f-thide">夜夜叶曳</span>
  $namePatt = '/<span class="tit f-ff2 s-fc0 f-thide">.*</';
  preg_match($namePatt, $transContent, $match);
  if(count($match)<1){
    echo $i."not exists\n";
    unlink('./code2/'.$fileName);
    continue;
  }
  $nickname = substr($match[0],38,-1);
  $infoPatt ='/<span>.*</';
  preg_match_all($infoPatt, $transContent, $matchx);
  $addressInfo = $matchx[0][3];
  $addressR1 = str_replace("<span>所在地区：", "", $addressInfo);
  $address   = str_replace("<", "", $addressR1);
  $addressArr=explode(" - ", $address);
  $addressHead = $addressArr[0];  //省
  $addressFoot = $addressArr[1];
  //匹配年龄
  $agePatt = '/data-age="[1-9]{1}[0-9]{5,}/';
  preg_match($agePatt, $transContent, $age);
  if(count($age)<1){
    $age = 0;
  } else {
    $age = str_replace("data-age=\"","",$age[0]);
  }
  $sql = "INSERT INTO ruser (uid, uname, addressHead, addressFoot, age)
          VALUES ($i, '{$nickname}', '{$addressHead}', '{$addressFoot}', $age);";

  if (mysqli_query($conn, $sql)) {
      echo $i.":insert success\n";
  } else {
      // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      echo $i.":insert failed<br/>";
  }
  unlink('./code2/'.$fileName);

}
mysqli_close($conn);






 ?>
