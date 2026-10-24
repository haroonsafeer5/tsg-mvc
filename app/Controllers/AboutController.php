<?php
class AboutController extends Controller
{
    public function index(): void
    {
        $this->view('about', ['title' => 'About Us - Tech SG Studio']);
    }
}