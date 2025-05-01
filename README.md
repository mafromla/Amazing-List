![amazing-list-LOGO](https://github.com/user-attachments/assets/4a91a6f7-145a-40d9-839a-4498bdb3951d)
# Amazing List  



# Amazing List

A modern **buy / sell / trade** marketplace built with **PHP 8, MySQL 8, HTML 5, CSS , and PHP**.  This README explains the folder layout, database setup, local‑development workflow, and contribution guidelines.

---

## 📑 Table of Contents

1. [Project Structure](#project-structure)
2. [Prerequisites](#prerequisites)
3. [Getting Started](#getting-started)
4. [Database Schema](#database-schema)
5. [Available Pages & Routes](#available-pages--routes)
6. [Development Guide](#development-guide)
7. [Deployment](#deployment)
8. [Roadmap](#roadmap)
9. [Versioning](#versioning)
10. [Contributing](#contributing)
11. [Contact](#contact)
12. [License](#license)

---

## Project Structure

```
AMAZINGLIST/
├── CSS/                       # All global & page‑specific style sheets
│   ├── style.css
│   ├── universal-style.css
│   ├── addlisting.css
│   ├── buy.css
│   ├── trade.css
│   ├── favorites.css
│   ├── messages.css
│   ├── profile.css
│   ├── productlisting.css
│   ├── register.css
│   └── placeholder
│
├── Database/                  # SQL scripts & migrations
│   └── schema.sql (example)
│
├── Images/                    # Optimised image assets
│   └── …
│
├── Pages/                     # Public‑facing PHP/HTML
│   ├── uploads/               # User‑uploaded images (runtime)
│   ├── add_favorite.php
│   ├── addlisting.php
│   ├── buypage.php
│   ├── connect.php
│   ├── delete_listing.php
│   ├── favorites.php
│   ├── fetch-buy-listings.php
│   ├── fetch-trade-listings.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── messages.php
│   ├── process-listing.php
│   ├── productlisting.php
│   ├── productlistingtest.html
│   ├── profile.php
│   ├── register.php
│   ├── send_message_or_offer.php
│   ├── sign-in.html
│   ├── tradepage.php
│   └── update-profile.php
│
├── Script/
│   └── script.js            
│
├── uploads/                   # (root‑level) fallback upload dir
├── README.md
└── .env.example               # Sample environment variables
```

---

## Prerequisites

| Tool / Service | Minimum Version | Notes                             |
| -------------- | --------------- | --------------------------------- |
| PHP            | 8.1             | PDO extension enabled             |
| MySQL          | 8.x             | or MariaDB 10.5+                  |
| Apache / Nginx | —               | mod\_rewrite (Apache) recommended |
|                |                 |                                   |

---

## Getting Started

1. **Clone the repo**
   ```bash
   git clone https://github.com/your-username/amazing-list.git
   cd amazing-list
   ```
2. **Copy the env template & adjust credentials**
   ```bash
   cp .env.example .env
   ```
3. **Import the database schema**
   ```bash
   mysql -u root -p < Database/schema.sql
   ```
4. **Start the server** (XAMPP / Laragon / PHP built‑in)
   ```bash
   php -S localhost:8000 -t .
   ```
5. **Visit** `http://localhost:8000/Pages/index.php`.

---

## Database Schema

| Table        | Purpose                          |
| ------------ | -------------------------------- |
| `User`       | Authentication & profile data    |
| `Categories` | Hierarchical item categories     |
| `Item`       | Listings (BUY or TRADE)          |
| `Favorites`  | Many‑to‑many between User & Item |
| `Messages`   | Private messages & offers        |
| `Reviews`    | Buyer → Seller feedback          |

---

## Available Pages & Routes

| Path                               | Type | Description                             |
| ---------------------------------- | ---- | --------------------------------------- |
| `/Pages/index.php`                 | PHP  | Landing page                            |
| `/Pages/buypage.php`               | PHP  | Browse items for sale                   |
| `/Pages/tradepage.php`             | PHP  | Browse items available for trade        |
| `/Pages/productlisting.php`        | PHP  | Single product details                  |
| `/Pages/addlisting.php`            | PHP  | Auth‑guarded form to post a new listing |
| `/Pages/profile.php`               | PHP  | User dashboard                          |
| `/Pages/messages.php`              | PHP  | Inbox & offers                          |
| `/Pages/register.php`              | PHP  | Create account                          |
| `/Pages/login.php`                 | PHP  | Sign in (username *or* email)           |
| `/Pages/send_message_or_offer.php` | PHP  | AJAX endpoint                           |

---

## Development Guide

### Coding Conventions

- **PSR‑12** coding standard for PHP. Run `phpcs --standard=PSR12 .` before committing.
- **Prepared statements only** (no interpolated SQL).
- Keep business logic out of templates. Re‑usable snippets live in `/includes/`.

### Git Workflow

1. Create an issue ➜ branch ➜ PR ➜ review ➜ merge.
2. Branch naming: `feature/login-modal`, `bugfix/price-validation`, `hotfix/v1.2.1-empty-msg`.
3. Commit style: `<type>(scope): summary`, e.g. `feat(auth): allow email login`.

---

## Deployment

| Target              | Notes                                          |
| ------------------- | ---------------------------------------------- |
| **GitHub Pages**    | Front‑end only (static build)                  |
| **Render.com**      | Free PHP runtime & MySQL add‑on                |
| **Self‑hosted VPS** | Ubuntu 22.04, Apache 2.4, PHP 8.3 FPM, Certbot |

---

## Roadmap

-

---

## Versioning

We follow **Semantic Versioning**: `MAJOR.MINOR.PATCH`.

| Tag      | Date       | Highlights                          |
| -------- | ---------- | ----------------------------------- |
| `v0.2.1` | 2025‑05‑02 | Updated file tree & README          |
| `v0.2.0` | 2025‑04‑30 | Added PHP backend, basic auth modal |
| `v0.1.0` | 2025‑03‑15 | Static front‑end prototype          |

---

## Contributing

1. Fork → clone → create a branch.
2. Write clear, self‑reviewed code.
3. Run `php -l` and any JS tests (coming soon).
4. Open a Pull Request explaining **what** & **why**.

---

## Contact

Mohamed Ali\
GitHub: [https://github.com/mafromla](https://github.com/mafromla)\
LinkedIn: [www.linkedin.com/in/mohamed-ali-982321275](http://www.linkedin.com/in/mohamed-ali-982321275)

---

## License

© 2025 Amazing List — All rights reserved.

This project is licensed for **educational use**. Contact the owner for commercial licensing options.


