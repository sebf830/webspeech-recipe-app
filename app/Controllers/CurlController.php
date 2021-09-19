<?php

namespace App\Controllers;

use DOMXPath;
use DOMDocument;
use App\Models\DishModel;
use App\Controllers\BaseController;

class CurlController extends BaseController
{
    public function search_url()
    {
        if ($this->request->getMethod() == 'post') {
            if ($this->request->getVar('link')) {
                $link = $this->request->getVar('link');

                $sh = curl_init();
                curl_setopt($sh, CURLOPT_URL, $link);
                curl_setopt($sh, CURLOPT_RETURNTRANSFER, true);
                $html = curl_exec($sh);

                $dom = new DOMDocument();
                @$dom->loadHTML($html);

                $xpath = new DOMXPath($dom);
                $paragraphs = $xpath->query("//*[@class and contains(concat(' ', normalize-space(@class), ' '), 'Stepsstyle__Text-sc-1el6pkn-3')]");
                $title_h3s = $xpath->query("//*[@class and contains(concat(' ', normalize-space(@class), ' '), 'Stepsstyle__StepTitle-sc-1el6pkn-1')]");
                $tag_imgs = $xpath->query("//*[@class and contains(concat(' ', normalize-space(@class), ' '), 'Picturestyle__PictureImg-dy77ha-0')]");
                $title_h1 = $dom->getElementsByTagName('h1');
                $qtes = $xpath->query("//*[@class and contains(concat(' ', normalize-space(@class), ' '), 'eYSThb')]");
                $ingredients = $xpath->query("//*[@class and contains(concat(' ', normalize-space(@class), ' '), 'dDuSlh')]");
                $category = $xpath->query("//*[@class and contains(concat(' ', normalize-space(@class), ' '), 'iYuJQV')]");

                $category_tab = [];
                foreach ($category as $cat) {
                    $cat_text = htmlentities($cat->textContent);
                    $cat_text = str_replace('&gt;', '', $cat_text);

                    $cati = explode('&nbsp;', $cat_text);
                    $category_name = $this->check_category($cati);
                    $category_tab = ['name' =>  $category_name];
                }


                $recipe = [];
                //titre de la recette
                foreach ($title_h1 as $h1) {
                    $h1_text = $h1->textContent;
                    $recipe = ['title' => $h1_text, 'personnes' => 4];
                }

                //titre étape
                $h3_array = array();
                foreach ($title_h3s as $h3) {
                    $h3_text = $h3->textContent;
                    array_push($h3_array, $h3_text);
                }
                //texte etape
                $p_array = array();
                foreach ($paragraphs as $p) {
                    $p_text = $p->textContent;
                    array_push($p_array, $p_text);
                }

                //image
                $img_array = array();
                for ($i = 0; $i < 2; $i++) {
                    $src = $tag_imgs[$i]->getAttribute('src');

                    $substring = substr($src, 0, 47);
                    $src = $substring . 'w1200h1800c1cx2000cy3000.jpg';
                    array_push($img_array, $src);
                }

                //quantités
                $qte_array = [];
                foreach ($qtes as $qte) {
                    $qte_text = $qte->textContent;

                    $conditionnement = str_replace(' ', '', preg_replace('`[0-9]`sm', '', trim($qte_text)));
                    $number_qte = str_replace(' ', '', preg_replace('/[^0-9]/', '', trim($qte_text)));
                    array_push($qte_array, $number_qte . $conditionnement);
                }

                //ingrédients
                $ingredient_array = [];
                foreach ($ingredients as $ingredient) {
                    $ingredient_text = $ingredient->textContent;
                    array_push($ingredient_array, $ingredient_text);
                }

                $steps = [];
                $array_steps = [];
                for ($i = 0; $i < count($h3_array); $i++) {
                    $array_steps += [$h3_array[$i] => $p_array[$i]];
                }
                $steps = ['steps' => $array_steps];
                $recipe_steps = array_merge($recipe, $steps);


                $all_images = [];
                for ($i = 0; $i < count($img_array); $i++) {
                    $all_images += ['image' => $img_array[$i]];
                }
                $allRecipe = array_merge($recipe_steps, $all_images);

                $ingredient = [];
                $array_ingredients = [];
                for ($i = 0; $i < count($ingredient_array); $i++) {
                    $array_ingredients += [$ingredient_array[$i] => $qte_array[$i]];
                }
                $ingredient = ['ingredients' => $array_ingredients];
                $recipe_array = array_merge($allRecipe, $ingredient);

                if ($this->request->getVar('action')) {
                    $dish = new DishModel();

                    $data_requested_dish = [
                        "dish_name" => $recipe['title'],
                        "quantity" => $recipe['personnes'],
                        "image" => $img_array[0],
                        "category" => $category_tab['name']
                    ];

                    $dish->create_dish($data_requested_dish);
                    $current_dish = $dish->getDishDatas($recipe['title']);

                    for ($i = 1; $i <= count($h3_array); $i++) {
                        $data_etape_dish = [
                            "etape_content" => $p_array[$i],
                            "etape_number" => $i,
                            "dish_id" => $current_dish['dish_id']
                        ];
                        $dish->create_etape($data_etape_dish);
                    }

                    for ($i = 1; $i <= count($qte_array); $i++) {

                        $conditionnement = str_replace(' ', '', preg_replace('`[0-9]`sm', '', trim($qte_array[$i])));
                        $number_qte = str_replace(' ', '', preg_replace('/[^0-9]/', '', trim($qte_array[$i])));

                        $data_igredients_dish = [
                            "ingredient_name" => $ingredient_array[$i],
                            "ingredient_quantity" => $number_qte,
                            "conditionnement" => $conditionnement,
                            "dish_id" => $current_dish['dish_id']
                        ];
                        $dish->create_ingredient($data_igredients_dish);
                    }



                    echo json_encode(array('success' => 'enregistré en base de donnée'));
                } else {

                    echo json_encode(array('recipe' => $recipe_array));
                }
            }
        }
    }

    public function check_category(array $array)
    {
        if (in_array('Plat principal', $array) || in_array('Plat unique', $array)) {
            return 'main';
        } else if (in_array('Entrée', $array) || in_array('Entr&eacute;e', $array)) {
            return 'starters';
        } else if (in_array('Dessert', $array)) {
            return 'dessert';
        }
    }
}
