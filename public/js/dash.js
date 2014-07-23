$(function(){
    getMessages();
})


function getMessages() {

    var delay = 400;
    $('.loader').show();
    $.get('/messages', function(data){

        $('.loader').hide();
        setTimeout( 'getMessages()', 2500 );

        messages = $.parseJSON(data);
        for ( m in messages )
        {
            console.log(messages[m].service, messages[m].state)
            switch (messages[m].state)
            {
                case 'OK':
                    $('.'+messages[m].service).removeClass('ALARM', delay);
                    $('.'+messages[m].service).removeClass('INSUFFICIENT_DATA', delay);
                    $('.'+messages[m].name).removeClass('ALARM', delay);
                    $('.'+messages[m].name).removeClass('INSUFFICIENT_DATA', delay);
                    break;
                case 'INSUFFICIENT_DATA':
                    $('.'+messages[m].service).addClass('INSUFFICIENT_DATA', delay);
                    $('.'+messages[m].service).removeClass('ALARM', delay);
                    $('.'+messages[m].name).addClass('INSUFFICIENT_DATA', delay);
                    $('.'+messages[m].name).removeClass('ALARM', delay);
                    break;
                case 'ALARM':
                    $('.'+messages[m].service).addClass('ALARM', delay);
                    $('.'+messages[m].service).removeClass('INSUFFICIENT_DATA', delay);
                    $('.'+messages[m].name).addClass('ALARM', delay);
                    $('.'+messages[m].name).removeClass('INSUFFICIENT_DATA', delay);
                    break;
                default:
                    break;
            }
        }
    })
}

