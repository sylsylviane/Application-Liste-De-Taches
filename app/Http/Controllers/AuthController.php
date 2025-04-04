<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Méthode pour afficher le formulaire de connexion
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Méthode pour afficher le formulaire d'inscription
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'min:6|max:20',
        ]);

        // Récupération des identifiants
        $credentials = $request->only('email', 'password');
        //Validation des identifiants
        if (!Auth::validate($credentials)):
            return redirect(route('login'))->withErrors(trans('auth.failed'))->withInput();
        endif;
        //Récupération de l'utilisateur
        $user = Auth::getProvider()->retrieveByCredentials($credentials); //
        //Gestion des rôles existants. Supprime toutes les associations actuelles de l'utilisateur avec des rôles.
        Auth::user()->roles()->detach();
        //Attribution du rôle
        if ($user->role_id == 1) {
            $user->assignRole('Admin');
        } elseif ($user->role_id == 2) {
            $user->assignRole('Employee');
        }

        return redirect()->intended(route('user.index'))->withSuccess('Signed in');
    }

    /**
     * Méthode pour déconnecter l'utilisateur
     */
    public function destroy()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
