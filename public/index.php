<?php
require '../vendor/autoload.php';
require '../config/aws.php';
use Aws\Sqs\SqsClient;


$app = new \Slim\Slim( array(
        'debug' => true,
        'templates.path' => '../views'
));

$app->get('/messages', function () use ($app, $queue_url) {
    //http://docs.aws.amazon.com/aws-sdk-php/guide/latest/service-sqs.html
    $client = SqsClient::factory(array(
        'key'    => AWS_ACCESS_KEY_ID,
        'secret' => AWS_SECRET_ACCESS_KEY,
        'region'  => 'us-east-1'
    ));

    $result = $client->receiveMessage(array(
        'QueueUrl' => $queue_url,
        'MaxNumberOfMessages' => 10,
        'AttributeNames' => array('All'),
    ));

    $response = array();
    $messages = $result->getPath('Messages');

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
                $response[$i]['name'] = $message_text->Trigger->Dimensions[0]->value;
            }

            $response[$i]['full'] = $message_text;

            $result = $client->deleteMessage(array(
                'QueueUrl' => $queue_url,
                'ReceiptHandle' => $message['ReceiptHandle'],
            ));
        }
    }

    echo json_encode( $response );
});

$app->get('/', function () use ($app, $services)
{

    $app->render('_header.php');
    $app->render('home.php', $services);
    $app->render('_footer.php');
});

$app->run();

