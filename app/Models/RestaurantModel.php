<?php
namespace App\Models;

use CodeIgniter\Model;

class RestaurantModel extends Model {
    protected $table = 'restaurant';
    protected $primaryKey = 'id';
    protected $allowedFields = ['restaurant_name', 'country_code', 'phone_number', 'email', 'password', 'photo', 'latitude', 'longitude', 'is_open'];

    public function getAllRestaurants() {
        return $this->findAll();
    }
    
    public function getMenuByRestaurantName($restaurantName) {
        return $this->db->table('menu')
                        ->where('restaurant_name', $restaurantName)
                        ->get()
                        ->getResultArray();
    }
    
    public function additemTocart($itemId, $restaurantId){
        $checkIfItemExists = $this->db->query("SELECT * FROM cart_table WHERE item_id ='$itemId' AND user_id ='$restaurantId'")->getNumRows();

        if($checkIfItemExists){
            return $this->db->query("UPDATE cart_table SET quantity = quantity + 1 WHERE user_id = '$restaurantId' AND item_id = '$itemId'");
        }

        return $this->db->query("INSERT INTO cart_table (user_id, item_id, quantity) VALUES ('$restaurantId', '$itemId', '1')");
    }

    public function getCartItem($userId){
        return $this->db->query("SELECT c.cart_id, c.user_id, c.item_id, m.name AS item_name, m.price AS item_price, c.quantity FROM cart_table c JOIN menu m ON c.item_id = m.id WHERE c.user_id = $userId")->getResultArray();
    }

    public function deleteCartItem($cartId){
        return $this->db->query("DELETE FROM cart_table WHERE cart_id = '$cartId'");
    }

    public function removeCartItems($restaurantId){
        return $this->db->query("DELETE FROM cart_table WHERE user_id = '$restaurantId'");
    }
}
