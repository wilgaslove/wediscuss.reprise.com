<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',         // Nom de l'utilisateur
        'avatar',       // URL de l'avatar de l'utilisateur
        'email',        // Adresse email de l'utilisateur
        'password',     // Mot de passe de l'utilisateur (crypté)
        'is_admin',     // Indicateur si l'utilisateur est administrateur
        'blocked_at',   // Date de blocage de l'utilisateur (si applicable)
    ];

    /**
     * Les attributs qui doivent être masqués lors de la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',        // Masquer le mot de passe lors de la sérialisation
        'remember_token',  // Masquer le token de "se souvenir" lors de la sérialisation
    ];

    /**
     * Les attributs qui doivent être castés en types spécifiques.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',  // Convertir l'attribut email_verified_at en instance de DateTime
            'password' => 'hashed',            // Convertir l'attribut password en chaîne de caractères hachée
        ];
    }

    /**
     * Définir la relation "appartient à plusieurs" entre User et Group.
     * Un utilisateur peut appartenir à plusieurs groupes et un groupe peut contenir plusieurs utilisateurs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user');  // La table pivot est group_user
    }

    /**
     * Définir la relation "a plusieurs" entre User et Message.
     * Un utilisateur peut avoir plusieurs messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);  // La relation est définie sur la clé étrangère user_id dans la table messages
    }
}
