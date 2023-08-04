<!DOCTYPE html>
<html>
<head>
  <title>Подтверждение бронирования отеля</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 16px;
      color: #1f2937;
      background-color: #f3f4f6;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 20px auto;
      padding: 20px;
      background-color: #f9fafb;
      border: 1px solid #818cf8;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1 {
      color: #818cf8;
      text-align: center;
      margin-bottom: 20px;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      margin-bottom: 10px;
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #1f2937;
      color: #f9fafb;
      font-size: 16px;
      font-weight: 500;
      text-decoration: none;
      border: 5px solid #1f2937;
      border-radius: 5px;
      transition: background-color 0.2s ease;
    }

    .button:hover {
      background-color: #818cf8;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Уважаемый(ая) {{ $name }},</h1>
    <p>Спасибо за бронирование в нашем отеле! Ваше бронирование успешно оформлено.</p>

    <h2>Детали бронирования:</h2>
    <ul>
      <li><strong>Отель:</strong> {{$booking->room->hotel->title}}</li>
      <li><strong>Дата заезда:</strong> {{$booking->started_at}}</li>
      <li><strong>Дата выезда:</strong> {{$booking->finished_at}}</li>
    </ul>

    <p>Если у вас возникли какие-либо вопросы или потребуется внести изменения в бронирование, пожалуйста, свяжитесь с нами.</p>

    <p>С наилучшими пожеланиями,<br>Команда отеля {{$booking->room->hotel->title}}</p>

    <p style="text-align: center;">
      <a class="button" href="{{route('bookings.show', ['booking'=>$booking->id])}}">Перейти на страницу бронирования</a>
    </p>
  </div>
</body>
</html>
