# PHP Laravel University Coursework Archive

This repository is an archive of PHP Laravel university coursework.

## Repository Structure

The project is organized into task sets, each containing a web application:

- [BMI Calculator](src/bmi-calculator): Simple BMI calculator.
- [Insurance System](src/insurance-system): Insurance system that allows to perform CRUD operations on users and their cars.
- [Monthly Budget Planning System](src/monthly-budget): System for planning monthly budget and tracking expenses.
- [Online Store](src/online-store): Simple online shop that was written as an exam task.

## Running the Projects

1. **Navigate to the project folder & install dependencies**:
   ```bash
   cd src/bmi-calculator
   composer install
   ```

2. **Environment & Database Configuration:**
    Copy the example environment file:
    ```bash
    cp .env.example .env
    ```

    Open the .env file and configure your database credentials.

    Generate the application key and run the migrations:
    ```bash
    php artisan key:generate
    php artisan migrate
    ```

3. **Start the Laravel development server:**
    ```bash
    php artisan serve
    ```

4. **Access the application:**
    Open your browser and navigate to: `http://127.0.0.1:8000`

## License

This project is licensed under The Unlicense - see the [LICENSE.md](LICENSE.md) file for details.
