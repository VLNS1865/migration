<?php
// IMPORTANT: Change this password before publishing the website.
// Use a long, unique password. The export endpoint requires it.
define('ADMIN_PASSWORD', 'CHANGE-THIS-TO-A-LONG-UNIQUE-PASSWORD');

// Data is stored locally in data/applications.json.
// Keep the data/ directory private; the included .htaccess blocks direct web access.
define('DATA_FILE', __DIR__ . '/data/applications.json');
