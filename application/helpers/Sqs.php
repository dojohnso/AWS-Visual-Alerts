<?php
require_once 'IAwsHelper.php';

class SqsHelper implements IAwsHelper
{
    static public function list_names( $client )
    {
        $results = $client->listQueues();

        $names = array();
        foreach ( $results['QueueUrls'] AS $instance )
        {
            // is full url. let's just get the name (last piece)
            $queue = explode( '/', $instance );
            $names[] = $queue[count($queue)-1];
        }

        return $names;
    }
}
