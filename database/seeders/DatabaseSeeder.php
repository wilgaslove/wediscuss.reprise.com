<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Créer des utilisateurs spécifiques
        $john = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.test',
            'is_admin' => true,
        ]);

        $john = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.test',
            'is_admin' => false,
        ]);

        //créer des users additionnels
        $additionalUsers = User::factory(20)->create();

        // Creation de groupes
        for ($i=0; $i < 5; $i++) { 
            $group = Group::factory()->create([ 
                'owner_id' => $john->id
               ]);

               $userIds = User::inRandomOrder()->limit(rand(2, 5))->pluck('id')->toArray(); // On prend entre 2 et 5 personnes
               $group->users()->attach(array_unique([$john->id, ...$userIds])); // puis on les insère dans la table pivot group_user
        }

        // Créer des messages
        Message::factory(1000)->create();
        
        $this->command->info('Seedage terminé avec succès !'); //loguer la complétion du seedage
    }
}
