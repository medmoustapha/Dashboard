<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Transformer\ProduitTransformer;

use Illuminate\Support\Facades\DB;
class chartController extends Controller
{        use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $ticketv = DB::table('LigneTicket')->select(DB::raw("SUM(LT_MtTTC) as TotaleVente"))
        ->where('LT_Annuler', '<>', true)->orWhereNull('LT_Annuler')->get();
        $ticketa = DB::table('LigneTicket')->select(DB::raw("SUM(LT_PACHAT*LT_Qte) as TotaleAchat"))
        ->where('LT_Annuler', '<>', true)->orWhereNull('LT_Annuler')->get();
        $ticketa = DB::table('LigneTicket')->select(DB::raw("SUM(LT_PACHAT*LT_Qte) as TotaleAchat"))
        ->where('LT_Annuler', '<>', true)->orWhereNull('LT_Annuler')->get();
        $ticket = DB::table('Ticket')->select( DB::raw(" Count(*) as NBTick"))->get();


      return view('Vente.dashboardvente',['vente'=>$ticketv->toArray(),'achat'=>$ticketa->toArray(),'TotaleTik'=>$ticket->toArray(),'title'=>"Totale"]);

    }
    public function produit()
    {

      
      return view('Vente.parProduit',['title'=>"Par Produit"]);

    }
    public function vendeur()
    {

  
      return view('Vente.parVendeur',['title'=>"Par Vendeur"]);

    }
    public function caisse()
    {

        $ticketv = DB::table('LigneTicket')->select(DB::raw("SUM(LT_MtTTC) as TotaleVente"))
        ->where('LT_Annuler', '<>', true)->orWhereNull('LT_Annuler')->get();

        $ticket = DB::table('Ticket')->select( DB::raw(" Count(*) as NBTick"))->get();
     

      return view('Vente.parCaise',['vente'=>$ticketv->toArray(),'TotaleTik'=>$ticket->toArray(),'title'=>"Par Caisse"]);

    }

    public function reglement()
    {
        $TotalRecu = DB::table('ReglementCaisse')
        ->join('Ticket', function($join)
        {
            $join->on('ReglementCaisse.REGC_NumTicket', '=', 'Ticket.TIK_NumTicket ');
            $join->on('ReglementCaisse.REGC_Exercice', '=', 'Ticket .TIK_Exerc');
            $join->on('ReglementCaisse.REGC_IdCarnet', '=', 'Ticket .TIK_IdCarnet');
        })
        ->select( DB::raw(" sum(REGC_MntTotalRecue) as MontantTotale"))
        ->where('Ticket.TIK_Annuler', '<>', true)->orWhereNull('Ticket.TIK_Annuler')
        ->get();
        $Totalespece = DB::table('ReglementCaisse')
        ->join('Ticket', function($join)
        {
            $join->on('ReglementCaisse.REGC_NumTicket', '=', 'Ticket.TIK_NumTicket ');
            $join->on('ReglementCaisse.REGC_Exercice', '=', 'Ticket .TIK_Exerc');
            $join->on('ReglementCaisse.REGC_IdCarnet', '=', 'Ticket .TIK_IdCarnet');
        })
        ->select( DB::raw(" sum(REGC_MntEspece) as Totalespece"))
        ->where('Ticket.TIK_Annuler', '<>', true)->orWhereNull('Ticket.TIK_Annuler')
        ->get();
        $Totalcheque = DB::table('ReglementCaisse')
        ->join('Ticket', function($join)
        {
            $join->on('ReglementCaisse.REGC_NumTicket', '=', 'Ticket.TIK_NumTicket ');
            $join->on('ReglementCaisse.REGC_Exercice', '=', 'Ticket .TIK_Exerc');
            $join->on('ReglementCaisse.REGC_IdCarnet', '=', 'Ticket .TIK_IdCarnet');
        })
        ->select( DB::raw(" sum(ReglementCaisse.REGC_MntChéque) as Totalcheque"))
        ->where('Ticket.TIK_Annuler', '<>', true)->orWhereNull('Ticket.TIK_Annuler')
        ->get();
        $Totalcarte = DB::table('ReglementCaisse')
        ->join('Ticket', function($join)
        {
            $join->on('ReglementCaisse.REGC_NumTicket', '=', 'Ticket.TIK_NumTicket ');
            $join->on('ReglementCaisse.REGC_Exercice', '=', 'Ticket .TIK_Exerc');
            $join->on('ReglementCaisse.REGC_IdCarnet', '=', 'Ticket .TIK_IdCarnet');
        })
        ->select( DB::raw(" sum(REGC_MntCarteBancaire) as Totalcarte"))
        ->where('Ticket.TIK_Annuler', '<>', true)->orWhereNull('Ticket.TIK_Annuler')
        ->get();
        $Totaltrait = DB::table('ReglementCaisse')
        ->join('Ticket', function($join)
        {
            $join->on('ReglementCaisse.REGC_NumTicket', '=', 'Ticket.TIK_NumTicket ');
            $join->on('ReglementCaisse.REGC_Exercice', '=', 'Ticket .TIK_Exerc');
            $join->on('ReglementCaisse.REGC_IdCarnet', '=', 'Ticket .TIK_IdCarnet');
        })
        ->select( DB::raw(" sum(REGC_MntTraite) as Totaltrait"))
        ->where('Ticket.TIK_Annuler', '<>', true)->orWhereNull('Ticket.TIK_Annuler')
        ->get();
        $ticketv = DB::table('LigneTicket')->select(DB::raw("SUM(LT_MtTTC) as TotaleVente"))
        ->where('LT_Annuler', '<>', true)->orWhereNull('LT_Annuler')->get();

  
      return view('Vente.Reglement',['TotalRecu'=>$TotalRecu->toArray(),'Totalespece'=>$Totalespece->toArray()
      ,'Totalcheque'=>$Totalcheque->toArray(),'Totalcarte'=>$Totalcarte->toArray()
      ,'Totaltrait'=>$Totaltrait->toArray(),'vente'=>$ticketv->toArray(),'title'=>"réglement"]);

    }
    public function indexachat()
    {

        $ticketv = DB::table('LigneTicket')->select(DB::raw("SUM(LT_MtTTC) as TotaleVente"))->get();
        $ticketa = DB::table('LigneTicket')->select(DB::raw("SUM(LT_PACHAT*LT_Qte) as TotaleAchat"))->get();

      return view('Vente.dashboardachat',['vente'=>$ticketv->toArray(),'achat'=>$ticketa->toArray()]);

    }

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
