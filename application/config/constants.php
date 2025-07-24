<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',              'rb');
define('FOPEN_READ_WRITE',            'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',    'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',  'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',          'ab');
define('FOPEN_READ_WRITE_CREATE',        'a+b');
define('FOPEN_WRITE_CREATE_STRICT',        'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',    'x+b');


/**
 * FOR BASE URL
 */
if (isset($_SERVER['HTTP_HOST'])) {
  $site_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
  $site_url .= '://' . $_SERVER['HTTP_HOST'];
  $site_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

  // Base URI (It's different to base URL!)
  $site_uri = parse_url($base_url, PHP_URL_PATH);
  if (substr($site_uri, 0, 1) != '/') $site_uri = '/' . $site_uri;
  if (substr($site_uri, -1, 1) != '/') $site_uri .= '/';
} else {
  $site_url = 'http://localhost/simpatda_bekasi/';
  $site_uri = '/';
}
// Define these values to be used later on
define('BASE_URL', $site_url);
define('BASE_URI', $site_uri);
define('APPPATH_URI', BASE_URI . APPPATH);

// We dont need these variables any more
unset($site_uri, $site_url);


/* End of file constants.php */
/* Location: ./application/config/constants.php */