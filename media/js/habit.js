var Habits = {};

Habits.init = function(){

    $('.ajax-loader').hide();

    $('.habit-day').css({'cursor': 'pointer'});
    $('.habit-day').click(function(){
        $(this).find(".ajax-loader").show();
        var postUrl = "/doChangeDayStatus";
        var dayId = $(this).find('input').val();
        var dayItem = $(this);
        $.post(postUrl, {
                day_id: dayId,
            },
            function(response) {
                $('.ajax-loader').hide();
                $(dayItem).removeClass('successful unsuccessful notdefined');
                $(dayItem).addClass(response);
            });
        });
}

window.onload = Habits.init