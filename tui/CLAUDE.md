# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

### Development Environment Setup
```bash
# Create conda environment
conda env create -f environment.yml

# Activate environment
conda activate scribe

# Install development dependencies
pip install -e .[dev]
```

### Development Commands
```bash
# Run the application
python -m scribe

# Run tests
pytest

# Code formatting
black src/

# Linting
ruff src/

# Type checking
mypy src/

# Development mode with hot reload
textual dev src/scribe/app.py
```

### Build and Package
```bash
# Build package
python -m build

# Install local package
pip install -e .
```

## Architecture

### Application Structure
- **Main App**: `src/scribe/app.py` - Core Textual application class with screen management
- **Entry Point**: `src/scribe/main.py` - Application entry point
- **API Client**: `src/scribe/api/client.py` - HTTP client for Laravel backend communication
- **Screens**: `src/scribe/screens/` - Individual screen components (Home, Login, Dashboard)

### Key Components
- **Scribe App**: Main application class inheriting from Textual's App
- **Screen Management**: Uses Textual's screen system with named screens (home, login, dashboard)
- **API Integration**: Async HTTP client using httpx for backend communication
- **Authentication**: Token-based auth flow with user session management

### Screen Flow
1. **Home Screen**: Welcome/landing screen with login option
2. **Login Screen**: Authentication form with email/password
3. **Dashboard Screen**: Main application interface post-authentication

### Configuration
- Environment variables loaded from `.env` file
- API base URL and key configurable via environment
- Development/production modes supported

### Dependencies
- **Textual**: Terminal UI framework
- **httpx**: Async HTTP client
- **pydantic**: Data validation
- **python-dotenv**: Environment configuration

## Development Notes

### Code Style
- Line length: 88 characters (Black/Ruff configuration)
- Python 3.13+ required
- Async/await patterns for API calls
- Type hints encouraged (mypy configuration present)

### API Integration
- Backend expects Laravel API structure
- Authentication via Bearer tokens
- Error handling with httpx exceptions
- Base URL configurable for different environments

### Testing
- pytest framework configured
- pytest-asyncio for async test support
- Test structure should mirror src/ directory