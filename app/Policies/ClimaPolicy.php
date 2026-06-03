<?php

namespace App\Policies;

use App\Models\Clima;
use App\Models\User;

class ClimaPolicy
{

    // PERMISO: Ver la noticia
    public function view(?User $user, Clima $clima): bool
    {
        // Si la noticia está aprobada, cualquiera la puede ver
        if ($clima->status === 'approved') {
            return true;
        }

        // Si no está aprobada, solo los editores o revisores pueden verla
        return $user && ($user->role === 'editor' || $user->role === 'revisor');
    }

    // PERMISO: Modificar/editar la noticia
    public function update(User $user, Clima $clima): bool
    {
        // Solo el editor dueño puede editarla si la noticia fue rechazada
        return $user->role === 'editor' && $clima->user_id === $user->id && $clima->status === 'rejected';
    }

    // PERMISO: Eliminar la noticia
    public function delete(User $user, Clima $clima): bool
    {
        // El editor dueño puede borrarla si está rechazada o aprobada
        $isEditorOwner = $user->role === 'editor' && $clima->user_id === $user->id && in_array($clima->status, ['rejected', 'approved']);
        
        // El revisor puede borrar noticias aprobadas
        $isRevisor = $user->role === 'revisor' && $clima->status === 'approved';

        return $isEditorOwner || $isRevisor;
    }

    // PERMISO: Aprobar o Rechazar la noticia
    public function review(User $user): bool
    {
        // Solo el revisor tiene permiso de revisión
        return $user->role === 'revisor';
    }
}
