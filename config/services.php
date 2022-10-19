<?php

/**
 * Services are globally registered in this file
 */

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Router;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Loader;
use Phalcon\Mvc\Model\Manager;



/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader = new Loader();

$loader->registerDirs(
    array(
        __DIR__ . '/../apps/library/',
        __DIR__ . '/../apps/library/SMTP/'

    )
);
$loader->register();

/**
 * Cloud Flare Fix CUSTOMER IP
 */
function ip_in_range($ip, $range)
{
    if (strpos($range, '/') !== false) {
        // $range is in IP/NETMASK format
        list($range, $netmask) = explode('/', $range, 2);
        if (strpos($netmask, '.') !== false) {
            // $netmask is a 255.255.0.0 format
            $netmask = str_replace('*', '0', $netmask);
            $netmask_dec = ip2long($netmask);
            return ((ip2long($ip) & $netmask_dec) == (ip2long($range) & $netmask_dec));
        } else {
            // $netmask is a CIDR size block
            // fix the range argument
            $x = explode('.', $range);
            while (count($x) < 4) $x[] = '0';
            list($a, $b, $c, $d) = $x;
            $range = sprintf("%u.%u.%u.%u", empty($a) ? '0' : $a, empty($b) ? '0' : $b, empty($c) ? '0' : $c, empty($d) ? '0' : $d);
            $range_dec = ip2long($range);
            $ip_dec = ip2long($ip);

            # Strategy 1 - Create the netmask with 'netmask' 1s and then fill it to 32 with 0s
            #$netmask_dec = bindec(str_pad('', $netmask, '1') . str_pad('', 32-$netmask, '0'));

            # Strategy 2 - Use math to create it
            $wildcard_dec = pow(2, (32 - $netmask)) - 1;
            $netmask_dec = ~$wildcard_dec;

            return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
        }
    } else {
        // range might be 255.255.*.* or 1.2.3.0-1.2.3.255
        if (strpos($range, '*') !== false) { // a.b.*.* format
            // Just convert to A-B format by setting * to 0 for A and 255 for B
            $lower = str_replace('*', '0', $range);
            $upper = str_replace('*', '255', $range);
            $range = "$lower-$upper";
        }

        if (strpos($range, '-') !== false) { // A-B format
            list($lower, $upper) = explode('-', $range, 2);
            $lower_dec = (float)sprintf("%u", ip2long($lower));
            $upper_dec = (float)sprintf("%u", ip2long($upper));
            $ip_dec = (float)sprintf("%u", ip2long($ip));
            return (($ip_dec >= $lower_dec) && ($ip_dec <= $upper_dec));
        }
        return false;
    }
}

if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $cf_ip_ranges = array('204.93.240.0/24',
        '204.93.177.0/24',
        '199.27.128.0/21',
        '172.64.0.0/13',
        '173.245.48.0/20',
        '103.21.244.0/22',
        '103.22.200.0/22',
        '103.31.4.0/22',
        '104.16.0.0/12',
        '131.0.72.0/22',
        '141.101.64.0/18',
        '108.162.192.0/18',
        '190.93.240.0/20',
        '188.114.96.0/20',
        '197.234.240.0/22',
        '198.41.128.0/17',
        '162.158.0.0/15',
        '2400:cb00::/32',
        '2606:4700::/32',
        '2803:f800::/32',
        '2405:b500::/32',
        '2405:8100::/32',
        '2c0f:f248::/32',
        '2a06:98c0::/29');
    foreach ($cf_ip_ranges as $range) {
        if (ip_in_range($_SERVER['REMOTE_ADDR'], $range)) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
            break;
        }
    }
}

$config = include __DIR__ . "/config.php";

if (!defined('MyS3Bucket')) {
    define('MyS3Bucket', 'indianimmigrationorg3');
}
if (!defined('MyCloudFrontURL')) {
    define('MyCloudFrontURL', 'https://d223iynz9gx8rj.cloudfront.net/');
}

// S3
!defined('MyS3Key') && define('MyS3Key', '');
!defined('MyS3Secret') &&  define('MyS3Secret', '');
// SMTP
!defined('SMTP_HOST') && define('SMTP_HOST', '');
!defined('SMTP_USERNAME') && define('SMTP_USERNAME', '');
!defined('SMTP_PASSWORD') && define('SMTP_PASSWORD', '');


/**
 * Database connection is created based in the parameters defined in the configuration file
 */

$di['db'] = function () use ($config) {
    return new DbAdapter(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->name,
        "schema" => $config->database->name,
        'charset' => $config->database->charset
    ));
};


$di['db_visacorp'] = function () use ($config) {
    return new DbAdapter(array(
        "host" => $config->database_visacorp->host,
        "username" => $config->database_visacorp->username,
        "password" => $config->database_visacorp->password,
        "dbname" => $config->database_visacorp->name,
        "schema" => $config->database_visacorp->name,
        'charset' => $config->database_visacorp->charset
    ));
};

$di['db_general'] = function () use ($config) {
    return new DbAdapter(array(
        "host" => $config->database_general->host,
        "username" => $config->database_general->username,
        "password" => $config->database_general->password,
        "dbname" => $config->database_general->name,
        "schema" => $config->database_general->name,
        'charset' => $config->database_general->charset
    ));
};


/**
 * Registering a router
 */
$di['router'] = function () {
    return include 'router.php';
};

/**
 * Start the session the first time some component request the session service
 */
$di['session'] = function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
};
/**
 * Register My component
 */
$di->set('my', function () {
    return new \My();
});

/**
 * Register GlobalVariable component
 */
$di->set('globalVariable', function () {
    return new \GlobalVariable();
});

/**
 * Register cookie
 */
$di->set('cookies', function () {
    $cookies = new \Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(false);
    return $cookies;
}, true);

/**
 * Register key for cookie encryption
 */
$di->set('crypt', function () {
    $crypt = new \Phalcon\Crypt();
    $crypt->setKey('binmedia123@@##'); //Use your own key!
    return $crypt;
});

/**
 * Register models manager
 */
$di->set('modelsManager', function () {
    return new Manager();
});

/**
 * Register PHPMailer manager
 */
$di->set('myMailer', function () {
    require_once(__DIR__ . "/../apps/library/SMTP/PHPMailer.php");
    $mail = new \PHPMailer();
    $mail->IsSMTP();//telling the class to use SMTP
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Host = SMTP_HOST;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->CharSet = 'utf-8';
    return $mail;
});

