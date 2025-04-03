<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SetLocaleController extends Controller
{
    /**
     *  Méthode pour changer la langue de l'application
     */
    public function index($locale){
        
        if(! in_array($locale, ['en', 'fr'])){
            abort(400);
        }
        // Lorsqu'un utilisateur sélectionne une langue, définit la langue sélectionnée dans la session.
        session()->put('locale', $locale); 
        return back();
    }
}
