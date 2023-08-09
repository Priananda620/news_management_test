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
    git clone https://github.com/Priananda620/news_management_test
    ```

2. **Navigate to Project Directory**: Change your current working directory to the project folder:

    ```sh
    cd news_management_test
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

7. **Migrate Database**: Run the database migrations to create tables and the seeders (user and role):

    ```sh
    php artisan migrate:fresh --seed
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

### Authentication

To use the API endpoints that require authentication, you need to authenticate your requests using the provided `login` endpoint. After successful authentication, you will receive an access token that should be included in the headers of subsequent requests.

- **Endpoint**: `/login`
- **Method**: POST
- **Parameters**:
  - `email`: User's email
  - `password`: User's password

#### Example:

```http
POST /api/login HTTP/1.1
Host: your-app-url
Content-Type: application/json

{
  "email": "prianandaazhar@yopmail.com",
  "password": "password123"
}

### Authenticated Routes

Once you have obtained the access token, you can access the following routes that require authentication:

#### Get User Details

- **Endpoint:** `/getUser`
- **Method:** `GET`

#### Get User Role

- **Endpoint:** `/getUserRole`
- **Method:** `GET`

#### Post Comment (Requires User Role: 2)

- **Endpoint:** `/comment/post`
- **Method:** `POST`
- **Middleware:** `checkUserRole:2`

#### Get All News

- **Endpoint:** `/news`
- **Method:** `GET`

#### Get News Details with Comments

- **Endpoint:** `/news/get-news-details/{news_id}`
- **Method:** `GET`

#### Create News (Requires User Role: 1)

- **Endpoint:** `/news/post`
- **Method:** `POST`
- **Middleware:** `checkUserRole:1`

#### Update News (Requires User Role: 1)

- **Endpoint:** `/news/update/{id}`
- **Method:** `POST` (Due to form data with image)
- **Middleware:** `checkUserRole:1`

#### Delete News (Requires User Role: 1)

- **Endpoint:** `/news/delete/{id}`
- **Method:** `DELETE`
- **Middleware:** `checkUserRole:1`

Please ensure that you include the necessary headers, parameters, and payloads when making requests to these endpoints.



## Features

- Create, read, update, and delete news articles.
- Comment on news articles.
- Retrieve news details along with associated comments.
- Pagination support for news articles and comments.

---
