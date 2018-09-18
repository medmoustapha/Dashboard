<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Transformer\ProduitTransformer;

use Illuminate\Support\Facades\DB;
use App\Models\Facture;
class FactureController extends Controller
{    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index() { 
        // $facture = facture::all();
        // $facture = facture::select('FACT_NomPrenomCli','FACT_CodeClient',sum('FACT_MntTTC as sum'))
        // ->groupBy('FACT_CodeClient','FACT_NomPrenomCli')->get();
        // $facture = DB::table('facture')->get();

        $facture = facture::select(DB::raw("SUM(FACT_MntTTC) as sum ,FACT_CodeClient,FACT_NomPrenomCli"))
	    ->groupBy(DB::raw("FACT_CodeClient,FACT_NomPrenomCli"))->take(10)
	    ->get();
        // $facture = facture::where('FACT_MntTTC', '>', '1000.000')->groupBy('FACT_CodeClient')->get();
        // $produit = Produit::paginate(5);
        //$users = Users::where('status', '=', 'active')->paginate(10);
        if($facture->count()){
            // return response()->json(['data' => $client]); // Use this by default
            return $this->response->array($facture->toArray()); // Use this if you using Dingo Api Routing Helpers
            // return $this->response->collection($produit, new ProduitTransformer()); // Use this if you using Fractal <=> Create a resource collection transformer
        //    return $this->response->paginator($produit, new ProduitTransformer()); // Use this if you using Fractal Responding With Paginated Items 
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
