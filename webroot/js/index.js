function showResult(urlObj, options)
{
    var formData = $("#mecab-form").serialize();
    var sentence = $("#mecab-form").find('#sentence').val();

    var pageSelector = urlObj.hash.replace( /\?.*$/, "" ),
        $page = $(pageSelector),
        $content = $page.children(":jqmData(role=content)"),
        markup = '<p>Result for:' + sentence + '</p><div data-role="collapsible-set" data-theme="c" data-content-theme="d">';

    $.ajax({
        type: "GET",
        url : "/mecab",
        cache: false,
        data: formData,
        success: function(data, status) {
            $(data).each(function() {
                markup += '<div data-role="collapsible"><h3>' + this.surface + ' [' + this.feature[0] + ']</h3><p>';
                $(this.feature).each(function() {
                    markup += this + '&nbsp;';
                });
                markup += '</p></div>';
            });
            markup += '</div>';
            $content.html(markup).trigger('create');
            //$page.page()は不要かも?
            //$page.page();
            $.mobile.changePage($page,options);
        },
        error: function(data, status) {
        }
    });
}

$(document).ready(function() {
    $(document).bind("pagebeforechange", function(e, data) {
        if (typeof data.toPage === "string") {
            var u = $.mobile.path.parseUrl(data.toPage), re = /^#result/;
            if (u.hash.search(re) !== -1) {
                showResult(u, data.options); 
                e.preventDefault();
            }
        }
    });
});
