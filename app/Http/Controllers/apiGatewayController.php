<?php

namespace App\Http\Controllers;
use DB;
use App\routes\web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artigo;

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

    public function allArtigos()
    {
        $inquilino = Artigo::all();
        //$inquilino = $this->model->all();

        return response()->json($inquilino);
        
        //return response()->json('Mostra todas os inquilinos');
        
    }

    public function createArtigo(Request $request)
    {
        print_r($request->input());
        $order = new Artigo;
        $order->email=$request->input('email');
        $order->id=$request->input('description');
        $order->save();
       //$inquilino = Inquilino::create($request->all());

       //return response()->json($inquilino);
    }


    public function mostraArtigos()
    {
        $results = DB::select("SELECT * FROM artigos");
        return response()->json($results);
    }

    public function entra()
    {
        $results = DB::select("SELECT * FROM utilizadores");
        return response()->json($results);
    }
}


?>