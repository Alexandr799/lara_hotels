# Запускает контейнеры в композе
run:
	docker-compose up -d && docker exec -it app  sh -c 'chmod -R 755 /var/www/hotels_laravel/storage && chown -R www-data:www-data /var/www/hotels_laravel/storage'
# Удаляет контейнеры в композе
reset:
	docker-compose down && docker rmi hotels_laravel-app:latest
# Совершает миграции базы данных внутри контейнера
migrate:
	docker exec -it app sh -c "php artisan migrate"
# Совершает миграции базы данных внутри контейнера
fake_data:
	docker exec -it app sh -c "php artisan db:seed"
