<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Models\LigneTicket;
class AchatController extends Controller
{    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
public function index() { 
      $ticketa = DB::table('LigneTicket')->select(DB::raw('SUM(LT_PACHAT*LT_Qte) as TotaleAchat'))->get();
       $ticketa->toArray();
       $tickets = DB::table('LigneTicket')->select(DB::raw("LT_Exerc,SUM(LT_PACHAT*LT_Qte) as TotaleAchat"))
       ->groupBy(DB::raw("LT_Exerc"))                      
       ->get();
      // $result = (array) json_decode($json);
       $tickets= json_decode($tickets, true);
     return view('achat.dashboardachat',compact('ticketa','tickets'),['title'=>"Total"]);
     }
public function Produit() { 
    return view('achat.parproduit',['title'=>"Par Produit"]);

   }
public function filterProduit(Request $request){
     
        $articles = DB::table('View_BonEntree_Lignebn_Art_fr')
         ->select(DB::raw(" sum(LIG_BonEntree_Qte) as LIG_BonEntree_Qte,ART_Designation"))
          ->groupBy(DB::raw("LIG_BonEntree_CodeArt,ART_Designation"))
          ->orderByRaw(DB::raw('LIG_BonEntree_Qte DESC' ))->take($request->req)->get();
        return $this->response->array($articles->toArray()); // Use this if you using Dingo Api Routing Helpers
   }
public function Famille() { 
    return view('achat.parfamille',['title'=>"Par Famille"]);

 }
public function Marque() { 
    return view('achat.parmarque',['title'=>"Par Marque"]);

 }
 public function Fournisseur() { 
    return view('achat.parFournisseur',['title'=>"Par Fournisseur"]);

 }
 public function filtrage() { 
        return view('achat.filtrercategory',['title'=>"Par category"]);
    
     }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

public function TotalAchat() { 
            $ticket = DB::table('LigneTicket')->select(DB::raw("SUM(LT_PACHAT*LT_Qte) as TotaleAchat"))->get();
            if($ticket->count()){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
public function TotaleProdExercice() { 
    $tickets = DB::table('bon_entree') ->join('ligne_bon_entree', 'bon_entree.BON_ENT_Num', '=', 'ligne_bon_entree.LIG_BonEntree_NumBon')
                                      ->join('article', 'ligne_bon_entree.LIG_BonEntree_CodeArt', '=', 'article.ART_Code ')
                                      ->select(DB::raw(" year(bon_entree.BON_ENT_Date) as year,sum(dbo.ligne_bon_entree.LIG_BonEntree_MntTTC) as TotaleAchat"))
                                      ->groupBy(DB::raw("year(bon_entree.BON_ENT_Date)"))
                                    
                                      ->get();
    if($tickets->count()){
        return $this->response->array($tickets->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
public function Top10artAchat() { 
            $articles = DB::table('View_BonEntree_Lignebn_Art_fr')
            ->select(DB::raw(" sum(LIG_BonEntree_Qte) as LIG_BonEntree_Qte,ART_Designation"))
                 ->groupBy(DB::raw("LIG_BonEntree_CodeArt,ART_Designation"))
                  ->orderByRaw(DB::raw('LIG_BonEntree_Qte DESC' ))->take(10)->get();
               
            if($articles->count()){
               // return response()->json($articles);
                return $this->response->array($articles->toArray()); // Use this if you using Dingo Api Routing Helpers
    
        }}
public function Top10Famil() { 
            $familles = DB::table('View_BonEntree_Lignebn_Art_fr')
            ->select(DB::raw("ART_Famille,FAM_Lib,sum(LIG_BonEntree_Qte) as qte"))
                 ->groupBy(DB::raw("ART_Famille,FAM_Lib"))
                 ->orderByRaw(DB::raw('sum(LIG_BonEntree_Qte) DESC' ))->take(10)
                 ->get();
                 
            if($familles->count()){
               // return response()->json($articles);
                return $this->response->array($familles->toArray()); // Use this if you using Dingo Api Routing Helpers
    
        }}
public function Top10Marque() { 
            $familles = DB::table('View_BonEntree_Lignebn_Art_fr')
            ->select(DB::raw("MAR_Code,MAR_Designation,sum(LIG_BonEntree_Qte) as qte"))
                 ->groupBy(DB::raw("MAR_Code,MAR_Designation"))
                 ->orderByRaw(DB::raw('sum(LIG_BonEntree_Qte) DESC' ))->take(10)
                 ->get();
                 
            if($familles->count()){
               // return response()->json($articles);
                return $this->response->array($familles->toArray()); // Use this if you using Dingo Api Routing Helpers
    
        }}
public function Top10Fournisseur() { 
            $familles = DB::table('View_BonEntree_Lignebn_Art_fr')
            ->select(DB::raw("BON_ENT_CodeFrs,FRS_Nomf,sum(LIG_BonEntree_Qte) as qte"))
                 ->groupBy(DB::raw("BON_ENT_CodeFrs,FRS_Nomf"))
                 ->orderByRaw(DB::raw('sum(LIG_BonEntree_Qte) DESC' ))->take(10)
                 ->get();
                 
            if($familles->count()){
               // return response()->json($articles);
                return $this->response->array($familles->toArray()); // Use this if you using Dingo Api Routing Helpers
    
        }}


public function create()
       {
        //
       }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
     {
        //
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function show($id)
     {
        //
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function edit($id)
     {
        //
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, $id)
     {
        //
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function destroy($id)
     {
        //
     }
public function listfournisseur(Request $request){
        $fournisseurs = DB::table('fournisseur')->get();
                      
        $fournisseurs= json_decode($fournisseurs, true);
      return view('achat.fournisseur',compact('fournisseurs'));
        //return response()->json($fournisseurs);
     }


}
