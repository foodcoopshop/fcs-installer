<?php
/**
 * Set of actions to step-by-step install the FoodCoopShop
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

$developer_mode = true;  // be verbose on failures, allow testing features
$test_mode = false;  // auto-set on trailing '-test' in JSON action

require_once 'defines.php';

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
        || verify_nonce($_POST['nonce'], API_NONCE) != 1
    ) {
        silent_exit($GLOBALS['results']['failNonce']);
    }
*/
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

/**
 * Do filesystem checks, e.g. Writing to .. is crucial
 * */
function step_1 (array $data) {
    $result = $GLOBALS['results']['success'];

    if ($GLOBALS['test_mode']) {  // skip in test_mode, we know it is working
        result_exit($result);
    }

    sleep(5);  // do not run too fast...
    result_exit($result);
}

/**
 * Do prerequisite testing (PHP versions and libraries, PHP.ini values etc.
 * */
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

    // add more initial checks here
/*
    ob_start();
    phpinfo();  // use constants to get smaller portions of info at once
    $phpinfo = ob_get_clean();
*/

    sleep(5);  // do not run too fast...
    result_exit($result);
}

/**
 * Stop an automatic running sequence of tests / actions
 * */
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
