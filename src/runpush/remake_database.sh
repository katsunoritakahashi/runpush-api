docker-compose exec db mysql -u root -ppassword -e "DROP DATABASE runpush_db;";
#dbを作成
docker-compose exec db mysql -u root -ppassword -e "CREATE DATABASE runpush_db;";
docker-compose exec management-console-app php artisan migrate:fresh --seed