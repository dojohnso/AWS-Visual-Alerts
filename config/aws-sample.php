<?php

// fill in and copy to config/aws.php

define( 'AWS_ACCESS_KEY_ID', '<your key id>' );
define( 'AWS_SECRET_ACCESS_KEY', '<your secret access key>' );

$queue_url = '<SQS queue url used for alerts>';

// Example of a services array. Filled in with services you use and the names of the nodes to monitor
// @TODO: populate this via an API call
$services = array(
    'services' => array(
        'RDS' => array('<RDS 1 name>', '<RDS 2 name>'),
        'EC2' => array( '<EC2 1 name>', '<EC2 2 name>' ),
        'ELB' => array('<ELB name>'),
        'Route53' => array( '<Health Check name>' ),
        'SQS' => array('<SQS queue name 1>'),
        'ElastiCache' => array(),
        'CloudFront' => array(),
        'S3' => array(),
    ),
);
