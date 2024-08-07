<?php
header("Access-Control-Allow-Origin: *");
header('Pragma: no-cache');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: 0');

// 存有图片链接的文件 image.txt
$lines = file('image.txt');

// 随机选择一行并去除换行符
$imageUrl = trim($lines[array_rand($lines)]);

// 获取图片内容
$imageContent = file_get_contents($imageUrl);

// 获取图片类型
$imageInfo = getimagesize($imageUrl);
$imageMimeType = $imageInfo['mime'];

// 返回图片内容
header("Content-Type: $imageMimeType");
echo $imageContent;
?>