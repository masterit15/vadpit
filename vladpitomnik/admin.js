$(function() {
    function initMoreImages() {
        if ($('input.field').val()) {}
        let result = [...$('input.field').val().split(',').map(Number)]
        $('.edition-selected').text('Выбрано: ' + result.length);
        $('.frame label').on('click', function(e) {
            $(this).toggleClass('checked')
            if ($(this).hasClass('checked')) {
                result.push(Number($(this).find('input:not(:checked)').val()))
            } else {
                result = result.filter(id => Number(id) !== Number($(this).children('input').val()))
            }
            result = result.filter(id => Number(id) !== 0)
            $('.field').val(result.join(','));
            $('.edition-selected').text('Выбрано: ' + result.length);
            return false
        })

    }
    $('.load_more').on('click', function() {
        loadMoreImages($(this).data('url'))
    })
    let selectcount = $('.load_more').data('selectcount')
    let ppp = selectcount > 10 ? selectcount : 10; // Post per page
    let pageNumber = 1;
    loadMoreImages($('.load_more').data('url'))

    function loadMoreImages(url) {
        $.ajax({
            type: "POST",
            url: url,
            data: { action: 'moreimage', pageNumber, ppp, post: $('.load_more').data('post') },
            beforeSend: function() {},
            success: function(res) {
                $('.frame').append(res)
            },
            complete: function() {
                initMoreImages()
                pageNumber++
            },
            error: function(err) {
                console.error('success', err);
            }
        })
    }
})