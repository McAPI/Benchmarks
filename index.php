<?php
// Debug
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

output("Start loading identifiers.");

// Load Identifiers
$file = new SplFileObject('usernames.txt');
$identifiers = array();

while(!($file->eof())) {
    $identifiers[] = trim($file->fgets());
}
$file = null;
output("Successfully loaded %d identifiers.", count($identifiers));

if(count($identifiers) < 1) {
    output("Not enough identifiers available to run the benchmark.");
    die;
}

// All services
output("Loading all services");
require_once __DIR__ . '/services/McAPIDEService.class.php';
require_once __DIR__ . '/services/McAPICAService.class.php';
require_once __DIR__ . '/services/MinecraftAPICOM.class.php';
require_once __DIR__ . '/services/McAPINET.class.php';
require_once __DIR__ . '/services/Razex.class.php';

$services = array(
    'mcapi.de'          => (new McAPIDEService),
    'mcapi.ca'          => (new McAPICAService),
    'minecraft-api.com' => (new MinecraftAPICOM),
    'mc-api.net'        => (new McAPINET),
    //'api.razex.de'     => (new Razex), Seems to be broken (14 - 7 - 2016 -> http://puu.sh/q1L6l/74170fdfd5.png)
);

output("Loaded %d services.", count($services));

if(count($services) < 1) {
    output("Not enough services available to run the benchmark.");
    die;
}

// Array to store all results
$result = array();

foreach($services as $name => $service) {

    output("Starting to benchmark %s.", $name);
    $deltaResult = array(
        'valid'         => 0,
        'invalid'       => 0,
        'totalTime'     => 0,
        'totalBytes'    => 0,
        'averageTime'   => 0,
        'averageBytes'  => 0,
        'log'           => []
    );

    $x = 1;
    foreach($identifiers as $identifier) {

        // send request
        $data = request($service->generate($identifier, (strlen($identifier <= 16))));
        $valid = $service->validate($data['data']);

        // If the data is valid, we can use it to calculate the scores
        $deltaResult[$valid ? 'valid' : 'invalid']++;
        $deltaResult['totalTime'] += $data['time'];
        $deltaResult['totalBytes'] += $data['bytes'];

        $deltaResult['log'][] = $data;

        output("%s (%d/%d): %s in %.2fs (%d bytes)", $name, $x, count($identifiers), $identifier, $data['time'], $data['bytes']);

        $x++;
    }

    $deltaResult['averageTime'] = ($deltaResult['totalTime'] / ($deltaResult['valid'] + $deltaResult['invalid']));
    $deltaResult['averageBytes'] = ($deltaResult['totalBytes'] / ($deltaResult['valid'] + $deltaResult['invalid']));
    $result[$name] = $deltaResult;
    output("Finished benchmarking %s.", $name);

}

// output all data
echo PHP_EOL . PHP_EOL . PHP_EOL;
foreach($result as $name => $entry) {
    output($name);
    output("    - Total Requests:  %d", ($entry['valid'] + $entry['invalid']));
    output("    - Total Bytes:  %d", $entry['totalBytes']);
    output("    - Avg. Bytes:  %.2fs", $entry['averageBytes']);
    output("    - Total Time:  %.2fs", $entry['totalTime']);
    output("    - Avg. Time:  %.2fs", $entry['averageTime']);
}

// Just a simple method to output data
function output($format) {

    $args = func_get_args();
    $arguments = null;
    if(count($args) > 1) {
        $arguments = array_slice($args, 1);
    }
    echo vsprintf($format, $arguments) . PHP_EOL;
}


/**
* This method will be called to send all requests.
*
* It returns an array of information.
* successfull -> true if successfull otherwise false
* time -> time in ms to send the request
* size -> size of bytes recieved
* result -> data returned by the API
*/
function request($url) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_SSL_VERIFYPEER  => false,
        CURLOPT_URL             => $url,
    ));
    $result = curl_exec($curl);

    $info = curl_getinfo($curl);
    $data = array(
        'successfull'   => ($info['http_code'] === 200),
        'time'          => $info['total_time'],
        'bytes'          => $info['size_download'],
        'data'          => $result,
    );


    curl_close($curl);

    return $data;

}
