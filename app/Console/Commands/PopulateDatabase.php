<?php

namespace App\Console\Commands;

use App\Models\Plan;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use App\User;

use App\Models\Item;
use App\Models\Collection;
use App\Models\Recipe;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use Illuminate\Support\Str;

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

    protected $nameDictionary = [
        'Halloumi Risotto',
        'Breakfast',
        'Burgers with Chips',
        'Chickpea Burgers, Coleslaw and Chips',
        'Fajitas',
        'Halloumi Bulgur Wheat',
        'Jacket Potatoes, Beans and Coleslaw',
        'Lasagne',
        'Mediterranean Salad, Rice and Falafel',
        'Pasta Bake',
        'Pizza, Coleslaw and Salad',
        'Sausage Pasta',
        'Spaghetti Bolognese',
        'Sweet Potato Chili',
        'Miso Aubergine Tacos',
        'Mango Chutney Halloumi Curry',
        'Toad in the Hole',
        'Greek Style Gyozas',
        'Miso Aubergine Tacos',
        'Chicken Nuggets',
        'Breakfast in Bed',
        'Greek Inspired Chickpea Jumble'
    ];

    protected $cookTimes = [
        10, 20, 30, 45, 60, 90, 120
    ];

    protected $servingSizes = [
        1,2,3,4,5,6
    ];

    protected $ratings = [
        2.5, 2.8, 3, 3.2, 3.4, 3.6, 3.9, 4.1, 4.3, 4.5, 4.7
    ];

    protected $nameDictionaryReduced = [];

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

        $guest = User::create([
            'email' => 'guest@alecgullon.co.uk',
            'name' => 'Guest',
            'password' => Hash::make('password'),
            'api_token' => 'abcd'
        ]);

        $alec = User::create([
            'email' => 'alec@alecgullon.co.uk',
            'name' => 'Alec',
            'password' => Hash::make('password'),
            'api_token' => 'efgh'
        ]);

        foreach ([$guest, $alec] as $user) {
            $this->nameDictionaryReduced = $this->nameDictionary;

            $this->generateItems($user);
            $this->generateCollections($user);
            $this->generateRecipes($user);
            $this->generatePlans($user);
        }
    }

    protected function generateItems($user)
    {
        $freshItems = ['Tomato', 'Lemon', 'Red Onion', 'Cucumber', 'Garlic Clove', 'Pepper', 'Potato', 'Courgette',
            'Sweet Potato', 'Onion', 'Spinach', 'Avocado', 'Carrot', 'Salad Leafs', 'Ginger', 'Lime'];

        foreach ($freshItems as $freshItem) {
            Item::create([
                'name' => $freshItem,
                'location_id' => 1,
                'user_id' => $user->id
            ]);
        }

        $chilledItems = ['Butter', 'Sweet Chili Sauce', 'Halloumi', 'Sour Cream and Chive Dip', 'Cheddar', 'Chipotle Mayo',
            'Parmesan', 'Coleslaw', 'Garlic Bread', 'Falafel', 'Hummus', 'Pizza', 'Vegetarian Spring Rolls', 'Milk'];

        foreach ($chilledItems as $chilledItem) {
            Item::create([
                'name' => $chilledItem,
                'location_id' => 2,
                'user_id' => $user->id
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
                'user_id' => $user->id
            ]);
        }

        $frozenItems = ['Sausage', 'Hash Browns', 'Vegetarian Burger', 'Quorn Pieces', 'Mince', 'Peas'];

        foreach ($frozenItems as $frozenItem) {
            Item::create([
                'name' => $frozenItem,
                'location_id' => 5,
                'user_id' => $user->id
            ]);
        }
    }

    protected function generateCollections($user)
    {
        $collections = [
            [
                'items' => [
                    ['Baked Beans',  1],
                    ['Sausage', 4],
                    ['Hash Browns', 0.25],
                    ['Egg', 2]
                ]
            ],
            [
                'items' => [
                    ['Vegetarian Burger',  2],
                    ['Brioche Burger Bun',  2],
                    ['Butter',  0.1],
                    ['Gherkin',  0.1],
                    ['Tomato', 1]
                ]
            ],
            [
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
                'items' => [
                    ['Potato', 2],
                    ['Baked Beans', 1],
                    ['Coleslaw', 0.5],
                    ['Cheddar', 0.25]
                ]
            ],
            [
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
                'name' => $this->randomName(),
                'user_id' => $user->id
            ]);

            foreach ($collection['items'] as $itemData) {
                try {
                    $item = Item::where(['name' => $itemData[0], 'user_id' => $user->id])->first();

                    $model->items()->attach($item->id, ['amount' => $itemData[1]]);
                } catch (\Exception $e) {
                    dd($itemData);
                }
            }
        }
    }

    public function generateRecipes($user)
    {
        $recipes = [
            [
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
            $name = $this->randomName();

            $slug = Str::slug($name);
            if ($user->id !== 1) {
                $slug .= '-' . $user->id;
            }

            $model = Recipe::create([
                'name' => $name,
                'slug' => $slug,
                'user_id' => $user->id,
                'recipe' => $this->exampleRecipe(),
                'published' => false,
                'image_id' => rand(1,20),
                'description' => 'Feed the family this comforting, budget-friendly sausage ragu with pasta. You can freeze the leftovers for another time and it tastes just as good.',
                'rating' => $this->ratings[array_rand($this->ratings)],
                'cook_time' => $this->cookTimes[array_rand($this->cookTimes)],
                'serving_size' => $this->servingSizes[array_rand($this->servingSizes)]
            ]);

            $order = 0;
            foreach ($recipe['items'] as $itemData) {
                try {
                    $item = Item::where(['name' => $itemData[0], 'user_id' => $user->id])->first();

                    $model->items()->attach($item->id, ['amount' => $itemData[1], 'precise_amount' => $itemData[2], 'order' => $order]);
                } catch (\Exception $e) {
                    dd($itemData);
                }

                $order++;
            }

            $name = $this->randomName();

            $slug = Str::slug($name);
            if ($user->id !== 1) {
                $slug .= '-' . $user->id;
            }

            $model = Recipe::create([
                'name' => $name,
                'slug' => $slug,
                'user_id' => $user->id,
                'recipe' => $this->exampleRecipe(),
                'published' => true,
                'image_id' => rand(1,20),
                'description' => 'Feed the family this comforting, budget-friendly sausage ragu with pasta. You can freeze the leftovers for another time and it tastes just as good.',
                'rating' => $this->ratings[array_rand($this->ratings)],
                'cook_time' => $this->cookTimes[array_rand($this->cookTimes)],
                'serving_size' => $this->servingSizes[array_rand($this->servingSizes)]
            ]);

            $order = 0;
            foreach ($recipe['items'] as $itemData) {
                try {
                    $item = Item::where(['name' => $itemData[0], 'user_id' => $user->id])->first();

                    $model->items()->attach($item->id, ['amount' => $itemData[1], 'precise_amount' => $itemData[2], 'order' => $order]);
                } catch (\Exception $e) {
                    dd($itemData);
                }

                $order++;
            }
        }

    }

    public function randomName()
    {
        if (count($this->nameDictionaryReduced) === 0) {
            return 'Add another name please!';
        }

        $key = array_rand($this->nameDictionaryReduced);
        $selected = $this->nameDictionaryReduced[$key];
        unset($this->nameDictionaryReduced[$key]);

        return $selected;
    }

    public function exampleRecipe()
    {
        return 'Chop up all the veg except the garlic: dice the peppers and onion and chop the sweet potato into small cubes. Stick everything in a pan with some oil on a medium heat. Season well with pepper and salt.

While the veg cooks through, chop up a largish amount of garlic and add to the pan. Add all the spices.

Add the passata, the beans and the tomato puree and stir well. Bring to a simmer and then cover and let cook on a gentle heat for 45-60 mins.';
    }

    public function generatePlans($user)
    {
        $plans = [
            [
                'items' => [
                    ['Red Onion', 1],
                    ['Garlic Clove', 3],
                    ['Halloumi', 0.5],
                    ['Oxo Cube', 1],
                    ['Parmesan', 0.25],
                    ['Risotto Rice', 0.1],
                    ['Onion', 1],
                    ['Pepper', 2],
                    ['Sweet Potato', 1],
                    ['Garlic Clove', 2],
                    ['Hot Chili Powder', 0.1],
                    ['Cayenne Pepper', 0.1],
                    ['Cocoa Powder', 0.1],
                    ['Cinnamon', 0.1],
                    ['Coriander', 0.1],
                    ['Passata', 1],
                    ['Tomato Puree', 0.25],
                    ['Black Beans', 1],
                    ['Kidney Beans', 1],
                    ['Sour Cream and Chive Dip', 0.5],
                    ['Rice Packet', 1],
                    ['Cheddar', 0.25],
                    ['Avocado', 1],
                    ['Red Onion', 0.25]
                ],
                'timestamp' => '2020-08-12 16:44:21'
            ],
            [
                'items' => [
                    ['Red Onion', 1],
                    ['Garlic Clove', 3],
                    ['Halloumi', 0.5],
                    ['Oxo Cube', 1],
                    ['Parmesan', 0.25],
                    ['Risotto Rice', 0.1],
                    ['Onion', 1],
                    ['Pepper', 2],
                    ['Sweet Potato', 1],
                    ['Garlic Clove', 2],
                    ['Hot Chili Powder', 0.1],
                    ['Cayenne Pepper', 0.1],
                    ['Cocoa Powder', 0.1],
                    ['Cinnamon', 0.1],
                    ['Coriander', 0.1],
                    ['Passata', 1],
                    ['Tomato Puree', 0.25],
                    ['Black Beans', 1],
                    ['Kidney Beans', 1],
                    ['Sour Cream and Chive Dip', 0.5],
                    ['Rice Packet', 1],
                    ['Cheddar', 0.25],
                    ['Avocado', 1],
                    ['Red Onion', 0.25]
                ],
                'timestamp' => '2020-08-05 12:56:08'
            ],
        ];

        foreach ($plans as $plan) {
            $model = Plan::create([
                'user_id' => $user->id,
                'created_at' => $plan['timestamp'],
                'updated_at' => $plan['timestamp']
            ]);

            foreach ($plan['items'] as $itemData) {
                try {
                    $item = Item::where(['name' => $itemData[0], 'user_id' => $user->id])->first();

                    $model->items()->attach($item->id, ['amount' => $itemData[1]]);
                } catch (\Exception $e) {
                    dd($itemData);
                }
            }
        }
    }
}
