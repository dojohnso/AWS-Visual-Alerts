<?php
require_once 'IAwsHelper.php';

class Ec2Helper implements IAwsHelper
{
    static public function list_names( $client )
    {
        $results = $client->describeInstances();

        $names = array();
        foreach ( $results['Reservations'] AS $reservations )
        {
            foreach ( $reservations['Instances'] AS $instance )
            {
                $names[] = $instance['InstanceId'];
            }
        }

        return $names;
    }
}
