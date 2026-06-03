<?php

namespace App\Policies;

use App\Models\Deporte;
use App\Models\User;

class DeportePolicy
{

    // PERMISO: Ver la noticia
    public function view(?User $user, Deporte $deporte): bool
    {
        // Si la noticia está aprobada, cualquiera (incluso visitas) la puede ver
        if ($deporte->status === 'approved') {
            return true;
        }

        // Si no está aprobada, solo los editores o revisores autenticados pueden verla
        return $user && ($user->role === 'editor' || $user->role === 'revisor');
    }

    // PERMISO: Modificar/editar la noticia
    public function update(User $user, Deporte $deporte): bool
    {
        // Solo el editor dueño de la noticia y cuando esta esté rechazada puede editarla
        return $user->role === 'editor' && $deporte->user_id === $user->id && $deporte->status === 'rejected';
    }

    // PERMISO: Eliminar la noticia
    public function delete(User $user, Deporte $deporte): bool
    {
        // El editor puede borrar sus noticias rechazadas
        $isEditorOwner = $user->role === 'editor' && $deporte->user_id === $user->id && $deporte->status === 'rejected';

        // El revisor puede borrar las noticias ya aprobadas
        $isRevisor = $user->role === 'revisor' && $deporte->status === 'approved';

        return $isEditorOwner || $isRevisor;
    }

    // PERMISO: Aprobar o Rechazar la noticia
    public function review(User $user): bool
    {
        // Solo el revisor puede aprobar o rechazar noticias
        return $user->role === 'revisor';
    }
}
