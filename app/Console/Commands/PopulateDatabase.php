<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use App\User;

use App\Models\Item;
use App\Models\Collection;
use App\Models\Recipe;

use Illuminate\Support\Facades\Hash;

class PopulateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds the database with demo data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('collection_item')->truncate();
        DB::table('collections')->truncate();
        DB::table('item_plan')->truncate();
        DB::table('item_recipe')->truncate();
        DB::table('items')->truncate();
        DB::table('plans')->truncate();
        DB::table('recipes')->truncate();
        DB::table('users')->truncate();

        User::create([
            'email' => 'me@alecgullon.co.uk',
            'name' => 'Alec',
            'password' => Hash::make('password'),
            'api_token' => 'abcd'
        ]);

        $this->generateItems();
        $this->generateCollections();
        $this->generateRecipes();
    }

    protected function generateItems()
    {
        $freshItems = ['Tomato', 'Lemon', 'Red Onion', 'Cucumber', 'Garlic Clove', 'Pepper', 'Potato', 'Courgette',
            'Sweet Potato', 'Onion', 'Spinach', 'Avocado', 'Carrot', 'Salad Leafs', 'Ginger', 'Lime'];

        foreach ($freshItems as $freshItem) {
            Item::create([
                'name' => $freshItem,
                'location_id' => 1,
                'user_id' => 1
            ]);
        }

        $chilledItems = ['Butter', 'Sweet Chili Sauce', 'Halloumi', 'Sour Cream and Chive Dip', 'Cheddar', 'Chipotle Mayo',
            'Parmesan', 'Coleslaw', 'Garlic Bread', 'Falafel', 'Hummus', 'Pizza', 'Vegetarian Spring Rolls', 'Milk'];

        foreach ($chilledItems as $chilledItem) {
            Item::create([
                'name' => $chilledItem,
                'location_id' => 2,
                'user_id' => 1
            ]);
        }

        $pantryItems = ['Baked Beans', 'Egg', 'Brioche Burger Bun', 'Gherkin', 'Chickpeas', 'Cumin', 'Coriander', 'Bread', 'Wraps',
            'Hot Chili Powder', 'Paprika', 'Oregano', 'Passata', 'Oxo Cube', 'Cinnamon', 'Pesto Pot', 'Bulgur Wheat', 'Risotto Rice',
            'Chili Flakes', 'Chopped Tomatoes', 'Lasagne Sheets', 'White Sauce', 'Rice Packet', 'Pitta Bread', 'Sweetcorn',
            'Basil', 'Parsley', 'Tomato Puree', 'Pasta', 'Straight Pasta', 'Thyme', 'Stir Fry Sauce Packet', 'Soy Sauce',
            'Cayenne Pepper', 'Cocoa Powder', 'Black Beans', 'Kidney Beans', 'Coconut Oil', 'Thai Red Curry Paste',
            'Peanut Butter', 'Coconut Milk', 'Plain Flour', 'Gravy Granules', 'Stuffing'];

        foreach ($pantryItems as $pantryItem) {
            Item::create([
                'name' => $pantryItem,
                'location_id' => 3,
                'user_id' => 1
            ]);
        }

        $frozenItems = ['Sausage', 'Hash Browns', 'Vegetarian Burger', 'Quorn Pieces', 'Mince', 'Peas'];

        foreach ($frozenItems as $frozenItem) {
            Item::create([
                'name' => $frozenItem,
                'location_id' => 5,
                'user_id' => 1
            ]);
        }
    }

    protected function generateCollections()
    {
        $collections = [
            [
                'name' => 'Breakfast',
                'items' => [
                    ['Baked Beans',  1],
                    ['Sausage', 4],
                    ['Hash Browns', 0.25],
                    ['Egg', 2]
                ]
            ],
            [
                'name' => 'Burgers with Chips',
                'items' => [
                    ['Vegetarian Burger',  2],
                    ['Brioche Burger Bun',  2],
                    ['Butter',  0.1],
                    ['Gherkin',  0.1],
                    ['Tomato', 1]
                ]
            ],
            [
                'name' => 'Chickpea Burgers, Coleslaw and Chips',
                'items' => [
                    ['Chickpeas', 1],
                    ['Lemon', 1],
                    ['Cumin', 0.1],
                    ['Coriander', 0.1],
                    ['Egg', 1],
                    ['Bread', 0.1],
                    ['Red Onion', 1],
                    ['Brioche Burger Bun', 2],
                    ['Tomato', 1],
                    ['Cucumber', 0.25],
                    ['Sweet Chili Sauce', 0.1],
                    ['Halloumi', 0.25]
                ]
            ],
            [
                'name' => 'Fajitas',
                'items' => [
                    ['Red Onion', 1],
                    ['Garlic Clove', 3],
                    ['Pepper', 1],
                    ['Quorn Pieces', 0.75],
                    ['Sour Cream and Chive Dip', 0.5],
                    ['Wraps', 4],
                    ['Cheddar', 0.25],
                    ['Hot Chili Powder', 0.1],
                    ['Paprika', 0.25],
                    ['Cumin', 0.1],
                    ['Coriander', 0.1],
                    ['Oregano', 0.1],
                    ['Chipotle Mayo', 0.1],
                    ['Passata', 0.5],
                    ['Avocado', 1]
                ]
            ],
            [
                'name' => 'Halloumi Bulgur Wheat',
                'items' => [
                    ['Red Onion', 1],
                    ['Garlic Clove', 3],
                    ['Oxo Cube', 1],
                    ['Halloumi', 0.5],
                    ['Cinnamon', 0.1],
                    ['Pesto Pot', 1],
                    ['Bulgur Wheat', 0.25]
                ]
            ],
            [
                'name' => 'Jacket Potatoes, Beans and Coleslaw',
                'items' => [
                    ['Potato', 2],
                    ['Baked Beans', 1],
                    ['Coleslaw', 0.5],
                    ['Cheddar', 0.25]
                ]
            ],
            [
                'name' => 'Lasagne',
                'items' => [
                    ['Pepper', 2],
                    ['Courgette', 1],
                    ['Sweet Potato', 1],
                    ['Onion', 1],
                    ['Chili Flakes', 0.1],
                    ['Garlic Clove', 2],
                    ['Chopped Tomatoes', 2],
                    ['Oregano', 0.1],
                    ['Oxo Cube', 1],
                    ['Spinach', 0.25],
                    ['Lasagne Sheets', 0.25],
                    ['White Sauce', 1],
                    ['Cheddar', 0.25],
                    ['Garlic Bread', 1]
                ]
            ],
            [
                'name' => 'Mediterranean Salad, Rice and Falafel',
                'items' => [
                        ['Falafel', 1],
                        ['Rice Packet', 1],
                        ['Hummus', 1],
                        ['Tomato', 1],
                        ['Cucumber', 0.25],
                        ['Red Onion', 0.5],
                        ['Pepper', 0.5],
                        ['Pitta Bread', 2],
                        ['Lemon', 0.5],
                        ['Halloumi', 0.5]
                ]
            ],
            [
                'name' => 'Pasta Bake',
                'items' => [
                    ['Red Onion', 1],
                    ['Garlic Clove', 3],
                    ['Pepper', 1],
                    ['Carrot', 1],
                    ['Sweetcorn', 0.5],
                    ['Chopped Tomatoes', 1],
                    ['Basil', 0.1],
                    ['Parsley', 0.1],
                    ['Tomato Puree', 0.25],
                    ['Garlic Bread', 1],
                    ['Pasta', 0.25],
                    ['Cheddar', 0.25]
                ]
            ],
            [
                'name' => 'Pizza, Coleslaw and Salad',
                'items' => [
                    ['Pizza', 1],
                    ['Coleslaw', 0.25],
                    ['Lemon', 0.5],
                    ['Salad Leafs', 0.25],
                    ['Tomato', 0.5],
                    ['Red Onion', 0.25],
                    ['Pepper', 0.5],
                    ['Cucumber', 0.25],
                    ['Carrot', 0.5]
                ]
            ],
            [
                'name' => 'Sausage Pasta',
                'items' => [
                    ['Red Onion', 1],
                    ['Garlic Clove', 3],
                    ['Pepper', 1],
                    ['Sausage', 4],
                    ['Garlic Bread', 1],
                    ['Pasta', 0.25],
                    ['Chopped Tomatoes', 1],
                    ['Tomato Puree', 0.25],
                    ['Basil', 0.25],
                    ['Parsley', 0.25]
                ]
            ],
            [
                'name' => 'Spaghetti Bolognese',
                'items' => [
                    ['Red Onion', 1],
                    ['Garlic Clove', 3],
                    ['Carrot', 1],
                    ['Mince', 0.5],
                    ['Chopped Tomatoes', 1],
                    ['Tomato Puree', 0.25],
                    ['Straight Pasta', 0.25],
                    ['Oregano', 0.1],
                    ['Thyme', 0.1],
                    ['Garlic Bread', 1],
                ]
            ]
        ];

        foreach ($collections as $collection) {
            $model = Collection::create([
                'name' => $collection['name'],
                'user_id' => 1
            ]);

            foreach ($collection['items'] as $itemData) {
                try {
                    $item = Item::where('name', $itemData[0])->first();

                    $model->items()->attach($item->id, ['amount' => $itemData[1]]);
                } catch (\Exception $e) {
                    dd($itemData);
                }
            }
        }
    }

    public function generateRecipes()
    {
        $recipes = [
            [
                'name' => 'Halloumi Risotto',
                'items' => [
                    ['Red Onion', 1, 'x1'],
                    ['Garlic Clove', 3, 'x3'],
                    ['Halloumi', 0.5, '1/2 a block'],
                    ['Oxo Cube', 1, 'x1'],
                    ['Parmesan', 0.25, '100g'],
                    ['Risotto Rice', 0.1, '100g']
                ]
            ],
            [
                'name' => 'Sweet Potato Chili',
                'items' => [
                    ['Onion', 1, 'x1'],
                    ['Pepper', 2, 'x2'],
                    ['Sweet Potato', 1, 'x1'],
                    ['Garlic Clove', 2, 'x2'],
                    ['Hot Chili Powder', 0.1, '1 Tsp'],
                    ['Cayenne Pepper', 0.1, '1 Tsp'],
                    ['Cocoa Powder', 0.1, '2 Tbsp'],
                    ['Cinnamon', 0.1, '1 Tbsp'],
                    ['Coriander', 0.1, '1 Tbsp'],
                    ['Passata', 1, '500ml'],
                    ['Tomato Puree', 0.25, '100g'],
                    ['Black Beans', 1, '100g'],
                    ['Kidney Beans', 1, '100g'],
                    ['Sour Cream and Chive Dip', 0.5, ''],
                    ['Rice Packet', 1, 'x1'],
                    ['Cheddar', 0.25, ''],
                    ['Avocado', 1, 'x1'],
                    ['Red Onion', 0.25, 'x1']
                ]
            ],
            [
                'name' => 'Toad in the Hole',
                'items' => [
                    ['Sausage', 4, 'x4'],
                    ['Egg', 2, 'x2'],
                    ['Plain Flour', 0.1, '50g'],
                    ['Milk', 0.1, ''],
                    ['Carrot', 2, 'x2'],
                    ['Potato', 2, 'x2'],
                    ['Gravy Granules', 0.1, '100g'],
                    ['Stuffing', 0.25, '']
                ]
            ]
        ];

        foreach ($recipes as $recipe) {
            $model = Recipe::create([
                'name' => $recipe['name'],
                'user_id' => 1,
                'recipe' => 'Lorem Ipsum'
            ]);

            $order = 0;
            foreach ($recipe['items'] as $itemData) {
                try {
                    $item = Item::where('name', $itemData[0])->first();

                    $model->items()->attach($item->id, ['amount' => $itemData[1], 'precise_amount' => $itemData[2], 'order' => $order]);
                } catch (\Exception $e) {
                    dd($itemData);
                }

                $order++;
            }
        }

    }
}
