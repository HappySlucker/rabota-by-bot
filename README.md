# ![RabotaBy Bot](logo.png) 

# About RabotaBy Bot

---

An automated **Selenium WebDriver** assistant designed to keep your visibility high on Rabota.by. This bot handles the repetitive task of updating your resumes so you can focus on getting interviewed.

## 🚀 Key Features

---

* **Automated Authentication:** Logs into your account securely using your phone number and password.
* **Smart Scheduling:** Automatically "boosts" (updates) your resumes in search results every **4 hours and 10 minutes**.
* **Business Hours Focus:** The update cycle begins daily at **10:00 AM** to maximize visibility when recruiters are active.

## ⚙️ Configuration

---

Configuration is read from environment variables. Copy the example file and fill in your values:

```bash
cp .env.example .env
```

Minimum required variables:

```dotenv
ACCOUNT_COUNTRY=BY # Options: RU, BY, KZ, UZ
ACCOUNT_PHONE=+375XXXXXXXXX
ACCOUNT_PASSWORD=your_password_here
```

The `.env` file is ignored by Git and is never overwritten by project updates.

### Feature modules

Enabled modules are configured in `config/modules.php` and can be toggled from `.env`:

```dotenv
ENABLE_RESUME_UPDATER=true
```

To add a new module, implement `App\Bot\Module\BotModule` and register it in `config/modules.php`. The `Handler` runs `Auth` first, then every enabled module in order.

## 🛠 Application Launch Guide

---

Follow these commands to get the bot up and running:

### 1. Build and Start
Build the environment and launch the containers:
```bash
make build
make up
```

### 2. Connect to Container
If you need to access the PHP-CLI environment manually:
```bash
make bash SERVICE=php
```