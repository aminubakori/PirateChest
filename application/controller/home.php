<?php

/**
 * Class Home
 */
class Home extends Controller
{
    public function index()
    {
        require 'application/views/home/index.php';
    }

    public function anonymous()
    {
        if(!isset($_SESSION))
        {
            ob_start();
            session_start();
        }

        $_SESSION['anonymous'] = true;
        header('Location:'.URL);
    }
}