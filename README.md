# Random-Image-API
简单搭建本地或外链随机图片API，可选是否检查Referer

```
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
```

```
<?php
// 检查请求的 Referer 头
$allowedReferer = 'https://www.makurasho.com';
if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $allowedReferer) === 0) {

    header("Access-Control-Allow-Origin: *");
    header('Pragma: no-cache');
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: 0');

    // 存有图片链接的文件 img.txt
    $lines = file('image.txt');

    // 随机选择一行并去除换行符
    $imageUrl = trim($lines[array_rand($lines)]);

    // 使用 cURL 获取图片内容，并设置 Referer 头
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $imageUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // 设置 Referer 头为 https://www.makurasho.com
    curl_setopt($ch, CURLOPT_REFERER, "https://www.makurasho.com");

    $imageContent = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

    curl_close($ch);

    // 如果获取成功，则返回图片内容
    if ($httpCode == 200) {
        header("Content-Type: $contentType");
        echo $imageContent;
    }

    // 如果获取失败，不设置错误状态码，客户端将不会收到具体的错误信息

} else {
    // 如果 Referer 不匹配，返回403禁止访问
    header("HTTP/1.1 403 Forbidden");
    exit;
}
```
