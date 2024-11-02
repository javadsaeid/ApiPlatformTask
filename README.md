# Project Documentation

## Table of Contents
- [Introduction](#introduction)
- [Installation](#installation)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)

## Introduction
This project is a web application built using PHP, JavaScript, React, and TypeScript. It uses Composer for PHP dependencies and npm for JavaScript dependencies. The project includes user management and API token generation functionalities.

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and npm
- Docker and Docker composer for db or postgresql installed locally.

### Steps
1. **Clone the repository:**
    ```sh
    git clone https://github.com/your-username/your-repository.git
    cd your-repository
    ```

2. **Install PHP dependencies:**
    ```sh
    composer install
    ```

3. **Install JavaScript dependencies:**
    ```sh
    npm install
    ```

4. **Set up the database:**
    ```sh
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:update --force
    ```

5. **Load fixtures:**
    ```sh
    php bin/console doctrine:fixtures:load
    ```

## Usage
1. **Start the development server:**
    ```sh
    symfony server:start
    ```

2. **Build the frontend assets:**
    ```sh
    npm run dev
    ```

3. **Access the application:**
   Open your browser and navigate to `http://localhost:8000`.

## Project Structure
```
.
├── assets
│   ├── React
│   │   └── app.tsx
│   ├── styles
│   │   └── app.css
├── src
│   ├── DataFixtures
│   │   └── AppFixtures.php
│   ├── Entity
│   │   └── ApiToken.php
│   ├── Factory
│   │   └── ApiTokenFactory.php
├── composer.json
├── package.json
└── ...
```

## Contributing
1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add some feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Open a pull request.

## License
This project is licensed under the MIT License. See the `LICENSE` file for more details.