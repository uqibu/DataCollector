##### 1：如何使用cURL

- 初始化 curl_init();
- 设置curl执行时相关选项 curl_setopt();
- 执行并获取结果 curl_exec();
- 释放资源 curl_close()

```
<?php

  $ch = curl_init();
  curl_setopt($ch, CURL_URL, "https://inscode.github.io/");
  curl_exec($ch);
  curl_close($ch);

 ?>
```
