<?php

// fill in and copy to config/aws.php

define( 'AWS_ACCESS_KEY_ID', '<your key id>' );
define( 'AWS_SECRET_ACCESS_KEY', '<your secret access key>' );

$queue_url = '<SQS queue url used for alerts>';

// Example of a services array. Filled in with services you want to monitor

// SDK classname => AWS namespace
$services = array(
    'Rds' => 'RDS',
    'Ec2' => 'EC2',
    'ElasticLoadBalancing' => 'ELB',
    'Route53' => 'Route53',
    'Sqs' => 'SQS',

    // 'ElastiCache' => 'ElastiCache', // no memcache elasticache, only redis
    // 'S3' => 'S3', // no S3
    // 'CloudFront' => 'CloudFront', // no CloudFront
);
