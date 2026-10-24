<?php
class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home', ['title' => 'Welcome to Tech SG Studio MVC']);
    }
}