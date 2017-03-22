<?php
/**
 * User interface to install the FoodCoopShop
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

require_once 'defines.php';
require_once 'translate.php';

$api = 'api.php';
$lang = empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? 'en' : parseAcceptLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'en');

render($api, $lang);

function render($api, $lang)
{
    $urlbase = HTTP_URLBASE;

    // prepare JS variable
    $options_js = array(
        'ajaxurl' => HTTP_URLBASE . '/' . $api,
        'ajaxact' => 'install',
    );
    $options_js = sprintf(
<<<'END_OF_JS'
    var fcsinstaller = fcsinstaller || {};
    fcsinstaller.options = %1$s;

END_OF_JS
        , json_encode($options_js)
    );

    $msgs = loadStrings($lang);
    $head = array();
    $body = array();
    extractStrings($msgs, $head, 'head');
    extractStrings($msgs, $body, 'body');

    $messages = '';
    foreach ($msgs as $key => $value) {
        $messages .= sprintf(
            '<div id="fcsinstaller-message-%1$s">%2$s</div>',
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
    <title>{$head['title']}</title>
    <script src="{$urlbase}/jquery.js" async></script>
    <script src="{$urlbase}/main.js" async></script>
    <script>{$options_js}</script>
  </head>
  <body>
    <h1>{$body['title']}</h1>
    <div id="fcsinstaller-content">
      <div>{$body['start']}</div>
    </div>
    <div id="fcsinstaller_messages" style="display: none">{$messages}</div>
  </body>
</html>
END_OF_HTML;
}

__HALT_COMPILER();
