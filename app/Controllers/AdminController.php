<?php

namespace App\Controllers;

use App\Models\RestaurantModel;
use CodeIgniter\Controller;

class AdminController extends Controller
{
    protected $restaurantModel;
    public function __construct()
    {
        $this->restaurantModel = new RestaurantModel();
    }

    public function approveRestaurant($email)
    {
        $this->restaurantModel->updateStatusByEmail($email, ['is_live' => 1]);
        return redirect()->to('/admin/dashboard')->with('success', 'Restaurant approved successfully!');
    }

    public function rejectRestaurant($email)
    {
        $this->restaurantModel->updateStatusByEmail($email, ['is_live' => 0]);
        return redirect()->to('/admin/dashboard')->with('error', 'Restaurant rejected successfully!');
    }
}
