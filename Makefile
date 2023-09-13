run:
	docker-compose up -d
reset:
	docker-compose down && docker rmi hotels_laravel-app:latest
