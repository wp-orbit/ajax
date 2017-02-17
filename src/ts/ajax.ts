class OrbitAjax
{
    static post(action, data?, success?, fail?) {
        jQuery
            .ajax({
                url: ajaxurl,
                data: {
                    action: action,
                    data: data
                },
                method: 'post'
            })
            .done((r) => {
                if ( success ) {
                    success(r);
                }
            })
            .fail((r) => {
                if ( fail ) {
                    fail(r);
                }
            });
    }
}