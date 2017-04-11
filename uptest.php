<?php
$begin = microtime(true);

require_once __DIR__ . '/../autoload.php';

// 引入鉴权类
use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;

function up($dir)
{
    $accessKey = 'ak';   //填写ak
    $secretKey = 'sk';   //填写sk
    // 构建鉴权对象
    $auth = new Auth($accessKey, $secretKey);
    // 要上传的空间
    $bucket = 'testupload';
    $dirArr = scandir($dir);

    $dirLen = count($dirArr);
    $totalTime = 0;
    $totalSize = 0;
    $fileNum   = 0;
    $info = array();
    for ($i=2; $i < $dirLen; $i++) {

        $filePath = $dir.'/'.$dirArr[$i];
        $token = $auth->uploadToken($bucket);

        $key = date("YmdHis",time()).$dirArr[$i];

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        echo "\n====> putFile result: \n";
        if ($err !== null) {
            var_dump($err);
        } else {
            var_dump($ret);
        }

        $fileSize = fileSize($filePath);
        $totalSize += $fileSize;
        $fileNum += 1;
        // file_put_contents('vertical.log', $now.'---'.$fileSize.'字节'.PHP_EOL, FILE_APPEND );
    }
    $info[] = $totalSize;
    $info[] = $fileNum;
    return $info;
}
  $info = up('star');
  $end = microtime(true);
  $allTime = ($end-$begin);
  $totalSize = ($info[0])/1048576;
  file_put_contents('vertical.log', "执行时间".'：'.$allTime.'秒'.'---'.$totalSize.'M'.'---上传文件数---'.$info[1].PHP_EOL, FILE_APPEND );
  echo $allTime."秒<br/>";
  echo $totalSize."M<br/>";
  echo $info[1]."个文件";

 ?>
