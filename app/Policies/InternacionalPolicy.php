<?php

namespace App\Policies;

use App\Models\Internacional;
use App\Models\User;

class InternacionalPolicy
{
    // PERMISO: Ver la noticia
    public function view(?User $user, Internacional $internacional): bool
    {
        // Si la noticia está aprobada, cualquiera la puede ver
        if ($internacional->status === 'approved') {
            return true;
        }

        // Si no está aprobada, solo los editores o revisores pueden verla
        return $user && ($user->role === 'editor' || $user->role === 'revisor');
    }

    // PERMISO: Modificar/editar la noticia
    public function update(User $user, Internacional $internacional): bool
    {
        // Solo el editor dueño puede editarla si la noticia fue rechazada
        return $user->role === 'editor' && $internacional->user_id === $user->id && $internacional->status === 'rejected';
    }

    // PERMISO: Eliminar la noticia
    public function delete(User $user, Internacional $internacional): bool
    {
        // El editor dueño puede borrarla si está rechazada
        $isEditorOwner = $user->role === 'editor' && $internacional->user_id === $user->id && $internacional->status === 'rejected';
        
        // El revisor puede borrar noticias aprobadas
        $isRevisor = $user->role === 'revisor' && $internacional->status === 'approved';

        return $isEditorOwner || $isRevisor;
    }

    // PERMISO: Aprobar o Rechazar la noticia
    public function review(User $user): bool
    {
        // Solo el revisor tiene permiso de revisión
        return $user->role === 'revisor';
    }
}
