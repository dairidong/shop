<?php

if (! function_exists('notify_url')) {
    function notify_url(string $routeName, $parameters = []): string
    {
        if (app()->environment('local') && $url = config('services.expose.url')) {
            return $url.route($routeName, $parameters, false);
        }

        return route($routeName, $parameters);
    }
}
