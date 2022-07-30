<?php

require_once __DIR__ . '/lib/simple_html_dom.php';
require_once __DIR__ . '/Configuration.php';

class ImageController
{
    public function getGalleryLinks(int $page): array
    {
        $galleryLinks = [];
        $galleryHtml = file_get_html(sprintf('%s?page=%s', Configuration::getGalleryList(), $page));

        foreach ($galleryHtml->find('div.teaser-content') as $galleryItem) {
            $galleryLinks[] = trim($galleryItem->find('a', 0)->href);
        }

        return $galleryLinks;
    }

    public function download(string $link): void
    {
        $fixedLink = Configuration::getBaseUrl() . $link;
        mkdir(Configuration::getExportPath() . $this->getGalleryName($link));
        $images = $this->getAllImages($fixedLink);

        foreach ($images as $image) {
            $path = sprintf('%s%s/%s.%s', Configuration::getExportPath(), $this->getGalleryName($link), uniqid(), pathinfo($image)['extension']);
            file_put_contents($path, file_get_contents($image));
        }

    }

    private function getAllImages(string $link): array
    {
        $imageLinks = [];
        $html = file_get_html($link);

        foreach ($html->find('li.gallery-item') as $item) {
            $imageLinks[] = trim($item->find('img', 0)->src);
        }

        return $imageLinks;
    }

    private function getGalleryName(string $link): string
    {
        return mb_substr(parse_url($link, PHP_URL_PATH), 20);
    }
}