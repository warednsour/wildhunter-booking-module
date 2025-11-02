🦌 Wild Hunter Booking Module
🎯 Задача

Реализовать минимальный Laravel-модуль для бронирования охотничьих туров с выбором гида.

Модуль должен включать:

миграции и модели: Guide, HuntingBooking

API:

GET /api/guides — список активных гидов

POST /api/bookings — создание бронирования

Логика проверок:

у гида не может быть два бронирования на одну дату

максимум 10 участников на один тур

⚙️ Использованные технологии

Laravel 10, PHP 8, MySQL

Валидация через FormRequest

Ресурсы (JsonResource) для чистых API-ответов

Статусы ошибок: 200, 400, 422

🧩 Решение

Миграции

guides — хранит имя, опыт (в годах) и статус активности

hunting_bookings — хранит бронирования с датой, количеством участников и связью с гидом

Валидация (StoreHuntingBookingRequest)

Проверяет корректность полей (required, date, max:10)

Гарантирует, что guide_id существует

Контроллер HuntingBookingController

Проверяет:

не занят ли гид в этот день

не превышен ли лимит участников (<=10)

Если всё ок → создаёт запись и возвращает JSON

Контроллер GuideController

Возвращает только активных гидов

Поддерживает фильтр ?min_experience=3

Ресурсы (GuideResource, HuntingBookingResource)

Приводят вывод API к чистому и читаемому JSON


🦌 WildHunter Booking Module (Laravel)

This module extends a base BookingCore system with the ability to manage and book hunting tours — including guide management, availability checks, and validation logic.

🚀 Features

Guides Management

Model: Guide

Fields: name, experience_years, is_active

Endpoint: GET /api/guides (with optional filter ?min_experience=)

Tour Bookings

Model: HuntingBooking

Fields: tour_name, hunter_name, guide_id, date, participants_count

Endpoint: POST /api/bookings

Validates:

The selected guide is not already booked on the same date.

The number of participants does not exceed 10.

The guide exists and is active.

Automatic Validation

Validation handled via StoreHuntingBookingRequest

Includes a custom error message in Russian:

Максимум 10 участников на тур.


RESTful Responses

201 Created — Booking successfully created

422 Unprocessable Entity — Validation or double-booking errors

200 OK — For successful GET requests

⚙️ API Endpoints
Method	Endpoint	Description
GET	/api/guides	List all active guides
GET	/api/guides?min_experience=3	Filter guides by experience
POST	/api/bookings	Create a new booking
Example Request:
POST /api/bookings
{
  "tour_name": "Bear Hunt",
  "hunter_name": "Alex Smith",
  "guide_id": 1,
  "date": "2025-11-20",
  "participants_count": 4
}

Example Response:
{
  "id": 7,
  "tour_name": "Bear Hunt",
  "hunter_name": "Alex Smith",
  "guide_id": 1,
  "date": "2025-11-20",
  "participants_count": 4,
  "created_at": "2025-11-02T19:00:00Z",
  "updated_at": "2025-11-02T19:00:00Z"
}

🧪 Tests

Feature tests ensure correctness of the booking logic:

Test	What it Verifies
✅ it_prevents_double_booking_for_the_same_guide_and_date()	The system refuses a booking if the guide is already booked that day
✅ it_allows_booking_when_guide_is_free_and_participants_are_valid()	A booking succeeds when conditions are valid
✅ it_rejects_when_participants_exceed_limit()	Booking fails if participants_count > 10

Run tests:

php artisan test


All tests should pass:

PASS  Tests\Feature\HuntingBookingTest
✓ it prevents double booking for the same guide and date
✓ it allows booking when guide is free and participants are valid
✓ it rejects when participants exceed limit

🧩 Integration into BookingCore

To integrate with the existing BookingCore structure:

Place migrations under /database/migrations.

Register API routes in routes/api.php.

Add the WildHunterServiceProvider (optional) to modularize the feature.

Extend the base booking system with BookingType = 'hunting'.

🧠 Tech Stack

Laravel 11

PHP 8.3

SQLite (Testing) / MySQL (Production)

PHPUnit Feature + Unit Tests

REST API Architecture

🏁 Summary

This module demonstrates:

Clean Laravel architecture (Models, Requests, Controllers)

RESTful response design

Validation best practices

Unit and Feature testing discipline