<?php

namespace App\Models;

use App\User;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Tightenco\Parental\HasParentModel;

class BackpackUser extends User
{
    use HasParentModel;

    protected $table = 'users';
    protected $fillable = [
        'ci', 'first_name', 'last_name', 'place_birth', 'nacionality', 'birthdate', 'gender', 'address', 'phone', 'email', 'password', 'type_user'
    ];

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
}
