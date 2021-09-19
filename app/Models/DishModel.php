<?php

namespace App\Models;

use CodeIgniter\Model;

class DishModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'dish';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['*'];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	public function getDishDatas($request)
	{
		$builder = $this->db->table('dish');
		$builder->select('*');
		$builder->like('dish_name', $request);
		$data = $builder->get()->getRowArray();
		return $data;
	}
	public function getIngredients($dish_id)
	{
		$builder = $this->db->table('ingredients');
		$builder->select('*');
		$builder->join('dish', 'ingredients.dish_id = dish.dish_id');
		$builder->where('ingredients.dish_id', $dish_id);
		$data = $builder->get()->getResultArray();
		return $data;
	}
	public function getSteps($dish_id)
	{
		$builder = $this->db->table('etape');
		$builder->select('*');
		$builder->join('dish', 'etape.dish_id = dish.dish_id');
		$builder->where('etape.dish_id', $dish_id);
		$data = $builder->get()->getResultArray();
		return $data;
	}
	public function getDishByCategory($categpry)
	{
		$builder = $this->db->table('dish');
		$builder->select('*');
		$builder->where('category', $categpry);
		$starters = $builder->get()->getResultArray();
		return $starters;
	}

	public function create_dish($data)
	{
		$builder = $this->db->table('dish');
		$builder->select('*');
		$builder->where('dish_name', $data['dish_name']);
		if (!$builder->get()->getRow()) {
			$builder->set($data)->insert();
		}
	}
	public function create_etape($data)
	{
		$builder = $this->db->table('etape');
		$builder->select('*');
		$builder->where('etape_content', $data['etape_content']);
		$builder->where('dish_id', $data['dish_id']);
		if (!$builder->get()->getRow()) {
			$builder->set($data)->insert();
		}
	}
	public function create_ingredient($data)
	{
		$builder = $this->db->table('ingredients');
		$builder->select('*');
		$builder->where('ingredient_name', $data['ingredient_name']);
		$builder->where('dish_id', $data['dish_id']);
		if (!$builder->get()->getRow()) {
			$builder->set($data)->insert();
		}
	}
}
