AWS-Visual-Alerts
=================

This is a visual representation of all nodes and instances that can be monitored by AWS CloudWatch.

> The basics: CloudWatch will send an alert to a SQS queue. This page monitors that queue for ALERT messages and will update visually if one is received. It will also update when OK or INSUFFICIENT_DATA messages are received.

To work, CloudWatch alerts should be set up to send a message to a SNS topic that has a SQS queue subscribed to it. Be sure to follow the instructions to allow that SNS topic access to the SQS queue you create.

Create a new IAM user, give it access keys, and put those into the config/aws-sample.php file, then rename it to aws.php. Also give this user Read Only access across the board so it can discover instance names for you.

Also in the aws.php file, place the SQS queue url used to receive the CloudWatch alerts, and specify (comment or uncomment) which services you are using and would like to monitor with this tool. The API is used to discover instance names and ids used with CloudWatch to match up with the UI.

To maintiain persistance, Firebase is used. Place your Firebase url into the public/js/config-sample.js file and rename it to config.js. If you do not wish to have persistance and only have the states change when a message is received from CloudWatch via SQS, you can ignore this (not recommended).
