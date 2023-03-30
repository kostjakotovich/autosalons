<?php
require_once 'connection.php';
require_once 'Offer.php';

$offer = new Offer();

// получить информацию об офферах
$offers = $offer->getOffers();

// получить информацию об оффере с ID = 1
$offerInfo = $offer->getOfferInfo(1);

?>
