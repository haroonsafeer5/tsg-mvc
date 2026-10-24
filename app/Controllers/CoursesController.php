<?php
class CoursesController extends Controller
{
    public function index(): void
    {
        $courseModel = new Course();
        $courses = $courseModel->all();
        $this->view('courses', [
            'title' => 'Available Courses',
            'courses' => $courses
        ]);
    }
}