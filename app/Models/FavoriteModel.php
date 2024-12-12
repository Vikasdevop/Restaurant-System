<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoriteModel extends Model
{
    protected $table = 'favorites'; // Assuming a 'favorites' table exists
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'restaurant_id'];
    
    public function isFavorite($user_id, $restaurant_id)
    {
        return $this->where('user_id', $user_id)
                    ->where('restaurant_id', $restaurant_id)
                    ->countAllResults() > 0;
    }

    public function addFavorite($user_id, $restaurant_id)
    {
        $this->insert([
            'user_id' => $user_id,
            'restaurant_id' => $restaurant_id,
        ]);
    }

    public function removeFavorite($user_id, $restaurant_id)
    {
        $this->where('user_id', $user_id)
             ->where('restaurant_id', $restaurant_id)
             ->delete();
    }
}
