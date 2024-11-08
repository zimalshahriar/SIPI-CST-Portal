# SIPI-CST-Portal

## Overview

The **SIPI-CST-Portal** is a web application designed for the **Computer Science and Technology (CST)** department of **Shyamoli Ideal Polytechnic Institute (SIPI)**. This portal serves as a centralized platform for students, teachers, and administrators to manage academic activities efficiently. It offers features such as user management, announcements, class schedules, and subject management.

## Features

- **User Management**: 
  - Admin can add, edit, and delete user accounts for students and teachers.
  - Role-based access control for different user types: Admin, Teacher, and Student.

- **Announcements**: 
  - Admin can create and manage announcements visible to all users.

- **Class Schedule Management**: 
  - Teachers can create and manage class schedules based on subjects assigned for specific semesters.

- **Subject Management**: 
  - Admin can add, edit, and delete subjects linked to specific semesters.
  - Teachers can view subjects and manage associated class schedules.

- **Responsive Design**: 
  - Built using Bootstrap 5.3 for a modern and mobile-friendly user interface.

## Technologies Used

- **Frontend**: HTML, CSS, Bootstrap 5.3, JavaScript
- **Backend**: PHP
- **Database**: MySQL

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/SIPI-CST-Portal.git


2. **Navigate to the project directory:**
   ```bash
   cd SIPI-CST-Portal
   ```

3. **Set up your database:**
   - Import the SQL files located in the `db` directory to create the necessary tables (`users`, `notices`, `subjects`, etc.) in your MySQL database.

4. **Configure your database connection:**
   - Update the `database.php` file with your database credentials.

5. **Start your web server:**
   - Use a local server like XAMPP, WAMP, or a similar server environment to run the PHP application.

6. **Access the portal in your web browser:**
   - Navigate to `http://localhost/SIPI-CST-Portal` (or your server's address).

## Usage

1. **Admin Login**: Use the default credentials to log in as an admin.
   - User ID: `admin-1`
   - Password: `your_password`

2. **User Management**: Admin can add, edit, and delete users through the manage user interface.

3. **Manage Announcements**: Admin can create, edit, and delete announcements for users.

4. **Manage Subjects**: Admin can add, edit, or delete subjects for specific semesters.

5. **Class Schedule**: Teachers can view and manage class schedules based on assigned subjects.

## Contributing

Contributions are welcome! If you have suggestions or improvements, please fork the repository and submit a pull request.

1. **Fork the repository**
2. **Create your feature branch:**
   ```bash
   git checkout -b feature/YourFeature
   ```

3. **Commit your changes:**
   ```bash
   git commit -m "Add some feature"
   ```

4. **Push to the branch:**
   ```bash
   git push origin feature/YourFeature
   ```

5. **Open a pull request**

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
---

Thank you for using the SIPI-CST-Portal! We hope it enhances your academic experience at SIPI.
```
