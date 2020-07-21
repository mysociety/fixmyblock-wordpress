var loadList = function(url, $el) {
    var $ = jQuery;
    var dfd = $.Deferred();

    var parseData = function(data){
        var data = removeImgSrc(data);
        var results = [];
        var headers = [];
        var $rows = $(data).find('tbody tr');
        $rows.each(function(i){
            var $row = $(this);
            if ( i === 0 ) { // header row
                $row.find('td').each(function(){
                    headers.push( $(this).text() );
                });
            } else {
                var result = {};
                $row.find('td').each(function(i){
                    if ( $(this).find('img').length ) {
                        // inline image, grab the src and set larger dimensions
                        var src = $(this).find('img').attr('data-src');
                        src = src.replace(/w\d+-h\d+$/, 'w1000-h1000');
                        result[ headers[i] ] = src;
                    } else if ( $(this).find('a').length ) {
                        // link element, the real URL is in the text node, not the href
                        result[ headers[i] ] = $(this).find('a').eq(0).text();
                    } else if ( $(this).find('br').length ) {
                        // long form text with line breaks
                        var regex = new RegExp('(<br\s*/?>){2}', 'gi');
                        result[ headers[i] ] = '<p>' + $(this).html().replace(regex, '</p><p>') + '</p>';
                    } else {
                        // either plain text, or something unexpected
                        result[ headers[i] ] = $(this).text();
                    }
                });
                results.push(result);
            }
        });
        dfd.resolve(results, $el);
    };

    var handleError = function(jqXHR, textStatus, errorThrown){
        $el.removeClass('loading');
        $el.addClass('failed');
        dfd.reject();
    };

    var removeImgSrc = function(html) {
        // Replace `<img src` with `<img data-src`.
        // Useful when you want to create a jQuery object from a HTML string,
        // but you don’t want the browser to load the images in that HTML.
        var regex = new RegExp('(<img[^>]*)src=', 'gi');
        return html.replace(regex, '$1data-src=');
    };

    $el.addClass('loading');
    $el.append('<p class="loader">Loading list…</p>');

    $.ajax({
        dataType: 'html',
        url: url
    }).done(parseData).fail(handleError);

    return dfd.promise();
};

var renderList = function(results, $el){
    var $ = jQuery;
    var template = $el.find('script[type="text/template"]').text();

    var categories = [];
    var regions = [];
    var $categoryFilter = $el.find('.js-filter-groups-by-category');
    var $regionFilter = $el.find('.js-filter-groups-by-region');

    $.each(results, function(i, result){
        var html = template;
        $.each(result, function(key, value){
            html = html.replace(
                new RegExp('\{\{' + key + '\}\}', 'g'),
                value
            );
            if ( key === 'category' && categories.indexOf(value) === -1 ) {
                categories.push(value);
            } else if ( key === 'region' && regions.indexOf(value) === -1 ) {
                regions.push(value);
            }
        });
        $el.append(html)
    });

    categories.sort();
    regions.sort();

    $.each(categories, function(i, category){
        $('<option>').text(category).appendTo($categoryFilter);
    });
    $.each(regions, function(i, region){
        $('<option>').text(region).appendTo($regionFilter);
    });

    $el.addClass('rendered post-list');
    $el.removeClass('loading');
    $el.removeClass('failed');
};

var setUpListFilters = function($el) {
    var $ = jQuery;
    var $filters = $el.find('.js-tenant-group-filters');
    var $textFilter = $el.find('.js-filter-groups-by-text');
    var $categoryFilter = $el.find('.js-filter-groups-by-category');
    var $regionFilter = $el.find('.js-filter-groups-by-region');

    var updateUI = function(){
        var text = $textFilter.val();
        var category = $categoryFilter.val();
        var region = $regionFilter.val();

        $el.find('.tenant-group').each(function(){
            var $tg = $(this);
            var show = true;

            if ( text !== '' && $tg.text().toUpperCase().indexOf(text.toUpperCase()) === -1 ) {
                show = false;
            }
            if ( category !== '' && $tg.attr('data-category') !== category ) {
                show = false;
            }
            if ( region !== '' && $tg.attr('data-region') !== region ) {
                show = false;
            }

            $tg.toggle(show);
        });
    }

    $filters.on('change', function(){
        updateUI();
    });
}

jQuery(function($){
    $('.js-tenant-group-list').each(function(){
        var $el = $(this);
        var url = $(this).find('a[href]').attr('href');
        if ( url ) {
            loadList(url, $el).done(renderList);
            setUpListFilters($el);
        }
    });
});
