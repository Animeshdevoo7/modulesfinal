<?php

namespace Drupal\node_json_data\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Controller\ControllerBase;

/**
 * class node json
 */
class DataController extends ControllerBase {

    public function index($api_key, $nid) {
    
    $nodedata = \Drupal::entityTypeManager()->getStorage('node')->load($nid);

        $json_data = [
            'node_id'=> $nid,
            'api'=> $api_key,
            'title' =>$nodedata->getTitle(),

        ];
        
        return new JsonResponse($json_data);
        
        
}

}

?>