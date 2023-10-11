# Cafe Management System

This repository contains the Cafe Management System project, an application designed to manage orders, users, and products for a cafe.

## Database Structure

The database for the Cafe Management System consists of several tables to store relevant information:

### Room

- **Fields:**
  - `room_no` (INT, PRIMARY KEY)

### User

- **Fields:**
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
  - `fullname` (VARCHAR(50), NOT NULL)
  - `email` (VARCHAR(50), NOT NULL, UNIQUE)
  - `hashed_password` (VARCHAR(100), NOT NULL)
  - `profile_img` (VARCHAR(255), NOT NULL)
  - `room_no` (INT, NOT NULL)
  - `ext` (INT, NOT NULL)
- **Foreign Key:**
  - `room_no` references `room(room_no)`

### Product

- **Fields:**
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
  - `name` (VARCHAR(50), NOT NULL)
  - `price` (INT UNSIGNED, NOT NULL)
  - `img` (VARCHAR(255), NOT NULL)
  - `is_available` (BOOLEAN, DEFAULT TRUE)

### Product Order

- **Fields:**
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
  - `user_id` (INT, NOT NULL)
  - `status` (ENUM('done', 'processing', 'out of delivery'), DEFAULT 'processing')
  - `order_date` (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
  - `notes` (TEXT)
  - `room_no` (INT, NOT NULL)
- **Foreign Keys:**
  - `user_id` references `user(id)`
  - `room_no` references `room(room_no)`

### Order Items

- **Fields:**
  - `order_id` (INT, NOT NULL)
  - `product_id` (INT, NOT NULL)
  - `quantity` (INT UNSIGNED, NOT NULL)
- **Foreign Keys:**
  - `order_id` references `product_order(id)`
  - `product_id` references `product(id)`

## Functionalities

### User (Frontend)

1. **User Registration:**

   - Users can register with their full name, email, hashed password, profile image, room number, and extension.

2. **User Login:**

   - Registered users can log in using their email and password.

3. **Ordering Drinks:**

   - Users can place orders for drinks.

4. **Cancel Orders:**
   - Users can cancel their placed orders.

### Admin (Backend)

1. **User Management:**

   - Admin can edit and delete user information.

2. **Product Management:**

   - Admin can edit and delete product information.

3. **Order Management:**
   - Admin can deliver orders.

## How to Run

1. **Setup the Database:**

   - Import the provided SQL schema into your database management system.

2. **PHP Server Setup:**

   - Set up a PHP server to run the project.

3. **Access the Project:**
   - Access the project by navigating to the appropriate URL in your web browser.

## Technologies Used

- **PHP:**

  - Used for backend server logic.

- **MySQL:**
  - Database management system to store and manage data.

This project is focused on server-side functionality using PHP, and no frontend frameworks have been utilized. Users can register, login, place orders, and cancel orders, while admins can manage users, products, and orders.
