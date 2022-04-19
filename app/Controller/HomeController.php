<?php

namespace thirthfamous\Controller;

use thirthfamous\App\View;

class HomeController
{

    function index()
    {
        View::render('Home/index', [
            "title" => "PHP Login Management"
        ]);
    }

}