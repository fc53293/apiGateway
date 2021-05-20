<?php

namespace App\Http\Controllers;
use DB;
use App\routes\web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artigo;
use App\Models\Utilizador;
use App\Models\Inquilino;
use App\Models\HistoricoSaldo;
use App\Models\Pagamento;
use Carbon\Carbon;

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

    public function showSignupSenhorio()
    {
        return view('registerSenhorio');
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
    
    public function createNewUser(Request $request)
    {

        $user = new Utilizador();
        $user->Username=$request->input('username');
        $user->Email=$request->input('mail');
        $user->Password=$request->input('pass');
        $user->PrimeiroNome=$request->input('firstName');
        $user->UltimoNome=$request->input('lastName');
        $user->Nacionalidade=$request->input('nacionalidade');
        $user->Nascimento=$request->input('nascimento');
        $user->Morada=$request->input('morada');
        $user->Telefone=$request->input('movel');
        $user->TipoConta="Interessado";
        $user->Saldo=0;
        $user->imagem="null.png";
        $user->api_Token="f8d16f8c-80c8-459e-abc5-2086811cc255";
        $user->save();
        return response()->json(['User'=>$user]);
        //Initialize the cURL session
    }

    public function createNewSenhorio(Request $request)
    {

        $user = new Utilizador();
        $user->Username=$request->input('username');
        $user->Email=$request->input('mail');
        $user->Password=$request->input('pass');
        $user->PrimeiroNome=$request->input('firstName');
        $user->UltimoNome=$request->input('lastName');
        $user->Nacionalidade=$request->input('nacionalidade');
        $user->Nascimento=$request->input('nascimento');
        $user->Morada=$request->input('morada');
        $user->Telefone=$request->input('movel');
        $user->TipoConta="Senhorio";
        $user->Saldo=0;
        $user->imagem="null.png";
        $user->api_Token="f8d16f8c-80c8-459e-abc5-2086811cc255";
        $user->save();
        return response()->json(['User'=>$user]);
        //Initialize the cURL session
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

    public function showWallet()
    {
        //Initialize the cURL session
        $ch = curl_init();

        //Return the page content
        
        curl_setopt($ch, CURLOPT_URL, "http://microinquilino-service:8081/wallet/1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
        curl_exec($ch);

        curl_close($ch);
    }

    public function showPayments()
    {
        //Initialize the cURL session
        $ch = curl_init();

        //Return the page content
        
        curl_setopt($ch, CURLOPT_URL, "http://microinquilino-service:8081/payment");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
        curl_exec($ch);

        curl_close($ch);
    }

    public function addMoney($id, Request $amount)
    {
        $user = Utilizador::find($id);
        $user->Saldo=$amount->input('amountToAdd')+$user->Saldo;
        $user->save();

        $histSaldo = new HistoricoSaldo();
        $user->IdSaldo=1;
        $histSaldo->IdUser=$id;
        $histSaldo->Username=$amount->input('nameUser');
        $histSaldo->Valor=$amount->input('amountToAdd');
        $histSaldo->Data=Carbon::now();
        $histSaldo->save();

        return response()->json(['res'=>$user->Saldo]);
    }

    public function pagarRenda(Request $request)
    {
        $user = new Pagamento();
        //$user->IdPagamento=1;
        $user->IdInquilino=1;
        $user->IdSenhorio=2;
        $user->Valor=$request->Valor;
        $user->Data=$request->Data;
        $user->Contribuinte=$request->Contribuinte;
        $user->save();
        // $data = array('IdPagamento' =>1,'IdInquilino' => 1, 'IdSenhorio' => 2, 'Valor' => 400, 'Data' => '2021-04-05 20:26:02', 'Contribuinte' => "222222222");
        // Pagamento::create($data);  


        return response()->json("va1");

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

    public function renovarAluguerInquilino(Request $req, $id)
    {
        $opcaoMeses = $req->input('renovarMeses1');
        $userLoged = 1;
 
        $rent = Inquilino::where('IdUser', $id)
        // $rent->FimContrato=Carbon::now()->addMonths(6);
        // $rent->save();
       ->update([
           'FimContrato' => Carbon::now()->addMonthsNoOverflow(6)
        ]);
        $rentDateInfo = Inquilino::where('IdUser',$id)->value('FimContrato');
        $result = Carbon::createFromFormat('Y-m-d H:i:s', $rentDateInfo)->isPast();
        return response()->json(['rentCheck'=>$result]);
        

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