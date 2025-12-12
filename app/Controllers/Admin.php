<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller
{
    public function index()
    {
        // Default admin page, might redirect to dashboard or list users
        return redirect()->to('/admin/dashboard');
    }
}