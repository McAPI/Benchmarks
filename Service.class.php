<?php

interface Service {

    /**
    * Will be called to generate the URL to send a request.
    * @param identifier Is eiter an username or an UUID.
    * @param isUsername Is true if the provided identifier is a username otherwise it's false (UUID)
    */
    public function generate($identifier, $isUsername);

    /**
    * Will be called to verify the result returned by the API.
    * @param data Is an array of the result.  
    * @return true if the data is valid otherwise false.
    */
    public function validate($data);

}
