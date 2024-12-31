<?php
namespace App\Models;
use CodeIgniter\Model;

class MenuModel extends Model
{
	protected $table = 'menu';
	protected $primaryKey = 'id';
	protected $allowedFields = ['type', 'name', 'price', 'photo', 'restaurant_id', 'restaurant_name', 'quantity_limit'];

	public function isDuplicateMenuItem($restaurant_id, $item_name)
	{
		return $this->where('restaurant_id', $restaurant_id)
			->where('name', $item_name)
			->countAllResults() > 0;
	}

	public function updateItemQuantityLimit($itemId, $quantityLimit)
	{
		return $this->db->table($this->table)
			->where('id', $itemId)
			->update(['quantity_limit' => $quantityLimit]);
	}

	public function getQuantityLimit($itemId)
	{
		$this->db->select('quantity_limit');
		$this->db->from('menu');
		$this->db->where('id', $itemId);
		$query = $this->db->get();
		return $query->row()->quantity_limit;
	}

}


