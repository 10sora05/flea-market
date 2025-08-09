flea-market(coachtech フリマアプリ)


-   このリポジトリは amd 版です(Windows/IntelCPU の Mac 向け)


## 環境構築

プロジェクトをセットアップするために、以下の手順を実行してください。

1. Dockerのビルド
まず、プロジェクトのルートディレクトリに移動し、Dockerコンテナをビルドします。

```
docker compose up -d --build
```

これにより、必要なコンテナが構築されます。

2. env ファイルを作成します。

```
cp src/.env.example src/.env
```

3. php にコンテナに移動します。
```
docker compose exec php bash
```

4. シーディングの実行
composer パッケージをインストールします。

```
composer install
```

5. アプリケーションキーを作成します。
```
php artisan key:generate
```

6. マイグレーションの実行
マイグレーションを実行して、データベースの構造を作成します。

```
php artisan migrate
```

これで、必要なテーブルがデータベースに作成されます。

7. シーディングの実行
もし必要であれば、シーディングも実行します。シーディングは、サンプルデータをデータベースに挿入するための処理です。

```
php artisan db:seed
```

シーディング後、サンプルデータがデータベースに挿入されます。



## 使用技術(実行環境)

このプロジェクトでは、以下の技術を使用しています。

・Laravel 8.x: PHPフレームワークで、アプリケーションのバックエンドロジックを処理します。

・Docker: コンテナ化された開発環境を提供し、依存関係やサーバー設定を簡素化します。

・MySQL: アプリケーションのデータベースとして使用しています。

・PHP 7.4: Laravelを実行するために使用するPHPのバージョン。

・Nginx: Webサーバーとして使用され、リクエストを処理します。

・Composer: PHPのパッケージマネージャーとして、Laravelの依存関係を管理します。

・mailtrap: メール認証機能

・Stripe: 決済機能実装


## ER図

<img src="ER.drawio.png" alt="ERimg">



## URL

・開発環境：http://localhost/

・phpMyAdmin:：http://localhost:8080/


