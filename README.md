# Bad Twitter Clone aka Social Tweet

**Social Tweet** is a PHP-based application that uses modern development practices, including Composer for dependency 
management and PHPUnit for testing. The project was built using **PHP 8.3** for enhanced performance and new language features.

## Table of Contents

1. [Features](#features)
2. [Requirements](#requirements)
3. [Installation](#installation)
4. [Usage](#usage)
5. [Testing](#testing)
6. [Contributing](#contributing)
7. [License](#license)

---

## Features

- Modular and clean architecture
- Dependency management using Composer
- Unit testing support with PHPUnit
- Environment configuration via PHP dotenv
- Utilizes robust libraries like `graham-campbell/result-type`, `phpoption/phpoption`, and Symfony polyfills for enhanced compatibility

---

## Requirements

- PHP 8.3 or higher
- Composer
- Web server (e.g., Apache, Nginx)
- PDO-supported database (if the project uses a database)

---

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/your-repository.git
   ```

2. Navigate to the project directory:
   ```bash
   cd your-repository
   ```

3. Install dependencies via Composer:
   ```bash
   composer install
   ```

4. Copy the `.env.example` file to `.env` and configure environment variables:
   ```bash
   cp .env.example .env
   ```

5. Run migrations (if applicable):
   ```bash
   php artisan migrate
   ```

---

## Usage

To start the project locally, use the built-in PHP server or configure your web server (e.g., Apache/Nginx).

For example using PHP:
```bash
php -S localhost:8000 -t public
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

---

## Testing

Unit tests are written using **PHPUnit**. To run the tests, use the following command:

```bash
vendor/bin/phpunit
```

Ensure that you are using the correct PHP version (8.3 or greater) for accurate results.

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create your feature branch (`git checkout -b feature/AmazingFeature`).
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`).
4. Push to the branch (`git push origin feature/AmazingFeature`).
5. Open a pull request.

---

## License

This project is licensed under the **[MIT License](LICENSE)**. Feel free to use, modify, and distribute this project as permitted under the terms of the license.

---

## Acknowledgments

- Libraries used:
    - [`graham-campbell/result-type`](https://github.com/GrahamCampbell/ResultType)
    - [`phpoption/phpoption`](https://github.com/schmittjoh/php-option)
    - [`symfony/polyfill-*`](https://github.com/symfony/polyfill)
    - [`vlucas/phpdotenv`](https://github.com/vlucas/phpdotenv)
- Special thanks to all contributors of the used open-source libraries.