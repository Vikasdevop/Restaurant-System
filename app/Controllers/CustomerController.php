<?php
namespace App\Controllers;
use App\Models\RestaurantModel;
use App\Models\FavoriteModel;
use CodeIgniter\Controller;
use App\Models\CustomerModel;

class CustomerController extends Controller
{
  protected $db;

  public function __construct()
  {
    $this->session = \Config\Services::session();
    helper("jwt_helper");
    $this->db = \Config\Database::connect();
  }

  public function dashboard()
  {
    $jwt = $this->session->get('token');
    $data = $jwt ? validateJWT($jwt) : null;
    $email = $this->session->get('email');

    if ($data && $data->email == $email) {
      $user_id = $this->session->get('user_id');
      $query = $this->db->query("SELECT 
                restaurant.*,
                CASE 
                    WHEN favorites.restaurant_id IS NOT NULL THEN 1
                    ELSE 0
                END AS is_favorite
            FROM 
                restaurant
            LEFT JOIN 
                favorites 
            ON  
                restaurant.id = favorites.restaurant_id AND favorites.user_id = $user_id;
            ")->getResultArray();

      $favorites = array_filter($query, fn($restaurant) => $restaurant['is_favorite'] == 1);

      return view('CustomerUsers/dashboard', [
        'restaurantMenus' => $query,
        'favorites' => $favorites
      ]);
    }

    return view('RestaurantUsers/login');
  }


  public function logout()
  {
    session()->destroy();
    return view("/login");
  }

  public function viewMenu($restaurantName)
  {
    $restaurantModel = new RestaurantModel();
    $restaurant = $restaurantModel->where('restaurant_name', $restaurantName)->first();

    if (!$restaurant) {
      return redirect()->back()->with('error', 'Restaurant not found.');
    }

    if (!$restaurant['is_open']) {
      return view('error_page', ['message' => 'This restaurant is currently closed.']);
    }
    $menuItems = $restaurantModel->getMenuByRestaurantName($restaurantName);

    $menuItems = $this->db->table('menu')
      ->where('restaurant_name', $restaurantName)
      ->get()
      ->getResult();


    if ($menuItems) {
      return view('menu/view_menu', [
        'menuItems' => $menuItems,
        'restaurant_name' => $restaurantName,
        'is_open' => $restaurant['is_open'],
      ]);
    } else {
      return redirect()->back()->with('error', 'No menu available for this restaurant.');
    }
  }

  public function viewRestaurants()
  {
    $db = \Config\Database::connect();
    $session = session();
    $userId = $session->get('user_id');
    if (!$userId) {
      return redirect()->to('/login');
    }
    $query = "SELECT r.*, 
                         (SELECT COUNT(*) FROM favorites f WHERE f.restaurant_id = r.id AND f.user_id = ?) AS is_favorite 
                  FROM restaurant r";
    $restaurantMenus = $db->query($query, [$userId])->getResultArray();
    return view('restaurants', ['restaurantMenus' => $restaurantMenus]);
  }

  public function addToFavorite($restaurant_id)
  {
    $model = new FavoriteModel();
    $user_id = session()->get('user_id');
    if (!$model->isFavorite($user_id, $restaurant_id)) {
      $model->addFavorite($user_id, $restaurant_id);
      return redirect()->back()->with('status', 'added');
    } else {
      return redirect()->back()->with('status', 'already_added');
    }
  }

  public function search()
  {
    $searchQuery = $this->request->getGet('search');
    $data = [];

    if ($searchQuery) {
      $sql = "SELECT * FROM restaurant WHERE restaurant_name LIKE ?";
      $query = $this->db->query($sql, ["%$searchQuery%"]);
      $data['restaurants'] = $query->getResultArray();
    } else {
      $data['restaurants'] = [];
    }

    $data['searchQuery'] = $searchQuery;
    return view('CustomerUsers/dashboard', $data);
  }

  public function removeFromFavorite($restaurant_id)
  {
    $model = new FavoriteModel();
    $user_id = session()->get('user_id');

    if ($model->isFavorite($user_id, $restaurant_id)) {
      $model->removeFavorite($user_id, $restaurant_id);
      return redirect()->back()->with('status', 'removed');
    } else {
      return redirect()->back()->with('status', 'not_in_favorites');
    }
  }

  public function toggleFavorite($restaurant_id)
  {
    $model = new FavoriteModel();
    $user_id = session()->get('user_id');
    if ($model->isFavorite($user_id, $restaurant_id)) {
      $this->removeFromFavorite($restaurant_id);
    } else {
      $this->addToFavorite($restaurant_id);
    }
  }

  private function checkIfFavorite($user_id, $restaurant_id)
  {
    $favoriteModel = new FavoriteModel();
    var_dump($restaurant_id);
    var_dump($favoriteModel->isFavorite($user_id, $restaurant_id));
    die();
    return $favoriteModel->isFavorite($user_id, $restaurant_id);
  }

  public function favoriterestaurants()
  {
    $userId = session()->get('user_id');
    $favoriteModel = new FavoriteModel();
    $restaurantModel = new RestaurantModel();

    $favoriteRestaurants = $favoriteModel->where('user_id', $userId)->findAll();
    $restaurantIds = array_column($favoriteRestaurants, 'restaurant_id');
    $restaurants = $restaurantModel->whereIn('id', $restaurantIds)->findAll();
    var_dump($restaurantIds);
    die();

    return view('CustomerUsers/dashboard', ['favorites' => $restaurants]);
  }

  public function customerProfile()
  {
    $session = session();
    $CustomerId = $session->get('user_id');
    $CustomerModel = new CustomerModel();
    $Customer = $CustomerModel->find($CustomerId);
    return view('CustomerUsers/customerProfile', ['Customer' => $Customer]);

  }

  public function CustomerUpdateprofile()
  {
    $session = session();
    $CustomerId = $session->get('user_id');
    $CustomerModel = new CustomerModel();

    $data = [
      'name' => $this->request->getPost('name'),
      'email' => $this->request->getPost('email'),
      'phone_number' => $this->request->getPost('phone_number'),
      'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
    ];

    if (
      !$this->validate([
        'name' => 'required|alpha_space',
        'email' => 'required|valid_email',
        'phone_number' => 'required|numeric',
        'password' => 'required|min_length[8]',
      ])
    ) {
      return redirect()->to('CustomerUsers/customerProfile')
        ->with('errors', $this->validator->getErrors())
        ->withInput();
    }

    try {
      $CustomerModel->where('id', $CustomerId)->update($CustomerId, $data);
      $session->setFlashdata('success', 'Profile updated successfully!');
    } catch (\Exception $e) {
      $session->setFlashdata('error', 'Failed to update profile. Try again later.');
    }

    return redirect()->to('CustomerUsers/dashboard');
  }

}
