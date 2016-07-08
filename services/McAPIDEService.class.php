<?php

require_once 'Service.class.php';

class McAPIDEService implements Service {

    public function __construct() {}

    public function generate($identifier, $isUsername) {
        return "https://mcapi.de/api/user/{$identifier}";
    }

    public function validate($data) {
        $data = json_decode($data, true);

        // unvalid JSON data
        if($data === null) {
            return false;
        }

        if(!array_key_exists('result', $data)) {
            return false;
        }

        return true;
    }

}
