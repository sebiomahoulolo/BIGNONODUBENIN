<?php

// Dans app/Http/Middleware/CheckIfAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // N'oubliez pas d'importer Auth

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Exemple de logique :
        // Suppose que votre modèle User a une colonne 'is_admin' (booléen)
        // ou une colonne 'role' (string)
        if (Auth::check() && Auth::user()->is_admin) { // ou Auth::user()->role === 'admin'
            return $next($request);
        }

        // Si l'utilisateur n'est pas admin, redirigez-le ou retournez une erreur
        // abort(403, 'Accès non autorisé.');
        return redirect('/home')->with('error', 'Vous n\'avez pas les droits d\'administrateur.');
    }
}
