# 取り組んだ課題
## 概要内容
- 特定の画像ファイルへのPathを与えると、AIで分析し、その画像が所属するClassを返却するAPIがあ
るとします
- このAPIに対してリクエストを投げ、レスポンスをDBに保存する処理を作成してください
- ただし、実際に動作するAPIは存在しないため、APIの仕様からレスポンスを想定し、保存処理を作成
してください

## 条件
- PHP、Python、JavaScriptの内、いずれかのフレームワークを利用してください
- UIの作成は任意とします

## レスポンスを保存するDB
※ 以下はMySQLのCREATE文になります。ご利用のRDBに合わせて変更してください。
```
CREATE TABLE `ai_analysis_log` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`image_path` varchar(255) DEFAULT NULL,
`success` varchar(255) DEFAULT NULL,
`message` varchar(255) DEFAULT NULL,
`class` int(11) DEFAULT NULL,
`confidence` decimal(5,4) DEFAULT NULL,
`request_timestamp` int(10) unsigned DEFAULT NULL,
`response_timestamp` int(10) unsigned DEFAULT NULL,
PRIMARY KEY (`id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## API仕様
### リクエスト
- URLベース: http://example.com/
- リクエスト: POST
- パラメーター
    - image_path
    - String
    - 画像ファイルPath
    - 例: /image/d03f1d36ca69348c51aa/c413eac329e1c0d03/test.jpg

### レスポンス
レスポンスは JSON で返却されます。

#### Success:リクエスト成功
```
{
"success": true,
"message": "success",
"estimated_data": {
"class": 3,
"confidence": 0.8683
}
}
```

#### Failure:リクエスト失敗
```
{
"success": false,
"message": "Error:E50012",
"estimated_data": {}
}
```

# 前提
- フォームUIから画像パスを送信するUIとした
- モックアップAPI（同一アプリケーション内に作成）へリクエスト
- レスポンスをDBに保存している

# 選択したアーキテクチャ
- 環境構築:Docker
- フレームワーク:Laravel9.9.0（PHP8.0.18）
- DB:MySQL8.0.28
- サーバー:apache2.4.53

# ご確認手順
リポジトリをclone  

task_klavisディレクトリに移動  
`cd task_klavis`

コンテナを立ち上げ  
`docker-compose up -d`

コンテナの立ち上げ時にデータベースも作成される
- DB名:image_database
- テーブル名:ai_analysis_log

コンテナの中に入る  
`docker-compose exec app bash`

Composerで依存ライブラリを入れる  
`composer install`

環境変数設定用.env ファイルをコピー  
`cp .env.example .env`

.envファイルにencryption keyを設定する  
`php artisan key:generate`

コンテナの外に出る  
`exit`

./app/.envファイルのDB情報を書き換える  
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=image_database
DB_USERNAME=root
DB_PASSWORD=pass
```

以下URLへアクセス  
http://localhost:80/image

フォームからテキスト（画像パス想定）を打ち込み`send`ボタンで送信  
保存結果が累積して画面上に表示される

## コードのご確認
コントローラーの記述  
/task_klavis/app/app/Http/Controllers/ImagesController.php

モデルの記述  
/task_klavis/app/app/Models/Ai_analysis_log.php

ビューの記述  
/task_klavis/app/resources/views/image/index.blade.php

ルート情報の記述  
/task_klavis/app/routes/web.php

マイグレーションの記述  
/task_klavis/app/database/migrations/2022_04_20_045931_ai_analysis_log.php
/task_klavis/app/database/seeders/Ai_analysis_logTableSeeder.php