<?php

if (! function_exists('user')) {
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

if (! function_exists('str_between')) {
    /**
     * Get the authenticated user.
     *
     * @return \App\Models\User
     */
    function str_between($subject = '', $start = '{', $end = '}')
    {
        $pattern = '/\\'.$start.'(.*?)\\'.$end.'/';

        preg_match_all($pattern, $subject, $matches);

        return $matches[1] ?? [];
    }
}
