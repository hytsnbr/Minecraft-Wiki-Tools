<?php

// エラー出ると邪魔なので無効化
error_reporting(E_ERROR);

// デバッグ用設定
const DEBUG = true;  // デバッグモード
const SHOW_DEBUG_LOG = false;  // デバッグログの出力
const DEBUG_LOG = './.log';

// バージョン
const JE_VER = '21w11a';
const BE_VER = '1.16.230.50';

//===== 本処理 =====//
unlink('./.log');

require('./createJavaJson.php');
require('./createBedrockJson.php');
require('./output.php');


/**
 * デバッグログ出力
 */
function debugLog(string $fileName, string $logStr)
{
  if (!DEBUG) return;

  $time = date('Y/m/d G:i:s');

  // log output to file
  $txt = "[{$time}] {$fileName} : {$logStr}";
  if (!file_exists(DEBUG_LOG)) {
    file_put_contents(DEBUG_LOG, $txt);
  } else {
    file_put_contents(DEBUG_LOG, $txt, FILE_APPEND);
  }

  // log output to console
  if (SHOW_DEBUG_LOG) {
    echo $txt;
  }
}
