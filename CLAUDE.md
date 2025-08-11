# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 11 application for a University Exam Archives system. It allows users to upload, manage, and archive exam documents with an approval workflow system.

## Development Commands

### Environment Setup
- Copy `.env.example` to `.env`: `cp .env.example .env`
- Generate application key: `php artisan key:generate`
- Run database migrations: `php artisan migrate`

### Development Server
- Start development server: `php artisan serve`
- Compile frontend assets (development): `npm run dev`
- Build frontend assets (production): `npm run build`

### Database
- Run migrations: `php artisan migrate`
- Rollback migrations: `php artisan migrate:rollback`
- Fresh migration with seeders: `php artisan migrate:fresh --seed`

### Testing
- Run all tests: `php artisan test` or `./vendor/bin/phpunit`
- Run specific test suite: `php artisan test --testsuite=Feature`
- Code formatting: `./vendor/bin/pint`

### Dependencies
- Install PHP dependencies: `composer install`
- Update PHP dependencies: `composer update`
- Install Node.js dependencies: `npm install`

## Architecture Overview

### Core Models
- **User**: Authentication with admin approval system (`is_approve`, `is_admin` fields)
- **Exam**: Main exam document entity with metadata (course info, dates, files)
- **File**: Additional files associated with exams
- **Message**: Broadcasting system for notifications
- **Department**: Academic departments
- **Academic**: Academic year management

### Key Features
- **Document Upload System**: Exams and files with PDF/DOCX support
- **Approval Workflow**: Admin approval required for user registration and document publication
- **Broadcasting System**: Message system with read/unread tracking
- **File Management**: Separate storage for exam documents and answer keys

### Database Configuration
- Default: SQLite (for development)
- Alternative: MySQL/PostgreSQL (commented in .env.example)

### Mail System
- Uses Mailjet for email notifications
- Approval, broadcast, and registration emails configured

### Frontend Stack
- Vite for asset compilation
- Bootstrap-based UI with custom styling
- Blade templating engine

### Storage Structure
- Exam documents: `storage/app/public/exam_documents/`
- Answer keys: `storage/app/public/answer_keys/`
- Profile pictures: User profile images
- Static assets: `public/` directory with organized subdirectories

### Authentication & Authorization
- Custom authentication with approval system
- Middleware protection for dashboard routes
- Role-based access (admin vs regular users)

### Key Route Groups
- Frontend routes: Landing page, login/registration
- Dashboard routes: Protected by auth middleware
- Admin functions: User approval, document management
- API-like routes: Search, filtering for exams