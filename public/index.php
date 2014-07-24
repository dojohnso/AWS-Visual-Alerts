<?php
require '../vendor/autoload.php';
require '../config/aws.php';

$app = new \Slim\Slim( array(
        'debug' => true,
        'templates.path' => '../views'
));

$app->get('/messages', function () use ($app, $queue_url) {
    //http://docs.aws.amazon.com/aws-sdk-php/guide/latest/service-sqs.html
    $client = Aws\Sqs\SqsClient::factory(array(
        'key'    => AWS_ACCESS_KEY_ID,
        'secret' => AWS_SECRET_ACCESS_KEY,
        'region'  => 'us-east-1'
    ));

    $result = $client->receiveMessage(array(
        'QueueUrl' => $queue_url,
        'MaxNumberOfMessages' => 1,
        'AttributeNames' => array('All'),
    ));

    $messages = $result->getPath('Messages');
    $response = array();

    if ( count( $messages ) )
    {
        foreach ($messages as $i => $message)
        {
            $body = json_decode($message['Body']);
            $message_text = json_decode( $body->Message );

            $namespace = explode( '/', $message_text->Trigger->Namespace );

            $response[$i]['state'] = $message_text->NewStateValue;
            $response[$i]['service'] = $namespace[count($namespace)-1];
            $response[$i]['alarm'] = $message_text->AlarmName;

            if ( $message_text->Trigger->Dimensions )
            {
                $response[$i]['node'] = $message_text->Trigger->Dimensions[0]->value;
            }

            $response[$i]['previous_state'] = $message_text->OldStateValue;
            $response[$i]['state_change_time'] = $message_text->StateChangeTime;
            $response[$i]['full'] = $message_text;

            $response[$i]['handle'] = $message['ReceiptHandle'];
        }
    }

    echo json_encode( $response );
});

$app->post('/messages/delete', function () use ($app, $queue_url) {
    $client = Aws\Sqs\SqsClient::factory(array(
        'key'    => AWS_ACCESS_KEY_ID,
        'secret' => AWS_SECRET_ACCESS_KEY,
        'region'  => 'us-east-1'
    ));

    $handle = $app->request->post('handle');

    // click click boom
    $result = $client->deleteMessage(array(
        'QueueUrl' => $queue_url,
        'ReceiptHandle' => $handle,
    ));
});

$app->get('/', function () use ($app, $services)
{
    // load up and check each service
    $display_services = array();


    foreach ( $services as $service => $namespace )
    {
        $class = "Aws"."\\".$service."\\".$service."Client";
        $helper_class = $service . "Helper";
        $client = $class::factory(array(
            'key'    => AWS_ACCESS_KEY_ID,
            'secret' => AWS_SECRET_ACCESS_KEY,
            'region'  => 'us-east-1'
        ));

        if ( file_exists( '../application/helpers/'.$service.'.php' ) )
        {
            require_once '../application/helpers/'.$service.'.php';

            $item_names = $helper_class::list_names( $client );

            $display_services[$service] = array( 'nodes' => $item_names, 'namespace' => $namespace );
        }
        else
        {
            throw new Exception("The helper for $service is not defined yet.");
        }
    }

    $display_services = array( 'display_services' => $display_services );
    $app->render('_header.php');
    $app->render('home.php', $display_services);
    $app->render('_footer.php');
});

$app->run();

