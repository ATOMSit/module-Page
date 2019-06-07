<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Page\Database\Seeders\TenantDatabaseSeeder\PageDatabaseSeeder;

class TenantPageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PageDatabaseSeeder::class);
    }
}
