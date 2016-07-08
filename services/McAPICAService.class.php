<?php

require_once 'Service.class.php';

class McAPICAService implements Service {

    public function __construct() {}

    public function generate($identifier, $isUsername) {
        if($isUsername) {
            return "https://mcapi.ca/uuid/player/{$identifier}";
        }
        return "https://mcapi.ca/name/uuid/{$identifier}";
    }

    public function validate($data) {
        $data = json_decode($data, true);

        // unvalid JSON data
        if($data === null) {
            return false;
        }

        if(!array_key_exists('uuid', $data)) {
            return false;
        }

        return true;
    }

}
