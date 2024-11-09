# Visitor Sign-In Manager

## Overview
The **Visitor Sign-In Manager** is a Laravel-based application designed for businesses to manage visitor sign-ins efficiently. This project is particularly useful for environments like dentists' offices, doctors' clinics, and other businesses where customer check-ins are required.

The platform enables businesses to create customized sign-in forms that can be displayed on tablets or mobile devices. Visitors can sign in either by using a tablet in the business location or by scanning a QR code with their own devices.

## Features

- **Custom Sign-In Forms**: Easily create and customize sign-in forms based on your business needs.
- **Tablet-Friendly Display**: Designed to be loaded on tablets for easy customer sign-ins at the business location.
- **QR Code Support**: Customers can scan a QR code to load the sign-in page on their own devices.
- **Visitor Tracking**: View and manage the list of visitors who have signed in.

## Requirements

- PHP 8.0+
- Laravel 9.x
- MySQL or another supported database
- Composer
- Node.js & NPM

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/brentscholl/visitor-manager.git
   cd visitor-manager
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up the environment file:
   ```bash
   cp .env.example .env
   ```
   Update your `.env` file with the necessary database and app configurations.

4. Generate the application key:
   ```bash
   php artisan key:generate
   ```

5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. Run database seeders (optional):
   ```bash
   php artisan db:seed
   ```

7. Compile frontend assets:
   ```bash
   npm run dev
   ```

## Usage

- **Admin Dashboard**: Businesses can log into the admin panel to create and manage sign-in forms and view visitor data.
- **Visitor Sign-In**: Display the sign-in page on a tablet or provide a QR code for visitors to sign in from their personal devices.

### QR Code Feature

Each sign-in form generates a unique QR code. Businesses can display this QR code at their entrance, allowing visitors to sign in by scanning it with their mobile phones.
