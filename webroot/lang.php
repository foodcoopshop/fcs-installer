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

    'unavail'   =>  'Service not available at the moment. Please try again later.',
    'invalid'   =>  'Invalid webservice data. Please try again later.',

    'intfail-1' =>  'No data to process. Contact developers.',
    'intfail-2' =>  'No action or unknown. Contact developers.',
    'intfail-3' =>  'No test mode outside developer system. Contact developers.',
    'intfail-4' =>  'Test mode action without real action. Contact developers.',
    'intfail-5' =>  'Action not implemented. Contact developers.',

    'step-0'    =>  'Checking Your PHP and webserver settings, please wait...',
    'step-1'    =>  'Initial tests pased, continue with filesystem checks. Please wait...',
    'step-2'    =>  sprintf('All done, continue with first Login to Your <a href="%1$s">FoodCoopShop</a>.', HTTP_BASE . '/index.php'),

    'fail-1'    =>  'Unknown external API fail. Contact developers.',
    'fail-2'    =>  'External API not available at the moment. Please try again later.',
    'fail-3'    =>  'Your PHP version does not match requirements. Please update Your webserver before retrying.',
    'fail-4'    =>  'Your webserver does not have the required zlib extension installed. Please install that on Your webserver before retrying.',
);
