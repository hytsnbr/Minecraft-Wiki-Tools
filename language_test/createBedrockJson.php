<?php

const BE_EN_JSON = './bedrock/en_US.lang';
const BE_JA_JSON = './bedrock/ja_JP.lang';
const BE_UPCOMING_EN_JSON = './bedrock/upcoming/en_US.lang';
const BE_UPCOMING_JA_JSON = './bedrock/upcoming/ja_JP.lang';

$fileData = [];

// vanilla
$fileData[] = [
  explode("\n", file_get_contents(BE_EN_JSON)),
  explode("\n", file_get_contents(BE_JA_JSON)),
];

// upcoming features
$fileData[] = [
  explode("\n", file_get_contents(BE_UPCOMING_EN_JSON)),
  explode("\n", file_get_contents(BE_UPCOMING_JA_JSON)),
];

/*
// Chemistry features are only implemented in Bedrock Edition.
$fileData[] = [
  explode("\n", file_get_contents('./bedrock/chemistry/en_US.lang')),
  explode("\n", file_get_contents('./bedrock/chemistry/ja_JP.lang')),
];
*/

$result = [];
foreach ($fileData as $data) {
  $en_lang = dotLangToJson($data[0]);
  $ja_lang = dotLangToJson($data[1]);
  $result[] = analyze($en_lang, $ja_lang);
}

// BEのみ中身の配列を結合して1つにする
$array = [];
for ($i = 0; $i < (count($result) - 1); ++$i) {
  $array += array_merge($result[$i], $result[$i + 1]);
}
$result = $array;

file_put_contents(
  './result/bedrock.json',
  json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);


//===== functions =====
function dotLangToJson(array $data): array
{
  $result = [];
  foreach ($data as $value) {
    if (preg_match("/^\s*#/", $value)) continue;  // inline comment
    if (mb_strlen($value) <= 1) continue;  // empty string (include TAB)

    $array = explode("=", $value);
    $lang_key = $array[0];
    $lang_value = $array[1];
    if (empty($lang_key) || empty($lang_value)) continue;
    $lang_value = preg_replace('/\t#/', '', $lang_value);
    $lang_value = trim(removeComment($lang_value));

    $result += ["{$lang_key}" => $lang_value];

    debugLog(basename(__FILE__), "翻訳キー: {$lang_key} / テキスト: {$lang_value}\n");
  }

  return $result;
}

function analyze(array $en_us, array $ja_jp): array
{
  $result = [];
  foreach ($en_us as $index => $value) {
    if (preg_match("/^\s*#/", $value)) continue;
    if (mb_strlen($value) <= 1) continue;

    $result += ["{$value}" => $ja_jp[$index]];
  }

  return $result;
}

function removeComment(string $str, int $start = 0): string
{
  if (mb_strpos($str, '##') === false) return $str;

  $tmp = mb_substr($str, $start, mb_strpos($str, '##') ?: mb_strlen($str));
  return removeComment($tmp, mb_strpos($tmp, '##') ?: 0);
}
