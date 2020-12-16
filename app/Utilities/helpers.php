<?php

if (!function_exists('user')) {
    /**
     * Get the authenticated user.
     *
     * @return \App\Models\User
     */
    function user()
    {
        return auth()->user();
    }
}