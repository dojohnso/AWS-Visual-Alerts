AWS-Visual-Alerts
=================

This is a visual representation of all nodes and instances that can be monitored by AWS CloudWatch.

To work, CloudWatch alerts should be set up to send a message to a SNS topic that has a SQS queue subscribed to it. Be sure to follow the instructions to allow that SNS topic access to the SQS queue you create.

Create a new IAM user, give it access keys, and put those into the config/aws-sample.php file, and rename it to aws.php. Also give this user Read Only access across the board so it can discover instance names for you.

Also in the aws.php file, place the SQS queue url used to receive the CloudWatch alerts, and specify (comment or uncomment) which services you are using and would like to monitor with this tool.

To maintiain persistance, Firebase is used. Place your Firebase url into the public/js/config-sample.js file and rename it to config.js. If you do not wish to have persistance and only have the states change when an ALERT or OK message is received, you can ignore this (not recommended).
