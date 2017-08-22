<?php
$content = $_POST['content'];
if (!empty($content)) {
  //正则表达式匹配查找图片路径
  $pattern = '/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.jpeg|\.png]))[\'|\"].*?[\/]?>/i';
  preg_match_all($pattern, $content, $res);
  $num = count($res[1]);
  for ($i = 0;$i < $num;$i++) {
    //重点留意php文件与图片的相对位置。_xj
    $newDir='../../tmp_dir/true_img/';//定义新目录。

    $ueditor_img = $res[1][$i];
    // var_dump($ueditor_img);//string(65) "/tmp_dir/ueditor/tmp_img/20170822/1503383120/1503383120216062.jpg" 
    //新建日期文件夹
    $tmp_arr = explode('/', $ueditor_img);
    $datefloder = $newDir . $tmp_arr[4].'/'.$tmp_arr[5];
    if (!is_dir($datefloder)) {
      mkdir($datefloder, 0777,true);
    }
    //源图片
    $tmpimg = '../../' . $ueditor_img;
    //新图片
    // $newimg = str_replace('/ueditor_temp/', '/ueditor/', $tmpimg);
    $newimg = $newDir.$tmp_arr[4].'/'.$tmp_arr[5].'/'.$tmp_arr[6];
    // //转移图片
    rename($tmpimg, $newimg);
  }
}
