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

Before launching the application, you must provide your Rabota.by credentials. Edit the `config/app.php` file and update the `account` array:

```php
'account' => [
    'country'  => 'BY', // Options: RU, BY, KZ, UZ
    'phone'    => '+375XXXXXXXXX',
    'password' => 'your_password_here'
],
```

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