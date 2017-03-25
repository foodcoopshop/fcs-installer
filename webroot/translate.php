<?php
/**
 * Translation functions
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

function parseAcceptLanguage($hal, $default)
{
    $langs = array();
    $codes = explode(',', $hal);  // split into values listed
    foreach ($codes as $code) {
        $parts = array();
        if (preg_match(
            '/^(?P<lang>[a-zA-Z]{2,8})(?:-(?P<state>[a-zA-Z]{2,8}))?(?:(?:;q=)(?P<q>\d\.\d))?$/',
            $code,
            $parts
        )) {
            if (empty($parts['lang'])) {
                continue;
            }
            if (isset($parts['q']) && ($parts['q'] < 0.1)) {
                continue;
            }
            if (empty($parts['q'])) {
                $parts['q'] = 1;
            }
            if (in_array($parts['lang'], $langs)) {
                if ($langs[$parts['lang']] < $parts['q']) {
                    $langs[$parts['lang']] = $parts['q'];
                }
            } else {
                $langs[$parts['lang']] = $parts['q'];
            }
        }
    }
    unset($codes);
    unset($code);
    unset($parts);

    // sort list based on value. Scrambles position. For those having many languages with same q value, position must be
    // used to get preference of languages. Minor issue, don't worry now...
    arsort($langs, SORT_NUMERIC);
    $langs = array_keys($langs);

    foreach ($langs as $lang) {
        if (is_readable(getLangFileName($lang))) {
            return $lang;
        }
    }

    return $default;
}

function extractStrings(&$msgs, &$dest, $sect)
{
    foreach ($msgs as $key => $value) {
        if (strpos($key, $sect . '-') === 0) {
            $dest[substr($key, strlen($sect . '-'))] = $value;
            unset($msgs[$key]);
        }
    }
}

function loadStrings($lang)
{
    return array_merge(loadLangFile('lang.php'), loadLangFile(getLangFileName($lang)));
}

function loadLangFile($file)
{
    if (is_readable($file)) {
        include $file;
    } else {
        $msgs = array();
    }
    return $msgs;
}

function getLangFileName($lang)
{
    return 'lang-' . $lang . '.php';
}
