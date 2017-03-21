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

$developer_mode = true;
$test_mode = false;  // auto-set on trailing '-test' in JSON action

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

define('ISWINDOWS', defined('PHP_WINDOWS_VERSION_MAJOR'));

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

    $actions = array(
        'step-0',
        'step-1',
        'step-2',
    );

    $results = array(  // predefined results for this script
        'success' =>  array(
            'success'   =>  true,  // result has payload as defined
            'message'   =>  'OK.',  // developer help
            'errno'     =>  0,  // not failed
        ),
    // developer fails
        'failEmpty' =>  array(
            'success'   =>  false,  // result is an error message
            'message'   =>  'no data to process.',  // developer help
            'errno'     =>  -1,  // internal fails produce negative error numbers
        ),
        'failNoAction' =>  array(
            'success'   =>  false,
            'message'   =>  'no action or unknown.',
            'errno'     =>  -2,
        ),
        'failNoTestOnLive' =>  array(
            'success'   =>  false,
            'message'   =>  'no test mode outside developer system.',
            'errno'     =>  -3,
        ),
        'failNoActionOnTest' =>  array(
            'success'   =>  false,
            'message'   =>  'test mode action without real action.',
            'errno'     =>  -4,
        ),
        'failNoActionOnSwitch' =>  array(
            'success'   =>  false,
            'message'   =>  'action not implemented.',
            'errno'     =>  -5,
        ),

    // fails to inform user about
        'failExternal' =>  array(  // for unknown API fails
            'success'   =>  false,
            'message'   =>  '',  // provided by external error source
            'errno'     =>  1,  // any unknown external error
        ),
        'failUnavail' =>  array(  // for timeout fails
            'success'   =>  false,
            'message'   =>  'service temporarily unavailable',
            'errno'     =>  2,
        ),
        'failPhpVersion' =>  array(
            'success'   =>  false,
            'message'   =>  'php version too low',
            'errno'     =>  3,
        ),
        'failPhpZlib' =>  array(
            'success'   =>  false,
            'message'   =>  'php zlib extension missing',
            'errno'     =>  4,
        ),
    );

api();

function api()
{
/*
        if (empty($_POST['nonce'])
            || wp_verify_nonce($_POST['nonce'], self::AJAX_NONCE) != 1
        ) {
            silent_exit($GLOBALS['results']['failNonce']);
        }
*/
		sleep(5);  // do not run too fast...

        if (empty($_POST['install'])) {
            silent_exit($GLOBALS['results']['failEmpty']);
        }

        $data = $_POST['install'];

        // check common parameters first
        if (empty($data['action'])
            || !in_array($data['action'], $GLOBALS['actions'])
        ) {
            silent_exit($GLOBALS['results']['failNoAction']);
        }

        if (strpos($data['action'], '-test') !== false) {
            if (!$GLOBALS['developer_mode']) {
                silent_exit($GLOBALS['results']['failNoTestOnLive']);
            }
            $GLOBALS['test_mode'] = true;  // this a test run
            $data['action'] = str_replace('-test', '', $data['action']);
            if (!in_array($data['action'], $actions)) {
                silent_exit($GLOBALS['results']['failNoActionOnTest']);
            }
        }

        switch($data['action']) {
            case 'step-0':
                step_0($data);
                break;

            case 'step-1':
                step_1($data);
                break;

            case 'step-2':
                step_stop();
                break;

            default:
                silent_exit($GLOBALS['results']['failNoActionOnSwitch']);
                break;
        }
}

    function step_1 (array $data) {
        $result = $GLOBALS['results']['success'];

		if ($GLOBALS['test_mode']) {  // skip in test_mode, we know it is working
	        result_exit($result);
		}

        result_exit($result);
    }

    function step_0 (array $data) {
        $result = $GLOBALS['results']['success'];

		if ($GLOBALS['test_mode']) {  // skip in test_mode, we know it is working
	        result_exit($result);
		}

		if (version_compare(phpversion(), '5.4.9', '<')) {
    		result_exit($GLOBALS['results']['failPhpVersion']);
		}

    if (!extension_loaded('zlib')) {
    	result_exit($GLOBALS['results']['failPhpZlib']);
    }

    ob_start();
    phpinfo();  // use constants to get smaller portions of info at once
    $phpinfo = ob_get_clean();
		// add more initial checks here

        result_exit($result);
    }

    function step_stop () {
        $result = $GLOBALS['results']['success'];
		$result['message'] = 'Stop.';
		$result['stop'] = 1;
        result_exit($result);
    }

    /**
     * Exit with result
     *
     * On all systems, exit with a aresult
     * */
    function result_exit ($result) {
        echo json_encode($result);
        exit;
    }

    /**
     * Silent Exit
     *
     * On development system be verbose, else exit silently
     * */
    function silent_exit ($result) {
        if ($GLOBALS['developer_mode']) {
            echo json_encode($result);
        }
        exit;
    }

