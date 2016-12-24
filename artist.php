<?php

$servername = "localhost";
$username   = "root";
$password   = "dongdong";
$dbname     = "yii2basic";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$conn->set_charset("utf8");
//105万到110万
for ($i=100; $i <= 5000; $i++) {
  $url = "http://music.163.com/artist?id=$i";
  $urlContent = file_get_contents($url);
  $userInfos  = explode("=", $url);
  $fileName   = $i.".txt";
  file_put_contents('./artist/'.$fileName, $urlContent);
  $transContent = file_get_contents('./artist/'.$fileName);
  $namePatt     = '/class=\"sname f-thide sname-max\" title=".*\">/';
  preg_match($namePatt, $transContent, $match);
  if (empty($match)) {
      echo "artist=".$i." not exists"."\n";
      unlink('./artist/'.$fileName);
      continue;
  }
  $nameInfo     = $match[0];
  $nameInfo     = str_replace("class=\"sname f-thide sname-max\" title=\"", "", $nameInfo);
  $nameInfo     = str_replace("\"", "", $nameInfo);
  $nameInfo     = str_replace(">", "", $nameInfo);
  $nameArrs     = explode(" - ", $nameInfo);
  $artistName   = $nameArrs[0];

  $aliasName    = !empty($nameArrs[0]) ? $nameArrs[0] : "无";
  $artistId     = $i;
  $password     = "123456";

  $stmt = $conn->prepare("INSERT INTO artist(artistid, artistname, aliasname, password)
                          VALUES(?, ?, ?, ?)");
  $stmt->bind_param("isss", $artistid, $artistname, $aliasname, $password);
  $artistid   = $artistId;
  $artistname = $artistName;
  $aliasname  = $aliasName;
  $password   = $password;
  $artistInsert = $stmt->execute();
  if($artistInsert) {
     echo "artist info insert success"."\n";
  } else {
     echo "artist info insert failed"."\n";
  }

   /*通过预处理方式新增歌曲信息*/

   $songPatt  = '/<textarea style="display:none;">.*/';
               preg_match($songPatt, $transContent, $match);
               $str     = (string)($match[0]);
               $newStr  = str_replace("style=\"display:none;\"", "", $str);
               $newStr  = str_replace("<textarea >", "", $newStr);
               $newStr  = str_replace("</textarea>", "", $newStr);
               $arrs    = json_decode($newStr);
               $subSong = array();
               $song    = array();
               $stmtSong= $conn->prepare("INSERT INTO artistsong
                                        (songId, songName, albumId, artistId, score, mvid)
                                        VALUES(?, ?, ?, ?, ?, ?)");
               $stmtSong->bind_param("isiisi", $songId, $songName, $albumId, $artistId, $score, $mvid);

               $stmtAlbum= $conn->prepare("INSERT INTO artistalbum
                                         (albumId, albumName, artistId)
                                         VALUES(?, ?, ?)");
               $stmtAlbum->bind_param("isi", $zjId, $zjName, $artistId);

               foreach ($arrs as $key => $value) {
                 $songId   = $value->id;
                 $songName = $value->name;
                 $albumId  = $value->album->id;
                 $artistId = $artistId;
                 $score    = $value->mvid;
                 $mvid     = $value->score;
                 $sCreate  = $stmtSong->execute();
                 
                 $zjId     = $value->album->id;
                 $zjName   = $value->album->name;
                 $artistId = $artistId;
                 $aCreate  = $stmtAlbum->execute();

                 if ($sCreate && $aCreate) {
                     echo "song and album insert success"."\n";
                 } elseif ($sCreate && !$aCreate) {
                     echo "song insert success but album failed"."\n";
                 } elseif (!$sCreate && $aCreate) {
                     echo "album insert success but song failed"."\n";
                 } else {
                     echo "song and album insert failed"."\n";
                 }
             
               }
  unlink('./artist/'.$fileName);
  echo "***************"."\n";

}
mysqli_close($conn);

 ?>
