<?php

namespace App\Controllers;

use App\Models\RestaurantModel;
use CodeIgniter\Controller;
use CodeIgniter\Database\Seeder;

class AdminController extends Controller
{
  public function dashboard()
  {
    $restaurantModel = new RestaurantModel();
    $data['restaurant'] = $restaurantModel->findAll();

    return view('Admin/dashboard', $data);
  }

  public function deleteRestaurant($id)
  {
    $restaurantModel = new RestaurantModel();
    if ($restaurantModel->delete($id)) {
      return redirect()->to('Admin/dashboard')->with('message', 'Restaurant deleted successfully!');
    } else {
      return redirect()->to('Admin/dashboard')->with('message', 'Failed to delete restaurant.');
    }
  }

  public function logout()
  {
    session()->destroy();
    return redirect()->to('/login');
  }

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

  public function adminDashboard()
  {
    if (session()->get('role_id') != 1) {
      return redirect()->to('CustomerUsers/dashboard');
    }
    return view('Admin/dashboard');
  }

  public function before(RequestInterface $request, $arguments = null)
  {
    if (session()->get('role_id') != 1) {
      return redirect()->to('CustomerUsers/dashboard');
    }
  }
}

class UserSeeder extends Seeder
{
  public function run()
  {
    $data = [
      'username' => 'admin',
      'password' => password_hash('admin123', PASSWORD_BCRYPT),
      'role_id' => 1,
    ];
    $this->db->table('users')->insert($data);
  }
}
