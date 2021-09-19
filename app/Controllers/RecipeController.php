<?php

namespace App\Controllers;

use App\Models\DishModel;
use App\Controllers\BaseController;

class RecipeController extends BaseController
{
    public function search_dish()
    {
        if ($this->request->getMethod() == 'post') {
            $dish = new DishModel();

            //recupere la requete vocale pour rechercher la plat
            $vocal_request = trim(ucfirst($this->request->getVar('value')));
            $result_request = $dish->getDishDatas($vocal_request);

            $array_dish = [
                'name' => $result_request['dish_name'],
                'dish_quantity' => $result_request['quantity'],
                'image' => $result_request['image'],
                // 'recipe' => $result['recipe']
            ];
            $array_ingredients = [];

            //recupere les ingredient d'un plat
            $ingredients = $dish->getIngredients($result_request['dish_id']);
            foreach ($ingredients as $ingredient) {
                array_push($array_ingredients, '<span class="qty">' . $ingredient['ingredient_quantity'] . '</span>' . ' ' . $ingredient['conditionnement'] . '  ' . $ingredient['ingredient_name']);
            }
            $ingredients = array('ingredients' => $array_ingredients);
            //on push un tableau d'ingrédient dans le tableau array_dish
            // $data_array = array_merge($array_dish, $ingredients);

            //on recupere les etapes de la recette
            $steps = $dish->getSteps($result_request['dish_id']);
            $array_steps = [];
            foreach ($steps as $step) {
                array_push($array_steps, '<div class="div_etape_' . $step['etape_number'] . '" ><h5>- Étape ' . $step['etape_number'] . ' : </h5><br><p class="etape_no_' . $step['etape_number'] . '">'  . $step['etape_content'] . '</p><br></div>');
            }
            $steps = array('steps' => $array_steps);
            $data_array = array_merge($array_dish, $steps, $ingredients);

            echo json_encode(array('result' => $data_array));
        }
    }

    public function category()
    {
        if ($this->request->getMethod() == 'post') {
            if ($this->request->getVar('category')) {
                $dish = new DishModel();
                $category = $dish->getDishByCategory($this->request->getVar('category'));
                echo json_encode(array('category' => $category));
            }
        }
    }

    public function form_url_search()
    {
        return view('search');
    }

    public function add_recipe_collection()
    {
        echo json_encode(array('succes' => 'c\'est réussi'));
    }
}
