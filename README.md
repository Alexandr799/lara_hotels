* Приложение для бронирования отелей

Функциональные возможности приложения
1. Регистрация и авторизация пользователей.
2. Фильтрация результатов поиска по цене, категории отеля, наличию
различных услуг и дополнительных опций (бесплатный завтрак,
доступ в интернет, кондиционер и так далее).3. Просмотр детальной информации об отеле (фотографии номеров,
описание, расположение и так далее).
4. Бронирование номеров пользователями.
5. Отправка подтверждения бронирования и информации о
бронировании на электронную почту пользователя.
6. Просмотр списка бронирований.
7. Отмена бронирований.
8. Создание, редактирование, удаление отелей. (выполняется через админку)
9. Создание, редактирование, удаление номеров. (выполняется через админку)

Приложение написано при помощи фреймворка Laravel, админка реализована на  Orchid

Система предполагает наличие двух ролей пользователей:
● администратор платформы;
● пользователь.


Система предполагает следующее разделение прав пользователей:
1. Администратор имеет полный доступ ко всем функциям системы.
Перечень уникальных разрешений для администратора платформы:
a. Создание/редактирование/удаление отелей, номеров и удобств
отелей.b. Просмотр/удаление бронирований для конкретного
пользователя или отеля.
c. Просмотр информации о пользователях системы.
d. Доступ к отдельным страницам, предназначенным для
администратора системы.
2. Гость — зарегистрированный пользователь, который может
просматривать информацию об отелях, номерах и ценах, а также
создавать и отменять бронирования.
3. Незарегистрированный пользователь не имеет доступа к
функционалу системы.


Для разворачивания приложение локально требуется выполнить ряд действий:
1. Проверить файл .env (пример в файле .env.example)
2. Команда composer install для загрузки пакетов
3. Команда php artisan migrate для выполнения миграций
4. Команда php artisan db:seed для наполнения фейковыми данными
5. Команда php artisan db:seed для наполнения фейковыми данными
6. Команда php artisan orchid:install для установки админки (будет доступна по адрес /admin)
7. Команда php artisan orchid:admin admin admin@admin.com password для создания рут пользователя админки
8. Команда npm i для загрузки js зависимостей
9. Команда php artisan serve для запуска приложения локально и тестирования (запуск сервера)
10. Команда npm run dev сборка клиента для отладки

