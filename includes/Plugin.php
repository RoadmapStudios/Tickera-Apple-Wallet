<?php

declare(strict_types=1);

namespace Tickera\WalletPass;

final class Plugin
{
    public static function bootstrap(): void
    {
        Admin::register();
        Api::register();
    }

    public static function setAppleMimeType(): void
    {
        if (!\function_exists('insert_with_markers') && \defined('ABSPATH')) {
            require_once \ABSPATH . 'wp-admin/includes/misc.php';
        }

        if (!\function_exists('get_home_path') && \defined('ABSPATH')) {
            require_once \ABSPATH . 'wp-admin/includes/file.php';
        }

        if (!\function_exists('get_home_path') || !\function_exists('insert_with_markers')) {
            return;
        }

        $htaccess = \get_home_path() . '.htaccess';
        $lines = ['AddType application/vnd.apple.pkpass    pkpass'];

        \insert_with_markers($htaccess, 'Apple Wallet Pass', $lines);
    }
}
