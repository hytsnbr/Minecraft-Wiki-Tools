<?php

// JSONファイル読み込み
$java = json_decode(file_get_contents('./result/java.json'));
$bedrock = json_decode(file_get_contents('./result/bedrock.json'));

// 出力結果の格納変数
$result_compare = '';
$result_wiki = "Java EditionとBedrock Edtionの翻訳の差異一覧\n\n{| class=\"wikitable sortable\"\n|-\n! 原文 !! Java Edition（[[Java Edition " . JE_VER . "|" . JE_VER . "]]） !! Bedrock Edition（[[Bedrock Edition " . BE_VER . "|" . BE_VER . "]]）\n";
$result_module = "{\n";

foreach ($bedrock as $key => $word) {
  if (property_exists($java, $key) && $java->$key !== $word) {
    // 比較ファイル作成処理
    $result_compare .= "{$key} => JE: " . $java->$key . " / BE: {$word}\n";

    // Minecraft Wikiに対応した表形式で出力
    $result_wiki .= "|-\n| {$key} || " . $java->$key . " || {$word}\n";

    // Luaでのテーブル形式で出力
    if (strpos($key, "'") !== false) {
      $result_module .= "  [\"" . mb_strtolower($key) . "\"] = \"{$word}\",\n";
    } else {
      $result_module .= "  ['" . mb_strtolower($key) . "'] = \"{$word}\",\n";
    }
  }
}
$result_wiki .= '|}';
$result_module  .= '}';

file_put_contents('./result/compare.txt', $result_compare);
file_put_contents('./result/output_wiki_style.txt', $result_wiki);
file_put_contents('./result/output_wiki_module_style.txt', $result_module);
