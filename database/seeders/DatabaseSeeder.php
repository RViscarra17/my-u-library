<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Genre;
use App\Models\RoleRoute;
use App\Models\Route;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleLibrarian = Role::create(['name' => 'librarian']);
        Role::create(['name' => 'student']);
        $user1 = User::create([
            'first_name' => 'Librarian',
            'last_name' => 'Librarian',
            'email' => 'librarian@gmail.com',
            'password' => Hash::make('admin')
        ]);

        $user2 = User::create([
            'first_name' => 'Student',
            'last_name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => Hash::make('admin')
        ]);

        $user1->assignRole($roleLibrarian);
        $user2->assignRole(2);

        Genre::create([
            'name' => 'Horror'
        ]);
        Genre::create([
            'name' => 'Drama'
        ]);
        Genre::create([
            'name' => 'Thriller'
        ]);

        // auth
        $route1 = Route::create([
            'name' => 'Books',
            'uri' => '/',
            'icon' => 'book',
            'order' => '1'
        ]);

        // student and librarian
        $route2 = Route::create([
            'name' => 'Checkouts',
            'uri' => '/checkouts',
            'icon' => 'checkout',
            'order' => '2'
        ]);

        // librarian
        $route3 = Route::create([
            'name' => 'Users',
            'uri' => '/users',
            'icon' => 'user',
            'order' => '3'
        ]);

        $route1->assignRole([1,2]);
        $route2->assignRole([1,2]);
        $route3->assignRole([1]);
    }
}
