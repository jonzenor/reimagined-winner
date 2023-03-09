<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function parseMarkdown(String $markdown): String
    {
        $html = Str::markdown($markdown);
        $html = str_replace("<a ", "<a class=\"link link-primary\" ", $html);

        return $html;
    }
}
