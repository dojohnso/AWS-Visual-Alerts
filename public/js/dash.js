var myRootRef;
$(function()
{
    myRootRef = new Firebase( firebase_url );

    updateStates();
})

function updateStates()
{
    var latest_date = 0;

    $('.service').each(function(){
        var service = $(this).data('service');
        $(this).next('.nodes').find('.node').each(function(){
            var node = $(this).data('node');

            var stateRef = myRootRef.child( service+'/'+node );
            stateRef.once('value', function(data) {
                if ( data.val() !== null )
                {
                    for ( state in data.val() )
                    {
                        //we have a state, lets do something with it
                        changeState( state, service, node )
                    }
                }
            });
        });
    });

    getMessages();
}

function pulseTitle()
{
    $('.navbar-brand').effect( "pulsate", {times:1}, 1000 );
}

function getMessages()
{
    pulseTitle()
    $.get('/messages', function(data){

        messages = $.parseJSON(data);
        if ( messages.length )
        {
            for ( m in messages )
            {
                // store message in Firebase for current state (ex: RDS/node-name/OK)
                var newMessage = myRootRef.child( messages[m].service + '/' + messages[m].node + '/' + messages[m].state )
                newMessage.set( messages[m] );

                changeState( messages[m].state, messages[m].service, messages[m].node )

                if ( messages[m].previous_state != messages[m].state )
                {
                    // delete previous from Firebase to maintain a "current" state
                    var oldMessage = myRootRef.child( messages[m].service + '/' + messages[m].node + '/' + messages[m].previous_state );
                    oldMessage.once('value', function(data) {
                        if ( data.val() !== null )
                        {
                            oldMessage.remove();
                        }
                    });
                }

                // delete this sqs message. we're done with it
                $.post('/messages/delete', {handle:messages[m].handle});
            }
        }

        setTimeout( 'getMessages()', 2500 );
    })
}

function changeState( state, service, node )
{
    var delay = 400;
    switch (state)
    {
        case 'OK':
            $('.'+service).addClass('OK', delay);
            $('.'+service).removeClass('ALARM', delay);
            $('.'+service).removeClass('INSUFFICIENT_DATA', delay);

            $('.'+node).addClass('OK', delay);
            $('.'+node).removeClass('ALARM', delay);
            $('.'+node).removeClass('INSUFFICIENT_DATA', delay);
            break;
        case 'INSUFFICIENT_DATA':
            $('.'+service).addClass('INSUFFICIENT_DATA', delay);
            $('.'+service).removeClass('ALARM', delay);
            $('.'+service).removeClass('OK', delay);

            $('.'+node).addClass('INSUFFICIENT_DATA', delay);
            $('.'+node).removeClass('ALARM', delay);
            $('.'+node).removeClass('OK', delay);
            break;
        case 'ALARM':
            $('.'+service).addClass('ALARM', delay);
            $('.'+service).removeClass('INSUFFICIENT_DATA', delay);
            $('.'+service).removeClass('OK', delay);
            $('.'+node).addClass('ALARM', delay);
            $('.'+node).removeClass('INSUFFICIENT_DATA', delay);
            $('.'+node).removeClass('OK', delay);
            break;
        default:
            break;
    }
}

function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}
