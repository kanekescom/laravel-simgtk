<?php

namespace Kanekescom\Simgtk\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Kanekescom\Simgtk\Models\Wilayah;

class WilayahPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Wilayah $wilayah): bool
    {
        return $user->can('view_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Wilayah $wilayah): bool
    {
        return $user->can('update_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Wilayah $wilayah): bool
    {
        return $user->can('delete_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Wilayah $wilayah): bool
    {
        return $user->can('force_delete_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Wilayah $wilayah): bool
    {
        return $user->can('restore_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Wilayah $wilayah): bool
    {
        return $user->can('replicate_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can import.
     */
    public function import(User $user): bool
    {
        return $user->can('import_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }

    /**
     * Determine whether the user can export.
     */
    public function export(User $user): bool
    {
        return $user->can('export_Kanekescom\Simgtk\Filament\Resources\WilayahResource');
    }
}
