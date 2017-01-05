<?php

require_once 'Service.class.php';

class MinecraftAPICOM implements Service {

    public function __construct() {}

    public function generate($identifier, $isUsername) {
        if($isUsername) {
            return "https://minecraft-api.com/api/uuid/uuid.php?pseudo={$identifier}";
        }
        return "https://minecraft-api.com/api/uuid/pseudo.php?uuid={$identifier}";
    }

    public function validate($data) {
        return !(empty($data));
    }

}
