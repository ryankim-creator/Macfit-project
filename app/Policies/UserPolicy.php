<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
  public function veiwAny(User $user){
    return $user->role()->id  ===1;
  }

  public function veiw(User $user, User $model){
    return $user->id ==$model->id||$user->role()->id ===1;
  }

  public function create(?User $user){
    return true;
  }

  public function upadate(User $user,User $model){
    return $user->id == $model->id||$user->role()->id ===1;
  }

  public function delete(User $user){
    return $user->role()->id  ===1;
  }
}
