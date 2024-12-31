<?php
// includes/db_connect.php

/*$host = 'mysql80.megaphone11.sakura.ne.jp';
$db   = 'megaphone11_gs_db';
$user = 'megaphone11_gs_db';
$pass = 'Usjpkyu7053';
$charset = 'utf8mb4';*/

/*$db = "mental";    //データベース名
$user   = "root";      //アカウント名
$pass   = "";          //パスワード：XAMPPはパスワード無し or MAMPはパスワード”root”に修正してください。
$host = "localhost"; //DBホスト

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";*/

/*$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}*/

//DB接続 ミス
/*function db_conn(){
    try {
        $db_name = "mental";    //データベース名
        $db_id   = "root";      //アカウント名
        $db_pw   = "";      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = "localhost"; //DBホスト
        return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    );
    } catch (PDOException $e) {
      exit('DB Connection Error:'.$e->getMessage());
    }
  }*/



  // DB接続
  function db_conn() {
      try {
          $db_name = "mental";    // データベース名
          $db_id   = "root";      // アカウント名
          $db_pw   = "";          // パスワード：XAMPPはパスワード無しに修正してください。
          $db_host = "localhost"; // DBホスト
  
          return new PDO(
              'mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, 
              $db_id, 
              $db_pw, 
              [
                  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                  PDO::ATTR_EMULATE_PREPARES   => false,
              ]
          );
      } catch (PDOException $e) {
          exit('DB Connection Error: '.$e->getMessage());
      }
  }
  ?>