<?php
$a_file = $_FILES["file"];  // 上傳的檔案內容

$path = "file/";  // 指定存檔的資料夾

// 判斷能否存入，若無則建立新的資料夾
if(!is_dir($path))
{
   mkdir($path);
}


// 上傳檔案處理
$msg = '';
$total = count($a_file["name"]);
for($i=0; $i<$total; $i++)
{
   if(isset($a_file["size"][$i]) && $a_file["size"][$i]>0)
   {
      $save_filename = $path . $a_file["name"][$i];  // 保留原來檔名
      $save_filename = iconv("utf-8", "big5", $save_filename);   // 處理中文檔名時需轉換
      
      if (@move_uploaded_file($a_file["tmp_name"][$i], $save_filename))
      {
         $msg .= '<BR>已成功上傳檔案：' . $save_filename;
      }
      else
      {
         $msg .= '<BR>上傳失敗……………' . $a_file["name"][$i];
      }      
      /*
      $msg .= '<BLOCKQUOTE>';
      $msg .= '儲存檔名：' . $save_filename . '<BR>';
      $msg .= '原始檔名：' . $a_file["name"][$i] . '<BR>';
      $msg .= '檔案大小：' . $a_file["size"][$i] . '<BR>';
      $msg .= '檔案類型：' . $a_file["type"][$i] . '<BR>';
      $msg .= '暫存檔名：' . $a_file["tmp_name"][$i] . '<BR>';
      $msg .= '</BLOCKQUOTE>';
      */
   }
}


$html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>檔案上傳</title>
</head>
<body>
<p>檔案上傳結果</p>
<p>{$msg}</p>
<hr>
<p>請注意讓使用者任意上傳檔案而未加控制，將有可能造成系統的漏洞，導致被入侵的危險。</p>
</body>
</html>
HEREDOC;

echo $html;
?>