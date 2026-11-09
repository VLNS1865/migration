SERVER 1865 - MIGRATION APPLICATION WEBSITE
============================================

WHAT IS INCLUDED
- index.html       Public application form
- style.css        Website design
- app.js           Form submission logic
- submit.php       Saves applications on your hosting server
- admin.html       Private Excel download page (no admin dashboard)
- export.php       Password-protected export endpoint
- config.php       Admin password setting
- data/            Stores applications in applications.json

IMPORTANT REQUIREMENTS
Your web hosting must support PHP 7.4+ (PHP 8+ recommended).
Upload the contents of this folder to your hosting's public web directory
(for example public_html). Do not upload the ZIP file itself as the website.

SETUP
1. Open config.php on your computer before uploading.
2. Replace:
   CHANGE-THIS-TO-A-LONG-UNIQUE-PASSWORD
   with a strong, unique admin password.
3. Upload all files and the data folder to your hosting.
4. Make sure the data folder is writable by PHP. If submissions fail,
   ask your hosting provider to set suitable permissions for that folder
   (commonly 750 or 755 depending on the hosting configuration).
5. Open your domain to test the application form.
6. Admin export page:
   https://YOUR-DOMAIN/admin.html
   Enter the password you set in config.php.
7. The site downloads:
   Server_1865_Migration_Applications.xlsx

HOW THE EXCEL EXPORT WORKS
- Every submitted application is stored on your hosting server.
- No Google account or external database is required.
- The admin export is protected by the password in config.php.
- The Excel file is sorted from highest to lowest Total Heroes Power.
- The workbook contains all seven requested player fields, a rank, and
  the submission timestamp.
- The Excel download uses the SheetJS library from jsDelivr CDN, so the
  admin browser needs an internet connection when exporting.

SECURITY AND PRIVACY
- Use HTTPS on your domain.
- Set a long unique admin password before publishing.
- Do not share the admin.html URL or password publicly.
- Keep data/ and config.php protected. The included .htaccess blocks
  direct access to the data directory on Apache hosting.
- The application form collects only the fields requested for recruitment.
- Back up data/applications.json regularly. It contains all applications.
- If your hosting uses Nginx rather than Apache, ask the host to block
  direct public access to /data/ and config.php; .htaccess is ignored by Nginx.

NOTE
This package is a ready-to-upload PHP website, not a hosted website.
You still need a domain and PHP-compatible hosting to publish it.

LANGUAGES
The public application page includes a language switcher for Arabic, English,
Turkish, Thai, Indonesian, and Korean. The selected language is remembered
in the visitor's browser. Form submissions are stored in the same fields,
regardless of the language used to submit.

MOBILE SUPPORT
The public page is responsive for phones, tablets, and desktop screens.
The layout, form fields, language selector, and buttons adapt to narrow screens.
