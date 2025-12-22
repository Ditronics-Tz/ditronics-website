# Ditronics CMS (PHP)

A production-ready, pure PHP CMS migrated from Next.js. Zero frameworks, zero dependencies beyond PHP core extensions.

## Features

- **No Frameworks**: Pure PHP with PDO, JSON, sessions - no Laravel, Symfony, or WordPress
- **Same Design**: Identical frontend to the original Next.js implementation
- **Admin Panel**: Full CRUD for laptops, settings, and contact inquiries
- **Session-based Auth**: Secure authentication with password_hash, CSRF protection
- **SQLite Database**: Lightweight, file-based database (easily swappable to MySQL/PostgreSQL)
- **File Uploads**: Secure image uploads with validation
- **Responsive Design**: Mobile-first CSS matching the original implementation

## Requirements

- PHP 8.0+ (tested on PHP 8.3)
- Extensions: PDO, pdo_sqlite, session, json, fileinfo

## Installation

### Option 1: PHP Built-in Server (Development)

```bash
cd cms-php/public
php -S localhost:8000
```

### Option 2: Apache with .htaccess

1. Point your web server's document root to `cms-php/public/`
2. Ensure `mod_rewrite` is enabled
3. The included `.htaccess` handles URL rewriting

### Option 3: Nginx

```nginx
server {
    listen 80;
    server_name example.com;
    root /path/to/cms-php/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
        expires 1y;
        add_header Cache-Control "public";
    }
}
```

## Directory Structure

```
cms-php/
├── public/                 # Web root (point server here)
│   ├── index.php          # Single entry point
│   ├── .htaccess          # Apache URL rewriting
│   ├── css/               # Stylesheets
│   │   └── styles.css     # Main CSS (mirrors Tailwind classes)
│   ├── images/            # Static images
│   └── uploads/           # User uploads
│       └── laptops/       # Laptop images
├── app/
│   ├── config/
│   │   └── config.php     # Configuration constants
│   ├── core/
│   │   ├── Database.php   # PDO wrapper with prepared statements
│   │   ├── Router.php     # Custom URL router
│   │   ├── Auth.php       # Session-based authentication
│   │   ├── CSRF.php       # CSRF protection
│   │   ├── View.php       # Template rendering with output buffering
│   │   └── Helpers.php    # Utility functions
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── PageController.php
│   │   ├── LaptopController.php
│   │   ├── AuthController.php
│   │   └── AdminController.php
│   └── views/
│       ├── layouts/       # Page layouts
│       │   ├── main.php   # Public layout
│       │   └── admin.php  # Admin layout
│       ├── pages/         # Page templates
│       │   ├── home.php
│       │   ├── services.php
│       │   ├── studio.php
│       │   ├── contact.php
│       │   ├── laptops.php
│       │   ├── laptop-detail.php
│       │   └── 404.php
│       ├── admin/         # Admin templates
│       │   ├── login.php
│       │   └── dashboard.php
│       └── partials/      # Reusable components
│           ├── navbar.php
│           └── footer.php
├── storage/
│   ├── cache/             # File cache
│   └── logs/              # Application logs
├── data/                  # Symlink to ../data (SQLite database)
└── database/
    └── migrations/        # SQL migrations (if needed)
```

## Configuration

Edit `app/config/config.php`:

```php
// Database path (default: SQLite)
define('DB_PATH', ROOT_PATH . '/data/ditronics.db');

// Site settings
define('SITE_NAME', 'Ditronics');
define('SITE_URL', 'https://yourdomain.com');

// Default admin (only used for initial setup)
define('DEFAULT_ADMIN_USERNAME', 'admin');
define('DEFAULT_ADMIN_PASSWORD', 'Ditronics@2036');
```

## Default Credentials

- **Username**: admin
- **Password**: Ditronics@2036

⚠️ **Change these immediately in production!**

## Routes

### Public Routes
- `GET /` - Homepage
- `GET /services` - Services page
- `GET /studio` - Studio page
- `GET /contact` - Contact form
- `POST /contact` - Submit contact form
- `GET /laptops` - Laptop catalog
- `GET /laptops/{slug}` - Laptop detail page

### Admin Routes
- `GET /admin/login` - Login page
- `POST /admin/login` - Authenticate
- `POST /admin/logout` - Logout
- `GET /admin` - Dashboard

### API Routes (Admin only)
- `GET/POST/PUT/DELETE /api/laptops` - Laptop CRUD
- `GET/PUT /api/settings` - Settings
- `GET/PUT/DELETE /api/inquiries` - Contact inquiries

## Security Features

1. **CSRF Protection**: All POST requests require valid CSRF token
2. **SQL Injection Prevention**: 100% prepared statements
3. **XSS Prevention**: All output escaped with `htmlspecialchars`
4. **Secure Sessions**: httpOnly, secure, sameSite cookies
5. **Password Hashing**: bcrypt with password_hash()
6. **File Upload Validation**: MIME type and size checks
7. **Rate Limiting**: Simple request throttling
8. **Security Headers**: X-Frame-Options, X-Content-Type-Options (via .htaccess)

## Performance Considerations

### PHP vs Next.js

| Aspect | PHP | Next.js |
|--------|-----|---------|
| Cold Start | ~10-50ms | ~200-500ms |
| Memory | 2-10MB/request | 50-200MB daemon |
| Scaling | Process per request | Single daemon + workers |
| Hosting | Shared hosting OK | Requires Node.js |

### Optimization Tips

1. **Enable OPcache** for PHP bytecode caching
2. **Use PHP-FPM** in production (not built-in server)
3. **Enable gzip compression** in web server
4. **Set proper cache headers** for static assets
5. **Consider Redis/Memcached** for session storage at scale

## Migration from Next.js

The migration process followed these steps:

1. **Database**: Same SQLite schema, data preserved
2. **Frontend**: HTML/CSS extracted from React components, converted to PHP templates
3. **API Routes**: Rebuilt as PHP controllers with same endpoints
4. **Auth**: Session-based auth replacing Next.js cookies
5. **SSR/SSG**: PHP renders pages directly (no hydration needed)
6. **API Calls**: Replaced with direct database queries

## Development

### Adding a New Page

1. Create controller in `app/controllers/`
2. Add route in `public/index.php`
3. Create view in `app/views/pages/`

### Adding New Fields

1. Add column to database (use SQLite CLI or migration script)
2. Update controller to handle field
3. Update views to display/edit field

## License

MIT License - Feel free to use for any purpose.
