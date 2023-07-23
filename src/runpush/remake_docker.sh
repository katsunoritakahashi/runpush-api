#元のdokcerコンテナを削除する。
docker-compose down --rmi all --volumes && \
docker-compose up -d --build && \
#composerで必要なファイルをインストールする。
docker-compose exec management-console-app bash -c "COMPOSER_MEMORY_LIMIT=-1 composer install" && \
#環境設定ファイルをexampleから作成
docker-compose exec management-console-app cp .env.example .env && \
#キーを作成したり再作成
docker-compose exec management-console-app php artisan key:generate && \
docker-compose exec management-console-app php artisan passport:install && \
docker-compose exec management-console-app php artisan storage:link && \
docker-compose exec management-console-app php artisan migrate:fresh --seed && \
docker-compose exec management-console-app php artisan vendor:publish --tag=jetstream-views  && \
docker-compose exec management-console-app php artisan vendor:publish --provider="Kreait\Laravel\Firebase\ServiceProvider" --tag=config && \
docker-compose exec management-console-app npm install -g n && \
docker-compose exec management-console-app n latest && \
docker-compose exec management-console-app npm install