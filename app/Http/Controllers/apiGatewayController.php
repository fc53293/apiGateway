<?php

namespace App\Http\Controllers;
use DB;
use App\routes\web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilizador;
use App\Models\Inquilino;
use App\Models\HistoricoSaldo;
use App\Models\Pagamento;
use App\Models\Rating;
use App\Models\Likes;
use App\Models\Senhorio;
use App\Models\Propriedade;

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
        $user->Password=md5($request->input('pass'));
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
        $user->Data=Carbon::now();
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



    public function showHomeInteressado()
    {
        //Initialize the cURL session
        $ch = curl_init();

        //Return the page content
        
        curl_setopt($ch, CURLOPT_URL, "http://microinteressado-service:8082/homeInteressado");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
        curl_exec($ch);

        curl_close($ch);
    }



    public function showInteressadoProfile()
    {
        //Initialize the cURL session
        $ch = curl_init();

        //Return the page content
        
        curl_setopt($ch, CURLOPT_URL, "http://microinteressado-service:8082/interessadoProfile/2");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
        curl_exec($ch);

        curl_close($ch);
    }


    public function showWalletInteressado()
    {
        //Initialize the cURL session
        $ch = curl_init();

        //Return the page content
        
        curl_setopt($ch, CURLOPT_URL, "http://microinteressado-service:8082/walletInteressado/2");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
        curl_exec($ch);

        curl_close($ch);
    }

    //Updates Inqilino
    public function updateInteressado(Request $req, $id)
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

    //Adiciona uma quantidade de saldo ao saldo atual do inquilino
    public function addSaldoInteressado($id, Request $amount){
        $user = Utilizador::find($id);
        $user->Saldo=$amount->input('amountToAdd')+$user->Saldo;
        $user->save();

        $histSaldo = new HistoricoSaldo();
        //$user->IdSaldo=1;
        $histSaldo->IdUser=$id;
        $histSaldo->Username=$amount->input('nameUser');
        $histSaldo->Valor=$amount->input('amountToAdd');
        $histSaldo->Data=Carbon::now();
        $histSaldo->save();

        return response()->json(['res'=>$user->Saldo]);
    }

    public function propertyInfo($id,$idUser)
    {
        //Initialize the cURL session
       $ch = curl_init();

       //Return the page content
       
       curl_setopt($ch, CURLOPT_URL, "http://microinteressado-service:8082/propertyInfo/".$id."/user/2");
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
       
       curl_exec($ch);

       curl_close($ch);

    }


    public function findPropriedade()
    {
       //Initialize the cURL session
       $ch = curl_init();

       //Return the page content
       
       curl_setopt($ch, CURLOPT_URL, "http://microinteressado-service:8082/findPropriedadeInteressado/2");
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
       
       curl_exec($ch);

       curl_close($ch);
    }


    //Atribuir interesse a uma propriedade, dando like
    public function likeProp(Request $request,$idProp,$idUser)
    {
        $userLoged = $idUser;

        $proplike = new Likes();
        $proplike->IdUser=$userLoged;
        $proplike->IdPropriedade=$idProp;
        $proplike->Data=Carbon::now();
        $proplike->save();

        return response()->json('Deu like na propriedade');

    }


    //Retirar o like dado anteriormente 
    public function deleteLikeProp($idProp,$idUser)
    {
        $proplike=Likes::where('IdPropriedade',$idProp)->where('IdUser',$idUser)->delete();

        return response()->json('Like retirado com sucesso');

    }


    //Atribuir pontua????o a uma propriedade
    public function rateProp(Request $req, $idProp, $idUser)
    {
        $proplike = new Rating();
        $proplike->IdUser=$idUser;
        $proplike->IdPropriedade=$idProp;
        $proplike->Rating=$req->input('star');
        $proplike->Data=Carbon::now();
        $proplike->save();

        $avgStar = Rating::where('IdPropriedade', $idProp)->avg('Rating');


        //return compact('medStar');
        return response()->json(['res'=>$avgStar]);

    }

    public function starNewRent(Request $request, $idProp,$idUser)
    {

        $userLoged = $idUser;
        
        $data = Utilizador::where('IdUser',$userLoged)->get();
        $prop = Propriedade::where('IdPropriedade',$idProp)->value('DuracaoAluguer');
        $prop2 = Propriedade::where('IdPropriedade',$idProp)->value('Preco');
        $prop3IdSenhorio = Propriedade::where('IdPropriedade',$idProp)->value('IdSenhorio');
        $prop4IdUser = Senhorio::where('IdSenhorio',$prop3IdSenhorio)->value('IdUser');
        // dd($prop4IdUser);
        $guardaSaldo = null;
        //$guardaPreco = null;
        foreach ($data as $data1){
            $guardaSaldo = $data1['Saldo'];
        }
     
        // foreach ($prop as $prop1){
        //     $guardaPreco = $prop1['Preco'];
        // }

        if ($result = $guardaSaldo < $prop2){
            //return compact('result');
            return response()->json("Nao tem dinheiro suficiente");
        }
     
        else{
            foreach ($data as $dataz) {
        
        
                $user = new Inquilino();
                $user->IdUser=$userLoged;
                $user->Username=$dataz->Username;
                $user->IdPropriedade=$idProp;
                $user->InicoiContrato=Carbon::now();
                $user->FimContrato=Carbon::now()->addMonthsNoOverflow((int)$prop);
                $user->save();
                }
        
                //$prop = Propriedade::where('IdPropriedade','=',$idProp)->get();
                $prop = Propriedade::where('IdPropriedade', $idProp)
               ->update([
                   'Disponibilidade' => 'indisponivel'
                ]);
                $data = Utilizador::where('IdUser',$userLoged)
                ->update([
                    'Saldo' => $guardaSaldo-$prop2
                 ]);

                $data2 = Utilizador::where('IdUser',$prop4IdUser)
                ->update([
                    'Saldo' => +$prop2
                ]);

                //return response()->json($prop);
                return redirect('http://myunirent.pt/homeInteressado');
        }


    }


    public function showCurrentUser(Request $request)
    {
        
        $email = $request->input('email');
        $password = $request->input('password');
        $tipoconta = Utilizador::where('Email', $email)->value("TipoConta");

        echo $tipoconta;
        
        if ($tipoconta == "Inquilino"){
            
            $ch = curl_init();

            //Return the page content
        
            curl_setopt($ch, CURLOPT_URL, "http://microinquilino-service:8081/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        
            curl_exec($ch);

            curl_close($ch);



            
        } else if ($tipoconta == "Senhorio") {

            

            //Initialize the cURL session
            $ch = curl_init();

            //Return the page content
            curl_setopt($ch, CURLOPT_URL, "http://microsenhorio-service:8083/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_exec($ch);
          
            curl_close($ch);



            

        } else if ($tipoconta == "Interessado") {

            //Initialize the cURL session
            $ch = curl_init();

            //Return the page content
            curl_setopt($ch, CURLOPT_URL, "http://microinteressado-service:8082/homeInteressado");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_exec($ch);
          
            curl_close($ch);

        }
    }



}
?>