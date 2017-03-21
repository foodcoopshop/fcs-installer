// jQuery.noConflict();

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

    if (opts.ajaxurl == null
        || opts.ajaxact == null
    ) {
        return;
    }

    me.blocked = false;
    me.initok = true;
};

fcsinstaller.getObj = function () {
    var me = fcsinstaller;
    me.init();
    if (me.initok === false) {
        return null;
    }
    return me;
};

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
	me.next();
}

fcsinstaller.next = function () {
    var me = fcsinstaller.getObj();
    if (me == null) {
        return false;
    }

    var opts = me.options;

    var params = {
        action: 'step-' + me.step,
    };

    var data = {
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

fcsinstaller.fail = function (data) {
    var me = fcsinstaller.getObj();
    if (me == null) {
        return false;
    }

    me.message('unavail');
    me.blocked = false;
    return false;
};

fcsinstaller.message = function (data) {
    var me = fcsinstaller.getObj();
    if (me == null) {
        return false;
    }

    jQuery("#fcsinstaller-content").html(jQuery('#fcsinstaller-message-' + data).html());
    return false;
};

jQuery(document).ready(function () {
    fcsinstaller.init();
});
