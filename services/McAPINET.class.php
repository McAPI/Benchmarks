<?php

require_once 'Service.class.php';

class McAPINET implements Service {

    public function __construct() {}

    public function generate($identifier, $isUsername) {
        if($isUsername) {
            return "https://eu.mc-api.net/v3/uuid/{$identifier}";
        }
        return "https://eu.mc-api.net/v3/name/{$identifier}";
    }

    public function validate($data) {
        $data = json_decode($data, true);

        // unvalid JSON data
        if($data === null) {
            return false;
        }

        if(!array_key_exists('uuid', $data)) {
            return true;
        }

        return true;
    }

}
