<?php
require __DIR__ . '/../../vendor/autoload.php';
session_start();

include_once(__DIR__ . "/config.php");

use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

$caller  = 0;
$dids    = array();
$results = array();
$type    = array("carrier");

$client = new Client(SID, TOK);

if (isset($_GET['caller'])) {
    $caller = 1;
    array_push($type, "caller-name");
}

$dids = preg_split("/\n/", $_GET['dids']);

try {
    foreach ($dids as $did) {
        if (preg_match('/^\s*$/', $did)) { continue; }
        $row = array();

        $did = preg_replace('/[^0-9]/', '', $did);
        if (! preg_match('/^\d{10}$/', $did)) {
            throw new Exception("Invalid DID " . $did);
        }

        array_push($row, $did);

        try {
            $number = $client->lookups
                ->phoneNumbers($did)
                ->fetch(array("type" => $type));

            array_push($row, $number->carrier["type"]);
            array_push($row, $number->carrier["name"]);
            if ($caller) { 
                array_push($row, $number->callerName["caller_name"]);
            }
        }
        catch (RestException $e) {
            if ($e->getStatusCode() == "404") {
              array_push($row, '');
              array_push($row, "No carrier information");
            }
        } 

        array_push($results, $row);
    }
}
catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}


$_SESSION['results'] = $results;

header("Location: /lrn/index.php");

?>
