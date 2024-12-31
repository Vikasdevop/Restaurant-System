<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class PaymentController extends Controller
{
  public function index()
  {
    $session = session();
    $cartData = $session->get('cart');
    return view('CustomerUsers/Payment', ['cartData' => $cartData]);
  }

  public function checkout()
  {
    $cartData = json_decode(file_get_contents('php://input'), true);
    if ($cartData) {
      $session = session();
      $session->set('cart', $cartData);
      return $this->response->setJSON(['success' => true]);
    } else {
      return $this->response->setJSON(['success' => false, 'message' => 'Invalid cart data']);
    }
  }
}