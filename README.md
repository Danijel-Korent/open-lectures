# open-lectures
Prototype for a web platform that aggregates free and public university lectures available on platforms like YouTube

The plan is basically to make an interactive version of the following list:
https://hr.wikipedia.org/wiki/Suradnik:Danijel.Korent/Popis_besplatnih_i_javno_dostupnih_sveu%C4%8Dili%C5%A1nih_video_predavanja

(Disclaimer: I'm not a web developer and I have no idea what I'm doing)

The latest version is online here:
https://otvorena-predavanja.hr

English version URL: pending

## Short-term todo

- Translate everything to English
- Buy an English domain and move the hosting there
- Change the title from "KB" to something more descriptive
- Add a report "dead link" button on each course
- Add wiki and phpBB to supplement this app on the English domain

## Planned features

### Basic

- [DONE] List of categories
- [DONE] In each category: a list of courses with links to YouTube playlists
- [DONE] Counter of total hours for all lectures in the database

### Extended

- [DONE] Search option
- List all courses of a specific university/professor
- Reporting dead links

### Community

- Rating the courses or single videos
- Adding annotations and tags to the lectures 
- Option to register/login
- Platform marks your watched videos or courses
- Discussion/QA forum for each video
- User can put courses on the todo/want-to-watch list

# Technical info

## Technology Stack

- Backend: PHP with custom MVC-like structure
- Database: Dual support for either MySQL or SQLite
- Frontend: Tailwind CSS with Alpine.js for interactivity

## File Structure

```
open-lectures/
├── admin/                 # Admin panel interface
│   ├── category/         # Category management
│   ├── courses/          # Course management
│   ├── lecturer/         # Lecturer management
│   ├── university/       # University management
│   └── login/            # Admin authentication
├── assets/               # Static assets
│   ├── css/             # Stylesheets
│   └── images/          # Images and icons
├── database/             # Database layer
│   ├── config.php       # Database configuration
│   ├── repo.php         # Repository pattern implementation
│   └── storage.php       # Data storage abstraction
├── partials/             # Reusable UI components
│   ├── header.php       # Site header
│   ├── footer.php       # Site footer
│   ├── layout.php       # Main layout template
│   └── admin_layout.php # Admin layout template
├── categories/           # Public category pages
├── category/             # Individual category view
├── search/               # Search functionality
├── stats/                # Statistics and analytics
└── index.php            # Main entry point
```

## Configuration

All runtime options now live in `constants.php` inside the `$appConfig` array. Use the global `config('section.key')` helper after including `constants.php` to read any value.

### Core Keys
- `app.*`: Site name plus error-reporting flags (e.g., disable `display_errors` in production).
- `database.driver`: Switch between `mysql` and `sqlite`.
- `database.mysql.*`: Host, username, password, database, port, and charset for the MySQL connection.
- `database.sqlite.*`: File path, schema file, and permission mask for the SQLite database.
- `paths.uploads.*`: Filesystem destinations for category, lecturer, and university uploads.
- `urls.assets`: Base URL used when rendering static assets.

### Database Setup
1. Choose the engine by setting `database.driver` to either `mysql` or `sqlite`.
2. For MySQL, fill in the `database.mysql` credentials.
3. For SQLite, adjust `database.sqlite.file` and `database.sqlite.schema` if you store the DB elsewhere.
4. The schema helper (`database/sqlite_schema.sql`) is applied automatically when a new SQLite file is created.

## Database Structure

The application uses a SQLite database with the following tables:

### Core Tables

#### `admin` - Administrator Accounts
- `id` (INTEGER PRIMARY KEY) - Unique admin identifier
- `name` (TEXT NOT NULL) - Admin display name
- `email` (TEXT NOT NULL) - Admin email address
- `password` (TEXT NOT NULL) - Hashed password
- `created_at` (TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP) - Account creation timestamp

#### `categories` - Course Categories
- `id` (INTEGER PRIMARY KEY) - Unique category identifier
- `name` (TEXT) - Category name (e.g., "Biologija", "Matematika")
- `image` (TEXT) - Category image filename

#### `courses` - Course Information
- `id` (INTEGER PRIMARY KEY) - Unique course identifier
- `name` (TEXT) - Course title
- `language` (TEXT) - Course language (e.g., "Engleski")
- `year` (TEXT) - Course year
- `n_lectures` (INTEGER) - Number of lectures
- `t_duration` (INTEGER) - Total duration in hours
- `course_code` (TEXT) - University course code
- `description` (TEXT) - Course description
- `link_1` (TEXT) - Primary video link (YouTube playlist)
- `link_2` (TEXT) - Secondary link (university page)
- `image` (TEXT) - Course thumbnail image URL
- `universityId` (INTEGER) - Foreign key to institutions table
- `categoryId` (INTEGER) - Foreign key to categories table
- `lecturerId` (INTEGER) - Foreign key to lecturers table

#### `institutions` - Universities/Institutions
- `id` (INTEGER PRIMARY KEY) - Unique institution identifier
- `name` (TEXT) - Institution name
- `country` (TEXT) - Country location
- `city` (TEXT) - City location
- `u_image` (TEXT) - Institution logo image filename

#### `lecturers` - Course Lecturers
- `id` (INTEGER PRIMARY KEY) - Unique lecturer identifier
- `firstName` (TEXT) - Lecturer's first name
- `lastName` (TEXT) - Lecturer's last name
- `l_image` (TEXT) - Lecturer profile image filename

### Sample Data

The database comes pre-populated with:

- **1 admin account** (admin@gmail.com)
- **14 categories** including Biologija, Kemija, Fizika, Matematika, Povijest, Psihologija, Računarstvo, Ekonomija, Elektrotehnika, Filozofija, Pedagogija, Politologija, and Nekategorizirano
- **17 institutions** including major universities like MIT, Stanford, Yale, Columbia, Harvard, Oxford, and others
- **99 lecturers** from various universities
- **102 courses** covering diverse subjects from biology and physics to computer science and philosophy

### Database Features

- **Foreign Key Relationships**: Courses are linked to institutions, categories, and lecturers
- **Image Management**: Support for category, institution, and lecturer images
- **Multilingual Support**: Courses can be in different languages
- **Metadata**: Comprehensive course information including duration, lecture count, and descriptions
- **Dual Link System**: Both video links and official course pages