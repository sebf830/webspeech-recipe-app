<?php

namespace App\Controllers;

use App\Models\DishModel;
use App\Controllers\BaseController;


class Home extends BaseController
{
	public function index()
	{

		return view('login');
	}

	public function speech()
	{
		return view('app');
	}

	public function search_dish()
	{
		if ($this->request->getMethod() == 'post') {
			$dish = new DishModel();

			//recupere la requete vocale pour rechercher la plat
			$value = trim(ucfirst($this->request->getVar('value')));
			$result = $dish->getDishDatas($value);

			$array_dish = [
				'name' => $result['dish_name'],
				'dish_quantity' => $result['quantity'],
				'image' => $result['image'],
				// 'recipe' => $result['recipe']
			];
			$array_ingredients = [];

			//recupere les ingredient d'un plat
			$ingredients = $dish->getIngredients($result['dish_id']);
			foreach ($ingredients as $ingredient) {
				array_push($array_ingredients, '<span class="qty">' . $ingredient['ingredient_quantity'] . '</span>' . ' ' . $ingredient['conditionnement'] . '  ' . $ingredient['ingredient_name']);
			}
			$ingredients = array('ingredients' => $array_ingredients);
			//on push un tableau d'ingrédient dans le tableau array_dish
			// $data_array = array_merge($array_dish, $ingredients);


			//on recupere les etapes de la recette
			$steps = $dish->getSteps($result['dish_id']);
			$array_steps = [];
			foreach ($steps as $step) {
				array_push($array_steps, '<h5>- Étape ' . $step['etape_number'] . ' : </h5><br><p class="etape_no_' . $step['etape_number'] . '">'  . $step['etape_content'] . '</p><br>');
			}
			$steps = array('steps' => $array_steps);
			$data_array = array_merge($array_dish, $steps, $ingredients);

			echo json_encode(array('result' => $data_array));
		}
	}

	public function starters()
	{
		if ($this->request->getMethod() == 'post') {
			if ($this->request->getVar('request')) {
				$dish = new DishModel();
				$starters = $dish->getStarters();
				echo json_encode(array('starters' => $starters));
			}
		}
	}
}
