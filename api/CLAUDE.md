# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Scribe Flow is a comprehensive writing project management system built with Laravel 12 and Vue 3. It enables authors to manage writing projects with features like AI-powered content generation, project tracking, and comprehensive metadata management.

## Architecture

### Core Models
- **Piece**: Central writing project model with comprehensive metadata (genre, tone, theme, POV, tense, status, word counts, dates)
- **User**: Standard Laravel user model with Fortify authentication
- **Lists**: Lookup tables for piece attributes (PieceGenre, PieceTone, PieceTheme, Pov, PieceTense, PieceStatus, PieceType)
- **GeneratorRequest**: Tracks AI generation requests and responses
- **Tag**: Spatie tags integration for flexible categorization

### Key Services
- **GeneratorAiService**: AI content generation using Prism PHP library
- **GeneratorContentService**: Content generation orchestration
- **PrepareAiRequestService**: AI request preparation and formatting
- **ContentGeneratorFactory**: Factory pattern for different generator types

### API Structure
- RESTful API with versioned routes (`api/v1/`)
- Laravel Sanctum for API authentication
- Spatie Query Builder for advanced filtering/sorting
- Custom Actions pattern for business logic (PieceCreateAction, PieceUpdateAction, etc.)

### Frontend Integration
- Vue 3 with Vite for asset compilation
- TailwindCSS for styling
- Concurrent development with Laravel backend

## Common Development Commands

### Development Environment
```bash
# Start all development services (server, queue, logs, vite)
composer run dev

# Individual services
php artisan serve
php artisan queue:listen --tries=1
php artisan pail --timeout=0
npm run dev
```

### Testing & Quality
```bash
# Run all tests and quality checks
composer test

# Individual checks
composer run test:unit          # PHPUnit tests with 100% coverage requirement
composer run test:types         # PHPStan static analysis
composer run test:lint          # Laravel Pint code style
composer run test:rector        # Rector code refactoring checks
composer run test:type-coverage # Pest type coverage (min 100%)
```

### Code Quality Tools
```bash
# Fix code style issues
composer run lint

# Run static analysis
composer run test:types

# Run Rector for code improvements
composer run rector
```

### Database Operations
```bash
# Run migrations
php artisan migrate

# Fresh database with seeding
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name

# Create seeder
php artisan make:seeder TableNameSeeder
```

### AI Integration
The application uses multiple AI providers via Prism PHP:
- OpenAI (GPT models)
- Anthropic (Claude models)
- Ollama (local models)
- OpenRouter (various models)

Configure providers in `config/generators.php` and respective environment variables.

## Development Patterns

### Action Classes
Business logic is organized in Action classes:
- `PieceCreateAction`: Creates new pieces
- `PieceUpdateAction`: Updates existing pieces
- `PieceGenerateAction`: Handles AI content generation
- Follow single responsibility principle

### DTOs (Data Transfer Objects)
- `PieceCreateItem`: Piece creation data
- `PieceStoreItem`: Piece storage data
- `PromptItem`: AI prompt configuration
- `GeneratorItem`: AI generator configuration

### Model Relationships
- Pieces belong to User and multiple List models
- Soft deletes enabled on Pieces and Tags
- Global scopes for filtering (PieceWithScope)
- Spatie slugs for SEO-friendly URLs

### Testing Strategy
- 100% code coverage requirement
- 100% type coverage requirement
- Pest testing framework
- Parallel test execution
- Feature and Unit test separation

## Queue System
- Laravel Horizon for queue monitoring
- Jobs for AI content generation (GenerateContentJob)
- Redis-based queues for production

## Code Style & Standards
- Laravel Pint for code formatting
- PHPStan level 9 for static analysis
- Rector for automated code improvements
- Strict type declarations
- Comprehensive docblocks for models

## Environment Configuration
Key environment variables:
- AI provider configurations (OPENAI_*, ANTHROPIC_*, OLLAMA_*, OPEN_ROUTER_*)
- Database settings
- Queue configuration
- Horizon settings

## File Structure Notes
- Models organized by domain (Pieces/, Lists/)
- Services in app/Services/
- DTOs in app/Dtos/
- Actions in app/Actions/
- API controllers in app/Http/Controllers/api/v1/
- Custom scopes in app/Models/*/Scopes/
