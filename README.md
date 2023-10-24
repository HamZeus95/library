# Symfony PHP Library App

Welcome to the Symfony PHP Library App! This is a sample Symfony application that demonstrates how to manage a library where an author can have many books, and books can have many readers. This README will guide you through the setup process.

## Table of Contents
- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
- [Usage](#usage)
- [Contributing](#contributing)
- [Contact](#contact)

## Prerequisites

Before you begin, ensure you have the following prerequisites installed on your system:

1. **PHP 8.2 or later** 

2. **Composer** 

3. **Symfony CLI (optional but recommended)** 

4. **MySQL or another supported database**  

## Getting Started

Clone this repository to your local machine:

1. **Clone the Repository**: Clone this repository to your local machine using Git:

    ```bash
    git clone https://github.com/HamZeus95/library
    ```

2. **Install the project dependencies using Composer:**: Navigate to the project directory and install vendor:

    ```bash
    cd library
    composer install
    ```

3. **Create the database and make migration using Symfony console:** 

    ```bash
    symfony console doctrine:database:create
    symfony console make:migration
    symfony console doctrine:migrations:migrate
    ```

## Usage

Once you done with databse configuration make this command :

    symfony serve

Visit the application in your web browser at http://127.0.0.1:8000.
    

## Contributing

If you would like to contribute to the development of this symfony application, please feel free to submit a pull request. We welcome any enhancements, bug fixes, or additional features that can improve the application.

## Contact

If you have any questions, suggestions, or feedback regarding this application, please feel free to contact us:

- Email: benali.hamza@esprit.tn
- GitHub: [Your GitHub Profile](https://github.com/HamZeus95) 

Happy coding!