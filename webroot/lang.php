<?php
/**
 * Translatable strings, must contain all strings in English
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

$msgs = array(
    'head-title'=>  'Installation of your FoodCoopShop',
    'body-title'=>  'Quick default installation of your FoodCoopShop',
    'body-start'=>  'If you see this, <span style="color: blue; cursor: pointer;" onclick="fcsinstaller.start();">we can start</span>. Let\'s find out if your server meets prerequisites...',
    'body-cookie'=> 'If you see this, your webserver or your browser are not configured to use cookies. Please configure your browser to allow cookies from your webserver. If they are allowed, configure your webserver to use cookies for session handling.',

    'unavail'   =>  'Service not available at the moment. Please try again later.',
    'invalid'   =>  'Invalid webservice data. Please try again later.',

    'intfail-1' =>  'No data to process. Contact developers.',
    'intfail-2' =>  'No action or unknown. Contact developers.',
    'intfail-3' =>  'No test mode outside developer system. Contact developers.',
    'intfail-4' =>  'Test mode action without real action. Contact developers.',
    'intfail-5' =>  'Action not implemented. Contact developers.',

    'step-0'    =>  'Checking Your PHP and webserver settings, please wait...',
    'step-1'    =>  'Initial tests passed, continue with filesystem checks. Please wait...',
    'step-2'    =>  'File system checks passed. Well done, all prerequisites are met. Now you can <span style="color: blue; cursor: pointer;" onclick="fcsinstaller.cont();">start the download and installation</span>.',
    'step-3'    =>  'Downloading the remote ZIP file. This may take a while, the ZIP is ~35MB. Please wait...',
    'step-4'    =>  'Unpacking the ZIP file. Please wait...',
    'step-5'    =>  sprintf('All done, continue with first Login to Your <a href="%1$s">FoodCoopShop</a>.', HTTP_BASE . '/index.php'),

    'fail-0'    =>  'Your webserver does not have the required PHAR extension installed. Please install that on Your webserver before retrying.',
    'fail-1'    =>  'Unknown external API fail. Contact developers.',
    'fail-2'    =>  'External API not available at the moment. Please try again later.',
    'fail-3'    =>  'Your webserver does not handle sessions or cookies correctly. Please reconfigure Your webserver before retrying.',
    'fail-4'    =>  'Your PHP version does not match requirements. Please update Your webserver before retrying.',
    'fail-5'    =>  'Your webserver does not have the required ZIP extension installed. Please install that on Your webserver before retrying.',
    'fail-6'    =>  'Your webserver already has a foodcoopshop.zip in Document Root. Please remove this file before retrying.',
    'fail-7'    =>  'Your webserver user is not able to write into Document Root. Please solve this problem before retrying.',
    'fail-8'    =>  'Your webserver cannot create writable directories in Document Root. Please solve this problem before retrying.',
    'fail-9'    =>  'Your webserver already has a tmp directory in Document Root. Please remove it before retrying.',
    'fail-10'   =>  'Your webserver cannot read a remote file via HTTP. Please solve this problem before retrying.',
    'fail-11'   =>  'Your webserver could not download the remote ZIP file from <a href="https://www.foodcoopshop.com/download/">FoodCoopShop download page</a>. Please try again later.',
);
