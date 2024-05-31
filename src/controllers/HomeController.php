<?php

require_once 'AppController.php';

class HomeController extends AppController
{
    public function no_access()
    {
        $this->render('no_access');
    }

    public function not_found()
    {
        $this->render('not_found');
    }
}