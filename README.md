
# 🚗 PHP Rent-a-Car System

[PHP Rent-a-Car](https://github.com/alexmihalascu/php_rentacar) is a car rental management system built in vanilla PHP. This project is designed to streamline the car rental process, making it easy to manage bookings, client information, and vehicle inventory.

## 📋 Requirements

- **XAMPP**: Download and install XAMPP to set up a local server environment for this project.
- **PHPMyAdmin**: Used for database management.

## 🚀 Installation Steps

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/alexmihalascu/php_rentacar.git
   ```

2. **Move Project to XAMPP’s htdocs Folder**:
   - Copy the project folder into the `htdocs` directory in your XAMPP installation. Example path:
     ```bash
     C:/xampp/htdocs/php_rentacar
     ```

3. **Start XAMPP**:
   - Launch XAMPP and start **Apache** and **MySQL** modules.

4. **Create the Database**:
   - Open your browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
   - Create a new database named `InchirieriAuto`.
   - Import the database schema:
     - Click on `InchirieriAuto` and select `Import`.
     - Choose the `.sql` file located in the repository (usually found in the `database` folder) to create the necessary tables and structure.

5. **Update Database Connection in Project Files**:
   - In the project files, locate the configuration file (e.g., `config.php`) and update it with your database credentials:
     ```php
     define('DB_SERVER', 'localhost');
     define('DB_USERNAME', 'root');
     define('DB_PASSWORD', '');
     define('DB_NAME', 'InchirieriAuto');
     ```

6. **Access the Project in the Browser**:
   - Open your browser and navigate to [http://localhost/php_rentacar](http://localhost/php_rentacar).

## 🛠️ Features

- **Car Management**: Easily add, update, or delete car entries.
- **Booking System**: Manage rentals, including availability, customer details, and booking history.
- **Customer Management**: Store customer information for easier management and quick look-up.
- **Reports**: Generate basic reports based on bookings and availability.

## 🤝 Contributions

Contributions are welcome! Feel free to fork this repository and submit a pull request.

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).
