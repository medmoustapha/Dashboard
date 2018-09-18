<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\DB;
use App\Models\LigneTicket;
class LigneTicketController extends Controller
{    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index() { 
        // $LigneTicket = LigneTicket::all();
        $ticket = DB::table('LigneTicket')->take(1000)->get();

        // $facture = facture::select('FACT_NomPrenomCli','FACT_CodeClient',sum('FACT_MntTTC as sum'))
        // ->groupBy('FACT_CodeClient','FACT_NomPrenomCli')->get();

     
        // $facture = facture::where('FACT_MntTTC', '>', '1000.000')->groupBy('FACT_CodeClient')->get();
        // $produit = Produit::paginate(5);
        //$users = Users::where('status', '=', 'active')->paginate(10);
        if($LigneTicket->count()){
            // return response()->json(['data' => $client]); // Use this by default
            return $this->response->array($LigneTicket->toArray()); // Use this if you using Dingo Api Routing Helpers
            // return $this->response->collection($produit, new ProduitTransformer()); // Use this if you using Fractal <=> Create a resource collection transformer
        //    return $this->response->paginator($produit, new ProduitTransformer()); // Use this if you using Fractal Responding With Paginated Items 
        }}
          /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function TotalVente() { 
            $ticket = DB::table('LigneTicket')->select(DB::raw("SUM(LT_MtTTC) as TotaleVente"))
            ->where('LT_Annuler', '<>', true)->orWhereNull('LT_Annuler')->get();
            if($ticket->count()){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
        public function TotalAchat() { 
            $ticket = DB::table('LigneTicket')->select(DB::raw("SUM(LT_PACHAT*LT_Qte) as TotaleAchat"))
            ->where('LT_Annuler', '<>', true)->orWhereNull('LT_Annuler')->get();
            if($ticket->count()){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
        public function TotalExercice() { 
            $ticket = DB::table('LigneTicket')
            ->select(DB::raw("LT_Exerc, SUM(LT_MtTTC) as TotaleVente ,SUM(LT_PACHAT*LT_Qte) as TotaleAchat"))
            ->where('LT_Annuler', '<>', true)->orWhereNull('LT_Annuler')
            ->groupBy(DB::raw("LT_Exerc"))->get();
            if($ticket->count()){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
        public function TotalVenteDate() { 
            $ticket = DB::table('LigneTicket')
            ->join('Ticket', function($join)
        {
            $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
            $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
            $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');
        })
            ->select(DB::raw("FORMAT ( Ticket.TIK_DateHeureTicket,  'yyyy-MM-dd', 'en-US' ) as year,SUM(LigneTicket.LT_MtTTC) as TotaleVente ,SUM(LT_PACHAT*LT_Qte) as TotaleAchat"))
            ->where('LigneTicket.LT_Annuler', '<>', true)->orWhereNull('LigneTicket.LT_Annuler')
            
            ->groupBy(DB::raw("FORMAT ( Ticket.TIK_DateHeureTicket, 'yyyy-MM-dd', 'en-US' )"))
            ->orderBy(DB::raw("FORMAT ( Ticket.TIK_DateHeureTicket, 'yyyy-MM-dd', 'en-US' )"))->get();
            if($ticket->count()){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
        public function Top10art(Request $request) { 
            $ticket = DB::table('LigneTicket')
            ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
            ->join('Ticket', function($join)
            {
                $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
                $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
                $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');
            })
            ->select( DB::raw("SUM(LigneTicket.LT_MtTTC) as TotaleVente ,article.ART_Designation"))
            ->whereRaw(DB::raw("FORMAT(Ticket.TIK_DateHeureTicket,'yyyy')=$request->year"))
            ->where('LigneTicket.LT_Annuler', '<>', true)->orWhereNull('LigneTicket.LT_Annuler')
            ->groupBy(DB::raw("LigneTicket.LT_CodArt,article.ART_Designation"))->orderByRaw(DB::raw('sum(LigneTicket.LT_MtTTC) DESC' ))->take($request->req)->get();
            if($ticket->count()>0){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
        public function Top10fam(Request $request) { 
    
            $ticket = DB::table('LigneTicket')
            ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
            ->join('famille', 'article.ART_Famille', '=', 'famille.FAM_Code')
            ->join('Ticket', function($join)
            {
                $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
                $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
                $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');
            })
            ->select( DB::raw("famille.FAM_Lib , SUM(LigneTicket.LT_MtTTC) as TotaleVente"))
            ->whereRaw(DB::raw("FORMAT(Ticket.TIK_DateHeureTicket,'yyyy')=$request->year"))
            ->where('LigneTicket.LT_Annuler', '<>', true)->orWhereNull('LigneTicket.LT_Annuler')
            ->groupBy(DB::raw("article.ART_Famille,famille.FAM_Lib"))->orderByRaw(DB::raw('sum(LigneTicket.LT_MtTTC) DESC' ))->take($request->req)->get();
            if($ticket->count()){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
        public function Top10Marque(Request $request) { 
            $ticket = DB::table('LigneTicket')
            ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
            ->join('marque', 'article.ART_Marque', '=', 'marque.MAR_Code')
            ->join('Ticket', function($join)
        {
            $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
            $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
            $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');
        })
            ->select( DB::raw("marque.MAR_Designation , SUM(LigneTicket.LT_MtTTC) as TotaleVente"))
            ->whereRaw(DB::raw("FORMAT(Ticket.TIK_DateHeureTicket,'yyyy')=$request->year"))
            ->where('LigneTicket.LT_Annuler', '<>', true)->orWhereNull('LigneTicket.LT_Annuler')
           
            ->groupBy(DB::raw("article.ART_Marque,marque.MAR_Designation"))->orderByRaw(DB::raw('sum(LigneTicket.LT_MtTTC) DESC' ))->take($request->req)->get();
            if($ticket->count()){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
        public function CaParVendeur() { 
            $ticket = DB::table('Ticket')
            ->join('SessionCaisse', 'Ticket.TIK_IdSCaisse', '=', 'SessionCaisse.SC_IdSCaisse')
            ->join('Utilisateur', 'SessionCaisse.SC_CodeUtilisateur', '=', 'Utilisateur.Code_Ut')
            ->select( DB::raw("Utilisateur.Nom , SUM(Ticket.TIK_MtTTC) as TotaleVente"))
            ->where('Ticket.TIK_Annuler', '<>', true)->orWhereNull('Ticket.TIK_Annuler')
            ->groupBy(DB::raw("SessionCaisse.SC_CodeUtilisateur,Utilisateur.Nom"))
            ->orderByRaw(DB::raw('sum(Ticket.TIK_MtTTC) DESC' ))->get();
            if($ticket->count()){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
        public function NBTickParCaisse() { 
            $ticket = DB::table('Ticket')
            ->join('SessionCaisse', 'Ticket.TIK_IdSCaisse', '=', 'SessionCaisse.SC_IdSCaisse')
            ->join('Caisse', 'SessionCaisse.SC_Caisse', '=', 'Caisse.CAI_IdCaisse')
            ->select( DB::raw("Caisse.CAI_DesCaisse , Count(*) as NBTick"))
            ->where('Ticket.TIK_Annuler', '<>', true)->orWhereNull('Ticket.TIK_Annuler')
            ->groupBy(DB::raw("Caisse.CAI_DesCaisse"))
            ->orderByRaw(DB::raw('Count(*) DESC' ))->get();
            if($ticket->count()){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
        public function TotaleTick() { 
            $ticket = DB::table('Ticket')
            
            ->select( DB::raw(" Count(*) as NBTick"))
            ->where('Ticket.TIK_Annuler', '<>', true)->orWhereNull('Ticket.TIK_Annuler')
            ->get();
            if($ticket->count()){
                return $this->response->array($ticket->toArray()); // Use this if you using Dingo Api Routing Helpers
  
        }}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
}
