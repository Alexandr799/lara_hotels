# Запускает контейнеры и устанавливаем зависимости
run:
	docker-compose up -d && docker exec -it app  bash -c 'chmod -R 755 ./storage && chown -R www-data:www-data ./storage && composer install' && docker-compose run --rm npm install
# Удаляет контейнеры в композе
reset:
	docker-compose down && docker rmi hotels_laravel-app:latest
# Совершает миграции базы данных внутри контейнера
migrate:
	docker exec -it app bash -c "php artisan migrate"
# Совершает миграции базы данных внутри контейнера
fake_data:
	docker exec -it app bash -c "php artisan db:seed"
# # Запускает фронт в процессе отладки
# dev:
# 	...
# Делает продакшен билд приложения
prod:
	docker-compose run --rm npm run build
