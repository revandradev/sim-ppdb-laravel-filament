<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CalonSiswa;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalonSiswaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CalonSiswa');
    }

    public function view(AuthUser $authUser, CalonSiswa $calonSiswa): bool
    {
        return $authUser->can('View:CalonSiswa');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CalonSiswa');
    }

    public function update(AuthUser $authUser, CalonSiswa $calonSiswa): bool
    {
        return $authUser->can('Update:CalonSiswa');
    }

    public function delete(AuthUser $authUser, CalonSiswa $calonSiswa): bool
    {
        return $authUser->can('Delete:CalonSiswa');
    }

    public function restore(AuthUser $authUser, CalonSiswa $calonSiswa): bool
    {
        return $authUser->can('Restore:CalonSiswa');
    }

    public function forceDelete(AuthUser $authUser, CalonSiswa $calonSiswa): bool
    {
        return $authUser->can('ForceDelete:CalonSiswa');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CalonSiswa');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CalonSiswa');
    }

    public function replicate(AuthUser $authUser, CalonSiswa $calonSiswa): bool
    {
        return $authUser->can('Replicate:CalonSiswa');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CalonSiswa');
    }

}