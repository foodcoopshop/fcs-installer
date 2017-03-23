/**
 * JS for User interface to install the FoodCoopShop
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

// create namespace
var fcsinstaller = fcsinstaller || {};
fcsinstaller.init = function () {
    var me = fcsinstaller;
    if (me.initok != null) {
        return;
    }
    me.initok = false;

    if (me.options == null) {
        return;
    }
    var opts = me.options;

    if (opts.nonce == null
        || opts.ajaxurl == null
        || opts.ajaxact == null
    ) {
        return;
    }

    me.blocked = false;
    me.initok = true;
};

// get initialized object
fcsinstaller.getObj = function () {
    var me = fcsinstaller;
    me.init();
    if (me.initok === false) {
        return null;
    }
    return me;
};

// start automatic running
fcsinstaller.start = function () {
    var me = fcsinstaller.getObj();
    if (me == null) {
        return false;
    }

    if (me.blocked) {
        return false;
    }
    me.blocked = true;

    me.message('step-0');
    me.step = 0;
    return me.next();
}

// use after requested user input was transfered into object "params"
fcsinstaller.cont = function (params) {
    var me = fcsinstaller.getObj();
    if (me == null) {
        return false;
    }

    if (me.blocked) {
        return false;
    }
    me.blocked = true;

    params = params || {};

    me.step += 1;
    me.message('step-' + me.step);
    return me.next(params);
}

// next step of automatic running. Appends params to payload
fcsinstaller.next = function (params) {
    var me = fcsinstaller.getObj();
    if (me == null) {
        return false;
    }

    var opts = me.options;

    params = params || {};
    params.action = 'step-' + me.step + '-test';

    var data = {
        nonce:  opts.nonce,
        action: opts.ajaxact,
    };
    data[opts.ajaxact] = params;
    jQuery.post(
        opts.ajaxurl,
        data,
        function (data) { me.success(data); },
        'json'
    ).fail(
        function (data) { me.fail(data); }
    );

    return false;
};

// got an answer from server
fcsinstaller.success = function (data) {
    var me = fcsinstaller.getObj();
    if (me == null) {
        return false;
    }

    if (data == null) {
        me.message('unavail');
        me.blocked = false;
        return false;
    }

    if (data.success == null) {
        me.message('invalid');
        me.blocked = false;
        return false;
    }

    if (data.success) {
        me.step += 1;
        me.message('step-' + me.step);
        if (data.stop != null) {
            me.blocked = false;
            return false;
        }
        me.next();
        return false;
    }

    if (data.errno == null) {
        me.message('invalid');
        me.blocked = false;
        return false;
    }

    if (data.errno < 0) {
        me.message('intfail-' + (data.errno * -1));
    }
    else {
        me.message('fail-' + data.errno);
    }
    me.blocked = false;
    return false;
};

// got no answer from server
fcsinstaller.fail = function (data) {
    var me = fcsinstaller.getObj();
    if (me == null) {
        return false;
    }

    me.message('unavail');
    me.blocked = false;
    return false;
};

// display something to the user
fcsinstaller.message = function (data) {
    var me = fcsinstaller.getObj();
    if (me == null) {
        return false;
    }

    jQuery("#fcsinstaller-content").html(jQuery('#fcsinstaller-message-' + data).html());
    return false;
};
