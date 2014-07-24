<?php
require_once 'IAwsHelper.php';

class ElasticLoadBalancingHelper implements IAwsHelper
{
    static public function list_names( $client )
    {
        $results = $client->describeLoadBalancers();

        $names = array();
        foreach ( $results['LoadBalancerDescriptions'] AS $instance )
        {
            $names[] = $instance['LoadBalancerName'];
        }

        return $names;
    }
}
