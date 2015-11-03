<?php 

define('DATE_TIME_FORMAT', 'Y-m-d H:i:s');
define('TIMESTAMP_FORMAT', 'Y-m-d G:i:s');
define('DATE_FORMAT', 'Y-m-d');

define('IS_AJAX', Request::ajax());
define('AJAX_ERROR', 'HTTP/1.1 500 Server Processing Error');