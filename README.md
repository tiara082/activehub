# ActiveHub Setup

## Requirements

* PHP >= 8.2
* Composer
* MySQL

## Installation

1. Clone repository
   git clone https://github.com/tiara082/activehub.git

2. Masuk folder
   cd activehub

3. Install dependency
   composer install

4. Copy env
   cp .env.example .env

5. Generate key
   php artisan key:generate

6. Run migration
   php artisan migrate

7. Run project
   php artisan serve
