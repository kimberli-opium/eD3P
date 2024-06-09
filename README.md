This repository provides a Laravel application designed to manage customers, products, and orders, and to send email notifications when orders are created. The application utilizes a queue system for handling background tasks and notifications.

## Features

- **Customer Management**: Create and retrieve customer details via HTTP requests.
- **Product Management**: Create and retrieve product details via HTTP requests.
- **Order Management**: Create and retrieve order details via HTTP requests.
- **Email Notifications**: Sends email notifications to customers when an order is processed, utilizing Laravel queues.

## Getting Started

### Prerequisites

- PHP 8.2 or later
- Composer
- SQLite (configured in `.env` file)

### Installation

1. **Clone the Repository**:
    ```bash
    git clone https://github.com/kimberli-opium/eD3P.git
    cd eD3P
    ```

2. **Install Dependencies**:
    ```bash
    composer install
    ```

3. **Environment Setup**:
    - Copy `.env.example` to `.env` and adjust configuration if necessary.
    ```bash
    cp .env.example .env
    ```
   
    - Generate an application key.
    ```bash
    php artisan key:generate
    ```

4. **Database Setup**:
    - Run the migrations to set up the SQLite database.
    ```bash
    php artisan migrate
    ```

After copying the .env file, ensure the DB_DATABASE variable contains the absolute path to your SQLite database file. 


### Running the Application

1. **Start the Development Server**:
    ```bash
    php artisan serve
    ```
   The application will be available at `http://localhost:8000`.

2. **Start the Queue Worker**:
    ```bash
    php artisan queue:work
    ```
   This will process queued jobs for sending email notifications.

### Testing the Application

- Mock HTTP requests for creating and retrieving customers, products, and orders can be found in the `Requests` folder. You can use tools like [Postman](https://www.postman.com/) or [cURL](https://curl.se/) to test these endpoints.

- Logs, including job processing and application errors, can be found in `storage/logs/laravel.log`.

## Code Structure

- **Controllers**:
    - The business logic for handling HTTP requests can be found in the `app/Http/Controllers` directory.
    - These controllers manage customer, product, and order CRUD operations.

- **Notifications**:
    - Email notifications are implemented in `app/Notifications/OrderShipped.php`.
    - This class sends an email when an order is created and is invoked by the queue job.

- **Queue Jobs**:
    - The queue job responsible for processing orders and sending notifications is found in `app/Jobs/ProcessOrder.php`.

## How It Works

1. **Customer Management**:
    - Customers can be created and retrieved via HTTP requests. The necessary endpoints are implemented in `app/Http/Controllers/CustomerController.php`.

2. **Product Management**:
    - Products can be created and retrieved via HTTP requests. The corresponding logic is in `app/Http/Controllers/ProductController.php`.

3. **Order Management**:
    - Orders can be created and retrieved via HTTP requests. The relevant code is in `app/Http/Controllers/OrderController.php`.

4. **Email Notification**:
    - When an order is created, an email notification is sent to the customer. This process is handled by `app/Jobs/ProcessOrder.php`, which dispatches the notification implemented in `app/Notifications/OrderCreated.php`.
