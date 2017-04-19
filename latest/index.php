<?php
/**
 * User interface loader to install the FoodCoopShop
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

render();

function render()
{
    // before trying loading the PHAR, make sure PHAR can be run
    if (version_compare(phpversion(), '5.4', '<')) {
        die('Installer cannot run on PHP version < 5.4');
    } else if (!extension_loaded('phar')) {
        die('Installer cannot run without PHAR extension');
    } else {
        header('Location:/fcs-installer.php/index2.php');
        exit;
    }
}

__halt_compiler();
