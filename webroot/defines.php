<?php
/**
 * Common set of defines
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @package       FoodCoopShop.FCSInstaller
 * @since         V0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @author        Michael Kramer <info@k-pd.de>
 * @copyright     Copyright (c) Michael Kramer, http://www.k-pd.de
 * @link          https://github.com/foodcoopshop/fcs-installer
 */

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('PS')) {
    define('PS', PATH_SEPARATOR);
}

if (!defined('ISWINDOWS')) {
    define('ISWINDOWS', defined('PHP_WINDOWS_VERSION_MAJOR'));
}

if (empty($_SERVER)
    || empty($_SERVER['DOCUMENT_ROOT'])
    || empty($_SERVER['SCRIPT_NAME'])
    || empty($_SERVER['HTTP_HOST'])
) {
    exit('Cannot run here. Your server does not provide required infos in $_SERVER[]: ' . print_r($_SERVER, true));
}

if (empty($_SERVER['REQUEST_SCHEME'])) {
    $_SERVER['REQUEST_SCHEME'] = 'http';
}

if (!defined('ISPHAR')) {
    if (!empty($_SERVER['PHAR_PATH_TRANSLATED'])) {
        define('ISPHAR', true);
    } else {
        define('ISPHAR', false);
    }
}

if (!defined('PATH_DOCROOT')) {
    define('PATH_DOCROOT', $_SERVER['DOCUMENT_ROOT']);
}

if (!defined('HTTP_URLROOT')) {
    if (ISPHAR) {
        define('HTTP_URLROOT', $_SERVER['SCRIPT_NAME'] . '/');
    } else {
        define('HTTP_URLROOT', '/');
    }
}

if (!defined('HTTP_BASE')) {
    define('HTTP_BASE', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
}

if (!defined('HTTP_URLBASE')) {
    define('HTTP_URLBASE', HTTP_BASE . HTTP_URLROOT);
}
