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

    public function showInquilinoProfile()
    {
        //Initialize the cURL session
        $ch = curl_init();

        //Return the page content
        
        curl_setopt($ch, CURLOPT_URL, "http://microinquilino-service:8081/inquilinoProfile/1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
        curl_exec($ch);

        curl_close($ch);
    }

    public function updateInquilinoProfile(Request $req, $id)
    {
        $data = Utilizador::find($id);
        $data->Username=$req->input('nomeUser');
        $data->PrimeiroNome=$req->input('primeiroNome');
        $data->UltimoNome=$req->input('ultimoNome');
        $data->Email=$req->input('mail');
        $data->Morada=$req->input('morada');
        $data->Nascimento=$req->input('dateNascimento');
        $data->save();
        
        return response()->json('Updated successfully.');
    }

    public function showPayment()
    {
        //Initialize the cURL session
        $ch = curl_init();

        //Return the page content
        
        curl_setopt($ch, CURLOPT_URL, "http://microinquilino-service:8081/payment");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
        curl_exec($ch);

        curl_close($ch);
    }


    public function showCurrentUser(Request $request)
    {
        
        $email = $request->input('email');
        $password = $request->input('password');

        $user = Utilizador::where('Email', $email)->get();
        foreach($user as $infoUser){
            $tipoconta = $infoUser->TipoConta;
        }

        echo $tipoconta;
        
        if ($tipoconta = "Inquilino"){
            

            $ch = curl_init();

            //Return the page content
        
            curl_setopt($ch, CURLOPT_URL, "http://microinquilino-service:8081/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
            curl_exec($ch);

            curl_close($ch);



            
        } else if ($tipoconta = "Senhorio") {

            

            //Initialize the cURL session
            $ch = curl_init();

            //Return the page content
            curl_setopt($ch, CURLOPT_URL, "http://microsenhorio-deployment:8082/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_exec($ch);
          
            curl_close($ch);



            

        } else if ($tipoconta = "Interessado") {

            

            //Initialize the cURL session
            $ch = curl_init();

            //Return the page content
            curl_setopt($ch, CURLOPT_URL, "http://microinteressado-deployment:8083/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_exec($ch);
          
            curl_close($ch);



           

        }
        //return response()->json($user);
    }

}
?>