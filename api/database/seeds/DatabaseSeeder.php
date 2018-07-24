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
        factory(\App\Models\User::class, 1)->states('admin')->create([
            'email' => 'admin@test.com',
            'name' => 'Admin'
        ]);
        // Make reviewers
        $reviewers = factory(\App\Models\User::class, 100)->states('regular-user')->create();
        $reviewers[] = factory(\App\Models\User::class)->states('regular-user')->create([
            'email' => 'user@test.com',
            'name' => 'user'
        ]);

        $owners = factory(\App\Models\User::class, 5)->states('owner')->create();
        $owners[] = factory(\App\Models\User::class)->states('owner')->create([
            'email' => 'owner@test.com',
            'name' => 'owner'
        ]);

        // Make N users with K restaurants each.
        foreach ($owners as $user) {
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
