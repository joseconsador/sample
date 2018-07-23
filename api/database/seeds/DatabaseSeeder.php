<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 2)->states('admin')->create();
        // Make reviewers
        $reviewers = factory(\App\Models\User::class, 100)->states('regular-user')->create();

        // Make N users with K restaurants each.
        foreach (factory(\App\Models\User::class, 5)->states('owner')->create() as $user) {
            /**
             * @var $restaurant \App\Models\Restaurant
             */
            foreach (factory(\App\Models\Restaurant::class, 10)->create(['owner_id' => $user->id]) as $restaurant) {
                foreach ($reviewers as $reviewer) {
                    $restaurant->reviews()->save(factory(\App\Models\Review::class)->create(
                        [
                            'user_id' => $reviewer->id,
                            'restaurant_id' => $restaurant->id,
                        ]
                    ));
                }
            }
        }
    }
}
