# Airo coding challenge

This repository contains the code I wrote for the technical challenge from Airo.

Some parts of the project may look a bit over-engineered because I wanted to show my understanding 
of software architecture and separation of concerns. Other parts are simple because I had limited time to finish the challenge.

The app is organized in the following layers:

- `Controllers`: Receive HTTP requests and validate them with the help of the `FormRequests`, and move the data to the `Service` layer.

- `Services`: Contain the main application/business logic, to keep controllers clean and easy to read.

- `Repositories`: It's not an implementation of the Repository pattern. It's another layer to separate the database 
  access from the services. They are optional/useless in this challenge, but I added them to show separation of concerns.

Another additional directories have been created:

- `Dtos`: Instead of sending the raw Request object or just an array from the `Controller`
  to the `Service`, I used a DTO (Data Transfer Object) to pass the data in a more
  strongly typed and organized way.

- `Enums`: Helpers for predefined sets of options, making the code cleaner and easier to read.

## Tests

A few Feature and Unit tests were added to verify the correctness of the API endpoints and the business logic. These tests cover both successful and error cases.

## Notes

- The app uses localStorage to store the JWT token. While this is fine for small apps or demos, in production, 
  HttpOnly cookies are preferred to avoid XSS vulnerabilities.

- The project was completed in under 5 hours, so some trade-offs were made between speed and full structure.

## Project setup

Note: To run this project `Docker`, and `Docker compose` must be installed in the host machine.

1. Clone the repository: `git clone git@github.com:smarulanda97/airo-challenge.git`.
2. Move to the project directory: `cd airo-challenge`.
3. Copy the .env.example file: `cp .env.example .env`.
4. Buid and create the containers: `docker compose up -d laravel.test mysql`.
5. Run composer install: `docker compose exec -it laravel.test composer install`.
6. Run the migrations, and seed the database: `docker compose exec -it laravel.test php artisan migrate:fresh --seed`.
7. Access the coding challenge page: `http://localhost`. You can log in using the following user (seeded automatically):
   - **Email:** test@example.com
   - **Password:** 123456

## Tech stack

- PHP 8.4 (Laravel 12)
- MySQL
- Docker + Docker Compose
- Alpine.js + Blade + Axios/Fetch (no frontend framework)
