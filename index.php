<?php

if (version_compare(PHP_VERSION, '8.2.0', '<')) {
    die("❌ LỖI: Server đang chạy PHP " . PHP_VERSION . ". Laravel yêu cầu ít nhất 8.2. Hãy kiểm tra lại file .htaccess!");
}

require __DIR__.'/public/index.php';
