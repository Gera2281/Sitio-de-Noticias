<?php

namespace App\Policies;

use App\Models\Tecnologia;
use App\Models\User;

class TecnologiaPolicy
{
    // PERMISO: Ver la noticia
    public function view(?User $user, Tecnologia $tecnologia): bool
    {
        // Si la noticia está aprobada, cualquiera la puede ver
        if ($tecnologia->status === 'approved') {
            return true;
        }

        // Si no está aprobada, solo los editores o revisores pueden verla
        return $user && ($user->role === 'editor' || $user->role === 'revisor');
    }

    // PERMISO: Modificar/editar la noticia
    public function update(User $user, Tecnologia $tecnologia): bool
    {
        // Solo el editor dueño puede editarla si la noticia fue rechazada
        return $user->role === 'editor' && $tecnologia->user_id === $user->id && $tecnologia->status === 'rejected';
    }

    // PERMISO: Eliminar la noticia
    public function delete(User $user, Tecnologia $tecnologia): bool
    {
        // El editor dueño puede borrarla si está rechazada o aprobada
        $isEditorOwner = $user->role === 'editor' && $tecnologia->user_id === $user->id && in_array($tecnologia->status, ['rejected', 'approved']);
        
        // El revisor puede borrar noticias aprobadas
        $isRevisor = $user->role === 'revisor' && $tecnologia->status === 'approved';

        return $isEditorOwner || $isRevisor;
    }

    // PERMISO: Aprobar o Rechazar la noticia
    public function review(User $user): bool
    {
        // Solo el revisor tiene permiso de revisión
        return $user->role === 'revisor';
    }
}
