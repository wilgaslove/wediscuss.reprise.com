<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //On sélectionne de manière un utilisateur
        $userIds = \App\Models\User::pluck('id')->toArray();

        //On décide de manière aléatoire si le message est un message direct (conversation) ou un message de group
        $isGroupMessage = fake()->boolean(50);

        // On sélectionn un sender aléatoirement
        $senderId = fake()->randomElement($userIds);

        // On initialise le receiverId et le groupId
        $receiverId = null;
        $groupId = null;

       
     // Ceci est un message de groupe
     if ($isGroupMessage) {
        # On s'assure que le groupe exist dansle BDD
        $groupIds = \App\Models\Group::pluck('id')->toArray();

        if (empty($groupIds)) {
            throw new \Exception("Aucun groupe trouvé dans la base de donnée");
        }
        //on prend au hazard un groupe
        $groupId = fake()->randomElement($groupIds);

        //Sélectionnner un groupe aléatoirement
        $group = \App\Models\Group::find($groupId);
        # On récupère un utilisateur du groupe  aléatoirement
        $senderId = fake()->randomElement($group->users->pluck('id')->toArray());
    } else {
        // C'est un message direct qu'on envoie
        //Sélectionner un receiver qui est différent du sender
        $receiverId = fake()->randomElement(array_diff($userIds, [$senderId])); // array_diff([1,2,3,4,5], [3]) => [1, 2, 4, 5]
    }

     if (!$isGroupMessage) {
        $conversationId = \App\Models\Conversation::firstOrCreate([
            'user_id1' => min($senderId, $receiverId),
            'user_id2' => max($senderId, $receiverId),
        ],
        [
            'last_message_id' => null,
        ]
        
    );
     }

    
        // Retourne un tableau associatif avec les données générées pour un message.
        return [
            'message' => fake()->realText(),  // Génère un texte aléatoire pour le message.
            'sender_id' => $senderId,         // ID de l'expéditeur du message.
            'receiver_id' => $receiverId,     // ID du destinataire du message.
            'group_id' => $groupId,           // ID du groupe (peut être null si aucun groupe n'a été sélectionné).
            'conversation_id' => $conversationId,          // ID de la conversation (actuellement vide).
        ];
    }
}
