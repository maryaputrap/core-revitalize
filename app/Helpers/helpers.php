<?php

if (!function_exists('readableRouteName')) {
    function readableRouteName($routeName)
    {
        $routeMap = [
            'home' => 'Home',
            'pop.create' => 'Add POP',
            'pop.index' => 'Point of Presence',
            'fdt.index' => 'Fiber Distribution Terminal',
            'logout' => 'Logout',
        ];

        return $routeMap[$routeName] ?? ucfirst($routeName);
    }
}
