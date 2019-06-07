<?php

namespace Modules\Page\Database\Seeders\TenantDatabaseSeeder;

use App\User;
use Modules\Page\Entities\Page;
use Illuminate\Database\Seeder;

class PageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::findOrFail(1);
        $homepage = new Page([
            'title' => "Home",
            'slug' => "home",
            'body' => "home",
        ]);
        $homepage->author()->associate($user)->save();
    }
}