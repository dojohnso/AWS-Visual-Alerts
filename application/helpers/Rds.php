<?php
require_once 'IAwsHelper.php';

class RdsHelper implements IAwsHelper
{
    static public function list_names( $client )
    {
        $results = $client->describeDBInstances();

        $names = array();
        foreach ( $results['DBInstances'] AS $instance )
        {
            $names[] = $instance['DBInstanceIdentifier'];
        }

        return $names;
    }
}
