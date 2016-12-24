<?php
  header("Content-type:text/html; charset=utf8");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://www.zhihu.com/");
  curl_exec($ch);
  curl_close($ch);

 ?>
