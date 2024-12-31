<?php
namespace App\Controllers;

use App\Models\RestaurantModel;
use App\Models\CustomerModel;
use App\Models\MenuModel;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RestaurantController extends Controller
{
  private $menuModel;

  public function __construct()
  {
    helper('jwt');
    $this->menuModel = new MenuModel();
  }

  public function login()
  {
    $session = session();
    if ($session->get('user_id')) {

      if ($session->get('role') === 'restaurant') {
        return redirect()->to('/menu');
      } else {
        return redirect()->to('CustomerUsers/dashboard');
      }
    }
    return view('RestaurantUsers/login.php');
  }

  public function loginUser()
  {
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    $role = $this->request->getPost('role');
    $userModel = $role === 'Restaurant' ? new RestaurantModel() : new CustomerModel();

    $user = $userModel->where(['email' => $email])->get()->getRowArray();


    if ($user && password_verify($password, $user['password'])) {

      $session = session();
      $jwt = createJWT(['id' => $user['id'], 'email' => $user['email'], 'role' => $role]);
      $role_id = isset($user['role_id']) ? $user['role_id'] : null;
      session()->set([
        'user_id' => $user['id'],
        'role' => $role,
        'role_id' => $role_id,
        'res' => $role === 'Restaurant' ? $user['restaurant_name'] : null,
        'token' => $jwt,
        'email' => $user['email']
      ]);

      if ($role_id == 1) {
        return redirect()->to('Admin/dashboard');
      }

      return redirect()->to($role === 'Restaurant' ? '/menu' : '/CustomerUsers/dashboard');
    } else {
      return redirect()->back()->with('error', 'Invalid login credentials');
    }
  }

  public function verifyRecaptcha($recaptchaResponse)
  {
    $secretKey = '6Lc1cqkqAAAAAE-_SFM4-K3b-i5dAX0dY2rFUl53';
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);
    return intval($responseKeys['success']) === 1;
  }

  public function logout()
  {
    session()->destroy();
    return redirect()->to('/login');
  }

  public function register()
  {
    return view('RestaurantUsers/register');
  }

  public function registerUser()
  {
    $restaurantModel = new RestaurantModel();
    $photo = $this->request->getFile('photo');
    if ($photo && $photo->isValid() && !$photo->hasMoved()) {
      $newName = $photo->getRandomName();
      $photo->move('Restaurant_photo/', $newName);
      $photoPath = 'Restaurant_photo/' . $newName;
    } else {
      return redirect()->back()->with('error', 'Photo upload failed. Please try again.');
    }
    $data = [
      'restaurant_name' => $this->request->getPost('restaurant_name'),
      'email' => $this->request->getPost('email'),
      'phone_number' => $this->request->getPost('phone_number'),
      'photo' => $photoPath,
      'country_code' => $this->request->getPost('country_code'),
      'latitude' => $this->request->getPost('latitude'),
      'longitude' => $this->request->getPost('longitude'),
      'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
    ];

    if ($restaurantModel->save($data)) {
      $this->sendEmail($data);
      return redirect()->to('/login')->with('success', 'Registration successful! Check your email.');
    } else {
      return redirect()->back()->with('error', 'Registration failed. Please try again.');
    }
  }

  public function customerRegister()
  {
    return view('CustomerUsers/register');
  }

  public function customerRegisterUser()
  {
    $customerModel = new CustomerModel();
    $data = [
      'name' => $this->request->getPost('name'),
      'email' => $this->request->getPost('email'),
      'phone_number' => $this->request->getPost('phone_number'),
      'country_code' => $this->request->getPost('country_code'),
      'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
    ];

    if ($customerModel->save($data)) {
      return redirect()->to('/login')->with('success', 'Customer registration successful!');
    } else {
      return redirect()->back()->with('error', 'Registration failed. Please try again.');
    }
  }

  public function registerRestaurantWithMenu()
  {
    $restaurant_name = $this->request->getPost('restaurant_name');
    $menu_items = $this->request->getPost('menu_items');

    foreach ($menu_items as $menu_item) {
      $data = [
        'restaurant_name' => $restaurant_name,
        'name' => $menu_item['name'],
        'price' => $menu_item['price'],
        'photo' => $menu_item['photo'],
      ];
      $this->menuModel->insert($data);
    }
    return redirect()->to('/restaurant/dashboard');
  }

  private function sendEmail($data)
  {
    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'priyam.srivastava@shipglobal.in';
      $mail->Password = 'xehkkjfjinzkptzj';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      $mail->setFrom('priyam.srivastava@shipglobal.in', 'Restaurant App');
      $mail->addAddress($data['email']);

      $mail->Subject = 'Welcome to Our Restaurant!';
      $mail->isHTML(true);
      $approveUrl = base_url("admin/approveRestaurant/" . urlencode($data['email']));
      $rejectUrl = base_url("admin/rejectRestaurant/" . urlencode($data['email']));

      $mail->Body = "
                <h2>Thank you for registering, {$data['restaurant_name']}!</h2>
                <p><strong>Email:</strong> {$data['email']}</p>
                <p><strong>Phone Number:</strong> {$data['phone_number']}</p>
                <p><strong>Country Code:</strong> {$data['country_code']}</p>
                <p>We look forward to serving you soon!</p>
                <p>
                <a href='{$approveUrl}' style='padding: 10px 20px; background-color: green; color: white; text-decoration: none; border-radius: 5px;'>Approve</a>
                <a href='{$rejectUrl}' style='padding: 10px 20px; background-color: red; color: white; text-decoration: none; border-radius: 5px;'>Reject</a>
                </p>
            ";

      $mail->send();
      log_message('info', 'Email sent successfully to ' . $data['email']);
    } catch (Exception $e) {
      log_message('error', 'Failed to send email: ' . $mail->ErrorInfo);
    }
  }

}
