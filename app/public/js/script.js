

$('.Likes-Icon').on('click', function() {
    let $btn = $(this);
    // Likeアイコンがonクラス持っていたら
    if ($btn.hasClass('on')) {

        $btn.removeClass('on');
        $btn.removeClass("HeartAnimation");
        $btn.css("background-position","left");
        
    } else {
        $btn.addClass('on');
        $btn.addClass("HeartAnimation");
    }
});