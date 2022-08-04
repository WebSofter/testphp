<?php
require_once __DIR__ . '/vendor/autoload.php';
use \App\HttpRequest;
use \App\CryptoPrice;

/**
 * *************** Create Request Object and get raw HTML code of page
 */
$request = new HttpRequest('https://myfin.by/crypto-rates', []);
$html = $request->getRaw();
/**
 * *************** Proxy connection if need
 */
//$request->proxy_ip = '0.25.30.65';
//$request->ip = 2595;
//$request->proxy_user = 'websofter';
//$request->proxy_password = 'secret';

/**
 * *************** Traverse coins
 */
$coins = [];
libxml_use_internal_errors(true);
$document = new DOMDocument();
$document->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$rows = $document->getElementsByTagName("tr");
for ($i = 0; $i < $rows->length; $i++) {
    $cols = $rows->item($i)->getElementsbyTagName("td");
    for ($j = 0; $j < $cols->length; $j++) {
        echo  " | ".$cols->item($j)->nodeValue;
    }
    if($i == 0) continue;
    $crypto = $cols->item(0)->nodeValue;
    $fiat = explode('$', $cols->item(1)->nodeValue)[0];
    $price = preg_replace('/[\$,\%]/',"", $cols->item(3)->nodeValue);
    $time = preg_replace('/[\$,\%]/',"", $cols->item(4)->nodeValue);
    $coins[] = [
        "crypto" => $crypto, 
        "fiat" => intVal($fiat), 
        "price" => floatVal($price), 
        "time" => intVal($time)
    ];
    echo "<br/>";
}

/**
 * *************** Create table from class Entity
 */
$container = require_once __DIR__.'/depdency.php';

/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = $container[\Doctrine\ORM\EntityManagerInterface::class]();
$tool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
$classes = array(
    $entityManager->getClassMetadata(CryptoPrice::class),
);
$tool->dropSchema($classes);
$tool->createSchema($classes);

/**
 * *************** Insert coins
 */
foreach ($coins as $coin) {
  $t = new CryptoPrice();
  //
  $t->setCrypto($coin['crypto']);
  $t->setFiat($coin['fiat']);
  $t->setPrice($coin['price']);
  $t->setTime($coin['time']);
  //
  $entityManager->persist($t);
  $entityManager->flush();
}


/**
 * *************** End
 */
try{
    $entityManager->flush();
}catch (Exception $e){
    echo $e->getMessage();
    die();
}