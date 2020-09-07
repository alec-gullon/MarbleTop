<?php

namespace App\Console\Commands;

use App\Models\Collection;
use App\Models\Item;
use App\Models\Plan;
use App\Models\Recipe;
use App\User;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    /**
     * Stub data holding names that should be assigned to the generated recipes and collections
     *
     * @var array
     */
    protected $nameDictionary = [];

    /**
     * A copy of the name data that is used to ensure there we do not attempt to populate the database with
     * repeat data
     *
     * @var array
     */
    protected $nameDictionaryReduced = [];

    /**
     * Stub data for fresh items
     *
     * @var array
     */
    protected $freshItems = [];

    /**
     * Stub data for chilled items
     *
     * @var array
     */
    protected $chilledItems = [];

    /**
     * Stub data for pantry items
     *
     * @var array
     */
    protected $pantryItems = [];

    /**
     * Stub data for frozen items
     *
     * @var array
     */
    protected $frozenItems = [];

    /**
     * Stub data for cook times
     *
     * @var array
     */
    protected $cookTimes = [];

    /**
     * Stub data for serving sizes
     *
     * @var array
     */
    protected $servingSizes = [];

    /**
     * Stub data for ratings
     *
     * @var array
     */
    protected $ratings = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->nameDictionary = config('stubs.recipe_names');

        $this->freshItems = config('stubs.fresh_items');
        $this->chilledItems = config('stubs.chilled_items');
        $this->pantryItems = config('stubs.pantry_items');
        $this->frozenItems = config('stubs.frozen_items');

        $this->cookTimes = config('stubs.cook_times');
        $this->servingSizes = config('stubs.serving_sizes');
        $this->ratings = config('stubs.ratings');

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
            'api_token' => Str::random()
        ]);

        $alec = User::create([
            'email' => 'alec@alecgullon.co.uk',
            'name' => 'Alec',
            'password' => Hash::make('password'),
            'api_token' => Str::random()
        ]);

        foreach ([$guest, $alec] as $user) {
            $this->nameDictionaryReduced = $this->nameDictionary;

            $this->generateItems($user);
            $this->generateCollections($user);
            $this->generateRecipes($user);
            $this->generatePlans($user);
        }
    }

    /**
     * Generates the stubbed items in the database for the specified $user
     *
     * @param $user
     */
    protected function generateItems($user)
    {
        $categories = [
            ['items' => $this->freshItems, 'location_id' => 1],
            ['items' => $this->chilledItems, 'location_id' => 2],
            ['items' => $this->pantryItems, 'location_id' => 3],
            ['items' => $this->frozenItems, 'location_id' => 5],
        ];

        foreach ($categories as $category) {
            foreach ($category['items'] as $item) {
                Item::create([
                    'name' => $item,
                    'location_id' => $category['location_id'],
                    'user_id' => $user->id
                ]);
            }
        }
    }

    /**
     * Generates some stubbed collections in the database for the specified $user
     *
     * @param $user
     */
    protected function generateCollections($user)
    {
        $collections = config('stubs.collections');

        foreach ($collections as $collection) {
            $model = Collection::create([
                'name' => $this->randomName(),
                'user_id' => $user->id
            ]);

            foreach ($collection as $itemData) {
                $item = Item::where(['name' => $itemData[0], 'user_id' => $user->id])->first();

                $model->items()->attach($item->id, ['amount' => $itemData[1]]);
            }
        }
    }

    /**
     * Generates some stubbed recipes in the database for the specified $user. Half of them will be set to be
     * unpublished and the other half (with matching data) will be set to published
     *
     * @param $user
     */
    public function generateRecipes($user)
    {
        $recipes = config('stubs.recipes');

        foreach ($recipes as $recipe) {
            $this->generateRecipe($user, $recipe, false);
            $this->generateRecipe($user, $recipe, true);
        }
    }

    /**
     * Generates a recipe authored by the specified $user with the specified list of ingredients in $recipe.
     * The published status is set based on the $published parameter
     *
     * @param           $user
     * @param array     $recipe
     * @param bool      $published
     */
    private function generateRecipe($user, $recipe, $published = false) {
        $name = $this->randomName();

        $slug = Str::slug($name);
        if ($user->id !== 1) {
            $slug .= '-' . $user->id;
        }

        $model = Recipe::create([
            'name' => $name,
            'slug' => $slug,
            'user_id' => $user->id,
            'recipe' => config('stubs.recipe'),
            'published' => $published,
            'image_id' => rand(1,20),
            'description' => config('stubs.description'),
            'rating' => $this->ratings[array_rand($this->ratings)],
            'cook_time' => $this->cookTimes[array_rand($this->cookTimes)],
            'serving_size' => $this->servingSizes[array_rand($this->servingSizes)]
        ]);

        $order = 0;
        foreach ($recipe as $itemData) {
            $item = Item::where(['name' => $itemData[0], 'user_id' => $user->id])->first();
            $model->items()->attach($item->id, ['amount' => $itemData[1], 'precise_amount' => $itemData[2], 'order' => $order]);

            $order++;
        }
    }

    /**
     * Generates some stubbed plans in the database for the specified $user
     *
     * @param $user
     */
    public function generatePlans($user)
    {
        $plans = config('stubs.plans');

        foreach ($plans as $plan) {
            $model = Plan::create([
                'user_id' => $user->id,
                'created_at' => $plan['timestamp'],
                'updated_at' => $plan['timestamp']
            ]);

            foreach ($plan['items'] as $itemData) {
                $item = Item::where(['name' => $itemData[0], 'user_id' => $user->id])->first();
                $model->items()->attach($item->id, ['amount' => $itemData[1]]);
            }
        }
    }

    /**
     * Returns a random name pulled from this $this->nameDictionaryReduced and then removes it from this
     * source to prevent future collisions. Returns a warning string if there are too few names in
     * $this->nameDictionaryReduced
     *
     * @return string
     */
    private function randomName()
    {
        if (count($this->nameDictionaryReduced) === 0) {
            return 'Add another name please!';
        }

        $key = array_rand($this->nameDictionaryReduced);
        $selected = $this->nameDictionaryReduced[$key];
        unset($this->nameDictionaryReduced[$key]);

        return $selected;
    }
}
