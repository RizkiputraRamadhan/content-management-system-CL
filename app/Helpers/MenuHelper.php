<?php

if (!function_exists('isActive')) {
    /**
     * Menentukan apakah menu aktif berdasarkan tipe menu.
     *
     * @param string $page
     * @param string|array $menu
     * @return string
     */
    function isActive(string $page, $menu): string
    {
        if (is_array($menu)) {
            return in_array($page, $menu) ? 'active subdrop' : '';
        }
        return $page === $menu ? 'active' : '';
    }
}