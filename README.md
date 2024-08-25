# Hotel-Management-Website-fullStack-
This repository contains the source code for a full-stack hotel management website developed using PHP, CSS, JavaScript, HTML, and SQL. The project is designed to handle various functionalities required for managing a hotel, including booking rooms, managing customer data, and handling payments. The database is managed using phpMyAdmin, and the project is hosted on a XAMPP server.

## Features

- **User Registration and Login:** Secure registration and login system for users.
- **Room Booking:** Users can browse available rooms, select dates, and book rooms.
- **Admin Panel:** Administrators can manage room availability, customer data, and bookings.
- **Payment Gateway Integration:** Simulated payment process for bookings.
- **Responsive Design:** Fully responsive design, ensuring compatibility with all devices.
- **Data Management:** All data is managed using MySQL with phpMyAdmin for database administration.

## Demo
### Frontend
![image](https://github.com/user-attachments/assets/88be5b8f-eec2-4cca-beb0-d82b63ed6c3f)
![image](https://github.com/user-attachments/assets/80a3a42c-6ac9-4eeb-b0b2-19488914e612)
![image](https://github.com/user-attachments/assets/ba91a46b-d4a7-4996-8ff1-e62008a699e5)

### Backend
![image](https://github.com/user-attachments/assets/067508ca-c6b7-414c-b5a5-418f1611789f) 
![image](https://github.com/user-attachments/assets/a0b84e43-a530-4a66-9f38-eb29d532b2f1)

## Technologies Used

- **Frontend:**
  - HTML
  - CSS
  - JavaScript
- **Backend:**
  - PHP
  - MySQL (phpMyAdmin)
- **Server:**
  - XAMPP (Apache, MySQL, PHP)
- **Version Control:**
  - Git

## Installation and Setup

To run this project locally, follow these steps:

### Prerequisites

- XAMPP installed on your machine
- Git installed on your machine

### Steps

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/your-username/hotel-management-website.git ````
2. **Start XAMPP:**
   - Open the XAMPP Control Panel.
   - Start the **Apache** and **MySQL** services by clicking on the "Start" button next to each.

3. **Set Up the Database:**
   - Open phpMyAdmin in your browser (usually at `http://localhost/phpmyadmin`).
   - Create a new database called `hotel_management`.
   - Import the SQL file located in the `database` directory of the project to set up the required tables.

4. **Configure the Database Connection:**
   - Open `connect.php` in the project directory.
   - Update the database credentials as needed:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = ""; // Default is empty
     $dbname = "hotel_management";
     ```

5. **Deploy the Project:**
   - Move the project folder to the `htdocs` directory of your XAMPP installation.
   - Access the project in your browser at `http://localhost/hotel-management-website`.
   
