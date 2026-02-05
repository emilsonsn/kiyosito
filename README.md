# ICO Platform Website

Welcome to the **ICO Platform Website** repository! This project is designed to provide a robust and user-friendly platform for managing Initial Coin Offerings (ICOs). Below, you will find detailed information about the project structure, features, installation, and usage.

---

## Table of Contents

1. [Project Overview](#project-overview)
2. [Features](#features)
3. [Project Structure](#project-structure)
4. [Installation](#installation)
5. [Usage](#usage)
6. [Assets](#assets)
7. [Contributing](#contributing)
8. [License](#license)
9. [Support](#support)

---

## Project Overview

The **ICO Platform Website** is a comprehensive solution for launching and managing ICO campaigns. It includes an admin panel for managing users, transactions, and configurations, as well as a frontend interface for users to participate in ICOs. The platform supports various payment gateways, multi-language support, and error handling.

---

## Features

- **Admin Panel**: Manage users, transactions, ICO phases, and settings.
- **Frontend Interface**: User-friendly interface for participating in ICOs.
- **Multi-Language Support**: Localization for global accessibility.
- **Payment Gateway Integration**: Supports multiple payment methods.
- **Error Handling**: Custom error pages for 404, 500, and other HTTP errors.
- **Security**: Includes CAPTCHA, Firebase integration, and secure password management.
- **Responsive Design**: Fully responsive and mobile-friendly design.
- **Whitepaper**: Includes a downloadable whitepaper for ICO details.

---

## Project Structure

The project is organized into the following directories:

### `src/assets`
Contains all static assets used in the project:
- **admin**: Admin-specific CSS, JS, and images.
- **errors**: Custom error page assets (CSS and images).
- **font**: Custom fonts used in the project.
- **global**: Global CSS, JS, and font files.
- **images**: Images used across the platform.
- **support**: Support-related assets.
- **templates**: Template files for different themes.
- **verify**: Verification-related assets.
- **whitepaper**: Contains the ICO whitepaper (`whitepaper.pdf`).

### `core`
Contains the backend logic and configuration:
- **app**: Application controllers, models, helpers, and middleware.
- **config**: Configuration files for app settings, database, mail, etc.
- **database**: Database migrations.
- **routes**: Route definitions for admin, user, and web interfaces.
- **storage**: Storage for logs, cache, and session data.
- **vendor**: Third-party libraries and dependencies.

---

## Installation

To set up the project locally, follow these steps:

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/Kiyosito/ico_platform.git
   cd ico-platform
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Set Up Environment Variables**:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update the `.env` file with your database credentials and other configurations.

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

6. **Start the Development Server**:
   ```bash
   php artisan serve
   ```

7. **Build Frontend Assets** (if applicable):
   ```bash
   npm run dev
   ```

---

## Usage

- Access the **Admin Panel** at `/admin`.
- Users can register and log in at `/login`.
- Customize the platform by modifying assets in the `src/assets` directory.
- Refer to the `whitepaper.pdf` for detailed ICO information.

---

## Assets

The `src/assets` directory contains all static files used in the project. Below is a breakdown of the key subdirectories:

- **admin/css**: Admin-specific stylesheets.
- **admin/js**: Admin-specific JavaScript files.
- **global/css**: Global stylesheets (e.g., Bootstrap, FontAwesome).
- **global/js**: Global JavaScript files (e.g., jQuery, Bootstrap).
- **images/frontend**: Frontend-specific images for banners, logos, and more.
- **whitepaper**: Contains the ICO whitepaper (`whitepaper.pdf`).

---

## Contributing

We welcome contributions from the community! To contribute:

1. Fork the repository.
2. Create a new branch for your feature or bugfix:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. Commit your changes:
   ```bash
   git commit -m "Add your commit message"
   ```
4. Push to your branch:
   ```bash
   git push origin feature/your-feature-name
   ```
5. Submit a pull request.

---

## License

This project is NOT licensed.

---

## Support

For any questions or issues, please contact us at:

- Email: support@kiyosito.io
- Website: [https://kiyosito.io](https://kiyosito.io)

Alternatively, open an issue in the repository for technical support.



