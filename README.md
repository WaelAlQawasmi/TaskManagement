# Task Management Backend API Documentation

This documentation outlines the API endpoints and usage for the Task Management backend.

## Authentication

### Sign Up

- **Endpoint:** `/api/signup`
- **Method:** POST
- **Description:** Registers a new user.
- **Request Body:**
  - `email` (string, required): User's email address.
  - `name` (string, required): User's name.
  - `password` (string, required): User's password.
- **Response:** Returns user data if successful.

### Log In

- **Endpoint:** `/api/login`
- **Method:** POST
- **Description:** Logs in a user.
- **Request Body:**
  - `email` (string, required): User's email address.
  - `password` (string, required): User's password.
- **Response:** Returns authentication token if successful.

## Task Management

### Create Task

- **Endpoint:** `/api/task`
- **Method:** POST
- **Description:** Creates a new task.
- **Request Body:**
  - `title` (string, required): Task title.
  - `description` (string, required): Task description.
- **Authentication:** Required.
- **Authorization:** All authenticated users can create tasks.
- **Response:** Returns created task data.

### Get All Tasks

- **Endpoint:** `/api/task`
- **Method:** GET
- **Description:** Retrieves all tasks.
- **Authentication:** Required.
- **Authorization:** Requires admin role.
- **Response:** Returns list of all tasks.

### Get Specific Task

- **Endpoint:** `/api/task/{task}`
- **Method:** GET
- **Description:** Retrieves a specific task.
- **Authentication:** Required.
- **Authorization:** Authenticated user must be assigned to the task, or be the task creator, or have admin role.
- **Response:** Returns specific task data.

### Update Specific Task

- **Endpoint:** `/api/task/{task}`
- **Method:** PUT
- **Description:** Updates a specific task.
- **Request Body:** Same as Create Task.
- **Authentication:** Required.
- **Authorization:** Authenticated user must be the task creator or have admin role.
- **Response:** Returns updated task data.

### Delete Specific Task

- **Endpoint:** `/api/task/{task}`
- **Method:** DELETE
- **Description:** Deletes a specific task.
- **Authentication:** Required.
- **Authorization:** Authenticated user must be the task creator or have admin role.
- **Response:** Returns success message upon deletion.

### Mark Task as Completed

- **Endpoint:** `/api/mark-tasks-completed/{task}`
- **Method:** POST
- **Description:** Marks a specific task as completed and sends email notification to task creator.
- **Authentication:** Required.
- **Authorization:** Authenticated user must be assigned to the task.
- **Response:** Returns success message.

### Assign Task to User

- **Endpoint:** `/api/assign-task/{task}`
- **Method:** POST
- **Description:** Assigns a task to a specific user and sends email notification to assigned user.
- **Request Body:**
  - `assignedUserId` (integer, required): ID of the user to assign the task to.
- **Authentication:** Required.
- **Authorization:** All authenticated users can assign tasks.
- **Response:** Returns success message.

### Filter Tasks

- **Endpoint:** `/api/tasks-filter/{status}`
- **Method:** GET
- **Description:** Filters tasks based on status (pending or completed).
- **Authentication:** Required.
- **Authorization:** For logged-in user's tasks or all users' tasks based on status.
- **Response:** Returns filtered tasks.

## Other Endpoints

### Log Viewer

- **URL:** `/log-viewer`
- **Description:** Access log viewer for admin users.

## Setup

- Clone the project 
- > composer install --no-dev
- > cp .env.example .env
-  set the DB configuration in `.env` file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=send-grid-token
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="username-send-grid"
MAIL_FROM_NAME="${APP_NAME}"
```
- > php artisan key:generate
- > php artisan migrate
- >  php artisan migrate --seed
- > php artisan passport:install

## To run test 
> php artisan test

