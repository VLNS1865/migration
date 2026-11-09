SERVER 1865 - GITHUB PAGES + GOOGLE SHEETS
===========================================

GitHub Pages cannot run PHP. This version stores applications in Google Sheets
using Google Apps Script. The site remains on GitHub Pages.

SETUP THE GOOGLE BACKEND
1. Sign in to the Google account that should own the applications.
2. Open https://script.google.com/ and create a New project.
3. Open Code.gs in this package, copy its full contents into the Apps Script editor.
4. Save. Select setup() in the function list and click Run.
5. Approve the Google permissions. Open the Execution log and copy the private
   spreadsheet URL shown there. Keep this sheet private.
6. Click Deploy > New deployment > select Web app.
7. Set "Execute as" to Me and "Who has access" to Anyone. Deploy and authorize.
8. Copy the Web app URL ending in /exec.

CONNECT THE WEBSITE
1. Open app.js and find GOOGLE_SCRIPT_URL near the bottom.
2. Replace PASTE_YOUR_GOOGLE_APPS_SCRIPT_WEB_APP_URL_HERE with your Web app URL.
   Keep the quotation marks.
3. Upload/commit the updated website files to GitHub Pages.
4. Test a submission and confirm that a row appears in the Google Sheet.

ADMIN / EXCEL
Open the private Google Sheet. It sorts applications automatically by Total
Heroes Power, highest first. Download Excel using:
File > Download > Microsoft Excel (.xlsx)
No separate admin dashboard is needed. Keep the spreadsheet private.

IMPORTANT
- Do not upload the old PHP files; GitHub Pages does not run PHP.
- Deploy the Apps Script as Execute as Me / Anyone, or public submissions fail.
- The browser sends a no-cors POST to Apps Script. It cannot read detailed
  server-side errors, so confirm the first test row appears in the Sheet.
- Anyone who knows the Apps Script web app URL can submit; consider CAPTCHA or
  other abuse prevention if the public form receives spam.
- If you change Code.gs later, use Deploy > Manage deployments > Edit >
  New version > Deploy.
- Keep your Google Sheet private and share only with trusted administrators.
