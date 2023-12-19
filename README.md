# Laravel RESTful API Project with JWT
This is a README file for a Laravel API project that implements JWT (JSON Web Token) authentication and provides RESTful routes for managing books. It serves as a guide for developers to understand the project structure, dependencies, configuration, and usage.

### Documentation
After the project is up and running you can enter in this url to see the API documentation:

http://localhost/api/documentation

:warning: To perform the api calls run the project configuration before.

### Project Structure
The project structure follows Laravel's default structure with some additions and modifications specific to this API:

- app/Http/Controllers/AuthController.php: Contains the controller responsible for handling auth-related API requests.
- app/Http/Controllers/BookController.php: Contains the controller responsible for handling book-related API requests.
- app/Http/Resources/BookResource.php: Defines the resource transformation for books returned by the API.
- app/Models/Book.php: Represents the Book model.
- routes/api.php: Defines the API routes for managing books.
- config/jwt.php: Configuration file for JWT authentication.

### Dependencies
- Laravel framework: Laravel is the foundation of the project
- JWT-auth: A package for JWT authentication in Laravel.

Make sure to review the composer.json file for the complete list of dependencies and their versions.

### Configuration

1. Clone the project repository.
2. Run composer install to install the project dependencies.
3. Configure your database connection in the .env file.
4. Run the database migrations using php artisan migrate.
5. Run the database seeder migrations using php artisan db:seed.
6. Generate the JWT secret key using php artisan jwt:secret.
7. Modify the config/jwt.php file to adjust JWT settings if needed.
8. Set up your web server or use Laravel's built-in development server with php artisan serve.

### Usage
Once the project is set up and the server is running, you can start making API requests to manage books. The following are the available routes:

 - GET /api/books | Retrieves a list of books
 - POST /api/books | Creates a new book
 - GET /api/books/{book} | Retrieves a specific book based on ID
 - PUT /api/books/{book} | Updates a specific book
 - DELETE /api/books/{book} | Deletes a specific book (SoftDelete)

:warning: To perform CRUD (Create, Read, Update, Delete) operations on books, you need to include a valid JWT token in the Authorization header of your API requests.

### Authentication
To authenticate with the API, follow these steps:

1. Send a POST request to /api/login with the following JSON payload: { 'email': 'your-email@example.com', 'password': 'your-password' }
2. If the credentials are valid, the API will respond with a JWT token. Else, the API will respond a 401.
3. Include the token in the Authorization header of subsequent API requests using the Bearer scheme.

Make sure to replace your-email@example.com and your-password with your actual email and password for authentication.

### Testing
To run automated tests in project use:

 - php artisan test

