<?php
// app/controllers/HomeController.php

class HomeController extends Controller
{
    public function index(): void
    {
        $settings = (new SettingModel())->getAll();
        $flash    = $this->getFlash();
        $this->view('pages/home', compact('settings', 'flash'), 'main');
    }
}
