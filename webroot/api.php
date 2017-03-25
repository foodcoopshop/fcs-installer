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

$foodcoopshop = 'https://www.foodcoopshop.com/wp-content/uploads/releases/foodcoopshop.zip';

$actions = array(
    'step-0',
    'step-1',
    'step-3',
    'step-4',
    'step-5',
);

$results = array(  // predefined results for this script
    'next' =>  array(
        'success'   =>  true,  // result has payload as defined
        'message'   =>  'OK.',  // developer help
        'errno'     =>  0,  // not failed
    ),
    'stop' =>  array(
        'success'   =>  true,  // result has payload as defined
        'message'   =>  'Stop.',  // developer help
        'errno'     =>  0,  // not failed
        'stop'      =>  1,  // signal stop
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
    'failCookie' =>  array(
        'success'   =>  false,
        'message'   =>  'php session cookie not ok',
        'errno'     =>  3,
    ),
    'failPhpVersion' =>  array(
        'success'   =>  false,
        'message'   =>  'php version too low',
        'errno'     =>  4,
    ),
    'failPhpZip' =>  array(
        'success'   =>  false,
        'message'   =>  'php zip extension missing',
        'errno'     =>  5,
    ),
    'failFsZipExists' =>  array(
        'success'   =>  false,
        'message'   =>  'foodcoopshop.zip exists',
        'errno'     =>  6,
    ),
    'failFsRootNotWritable' =>  array(
        'success'   =>  false,
        'message'   =>  'document root not writable',
        'errno'     =>  7,
    ),
    'failFsCantMkdir' =>  array(
        'success'   =>  false,
        'message'   =>  'cannot create subdirectories',
        'errno'     =>  8,
    ),
    'failFsTmpExists' =>  array(
        'success'   =>  false,
        'message'   =>  'tmp/ exists',
        'errno'     =>  9,
    ),
    'failFsCantHttp' =>  array(
        'success'   =>  false,
        'message'   =>  'cannot read file via http',
        'errno'     =>  10,
    ),
    'failZipDownload' =>  array(
        'success'   =>  false,
        'message'   =>  'cannot download remote file',
        'errno'     =>  11,
    ),
);

api();
function api()
{
    if (empty($_POST['nonce'])
    || !session_start()
    || $_POST['nonce'] != session_id()
    ) {
        exitResult($GLOBALS['results']['failCookie']);
    }

    if (empty($_POST['action'])) {
        exitSilent($GLOBALS['results']['failEmpty']);
    }

    $data = $_POST['action'];

    if (empty($_POST[$data])) {
        exitSilent($GLOBALS['results']['failEmpty']);
    }

    $data = $_POST[$data];

    // check common parameters first
    if (empty($data['action'])) {
        exitSilent($GLOBALS['results']['failNoAction']);
    }

    if (strpos($data['action'], '-test') !== false) {
        if (!$GLOBALS['developer_mode']) {
            exitSilent($GLOBALS['results']['failNoTestOnLive']);
        }
        $GLOBALS['test_mode'] = true;  // this a test run
        $data['action'] = str_replace('-test', '', $data['action']);
        if (!in_array($data['action'], $GLOBALS['actions'])) {
            exitSilent($GLOBALS['results']['failNoActionOnTest']);
        }
    }

    switch ($data['action']) {
        case 'step-0':
            step0($data);
            stepNext();
            break;
        case 'step-1':
            step1($data);
            stepStop();
            break;
        case 'step-3':
            step3($data);
            stepNext();
            break;
        case 'step-4':
            step4($data);
            stepStop();
            break;
        case 'step-5':
            stepStop();
            break;
        default:
            exitSilent($GLOBALS['results']['failNoActionOnSwitch']);
            break;
    }
}

/**
 * Do unpack the ZIP
 * */
function step4(array $data)
{
    /*
    if ($GLOBALS['test_mode']) {  // skip in test_mode, its unzipped already
        return;
    }
    */

    $localfile = PATH_DOCROOT . DS . 'foodcoopshop.zip';
    // TODO: use ZipArchive to extract contents http://php.net/manual/de/class.ziparchive.php
    // TODO: run commands in shellcommands.txt to set required rights

    //    if (!$GLOBALS['test_mode']) {  // skip in test_mode, we know it is working
        sleep(5);  // do not run too fast...
    //    }
    return;
}

/**
 * Do download the remote ZIP
 * */
function step3(array $data)
{
    /*
    if ($GLOBALS['test_mode']) {  // skip in test_mode, we do have the zip
        return;
    }
    */

    $localfile = PATH_DOCROOT . DS . 'foodcoopshop.zip';
    if (!copy($GLOBALS['foodcoopshop'], $localfile)) {
        exitResult($GLOBALS['results']['failZipDownload']);
    }
    // TODO: check for existence
    return;
}

/**
 * Do filesystem checks, e.g. Writing to .. is crucial
 * */
function step1(array $data)
{
    /*
    if ($GLOBALS['test_mode']) {  // skip in test_mode, we know it is working
        return;
    }*/

    // TODO: disk_free_space ( string $directory ) 130MB + temp file space

    // prevent doing harm
    $testfile = PATH_DOCROOT . DS . 'foodcoopshop.zip';
    if (file_exists($testfile)) {
        exitResult($GLOBALS['results']['failFsZipExists']);
    }

    // try to create, read and delete a file in Document Root
    if (!testReadWrite($testfile)) {
        exitResult($GLOBALS['results']['failFsRootNotWritable']);
    }

    // prevent doing harm
    $testfile = PATH_DOCROOT . DS . 'tmp' . DS . 'foodcoopshop.zip';
    if (file_exists(dirname($testfile))) {
        exitResult($GLOBALS['results']['failFsTmpExists']);
    }

    // create, write into, read from and delete a subdirectory of Document Root
    if (!mkdir(dirname($testfile))
        || !testReadWrite($testfile)
        || !rmdir(dirname($testfile))
    ) {
        exitResult($GLOBALS['results']['failFsCantMkdir']);
    }

    $testfile = PATH_DOCROOT . DS . 'foodcoopshop.zip';
    testFileCreate($testfile);
    $file = fopen(HTTP_BASE . '/foodcoopshop.zip', 'rb');
    $ok = is_resource($file);
    fclose($file);
    testFileDelete($testfile);
    if (!$ok) {
        exitResult($GLOBALS['results']['failFsCantHttp']);
    }

    sleep(5);  // do not run too fast...

    return;
}

/**
 * Do prerequisite testing (PHP versions and libraries, PHP.ini values etc.
 * */
function step0(array $data)
{
    if ($GLOBALS['test_mode']) {  // skip in test_mode, we know it is working
        return;
    }

    if (version_compare(phpversion(), '5.5', '<')) {
        exitResult($GLOBALS['results']['failPhpVersion']);
    }

    if (!extension_loaded('zip')) {
        exitResult($GLOBALS['results']['failPhpZip']);
    }
    // TODO: check that allow_url_fopen is true
    // TODO: check that Registered PHP Streams  http and zip are set
    // TODO: check for ZipArchive class functions and the functions used to extract files
    // add more initial checks here
    /*
    ob_start();
    phpinfo();  // use constants to get smaller portions of info at once
    $phpinfo = ob_get_clean();
    */

    sleep(5);  // do not run too fast...
    return;
}

/**
 * Stop an automatic running sequence of tests / actions
 * */
function stepStop()
{
    exitResult($GLOBALS['results']['stop']);
}

/**
 * Next step in automatic running sequence of tests / actions
 * */
function stepNext()
{
    exitResult($GLOBALS['results']['next']);
}

/**
 * Exit with result
 *
 * On all systems, exit with a aresult
 * */
function exitResult($result)
{
    echo json_encode($result);
    exit;
}

/**
 * Silent Exit
 *
 * On development system be verbose, else exit silently
 * */
function exitSilent($result)
{
    if ($GLOBALS['developer_mode']) {
        echo json_encode($result);
    }
    exit;
}

/**
 * Do read/write testing on file
 * */
function testReadWrite($filename)
{
    if (!testFileCreate($filename)) {
        return false;
    }
    clearstatcache();
    if (!testFileDelete($filename)) {
        return false;
    }
    return true;
}

/**
 * Create testfile
 * */
function testFileCreate($filename)
{
    if (!is_writable(dirname($filename))
        || ($file = @fopen($filename, 'ab')) === false
        || @fwrite($file, 'test') === false
        || @fclose($file) === false
    ) {
        return false;
    }
    return true;
}

/**
 * Delete testfile
 * */
function testFileDelete($filename)
{
    if (@file_get_contents($filename) !== 'test'
        || (fileperms($filename) & 0700) < 0600
        || @unlink($filename) === false
    ) {
        return false;
    }
    return true;
}
