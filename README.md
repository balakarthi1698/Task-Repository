
## Setup steps

1. Clone the repository
2. Copy .env.example to .env
3. Make sure of database connection details
4. Execute below commands
    - composer install
    - php artisan key:generate
    - php artisan migrate
    - php artisan serve
5. Now application will run in http://localhost:8000

## About App

1. Admin login can perform below operations:
    - Add new product item along with details
    - Edite existing product details
    - Remove product items
    - View profile details
    - View registered users list
2. User login can perform below:
    - View product details
    - Add product item to their cart
    - View cart list
    - View profile details
