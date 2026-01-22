# 🔐 Web Vuln Testing (VulnShop)

> ⚠️ **DISCLAIMER**  
> Project ini berisi **aplikasi web yang sengaja dibuat memiliki kerentanan** dan **TIDAK AMAN** untuk penggunaan produksi.  
> Digunakan **hanya untuk pembelajaran, simulasi, dan latihan keamanan siber** pada lingkungan yang kamu miliki izin penuh.

---

## 🎯 Tentang Project
**Web Vuln Testing (VulnShop)** adalah aplikasi web sederhana yang dibuat sebagai **lab pengujian keamanan web**.  
Project ini ditujukan untuk **pemula (newbie)** yang ingin memahami dasar-dasar kerentanan web secara praktik langsung.

---

## ✨ Fitur
- Login Admin (simulasi autentikasi)
- Database dummy untuk pengujian
- Struktur kode sederhana & mudah dipahami
- Cocok untuk latihan Web Pentesting dasar

---

## 🧰 Teknologi yang Digunakan
- PHP (Native)
- MySQL / MariaDB
- Apache (XAMPP / LAMP / WAMP)

---

## ✅ Prasyarat
Pastikan sudah terinstall di sistem kamu:
- PHP 7.x / 8.x
- MySQL atau MariaDB
- Web Server (Apache/Nginx)
- phpMyAdmin (opsional)

💡 **Rekomendasi untuk pemula:** gunakan **XAMPP**

---

## 🚀 Cara Instalasi & Menjalankan

### 1️⃣ Download / Clone Repository
```bash
git clone https://github.com/Apriyanto28/web-vuln-testing.git
cd web-vuln-testing
````

Atau download manual lalu extract ke folder web server.

---

### 2️⃣ Buat Database

Buat database baru dengan nama:

```text
vulnshop
```

Import file SQL yang disertakan pada repository.

Contoh via phpMyAdmin:

1. Buka phpMyAdmin
2. Buat database `vulnshop`
3. Import file `.sql`

---

### 3️⃣ Konfigurasi Database

Buka file:

```text
db.php
```

Sesuaikan konfigurasi database:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "vulnshop";
```

---

### 4️⃣ Jalankan Aplikasi

Pindahkan folder project ke:

* **XAMPP:** `htdocs/`
* **LAMP:** `/var/www/html/`

Akses melalui browser:

```text
http://localhost/web-vuln-testing/
```

---

## 🔑 Akun Default

Gunakan akun berikut untuk login:

| Role  | Username | Password |
| ----- | -------- | -------- |
| Admin | admin    | admin123 |

> Kredensial ini sengaja dibuat sederhana untuk keperluan lab/testing.

---

## 🧪 Catatan Pembelajaran

Beberapa hal yang bisa dipelajari dari project ini:

* Validasi input yang lemah
* Otentikasi dan session
* Pengelolaan database
* Error handling & informasi sensitif

⚠️ **Selalu lakukan pengujian secara etis dan legal.**

---

## 🤝 Kontribusi

Kontribusi sangat terbuka:

1. Fork repository
2. Buat branch fitur
3. Commit perubahan
4. Buat Pull Request

---

## 📜 Lisensi

Project ini dibuat untuk **pembelajaran keamanan siber**.
Gunakan sesuai kebutuhan edukasi dan riset pribadi.

---

## 🙌 Penutup

✨ **Have fun with Web Security Testing!**
Belajar keamanan siber dimulai dari memahami bagaimana sebuah sistem bisa menjadi rentan.

