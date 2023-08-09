# Laravel News Management API

Welcome to the Laravel News Management API! This API allows you to manage news articles and comments associated with them.

## Table of Contents

- [Installation](#installation)
- [API Documentation](#api-documentation)
- [Features](#features)

## Installation

Follow these steps to set up and run the project:

1. **Clone the Repository**: Clone this repository to your local machine using the following command:

    ```sh
    git clone https://github.com/your-username/your-repo.git
    ```

2. **Navigate to Project Directory**: Change your current working directory to the project folder:

    ```sh
    cd your-repo
    ```

3. **Install Dependencies**: Install the required PHP dependencies using Composer:

    ```sh
    composer install
    ```

4. **Create `.env` File**: Copy the example `.env` file and configure it with your environment settings:

    ```sh
    cp .env.example .env
    ```

    Make sure to set your database connection details, application URL, and other required settings.

5. **Generate App Key**: Generate the application key:

    ```sh
    php artisan key:generate
    ```

6. **Generate Passport Keys**: Generate the keys required for Laravel Passport:

    ```sh
    php artisan passport:keys
    ```

7. **Migrate Database**: Run the database migrations to create tables:

    ```sh
    php artisan migrate
    ```

8. **Create Passport Personal Access Client**: Create a personal access client for Laravel Passport:

    ```sh
    php artisan passport:client --personal
    ```

9. **Start Development Server**: Start the Laravel development server:

    ```sh
    php artisan serve
    ```

   The application will be accessible at `http://127.0.0.1:8000`.

10. **Run Tests (Optional)**: If you want to run tests, use the following command:

    ```sh
    php artisan test
    ```

You have successfully set up the project! You can now create, update, and retrieve news, manage comments, and interact with the API endpoints.

## API Documentation

For detailed information on how to use the API endpoints, refer to the [API Documentation](doc/api-documentation.md).

## Features

- Create, read, update, and delete news articles.
- Comment on news articles.
- Retrieve news details along with associated comments.
- Pagination support for news articles and comments.

---
