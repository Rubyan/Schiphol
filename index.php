<?php
/**
 Script to determine which of the 6 runways on Schiphol Airport are used
 for starting or landing and notify using prowl if a change is detected
**/
 
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\DomCrawler\Crawler;

$apikey = "your-prowl-api-key-here";

//$date = "2016-07-03%2010:30:00";
//$params = "?date=" . $date;

$params = "";

$url = "https://www.lvnl.nl/airtraffic" . $params;
$content = file_get_contents($url);

$crawler = new Crawler($content);

// search this css id
$crawler = $crawler->filter("#runwayVisual");

// debug data
$html = '';
foreach ($crawler as $domElement) {
    $html.= $domElement->ownerDocument->saveHTML();
}

$runways = ['polderbaan', 'zwanenburgbaan', 'buitenveldertbaan', 'kaagbaan', 'aalsmeerbaan', 'oostbaan'];
$state = ["date" => date("Y-m-d H:i:s")];

foreach ($runways as $runway) {
	$x = $crawler->filter("#" . $runway);
	$state[$runway] = $x->attr('class');
}
$previous_state = (array)json_decode(file_get_contents("state.json"));

echo "Vorige start- en landingsbanen in Schiphol:\n";
foreach($previous_state as $k => $v) {
echo $k . ":\t" . $v . "\n";
}

echo "Actuele start- en landingsbanen in Schiphol:\n";
foreach($state as $k => $v) {
echo $k . ":\t" . $v . "\n";
}

file_put_contents("state.json", json_encode($state));

// now find the diffs
$changes = "";
foreach ($runways as $runway) {
	if ($previous_state[$runway] != $state[$runway]) {
		$changes = "De " . ucfirst($runway) . " is veranderd van " . (empty($previous_state[$runway]) ? "buiten gebruik" : $previous_state[$runway]) . " naar " . (empty($state[$runway]) ? "buiten gebruik" : $state[$runway]) . "\n";
	}
}

if ($changes != "") {
	echo $changes;
	
    $p = new Prowl\Prowl();
    $p->setApplication('Schiphol');
    $p->setKey($apikey);
    $p->setFailOnNotAuthorized(false);
    $p->setSubject("Verandering in start/landingsbaan op Schiphol");
    $p->setMessage($changes);
    $p->push();
} else {
	echo "Er zijn geen veranderingen\n";
}
