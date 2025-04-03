<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // public function __construct(){
    //     $this->middleware('auth');
    // }

    /**
     * Méthode pour afficher la liste des utilisateurs
     */
    public function index()
    {
        // Vérifier si l'utilisateur connecté a le rôle 'Admin'
        // Si l'utilisateur n'a pas le rôle 'Admin', rediriger vers une page d'erreur 403
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }
        // Récupérer les utilisateurs avec leurs tâches associées
        $users = User::Select('id', 'name', 'email')
                ->OrderBy('name')
                ->with('tasks')
                ->paginate(5);
        
        return view('user.index', ['users'=>$users]);
    }

    /**
     * Méthode pour afficher le formulaire de création d'un utilisateur
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Méthode pour stocker un nouvel utilisateur
     */
    public function store(Request $request)
    {
        // Validation des données du formulair
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|max:20',
        ]);

        // Créer un nouvel utilisateur
        $user = new User;
        // Remplir les champs de l'utilisateur avec les données du formulaire
        $user->fill($request->all());
        // Enregistrer l'utilisateur dans la base de données
        $user->save();

        return redirect(route('user.index'))->withSuccess('User created successfully!');
    }

    /**
     * Méthode pour afficher le formulaire de mot de passe oublié
     */
    public function forgot(){
        return view('user/forgot');
    }

    /**
     * Méthode pour envoyer un email de réinitialisation de mot de passe
     */
    public function email(Request $request){
        // Validation des données du formulaire
        $request->validate([
            'email'=> 'required|email|exists:users'
        ]);
        // Récupérer l'utilisateur correspondant à l'email
        $user = User::where('email', $request->email)->first();

        // Récupérer l'ID de l'utilisateur
        $userId = $user->id;
        // Générer un mot de passe temporaire et l'enregistrer dans la base de données
        $tempPassword = str::random(45);
        $user->temp_password = $tempPassword;
        $user->save();

        // Envoyer un email à l'utilisateur avec le lien de réinitialisation de mot de passe
        $body="<a href='".route('user.reset', [$userId, $tempPassword])."'>Click here to reset your password</a>";

        $to_name = $user->name;
        $to_email = $request->email;

        // Envoyer l'email
        Mail::send('user.mail', ['name'=> $to_name, 'body' =>$body ], 
        function($message) use ($to_email){
            $message->to($to_email)->subject('Reset Password');
        });
        return redirect(route('login'))->withSuccess('Please check your email to reset the password!');
    }

    /**
     * Méthode pour afficher le formulaire de réinitialisation de mot de passe
     */
    public function reset(User $user, $token){
        if($user->temp_password === $token){
            return view('user.reset');
        }
        return redirect(route('user.forgot'))->withErrors(trans('auth.failed'));
    }

    /**
     * Méthode pour réinitialiser le mot de passe
     */
    public function resetUpdate(User $user, $token, Request $request){
        if($user->temp_password === $token){
            $request->validate([
                'password' => 'required|min:6|max:20|confirmed'
            ]);

            $user->password = $request->password;
            $user->temp_password = NULL;
            $user->save();
            return redirect(route('login'))->withSuccess('Password chnaged with success!');
        }
        return redirect(route('user.forgot'))->withErrors(trans('auth.failed'));
    }


}
