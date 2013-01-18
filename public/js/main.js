/**
 * build and display ResultPopover
 * @param el HTML-Element/Button, that is clicked/hovered to show this popover
 */
function showResultPopover(el) {
    $('.popover').remove();

    // determine position for popover
    var position = $(el).offset();
    var top = position.top + ($(el).height() / 2) - 67;
    var left = position.left  + ($(el).width() / 2) + 40;

    // build popover-html
    var titleData = $(el).attr('title');
    var contentData = $(el).attr('data-content');
    var html  = buildResultPopoverHtml(titleData, contentData, top, left);

    // append popover
    $(el).after(html);

    // add mouseleave-listener to popover
    $('.popover').mouseleave( function() {
        $(this).remove();
    });

    // load match-form to popover
    $('.popover .btn-small').click( function() {
        $('.popover').unbind('mouseleave');
        $('.match').unbind('mouseout, mouseleave');

        $('.popover .popover-content').html('<img src="/img/throbber.gif" />');

        var url = $(this).attr('href');
        console.log(url);
        $.ajax({
            url: url,
            success: function(data) {
                $('.popover').width(500);
                $('.popover .popover-content').html(data);

                $('#cancelEditMatchResult').click( function() {
                    $('.popover').remove();
                });
            }
        })
        return false;
    });
}

/**
 * build HTML for Result-Popover
 * @param title
 * @param content
 * @param top
 * @param left
 * @return {String}
 */
function buildResultPopoverHtml(title, content, top, left) {
    var html = '';
    html += '<div class="popover fade right in" style="top: ' + top + 'px; left: ' + left + 'px; display: block;">';
        html += '<div class="arrow"></div>';
        html += '<div class="popover-inner">';
            html += '<h3 class="popover-title">' + title + '</h3>';
            html += '<div class="popover-content">' + content + '</div>';
        html += '</div>';
    html += '</div>';

    return html;
}