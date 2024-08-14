<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id1',         // ID du premier utilisateur participant à la conversation
        'user_id2',         // ID du deuxième utilisateur participant à la conversation
        'last_message_id', // ID du dernier message envoyé dans la conversation
    ];

    /**
     * Définir la relation "appartient à" entre Conversation et Message.
     * Chaque conversation peut avoir un dernier message, défini par last_message_id.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id');  // La clé étrangère est last_message_id
    }

    /**
     * Définir la relation "appartient à" entre Conversation et User pour le premier utilisateur.
     * Chaque conversation est associée à un premier utilisateur, défini par user_id1.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user1()
    {
        return $this->belongsTo(User::class, 'user_id1');  // La clé étrangère est user_id1
    }

    /**
     * Définir la relation "appartient à" entre Conversation et User pour le deuxième utilisateur.
     * Chaque conversation est associée à un deuxième utilisateur, défini par user_id2.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user2()
    {
        return $this->belongsTo(User::class, 'user_id2');  // La clé étrangère est user_id2
    }
}
