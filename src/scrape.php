<?php

require_once __DIR__ . '/Logger.php';
require_once __DIR__ . '/Configuration.php';
require_once __DIR__ . '/ImageController.php';

$logger = Logger::getInstance(Configuration::getLogPath());

$logger->info('scraper by f0xcb');
$logger->info(sprintf('pages to export %s', Configuration::getPageCount()));

$imageController = new ImageController();
$listOfGalleries = [];

$logger->info('start to get galleries');
for ($i = 0; $i <= Configuration::getPageCount(); $i++) {
    $logger->info(sprintf('try to get gallery page %s', $i));
    $listOfGalleries = array_merge($listOfGalleries, $imageController->getGalleryLinks($i));
}
$logger->info(sprintf('get %s galleries', count($listOfGalleries)));

$logger->info('start to download galleries');
foreach ($listOfGalleries as $gallery) {
    $logger->info(sprintf('download gallery: %s', $gallery));
    $imageController->download($gallery);
}
$logger->info(sprintf('saved all galleries to %s', Configuration::getExportPath()));