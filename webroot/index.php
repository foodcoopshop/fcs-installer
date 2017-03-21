<?php
/**
 * Do all the magic stuff
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) 
 * @package       FoodCoopShop.FCSInstaller
 * @since         V0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

if (empty($_SERVER)
	|| empty($_SERVER['DOCUMENT_ROOT'])
	|| empty($_SERVER['SCRIPT_NAME'])
	|| empty($_SERVER['REQUEST_SCHEME'])
	|| empty($_SERVER['HTTP_HOST'])
) {
	exit('Cannot run here. Your server does not provide required infos in $_SERVER[]: ' . print_r($_SERVER, true));
}

if (!defined('PHAR')) {
	if (!empty($_SERVER['PHAR_PATH_TRANSLATED'])) {
		define('PHAR', true);
	}
	else {
		define('PHAR', false);
	}
}

if (!defined('DOCROOT')) {
	define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);
}

if (!defined('URLROOT')) {
	if (PHAR) {
		define('URLROOT', $_SERVER['SCRIPT_NAME']);
	}
	else {
		define('URLROOT', '/');
	}
}

if (!defined('URLBASE')) {
	define('URLBASE', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . URLROOT);
}

// $lang = parse_accept_language(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'de');
$lang = 'de';

$api = 'api.php';

render(URLBASE . '/' . $api, $lang);

function render($api, $lang)
{
	$urlbase = URLBASE;
    // prepare JS variable
    $options_js = array(
        'ajaxurl' => $api,
        'ajaxact' => 'install',
    );
	$options_js = sprintf(
<<<'END_OF_JS'
    var fcsinstaller = fcsinstaller || {};
    fcsinstaller.options = %1$s;

END_OF_JS
        , json_encode($options_js)
    );

            $msgs = array(
                'unavail'   =>  'Service not available at the moment. Please try again later.',
                'invalid'   =>  'Invalid webservice data. Please try again later.',

                'intfail-1' =>  'No data to process. Contact developers.',
                'intfail-2' =>  'No action or unknown. Contact developers.',
                'intfail-3' =>  'No test mode outside developer system. Contact developers.',
                'intfail-4' =>  'Test mode action without real action. Contact developers.',
                'intfail-5' =>  'Action not implemented. Contact developers.',

                'step-0'    =>  'Checking Your PHP and webserver settings, please wait...',
                'step-1'    =>  'Initial tests pased, continue with filesystem checks. Please wait...',
                'step-2'    =>  sprintf('All done, continue with first Login to Your <a href="%1$s">FoodCoopShop</a>.', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/index.php'),

                'fail-1'    =>  'Unknown external API fail. Contact developers.',
                'fail-2'    =>  'External API not available at the moment. Please try again later.',
                'fail-3'    =>  'Your PHP version does not match requirements. Please update Your webserver before retrying.',
                'fail-4'    =>  'Your webserver does not have the required zlib extension installed. Please install that on Your webserver before retrying.',
            );
            $messages = '';
            foreach ($msgs as $key => $value) {
                $messages .= sprintf(
                    '<p id="fcsinstaller-message-%1$s">%2$s</p>',
                    $key,
                    $value
                );
            }
    

	echo
<<<END_OF_HTML
<!doctype html>
<html lang="{$lang}">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation deines FoodCoopShop</title>
	<script src="{$urlbase}/jquery.js"></script>
	<script src="{$urlbase}/main.js"></script>
	<script>{$options_js}</script>
  </head>
  <body>
    <h1>Schnelle Standard-Installation deines FoodCoopShop</h1>
	<div id="fcsinstaller-content">
      <p>Wenn Du dies hier siehst, kann es losgehen. Mal sehen, ob dein Server <span style="color: blue; cursor: pointer;" onclick="fcsinstaller.start();">geeignet</span> ist...</p>
    </div>
    <div id="fcsinstaller_messages" style="display: none">{$messages}</div>
  </body>
</html>
END_OF_HTML;
/*
	echo 'PHAR: ' . (int)PHAR . PHP_EOL;
	echo 'DOCROOT: ' . DOCROOT . PHP_EOL;
	echo 'URLROOT: ' . URLROOT . PHP_EOL;
	echo 'URLBASE: ' . URLBASE . PHP_EOL;
	echo '$api: ' . print_r($api, true) . PHP_EOL;
	echo '$lang: ' . print_r($lang, true) . PHP_EOL;

	if (isset($_SERVER)) {
		echo '_SERVER:' . print_r($_SERVER, true) . PHP_EOL;
	}
	if (isset($_GET)) {
		echo '_GET:' . print_r($_GET, true) . PHP_EOL;
	}
	if (isset($_REQUEST)) {
		echo '_REQUEST:' . print_r($_REQUEST, true) . PHP_EOL;
	}
	if (isset($GLOBALS)) {
		echo 'GLOBALS:' . print_r($GLOBALS, true) . PHP_EOL;
	}

	echo 'Done.' . PHP_EOL;
	exit;
*/
}

__HALT_COMPILER();
