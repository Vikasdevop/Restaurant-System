<?php
namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\RestaurantModel;

class MenuController extends BaseController
{
    protected $restaurantModel;

    public function __construct(){
        $this->restaurantModel = new RestaurantModel();
        $this->session = \Config\Services::session();
        helper("jwt_helper");
    }

    // public function toggle_status() {
    //     if ($this->request->isAJAX()) {
    //         $restaurantName = $this->request->getJSON('restaurant_name');
    //         $is_open = $this->request->getJSON('is_open');

    //         $updated = $this->restaurantModel->where('restaurant_name', $restaurantName)
    //                                          ->set('is_open', $is_open)
    //                                          ->update();

    //         if ($updated) {
    //             return $this->response->setJSON(['success' => true, 'message' => 'Status updated successfully!']);
    //         } else {
    //             return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status.']);
    //         }
    //     }
    //     return redirect()->to('/menu')->with('message', 'Invalid request.');
    // }


    public function index() {
        $db = \Config\Database::connect();
        $jwt = $this->session->get('token');
        $data = $jwt ? validateJWT($jwt) : null;
        $restaurantId = session()->get('user_id');
        $restaurantname = session()->get('res');
        $restaurant = $db->query("SELECT * FROM restaurant WHERE id ='$restaurantId'")->getRowArray();
        $restaurants = $db->table('restaurant')->get()->getResultArray();
        $menuModel = new MenuModel();

        $currentMenuItems = $menuModel->where('restaurant_id', $restaurantId)->findAll();

        $menuTypes = ['Beverages', 'Starter', 'Main Course', 'Dessert'];

        $restaurantName = $restaurant['restaurant_name'] ?? 'Unknown Restaurant';
        $isOpen = $restaurant['is_open'] ?? false;

        return view('menu/index', [
            'menuTypes' => $menuTypes,
            'currentMenuItems' => $currentMenuItems,
            'restaurants' => $restaurants,
            'restaurant_name' => $restaurantName,
            'is_open' => $restaurant['is_open']
        ]);
    }

//
    public function menu() {
        $restaurant_id = session()->get('restaurant_id');

        if (!$restaurant_id) {
            return redirect()->back()->with('error', 'Restaurant not found or session expired.');
        }
        $restaurant = $this->db->table('restaurant')->where('id', $restaurant_id)->get()->getRow();

        if (!$restaurant) {
            return redirect()->back()->with('error', 'Restaurant details not found.');
        }
        if (!$restaurant->is_open) {
            return view('error_page', ['message' => 'This restaurant is currently closed.']);
        }
        $menuItems = $this->db->table('menu')->where('restaurant_name', $restaurant->name)->get()->getResult();
        
        return view('/menu', [
            'menuItems' => $menuItems,
            'restaurant_id' => $restaurant_id,
            'restaurant_name' => $restaurant['restaurant_name'],
            'is_open' => $restaurant['is_open'],
        ]);
    }

//

    // public function updateStatus()
    // {
    //     $restaurantId = $this->request->getPost('restaurant_id');
    //     $status = $this->request->getPost('status');
    //     $db = \Config\Database::connect();
    //     $db->table('restaurant')->where('id', $restaurantId)->update(['status' => $status]);
    //     return $this->response->setJSON(['success' => true]);
    // }


    public function getItemQuantityLimit($itemId) {
    $this->load->model('Menu_model');
    $quantity_limit = $this->Menu_model->getQuantityLimit($itemId);
    echo json_encode(['quantity_limit' => $quantity_limit]);
    }

    public function setItemQuantityLimit()
    {
        $itemId = $this->request->getPost('item_id');
        $quantityLimit = $this->request->getPost('quantity_limit');
        if ($itemId && $quantityLimit) {
            $itemModel = new MenuModel();
            $itemModel->updateItemQuantityLimit($itemId, $quantityLimit);
            return redirect()->to('/menu')->with('success', 'Quantity limit updated');
        } else {
            return redirect()->back()->with('error', 'Invalid data');
        }
    }
    
    public function view($type)
    {
        $menuModel = new MenuModel();
        $restaurantId = session()->get('user_id');
        $items = $menuModel->findAll();
        $data['items'] = $menuModel->where('restaurant_id', $restaurantId)
                                   ->where('type', $type)
                                   ->findAll();
        $data['type'] = $type;

        return view('menu/view', $data);
    }

    public function add()
    {
        return view('menu/add');
    }

    public function profile() {
    $session = session();
    $restaurantId = $session->get('user_id');
    $restaurantModel = new RestaurantModel();
    $restaurant = $restaurantModel->find($restaurantId);
    return view('menu/profile', ['restaurant' => $restaurant]);
    }

    public function updateprofile()
    {
        $session = session();
        $restaurantId = $session->get('user_id');
        $restaurantModel = new RestaurantModel();
    
        $photo = $this->request->getFile('photo');
        $rules = [
            'restaurant_name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'phone_number' => 'required|numeric|min_length[10]',
            'password' => 'required|min_length[8]',
        ];
    
        if ($this->validate($rules)) {
            $data = [
                'restaurant_name' => $this->request->getPost('restaurant_name'),
                'email' => $this->request->getPost('email'),
                'phone_number' => $this->request->getPost('phone_number'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            ];
    
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $uploadPath = FCPATH . '/Restaurant_photo';
                $photoName = $photo->getRandomName(); // Use a random name for the uploaded file
                $photo->move($uploadPath, $photoName);
                $data['photo'] = '/Restaurant_photo/' . $photoName; // Update the photo path in the data
            }
    
            $restaurantModel->where('id', $restaurantId)->update($restaurantId, $data);
            $session->setFlashdata('success', 'Profile updated successfully!');
            return redirect()->to('/menu');
        } else {
            return redirect()->to('/menu/profile')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
    }

    public function viewmenu ($id)
    {
        $db = \Config\Database::connect();
        $getmenu = $db->query("SELECT * FROM menu WHERE restaurant_id='$id'");
        $menus = $getmenu->getResultArray();
        return view('/CustomerUsers/view_menu', ['menus' => $menus, 'restaurantId' => $id]);
    }

    public function deleteMenuItem($id) {
        $menuModel = new MenuModel();

        if ($menuModel->delete($id)) {
            return redirect()->back()->with('status', 'Menu item deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete menu item.');
        }
    }

    public function store()
    {
        if (!$this->validate([
            'type' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'photo' => 'uploaded[photo]|max_size[photo,2048]|is_image[photo]',
        ])) {
            return redirect()->back()->with('error', $this->validator->listErrors());
        }

        $menuModel = new MenuModel();
        $restaurantId = session()->get('user_id');
        $itemName = $this->request->getPost('name');

        $duplicate = $menuModel->where('restaurant_id', $restaurantId)
                               ->where('name', $itemName)
                               ->first();

        if ($duplicate) {
            return redirect()->back()->with('error', 'This menu item already exists for your restaurant.');
        }

        $photo = $this->request->getFile('photo');
        if ($photo->isValid() && !$photo->hasMoved()) {
            $photoName = $photo->getRandomName();
            $photo->move('uploads/menu_photos', $photoName);
        }

        $data = [
            'restaurant_id' => $restaurantId,
            'restaurant_name' => session()->get('res'),
            'type' => $this->request->getPost('type'),
            'name' => $itemName,
            'price' => $this->request->getPost('price'),
            'photo' => $photoName,
            'quantity_limit' => $this->request->getPost('quantity_limit')
        ];

        $menuModel->save($data);

        return redirect()->to('/menu')->with('status', 'Menu item added successfully');
    }

    public function addToCart(){
        $json = $this->request->getJSON();
        $itemId = $json->itemId;
        $session = session();
        $restaurantId = $session->get('user_id');
        
        $result = $this->restaurantModel->additemTocart($itemId, $restaurantId);
        return $this->response->setJSON(['status' => true]);
    }

    public function showCart(){
        $session = session();
        $restaurantId = $session->get('user_id');
        $itemInfo = $this->restaurantModel->getCartItem($restaurantId);
        $total = 0;
        foreach ($itemInfo as $item) {
            $total += $item['item_price'] * $item['quantity'];
        }

        // var_dump($total);
        // die();
        return view("\CustomerUsers\Payment",['cartItems'=>$itemInfo, 'total' => $total]);
    }

    public function deleteFromCart($cartId){
        $deleteItem = $this->restaurantModel->deleteCartItem($cartId);
        return redirect()->to('CustomerUsers/Payment');
    }

    public function confimPaymentAPI(){
        $session = session();
        $restaurantId = $session->get('user_id');
        $res = $this->restaurantModel->removeCartItems($restaurantId);
        if($res){
            return $this->response->setJSON(['status'=>true]);
        }
        return $this->response->setJSON(['status'=>false]);
    }

    public function changeRestaurantStatus(){
        $statusId = $this->request->getGet('status');
        
        $session = session();
        $restaurantId = $session->get('user_id');

        $res = $this->restaurantModel->changeStatus($restaurantId, $statusId);

        return redirect()->to('/menu');
    }
}
