var OrbitAjax = (function () {
    function OrbitAjax() {
    }
    OrbitAjax.post = function (action, data, success, fail) {
        jQuery
            .ajax({
            url: ajaxurl,
            data: {
                action: action,
                data: data
            },
            method: 'post'
        })
            .done(function (r) {
            if (success) {
                success(r);
            }
        })
            .fail(function (r) {
            if (fail) {
                fail(r);
            }
        });
    };
    return OrbitAjax;
}());
