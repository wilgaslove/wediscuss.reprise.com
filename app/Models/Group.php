<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',            // Nom du groupe
        'description',     // Description du groupe
        'owner_id',        // ID de l'utilisateur propriétaire du groupe
        'last_message_id', // ID du dernier message envoyé dans le groupe
    ];

    /**
     * Définir la relation "appartient à plusieurs" entre Group et User.
     * Un groupe peut avoir plusieurs utilisateurs associés.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user');  // Définir la relation de plusieurs à plusieurs via la table pivot 'group_user'
    }

    /**
     * Définir la relation "a plusieurs" entre Group et Message.
     * Un groupe peut avoir plusieurs messages associés.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);  // Définir la relation un-à-plusieurs avec le modèle Message
    }

    /**
     * Définir la relation "appartient à" entre Group et User pour le propriétaire.
     * Chaque groupe a un propriétaire, défini par owner_id.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');  // Définir la relation "appartient à" avec le modèle User via la clé étrangère owner_id
    }
}
