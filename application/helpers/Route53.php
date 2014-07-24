<?php
require_once 'IAwsHelper.php';

class Route53Helper implements IAwsHelper
{
    static public function list_names( $client )
    {
        $results = $client->listHealthChecks();

        $names = array();
        foreach ( $results['HealthChecks'] AS $instance )
        {
            $names[] = $instance['Id'];
        }

        return $names;
    }
}
