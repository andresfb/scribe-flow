# Query
I want to write an app to track my creative writing. The app will have an API in Laravel 12 with a MySQL backend, a web frontend using VueJS, and a TUI in PHP-TUI and Symfony (which consume the API).  
One of the features I want is to add a record for each piece (novel, short story) I want to write. I also want to add notes, images, references, links to sites, video clips, and such to that record to help with inspiration. Other features include the ability to track the piece status (seed, idea, planning, research, drafting, editing, etc.) and dates, character profiles, settings, POV, tense, genre, and others. Lastly, I need to keep a versioned record of my drafts.
Please provide me with the database schema and system design for such a system and suggest any other features you think the system could use.

# Response
I've created a comprehensive database schema and system design for your creative writing tracker. The design includes:

---

## Key Features Implemented:

1. Core Writing Management
- Pieces table for novels/short stories with status tracking
- Comprehensive metadata including POV, tense, genre
- Full version control with draft management and comparisons

2. Inspiration & Research
- Notes system with categorization
- Attachments for images, videos, and documents
- References manager for external sources

3. Story Elements
- Character profiles with detailed attributes
- Settings management with atmosphere and significance
- Plot outline support with multiple structure types

4. Progress Tracking
- Writing sessions with time and word count tracking
- Milestones and goals
- Comprehensive analytics

5. Advanced Features
- Chapter-by-chapter organization
- Feedback and beta reader management
- Submission tracking for publishing

## Additional Features I Recommend:

1. **Writing Habits**: Daily word count goals, streak tracking, and optimal writing time analysis
2. **AI Integration**: Grammar checking, plot hole detection, character name generation
3. **Export Options**: Multiple format support (DOCX, PDF, EPUB) with proper manuscript formatting
4. **World Building Tools**: Map creator, timeline builder, language tracker
5. **Mobile Companion**: Quick capture app with voice notes and offline sync
6. **Community Features**: Writing challenges, peer review exchange, achievement system

### The architecture is designed to be:

- **Scalable**: Proper indexing and caching strategies
- **Secure**: JWT auth, input validation, encryption for sensitive content
- **Performant**: Optimized queries, lazy loading, response caching
- **Maintainable**: Clear service layer separation, modular component structure

The system supports your three-tier approach (Laravel API, Vue frontend, PHP-TUI) with a clean separation of concerns and RESTful API design that both frontends can consume efficiently.
Would you like me to elaborate on any specific part of the design or help you implement any particular component?

---

# Creative Writing Tracker - Database Schema & System Design

## Database Schema

### Core Tables

#### users
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
);
```

#### pieces
```sql
CREATE TABLE pieces (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    genre VARCHAR(100) NULL,
    sub_genre VARCHAR(100) NULL,
    type ENUM('novel', 'short_story', 'novella', 'poem', 'screenplay', 'other') NOT NULL,
    status ENUM('seed', 'idea', 'planning', 'research', 'drafting', 'editing', 'revision', 'beta_reading', 'submission', 'published', 'abandoned') NOT NULL DEFAULT 'seed',
    pov ENUM('first_person', 'second_person', 'third_person_limited', 'third_person_omniscient', 'multiple', 'other') NULL,
    tense ENUM('past', 'present', 'future', 'mixed') NULL,
    synopsis TEXT NULL,
    target_word_count INT UNSIGNED NULL,
    current_word_count INT UNSIGNED DEFAULT 0,
    setting_time_period VARCHAR(255) NULL,
    setting_location VARCHAR(255) NULL,
    themes JSON NULL,
    tags JSON NULL,
    start_date DATE NULL,
    target_completion_date DATE NULL,
    completion_date DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_status (user_id, status),
    INDEX idx_slug (slug),
    INDEX idx_genre (genre)
);
```

### Content & Inspiration Tables

#### notes
```sql
CREATE TABLE notes (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NULL,
    content TEXT NOT NULL,
    type ENUM('general', 'plot', 'character', 'setting', 'dialogue', 'research', 'revision') DEFAULT 'general',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    INDEX idx_piece_type (piece_id, type)
);
```

#### attachments
```sql
CREATE TABLE attachments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    type ENUM('image', 'video', 'audio', 'document', 'other') NOT NULL,
    title VARCHAR(255) NULL,
    description TEXT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_size INT UNSIGNED NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    metadata JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    INDEX idx_piece_type (piece_id, type)
);
```

#### references
```sql
CREATE TABLE references (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    type ENUM('website', 'book', 'article', 'video', 'podcast', 'other') NOT NULL,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NULL,
    url VARCHAR(500) NULL,
    description TEXT NULL,
    notes TEXT NULL,
    accessed_date DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    INDEX idx_piece (piece_id)
);
```

### Character & Setting Tables

#### characters
```sql
CREATE TABLE characters (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    role ENUM('protagonist', 'antagonist', 'deuteragonist', 'tertiary', 'minor', 'other') NOT NULL,
    age VARCHAR(50) NULL,
    gender VARCHAR(50) NULL,
    occupation VARCHAR(255) NULL,
    physical_description TEXT NULL,
    personality_traits TEXT NULL,
    backstory TEXT NULL,
    motivations TEXT NULL,
    character_arc TEXT NULL,
    relationships TEXT NULL,
    additional_notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    INDEX idx_piece_role (piece_id, role)
);
```

#### settings
```sql
CREATE TABLE settings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    type ENUM('primary', 'secondary', 'mentioned') DEFAULT 'secondary',
    time_period VARCHAR(255) NULL,
    location VARCHAR(255) NULL,
    description TEXT NULL,
    atmosphere TEXT NULL,
    significance TEXT NULL,
    related_scenes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    INDEX idx_piece (piece_id)
);
```

### Version Control Tables

#### drafts
```sql
CREATE TABLE drafts (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    version_number INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    word_count INT UNSIGNED NOT NULL,
    notes TEXT NULL,
    is_major_version BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    INDEX idx_piece_version (piece_id, version_number),
    UNIQUE KEY unique_piece_version (piece_id, version_number)
);
```

#### draft_comparisons
```sql
CREATE TABLE draft_comparisons (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    from_draft_id BIGINT UNSIGNED NOT NULL,
    to_draft_id BIGINT UNSIGNED NOT NULL,
    diff_data JSON NOT NULL,
    additions_count INT UNSIGNED DEFAULT 0,
    deletions_count INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    FOREIGN KEY (from_draft_id) REFERENCES drafts(id) ON DELETE CASCADE,
    FOREIGN KEY (to_draft_id) REFERENCES drafts(id) ON DELETE CASCADE,
    INDEX idx_piece (piece_id)
);
```

### Progress & Analytics Tables

#### writing_sessions
```sql
CREATE TABLE writing_sessions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    piece_id BIGINT UNSIGNED NOT NULL,
    start_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP NULL,
    duration_minutes INT UNSIGNED NULL,
    words_written INT DEFAULT 0,
    starting_word_count INT UNSIGNED NOT NULL,
    ending_word_count INT UNSIGNED NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    INDEX idx_user_date (user_id, start_time),
    INDEX idx_piece_date (piece_id, start_time)
);
```

#### milestones
```sql
CREATE TABLE milestones (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    target_date DATE NULL,
    completed_date DATE NULL,
    type ENUM('word_count', 'chapter', 'draft', 'submission', 'custom') NOT NULL,
    target_value VARCHAR(255) NULL,
    actual_value VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    INDEX idx_piece_completed (piece_id, completed_date)
);
```

### Additional Feature Tables

#### plot_outlines
```sql
CREATE TABLE plot_outlines (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    structure_type ENUM('three_act', 'five_act', 'heros_journey', 'save_the_cat', 'custom') DEFAULT 'custom',
    outline_data JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    UNIQUE KEY unique_piece (piece_id)
);
```

#### chapters
```sql
CREATE TABLE chapters (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    chapter_number INT UNSIGNED NOT NULL,
    title VARCHAR(255) NULL,
    summary TEXT NULL,
    target_word_count INT UNSIGNED NULL,
    current_word_count INT UNSIGNED DEFAULT 0,
    status ENUM('planned', 'drafting', 'complete') DEFAULT 'planned',
    notes TEXT NULL,
    order_index INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    INDEX idx_piece_order (piece_id, order_index),
    UNIQUE KEY unique_piece_chapter (piece_id, chapter_number)
);
```

#### feedback
```sql
CREATE TABLE feedback (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    draft_id BIGINT UNSIGNED NULL,
    reviewer_name VARCHAR(255) NOT NULL,
    reviewer_email VARCHAR(255) NULL,
    type ENUM('beta_reader', 'editor', 'peer', 'professional', 'other') NOT NULL,
    overall_rating INT UNSIGNED NULL CHECK (overall_rating >= 1 AND overall_rating <= 5),
    comments TEXT NOT NULL,
    strengths TEXT NULL,
    weaknesses TEXT NULL,
    suggestions TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    FOREIGN KEY (draft_id) REFERENCES drafts(id) ON DELETE SET NULL,
    INDEX idx_piece (piece_id)
);
```

#### submission_tracking
```sql
CREATE TABLE submission_tracking (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    piece_id BIGINT UNSIGNED NOT NULL,
    publisher_name VARCHAR(255) NOT NULL,
    submission_type ENUM('agent', 'publisher', 'magazine', 'contest', 'anthology', 'other') NOT NULL,
    submission_date DATE NOT NULL,
    response_date DATE NULL,
    status ENUM('pending', 'accepted', 'rejected', 'revise_resubmit', 'withdrawn') DEFAULT 'pending',
    notes TEXT NULL,
    contact_info TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (piece_id) REFERENCES pieces(id) ON DELETE CASCADE,
    INDEX idx_piece_status (piece_id, status)
);
```

## System Architecture

### API Layer (Laravel 12)

#### Core API Endpoints

**Authentication**
- POST /api/auth/register
- POST /api/auth/login
- POST /api/auth/logout
- POST /api/auth/refresh
- GET /api/auth/user

**Pieces Management**
- GET /api/pieces (with filtering, sorting, pagination)
- POST /api/pieces
- GET /api/pieces/{id}
- PUT /api/pieces/{id}
- DELETE /api/pieces/{id}
- PATCH /api/pieces/{id}/status

**Drafts & Versioning**
- GET /api/pieces/{id}/drafts
- POST /api/pieces/{id}/drafts
- GET /api/drafts/{id}
- GET /api/drafts/{id}/compare/{otherId}
- POST /api/drafts/{id}/restore

**Characters & Settings**
- GET /api/pieces/{id}/characters
- POST /api/pieces/{id}/characters
- PUT /api/characters/{id}
- DELETE /api/characters/{id}
- Similar endpoints for settings

**Writing Sessions**
- POST /api/sessions/start
- POST /api/sessions/end
- GET /api/sessions/active
- GET /api/sessions/history

**Analytics**
- GET /api/analytics/dashboard
- GET /api/analytics/writing-stats
- GET /api/analytics/progress/{pieceId}

### Service Layer Architecture

```php
// Example Service Structure
namespace App\Services;

class PieceService {
    public function createPiece(array $data): Piece
    public function updatePiece(Piece $piece, array $data): Piece
    public function attachFile(Piece $piece, UploadedFile $file): Attachment
    public function createDraft(Piece $piece, string $content): Draft
    public function compareVersions(Draft $from, Draft $to): array
}

class WritingSessionService {
    public function startSession(User $user, Piece $piece): WritingSession
    public function endSession(WritingSession $session): WritingSession
    public function calculateStats(WritingSession $session): array
}

class AnalyticsService {
    public function getUserStats(User $user, ?DateRange $range = null): array
    public function getPieceProgress(Piece $piece): array
    public function getWritingStreak(User $user): int
}
```

### Frontend Architecture (VueJS)

#### Component Structure
```
src/
├── components/
│   ├── pieces/
│   │   ├── PieceList.vue
│   │   ├── PieceCard.vue
│   │   ├── PieceEditor.vue
│   │   └── PieceMetadata.vue
│   ├── drafts/
│   │   ├── DraftEditor.vue
│   │   ├── DraftComparison.vue
│   │   └── VersionHistory.vue
│   ├── characters/
│   │   ├── CharacterProfile.vue
│   │   └── CharacterList.vue
│   ├── writing/
│   │   ├── WritingSession.vue
│   │   └── WordCounter.vue
│   └── analytics/
│       ├── Dashboard.vue
│       ├── ProgressChart.vue
│       └── WritingCalendar.vue
├── stores/
│   ├── auth.js
│   ├── pieces.js
│   ├── drafts.js
│   └── sessions.js
└── views/
    ├── Home.vue
    ├── PieceDetail.vue
    ├── Writing.vue
    └── Analytics.vue
```

### TUI Architecture (PHP-TUI + Symfony)

#### Command Structure
```
src/
├── Command/
│   ├── PieceListCommand.php
│   ├── PieceCreateCommand.php
│   ├── WritingSessionCommand.php
│   └── StatsCommand.php
├── TUI/
│   ├── Screens/
│   │   ├── MainMenuScreen.php
│   │   ├── PieceListScreen.php
│   │   ├── WritingScreen.php
│   │   └── StatsScreen.php
│   └── Components/
│       ├── PieceTable.php
│       ├── WordCounter.php
│       └── ProgressBar.php
```

## Additional Feature Suggestions

### 1. **Writing Habits & Goals**
- Daily/weekly/monthly word count goals
- Writing streak tracking
- Habit formation features with reminders
- Time-of-day analysis for optimal writing periods

### 2. **AI Integration**
- Grammar and style checking
- Character name generator
- Plot hole detection
- Dialogue consistency checker
- Writing prompt generator

### 3. **Collaboration Features**
- Share pieces with beta readers
- Comment system for feedback
- Real-time collaborative editing
- Version control with branching for different story paths

### 4. **Export & Publishing**
- Export to various formats (DOCX, PDF, EPUB, Markdown)
- Manuscript formatting (standard manuscript format)
- Query letter templates and tracking
- Synopsis generator

### 5. **Research Organization**
- Web clipper browser extension
- OCR for scanned research materials
- Citation manager
- Research timeline visualization

### 6. **World Building Tools**
- Map creator/viewer
- Timeline builder for complex chronologies
- Language/dialect tracker
- Culture and society builder

### 7. **Mobile App**
- Quick note capture
- Voice-to-text for ideas on the go
- Offline synchronization
- Widget for daily word count

### 8. **Community Features**
- Writing challenges/competitions
- Peer review exchange
- Writing group management
- Achievement system/gamification

### 9. **Advanced Analytics**
- Sentiment analysis of chapters
- Pacing analysis
- Dialogue vs. narrative ratio
- Character appearance frequency
- Reading time estimates

### 10. **Integration Features**
- Google Docs sync
- Scrivener import/export
- Goodreads integration for published works
- Social media scheduling for book promotion

## Security Considerations

1. **API Security**
   - JWT authentication with refresh tokens
   - Rate limiting per endpoint
   - Input validation and sanitization
   - File upload restrictions and virus scanning

2. **Data Protection**
   - Encryption at rest for sensitive content
   - Regular automated backups
   - GDPR compliance features
   - Data export functionality

3. **Access Control**
   - Role-based permissions (if adding collaboration)
   - Piece-level privacy settings
   - API key management for third-party integrations

## Performance Optimization

1. **Database**
   - Implement database indexing strategy
   - Use read replicas for analytics queries
   - Cache frequently accessed data (Redis)
   - Optimize draft storage with compression

2. **API**
   - Implement response caching
   - Use eager loading to prevent N+1 queries
   - Paginate all list endpoints
   - Implement GraphQL for flexible data fetching

3. **Frontend**
   - Lazy load components
   - Implement virtual scrolling for large lists
   - Use service workers for offline functionality
   - Optimize bundle size with code splitting