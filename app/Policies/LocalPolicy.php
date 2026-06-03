<?php

namespace App\Policies;

use App\Models\Local;
use App\Models\User;

class LocalPolicy
{
    // PERMISO: Ver la noticia
    public function view(?User $user, Local $local): bool
    {
        // Si la noticia está aprobada, cualquiera la puede ver
        if ($local->status === 'approved') {
            return true;
        }

        // Si no está aprobada, solo los editores o revisores pueden verla
        return $user && ($user->role === 'editor' || $user->role === 'revisor');
    }

    // PERMISO: Modificar/editar la noticia
    public function update(User $user, Local $local): bool
    {
        // Solo el editor dueño puede editarla si la noticia fue rechazada
        return $user->role === 'editor' && $local->user_id === $user->id && $local->status === 'rejected';
    }

    // PERMISO: Eliminar la noticia
    public function delete(User $user, Local $local): bool
    {
        // El editor dueño puede borrarla si está rechazada
        $isEditorOwner = $user->role === 'editor' && $local->user_id === $user->id && $local->status === 'rejected';
        
        // El revisor puede borrar noticias aprobadas
        $isRevisor = $user->role === 'revisor' && $local->status === 'approved';

        return $isEditorOwner || $isRevisor;
    }

    // PERMISO: Aprobar o Rechazar la noticia
    public function review(User $user): bool
    {
        // Solo el revisor tiene permiso de revisión
        return $user->role === 'revisor';
    }
}
