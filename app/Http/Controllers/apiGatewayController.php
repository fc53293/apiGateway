<?php

namespace App\Http\Controllers;
use DB;
use App\routes\web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artigo;
use App\Models\Utilizador;

class apiGatewayController extends Controller
{
    public function showSigninPage()
    {
        return view('login');
    }

    public function showSignupPage()
    {
        return view('register');
    }


    public function showHome()
    {
        //Initialize the cURL session
        $ch = curl_init();

        //Return the page content
        
        curl_setopt($ch, CURLOPT_URL, "http://microinquilino-service:8081/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
        curl_exec($ch);

        curl_close($ch);
    }

    public function showPayment()
    {
        //Initialize the cURL session
        $ch = curl_init();

        //Return the page content
        
        curl_setopt($ch, CURLOPT_URL, "myunirent.pt/payment");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
        curl_exec($ch);

        curl_close($ch);
    }

    public function showCurrentUser(Request $request)
    {
        
        //Initialize the cURL session
        $ch = curl_init();

        //Return the page content
        
        curl_setopt($ch, CURLOPT_URL, "http://microinquilino-service:8081/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
        curl_exec($ch);

        curl_close($ch);
    }

}
?>