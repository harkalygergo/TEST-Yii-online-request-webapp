# TEST Yii online requests webapp
###### 2025.06.24.2

## Megoldások

- Yii2 felhasználása
- konfigurációs adatok kiszervezése dotenv fájlba, .env.dist példafájl
- rendszer felállítása domain név alatt
- fejlesztés vezetése GitHub-on
- GitHub workflow bevezetése az automatikus szoftverkiadáshoz
- sikertelen bejelentkezés számolása, email superadminnak

## Továbbfejlesztési lehetőségek

- validációk hozzáadása a felhasználói űrlaphoz
- develop / release branch-ek bevezetése, a GitHub workflow-ban is
- password salt bevezetése dotenv-en keresztül
- sikertelen bejelentkezések után IP tiltás

## Requirements
- PHP 8.2
- MySQL 7
- Yii Framework 2.x
- Composer

## How to install?

- Clone source code from GitHub
- Run `composer install` command in yii2 directory
- Update Composer dependencies with `composer update` command
- Copy `.env.dist` to `yii2/.env` and modify.
- Point your web server document root to the `web` directory of the cloned repository.
- Migrate database with `php yii migrate` command
- Update NPM dependencies with `npm install` command
- Build assets with `npm run build` command
- Update Webpack Encore with `npm run encore production` command
- Run the application with `php yii serve` command
- Access the application at `http://localhost:8080`
- Create an `.htaccess` file in the root directory with the following content to enable URL rewriting:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?$1 [QSA,L]
</IfModule>
```

## Task

Készíts egy web alapú szoftvert, amely egy weboldalon keresztül fogadja egy építőipari vállalkozás ügyfeleitől érkező igényeket egy űrlapon.
A beérkező igényekhez a felhasználónak kelljen megadnia: Név, E-mail cím, Munka típusa (állapotfelmérés, alapozás-előkészítés, építkezés, műszaki ellenőrzés), Munka részletezése (szövegesen).

A felhasználó kapjon visszajelzést, hogy fogadta a rendszer az igényeit.

A szoftver tárolja az igényeket.

Készíts egy háttérfolyamatot, amely CSV formátumba exportálja a beérkezett igényeket.

A CSV-be kerüljön bele az összes mező, amelyet a felhasználó kitöltött, továbbá:

- igény beérkezésének időpontja
- egyéb információk a beküldőről (IP cím, stb.)

A háttérfolyamatnak lehessen megadni, hogy milyen időszakban beérkezett igényeket kérdezze le (hónapra vonatkozóan, tehát pl. lehessen csak a 2025-05 hónapban érkezett igényeket CSV-be exportálni).
