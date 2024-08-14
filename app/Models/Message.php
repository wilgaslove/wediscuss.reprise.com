<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',          // Contenu du message
        'sender_id',        // ID de l'expéditeur du message
        'receiver_id',      // ID du destinataire du message
        'group_id',         // ID du groupe auquel le message appartient (si applicable)
        'conversation_id', // ID de la conversation à laquelle le message appartient
    ];

    /**
     * Définir la relation "appartient à" entre Message et User pour l'expéditeur.
     * Un message est envoyé par un utilisateur (l'expéditeur).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');  // Relation définie sur la clé étrangère sender_id
    }

    /**
     * Définir la relation "appartient à" entre Message et User pour le destinataire.
     * Un message est reçu par un utilisateur (le destinataire).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');  // Relation définie sur la clé étrangère receiver_id
    }

    /**
     * Définir la relation "appartient à" entre Message et Group.
     * Un message peut appartenir à un groupe.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group() {
        return $this->belongsTo(Group::class);  // La clé étrangère est group_id par défaut
    }

    /**
     * Définir la relation "a plusieurs" entre Message et MessageAttachement.
     * Un message peut avoir plusieurs pièces jointes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachements() {
        return $this->hasMany(MessageAttachement::class);  // La clé étrangère est message_id par défaut
    }
}
