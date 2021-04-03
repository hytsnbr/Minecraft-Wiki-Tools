<?php

const JAVA_EN_JSON = './java/en_us.json';
const JAVA_JA_JSON = './java/ja_jp.json';

// Java Editionでの比較データを作成
$en_java = json_decode(file_get_contents(JAVA_EN_JSON));
$ja_java = json_decode(file_get_contents(JAVA_JA_JSON));

$result = [];
foreach ($en_java as $index => $line) {
  $result += ["{$line}" => $ja_java->$index];

  debugLog(basename(__FILE__), "英: {$line} / 日: {$ja_java->$index}\n");
}

file_put_contents(
  './result/java.json',
  json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);
