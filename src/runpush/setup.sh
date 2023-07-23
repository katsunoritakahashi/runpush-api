#dockerが立ち上がっていなければ下記コマンドで立ち上げる
#docker-compose up -d
#laravel8のインストールを実行
docker-compose exec app composer create-project --prefer-dist "laravel/laravel=8.*" .
#laravel jetstream(ログイン機能)をインストール
docker-compose exec app bash -c "COMPOSER_MEMORY_LIMIT=-1 composer require laravel/jetstream"
#jestreamをinertiaを選択してインストール
docker-compose exec app php artisan jetstream:install inertia
#下記でnpmをインストールする(nodeはdockerfileでインストール済み)
docker-compose exec app npm install
#デプロイをする為に権限を変更
sudo chmod -R 777 backend/*
#デプロイをする
docker-compose exec app npm run dev
#ルートディレクトリにある、.envファイルの設定をコピー
mv -f .env.example backend/.env
#dbを作成
docker-compose exec db mysql -u root -ppassword -e "CREATE DATABASE runpush_db;";
#.envファイルのDBの接続情報が整っていないとエラーになる。
docker-compose exec app php artisan migrate
sudo chmod -R 777 backend/storage/*