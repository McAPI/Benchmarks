<?php

require_once 'Service.class.php';

class Razex implements Service {

    public function __construct() {}

    public function generate($identifier, $isUsername) {
        if($isUsername) {
            return "https://api.razex.de/user/uuid/{$identifier}";
        }
        return "https://api.razex.de/user/username/{$identifier}";
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
