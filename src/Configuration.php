<?php

require_once __DIR__ . '/../config.php';

class Configuration
{
    public static function getBaseUrl(): string
    {
        if (!defined('BASE_URL')) {
            throw new RuntimeException('Required parameter BASE_URL is missing');
        }

        return BASE_URL;
    }

    public static function getGalleryList(): string
    {
        if (!defined('GALLERY_LIST')) {
            throw new RuntimeException('Required parameter GALLERY_LIST is missing');
        }

        return GALLERY_LIST;
    }

    public static function getExportPath(): string
    {
        if (!defined('EXPORT_PATH')) {
            throw new RuntimeException('Required parameter EXPORT_PATH is missing');
        }

        return EXPORT_PATH;
    }

    public static function getLogPath(): string
    {
        if (!defined('LOG_PATH')) {
            throw new RuntimeException('Required parameter LOG_PATH is missing');
        }

        return LOG_PATH;
    }

    public static function getPageCount(): int
    {
        if (!defined('PAGE_COUNT')) {
            throw new RuntimeException('Required parameter PAGE_COUNT is missing');
        }

        return PAGE_COUNT;
    }

}