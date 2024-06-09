<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class Customer extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password'];

    public function orders(): Relation
    {
        return $this->hasMany(Order::class);
    }

    public function routeNotificationForMail(Notification $notification): string
    {
        return $this->email;
    }
}
