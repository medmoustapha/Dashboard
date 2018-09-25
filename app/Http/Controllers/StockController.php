<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Datatables;
class StockController extends Controller
{
public function index(){
  if(Auth::check()){
        $stations =     DB::table('station')->get();
        $familles=DB::table('famille')->get();
        $marques=DB::table('marque')->get();
        $fournisseurs=DB::table('fournisseur')->get();  
   return view('stock.articleParStation',compact('stations','familles','marques','fournisseurs'),['title'=>"Article Par Station"]);
  }
  else {  return Redirect::to('login'); }
 }
public function articlesParStation(Request $request){ 
    
        $out='';
      $station=$request->get('station');
      $famille=$request->get('famille');
      $marque=$request->get('marque');
      $fournisseur=$request->get('fournisseur');
      $QteAfficher=$request->get('QteAfficher');
      if($station!="Tout"){
        if($famille!="Tout"){
           if($marque!="Tout"){
                if($fournisseur!="Tout"){
                    if($QteAfficher==0){
                      $articlesStation =DB::table('stock_par_station_valeur_achat')
                                       ->where('STAT_Desg',$station)
                                       ->where('MAR_Designation',$marque)
                                       ->where('FAM_Lib',$famille)
                                       ->where('FRS_Nomf',$fournisseur)
                                       ->where('SART_Qte','<=',$QteAfficher)
                                       ->get();
                           }
                    elseif($QteAfficher==1){
                      $articlesStation =DB::table('stock_par_station_valeur_achat')
                                       ->where('STAT_Desg',$station)
                                       ->where('MAR_Designation',$marque)
                                       ->where('FAM_Lib',$famille)
                                       ->where('FRS_Nomf',$fournisseur)
                                       ->where('SART_Qte','>=',$QteAfficher)
                                       ->get();
                       }
                    else{
                      $articlesStation =DB::table('stock_par_station_valeur_achat')
                      ->where('STAT_Desg',$station)
                      ->where('MAR_Designation',$marque)
                      ->where('FAM_Lib',$famille)
                      ->where('FRS_Nomf',$fournisseur)
                      ->get();
                    }
                  }
                else{
                    if($QteAfficher==0){
                        $articlesStation =DB::table('stock_par_station_valeur_achat')
                      ->where('STAT_Desg',$station)
                      ->where('MAR_Designation',$marque)
                      ->where('FAM_Lib',$famille)
                      ->where('SART_Qte','<=',$QteAfficher)
                      ->get();}
                    elseif($QteAfficher==1){
                        $articlesStation =DB::table('stock_par_station_valeur_achat')
                        ->where('STAT_Desg',$station)
                        ->where('MAR_Designation',$marque)
                        ->where('FAM_Lib',$famille)
                        ->where('SART_Qte','>=',$QteAfficher)
                        ->get();
                      }
                      else{
                        $articlesStation =DB::table('stock_par_station_valeur_achat')
                        ->where('STAT_Desg',$station)
                        ->where('MAR_Designation',$marque)
                        ->where('FAM_Lib',$famille)
                      
                        ->get();
  
                       }
  
                }
              
              }
           else{
              if($QteAfficher==0){
                  $articlesStation =DB::table('stock_par_station_valeur_achat')
                ->where('STAT_Desg',$station)
                ->where('FAM_Lib',$famille)
                ->where('SART_Qte','<=',$QteAfficher)
                ->get();}
              elseif($QteAfficher==1){
                  $articlesStation =DB::table('stock_par_station_valeur_achat')
                  ->where('STAT_Desg',$station)
                  ->where('FAM_Lib',$famille)
                  ->where('SART_Qte','>=',$QteAfficher)
                  ->get();
                }
                else{
                  $articlesStation =DB::table('stock_par_station_valeur_achat')
                  ->where('STAT_Desg',$station)
                  ->where('FAM_Lib',$famille)
                
                  ->get();
  
                 }
             }
           }
        else{
         if($QteAfficher==0){
          $articlesStation =DB::table('stock_par_station_valeur_achat')
          ->where('STAT_Desg',$station)
          ->where('SART_Qte','<=',$QteAfficher)
          ->get();   }
          elseif($QteAfficher==1){
            $articlesStation =DB::table('stock_par_station_valeur_achat')
            ->where('STAT_Desg',$station)
            ->where('SART_Qte','>=',$QteAfficher)
            ->get();
          }
          else {
            $articlesStation =DB::table('stock_par_station_valeur_achat')
            ->where('STAT_Desg',$station)
            ->get(); 
          }
           }
       }
     else{
      if($QteAfficher==0){
          $articlesStation =DB::table('stock_par_station_valeur_achat')
          ->where('SART_Qte','<=',$QteAfficher)
                            ->get();
                        }
          elseif($QteAfficher==1){
           $articlesStation =DB::table('stock_par_station_valeur_achat')
             ->where('SART_Qte','>=',$QteAfficher)
                              ->get();
        }
       else{  
        $articlesStation =DB::table('stock_par_station_valeur_achat')->get();
  
        }
     
      
       }
     
       $total_row = $articlesStation->count();
         //  dd($total_row);
          if($total_row > 0){
         foreach($articlesStation as $article){
    
           $out.= '<tr>
                      <td>'.$article->ART_CodeBar.'</td><td>'.$article->ART_Designation.'</td>
                      <td>'.$article->FAM_Lib.'</td>
                      <td>'.$article->MAR_Designation.'</td>
                      <td>'.$article->SART_Qte.'</td>
                    </tr>';
          } }
         else{ 
             $out .='<tr>
                   <td align="center" colspan="6">No Data Found</td>
                 </tr>';
         } 
       return response($out);
     }

public function valeurStockIndex(){  
  if(Auth::check()){
    $stations =     DB::table('station')->get();
    $familles=DB::table('famille')->get();
    $marques=DB::table('marque')->get();
    $fournisseurs=DB::table('fournisseur')->get();

              return view('stock.valeurStock',compact('stations','familles','marques','fournisseurs'),['title'=>"Liste des stocks articles / station"]);
      }
  else {  return Redirect::to('login'); }
  }
public function valeurStock(Request $request){ 
    $out='<div class="row">';
    $station=$request->get('station');
    $famille=$request->get('famille');
    $marque=$request->get('marque');
    $fournisseur=$request->get('fournisseur');
    $QteAfficher=$request->get('QteAfficher');
    if($station!="Tout"){
      if($famille!="Tout"){
         if($marque!="Tout"){
              if($fournisseur!="Tout"){
                  if($QteAfficher==0){
                    $articlesStation =DB::table('stock_par_station_valeur_achat')
                                     ->where('STAT_Desg',$station)
                                     ->where('MAR_Designation',$marque)
                                     ->where('FAM_Lib',$famille)
                                     ->where('FRS_Nomf',$fournisseur)
                                     ->where('SART_Qte','<=',$QteAfficher)
                                     ->get();
                         }
                  elseif($QteAfficher==1){
                    $articlesStation =DB::table('stock_par_station_valeur_achat')
                                     ->where('STAT_Desg',$station)
                                     ->where('MAR_Designation',$marque)
                                     ->where('FAM_Lib',$famille)
                                     ->where('FRS_Nomf',$fournisseur)
                                     ->where('SART_Qte','>=',$QteAfficher)
                                     ->get();
                     }
                  else{
                    $articlesStation =DB::table('stock_par_station_valeur_achat')
                    ->where('STAT_Desg',$station)
                    ->where('MAR_Designation',$marque)
                    ->where('FAM_Lib',$famille)
                    ->where('FRS_Nomf',$fournisseur)
                    ->get();
                  }
                }
              else{
                  if($QteAfficher==0){
                      $articlesStation =DB::table('stock_par_station_valeur_achat')
                    ->where('STAT_Desg',$station)
                    ->where('MAR_Designation',$marque)
                    ->where('FAM_Lib',$famille)
                    ->where('SART_Qte','<=',$QteAfficher)
                    ->get();}
                  elseif($QteAfficher==1){
                      $articlesStation =DB::table('stock_par_station_valeur_achat')
                      ->where('STAT_Desg',$station)
                      ->where('MAR_Designation',$marque)
                      ->where('FAM_Lib',$famille)
                      ->where('SART_Qte','>=',$QteAfficher)
                      ->get();
                    }
                    else{
                      $articlesStation =DB::table('stock_par_station_valeur_achat')
                      ->where('STAT_Desg',$station)
                      ->where('MAR_Designation',$marque)
                      ->where('FAM_Lib',$famille)
                    
                      ->get();

                     }

              }
            
            }
         else{
            if($QteAfficher==0){
                $articlesStation =DB::table('stock_par_station_valeur_achat')
              ->where('STAT_Desg',$station)
              ->where('FAM_Lib',$famille)
              ->where('SART_Qte','<=',$QteAfficher)
              ->get();}
            elseif($QteAfficher==1){
                $articlesStation =DB::table('stock_par_station_valeur_achat')
                ->where('STAT_Desg',$station)
                ->where('FAM_Lib',$famille)
                ->where('SART_Qte','>=',$QteAfficher)
                ->get();
              }
              else{
                $articlesStation =DB::table('stock_par_station_valeur_achat')
                ->where('STAT_Desg',$station)
                ->where('FAM_Lib',$famille)
              
                ->get();

               }
           }
         }
      else{
       if($QteAfficher==0){
        $articlesStation =DB::table('stock_par_station_valeur_achat')
        ->where('STAT_Desg',$station)
        ->where('SART_Qte','<=',$QteAfficher)
        ->get();   }
        elseif($QteAfficher==1){
          $articlesStation =DB::table('stock_par_station_valeur_achat')
          ->where('STAT_Desg',$station)
          ->where('SART_Qte','>=',$QteAfficher)
          ->get();
        }
        else {
          $articlesStation =DB::table('stock_par_station_valeur_achat')
          ->where('STAT_Desg',$station)
          ->get(); 
        }
         }
     }
   else{
    if($QteAfficher==0){
        $articlesStation =DB::table('stock_par_station_valeur_achat')
        ->where('SART_Qte','<=',$QteAfficher)
                          ->get();
                      }
        elseif($QteAfficher==1){
         $articlesStation =DB::table('stock_par_station_valeur_achat')
           ->where('SART_Qte','>=',$QteAfficher)
           ->get();
      }
     else{  
      $articlesStation =DB::table('stock_par_station_valeur_achat')->get();

      }
   
    
     }
  $total_row = $articlesStation->count();
     //dd($total_row);
      if($total_row > 0){
          $puhttotal=0;
          $pvttcTotal=0;
          $Qtétotal=0;
          $vacmptotal=0;
          $vattctotal=0;
          $vvttctotal=0;
       foreach($articlesStation as $article){
        $article->SART_Qte = round($article->SART_Qte,2);
        $article->ART_PrixUnitaireHT= round($article->ART_PrixUnitaireHT,2);
        $article->UNITE_ARTICLE_PrixVenteTTC= round( $article->UNITE_ARTICLE_PrixVenteTTC,2);
        $puhttotal+=$article->ART_PrixUnitaireHT= round($article->ART_PrixUnitaireHT,2);
        $article->val_Achat= round($article->val_Achat,2);
        $article->val_Achat_TTC= round($article->val_Achat_TTC,2);
        $article->val_Vente= round($article->val_Vente,2);
        $pvttcTotal+=$article->UNITE_ARTICLE_PrixVenteTTC;
        $Qtétotal+=$article->SART_Qte;
        $vacmptotal+=$article->val_Achat;
        $vattctotal+=$article->val_Achat_TTC;
        $vvttctotal+=$article->val_Vente;
         $out.= '<tr>
               <div class=col-md-1><td>'.$article->ART_CodeBar.'</td></div>
               <div class=col-md-1>  <td>'.$article->ART_Designation.'</td></div>
               <div class=col-md-1> <td>'.$article->FAM_Lib.'</td></div>
               <div class=col-md-1> <td>'.$article->MAR_Designation.'</td></div>
               <div class=col-md-1> <td>'.$article->FRS_Nomf.'</td></div>
               <div class=col-md-1> <td>'.$article->ART_PrixUnitaireHT.'</td></div>
               <div class=col-md-1> <td>'.$article->UNITE_ARTICLE_PrixVenteTTC.'</td></div>
               <div class=col-md-1> <td>'.$article->SART_Qte.'</td></div>
               <div class=col-md-1> <td>'.$article->val_Achat.'</td></div>
               <div class=col-md-1> <td>'.$article->val_Achat_TTC.'</td></div>
               <div class=col-md-1>  <td>'.$article->val_Vente.'</td></div>
          </tr>';
                
       } 
       $out.= '<tr class="panel-footer">
            <div class=col-md-1><td colspan=5><center><b>Total</b></center></td></div>
            <div class=col-md-1>  <td>'.$puhttotal.'</td></div>
            <div class=col-md-1> <td>'.$pvttcTotal.'</td></div>
            <div class=col-md-1> <td>'. $Qtétotal.'</td></div>
            <div class=col-md-1> <td>'.$vacmptotal.'</td></div>
            <div class=col-md-1> <td>'.$vattctotal.'</td></div>
            <div class=col-md-1> <td>'.$vvttctotal.'</td></div></tr>';
          
      }
      else{ 
           $out .='<tr>
                 <td align="center" colspan="6">No Data Found</td>
               </tr>';
       } 
     return response($out);

 }
public function articleEnRupture(Request $request){
  if(Auth::check()){
    $articles =     DB::table('article_marque_famille')
                       ->orderBy('ART_QteStock', 'asc')
                       ->limit(10)
                       ->get();
    $marques =     DB::table('article_marque_famille')
                       ->select('MAR_Designation')
                       ->distinct()
                       ->get();
    $familles =     DB::table('article_marque_famille')
                       ->distinct()
                       ->select('FAM_Lib')
                       //
                       ->get();
  
    
    return view('stock.articleenrupture',compact('articles','marques','familles'),['title'=>"Article En Rupture",'articles'=> response()->json($articles)]);
  }
  else {  return Redirect::to('login'); }
 }
public function articleEnRupturechart(Request $request){
      $articles =     DB::table('article_marque_famille')
                         ->orderBy('ART_QteStock', 'asc')
                         ->limit(10)
                         ->get();
         return response()->json($articles);   
       }
public function  filterArticleRupture(Request $request){
  $famille=$request->get('famille');
  $marque=$request->get('marque');
  
  $out='';
  if($famille =="Tout" and $marque =="Tout"){
                 $articles =     DB::table('article_marque_famille')
                        ->orderBy('ART_QteStock', 'asc')
                        ->limit(10)
                        ->get();
                        $total_row = $articles->count();
                       
                    if($total_row > 0){
                           
                        foreach($articles as $article){
                   
                          $out.= '<tr>
                                     <td>'.$article->ART_Code.'</td>
                                     <td>'.$article->ART_CodeBar.'</td>
                                     <td>'.$article->ART_Designation.'</td>
                                     <td>'.$article->ART_QTEmin.'</td>
                                     <td>'.$article->ART_QteStock.'</td>
                                   </tr>';
                         } 
                        }
                    else{ 
                            $out .='<tr>
                                  <td align="center" colspan="6">No Data Found</td>
                                </tr>';
                        } 
                        $data = array(
                          'table_data'  => $out,
                          'articles'=>$articles);
                      return response($data);
    }
  elseif($famille !='Tout' and $marque=='Tout'){
      $articles =     DB::table('article_marque_famille')
                        ->where('FAM_Lib',$famille)
                        ->orderBy('ART_QteStock', 'asc')
                        ->limit(10)
                        ->get();
                        $total_row = $articles->count();
                  
                      if($total_row > 0){
                           
                        foreach($articles as $article){
                   
                          $out.= '<tr>
                                     <td>'.$article->ART_Code.'</td>
                                     <td>'.$article->ART_CodeBar.'</td>
                                     <td>'.$article->ART_Designation.'</td>
                                     <td>'.$article->ART_QTEmin.'</td>
                                     <td>'.$article->ART_QteStock.'</td>
                                   </tr>';
                         } }
                        else{ 
                            $out .='<tr>
                                  <td align="center" colspan="6">No Data Found</td>
                                </tr>';
                        } 
                        $data = array(
                          'table_data'  => $out,
                          'articles'=>$articles);
                      return response($data);
    }
  elseif($famille =='Tout' and $marque!='Tout'){
      $articles =     DB::table('article_marque_famille')
      ->where('MAR_Designation',$marque)
      ->orderBy('ART_QteStock', 'asc')
      ->limit(10)
      ->get();
     
      $total_row = $articles->count();
                        //  dd($total_row);
                         if($total_row > 0){
                           
                        foreach($articles as $article){
                   
                          $out.= '<tr>
                                     <td>'.$article->ART_Code.'</td>
                                     <td>'.$article->ART_CodeBar.'</td>
                                     <td>'.$article->ART_Designation.'</td>
                                     <td>'.$article->ART_QTEmin.'</td>
                                     <td>'.$article->ART_QteStock.'</td>
                                   </tr>';
                         } }
                        else{ 
                            $out .='<tr>
                                  <td align="center" colspan="6">No Data Found</td>
                                </tr>';
                        } 
                        $data = array(
                          'table_data'  => $out,
                          'articles'=>$articles);
     return response($data);

    }
  else{
      $articles =     DB::table('article_marque_famille')
      ->where('MAR_Designation',$marque)
      ->where('FAM_Lib',$famille)
      ->orderBy('ART_QteStock', 'asc')
      ->limit(10)
      ->get();
     
                      $total_row = $articles->count();
                        //  dd($total_row);
                       if($total_row > 0){
                           
                        foreach($articles as $article){
                   
                          $out.= '<tr>
                                     <td>'.$article->ART_Code.'</td>
                                     <td>'.$article->ART_CodeBar.'</td>
                                     <td>'.$article->ART_Designation.'</td>
                                     <td>'.$article->ART_QTEmin.'</td>
                                     <td>'.$article->ART_QteStock.'</td>
                                   </tr>';
                         } }
                        else{ 
                            $out .='<tr>
                                  <td align="center" colspan="6">No Data Found</td>
                                </tr>';
                        } 
                        $data = array(
                          'table_data'  => $out,
                          'articles'=>$articles);
      return response($data);
    }
   
 }
public function filterArticleRuptureChart(Request $request){
  $famille=$request->famille;
  $marque=$request->marque;
 
  
  if($famille != "Tout" and $marque!= "Tout" ){
    $articles =     DB::table('article_marque_famille')
                       ->where('MAR_Designation',$famille)
                       ->where('FAM_Lib',$marque)
                       ->orderBy('ART_QteStock', 'asc')
                       ->limit(10)
                       ->get();
      
    }
  elseif($famille !='Tout' and $marque=='Tout'){
      $articles =     DB::table('article_marque_famille')
                        ->where('FAM_Lib',$famille)
                       ->orderBy('ART_QteStock', 'asc')
                        ->limit(10)
                        ->get();
  
    }
  elseif($famille =='Tout' and $marque!='Tout'){
      $articles =     DB::table('article_marque_famille')
                         ->where('MAR_Designation',$marque)
                       ->orderBy('ART_QteStock', 'asc')
                         ->limit(10)
                         ->get();
      

    }
  else{
    $articles =     DB::table('article_marque_famille')
                       ->orderBy('ART_QteStock', 'asc')
                       ->limit(10)
                       ->get();
  
    }
     return response()->json($articles);
    
 }
public function inventaireIndex(){
  if(Auth::check()){
               $todayDate = date("Y-m-d");
               $stations =     DB::table('station')
                                  ->select('STAT_Desg','STAT_Code')
                                  ->distinct()
                                  ->get();
   return view('stock.inventairjournalier',compact('stations','todayDate'),['title'=>"Inventaire Journalier"]);
  }
  else {  return Redirect::to('login'); }
 }
public function inventaireFilter(Request $request){
  $date1=$request->get('date1');
  $date2=$request->get('date2');
  if($date2==null){
    $date2=date("m-d-Y H:i");
     }
  if($date1==null){
      $date1=date("01-01-2000 12:00");
       }
  $station=$request->get('station');
  $out='<thead>
              <tr>
                 <th>Réf</th>
                 <th>Désignation</th>
                 <th>Qté Vendu</th>
                 <th>Qté Stk</th>
                 <th>Qté Reel</th>
              </tr>
       </thead>
       <tbody  class="panel panel-default">';
  if($station=="Tout"){
    $results = DB::table('LigneTicket')
    ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
    ->join('Ticket', function($join){ $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
                                      $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
                                      $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');})
    ->join('SessionCaisse', 'Ticket.TIK_IdSCaisse', '=', 'SessionCaisse.SC_IdSCaisse ')
    ->join('Caisse', 'SessionCaisse.SC_Caisse', '=', 'Caisse.CAI_IdCaisse')
    ->join('StationArticle', 'StationArticle.SART_CodeArt', '=', 'LigneTicket.LT_CodArt')

    ->select( DB::raw(" SUM(LigneTicket.LT_Qte) AS Qte_Vendu,LT_CodArt AS Code_Art,article.ART_Designation,
                                          ( SELECT  SUM(SART_Qte) AS Qte_Stock 
                                             FROM dbo.StationArticle
                                             WHERE (SART_CodeArt = dbo.LigneTicket.LT_CodArt)
                                             ) as Qte_Stock"))                                                                                            
   ->whereBetween('Ticket.TIK_DateHeureTicket', array($date1, $date2))
    ->groupBy(DB::raw("LigneTicket.LT_CodArt,article.ART_Designation"))
    ->orderBy('Qte_Stock', 'desc')
    ->limit(100)
    ->get();
    $total_row = $results->count();
            ($total_row);
               if($total_row > 0){
                   
                foreach($results as $article){
                 
                   $QteReell=$article->Qte_Stock-(+$article->Qte_Vendu);
                  $out.= '<tr>
                            
                             <td>'.$article->Code_Art.'</td>
                             <td>'.$article->ART_Designation.'</td>
                             <td bgcolor="#0EB204">'.$article->Qte_Vendu.'</td>
                             <td bgcolor="red"><font color="#FFFFFF">'.$article->Qte_Stock.'</font></td>
                             <td>'. $QteReell.'</td>
                            
                           </tr>';
                 } }
               else{ 
                  $out .='<tr>
                        <td align="center" colspan="6">No Data Found</td>
                      </tr>';
              } 

                
   }
  else{
   /*  $results=DB::table('View_InventaireSation')
                 ->where('INV_Code_Station','LIKE','%'.$station.'%')
                 ->whereBetween('INV_Date', array($date1, $date2))
                 ->get(); */
        $results = DB::table('LigneTicket')
                 ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
                 ->join('Ticket', function($join){ $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
                                                   $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
                                                   $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');})
                 ->join('SessionCaisse', 'Ticket.TIK_IdSCaisse', '=', 'SessionCaisse.SC_IdSCaisse ')
                 ->join('Caisse', 'SessionCaisse.SC_Caisse', '=', 'Caisse.CAI_IdCaisse')
                 ->join('StationArticle', 'StationArticle.SART_CodeArt', '=', 'LigneTicket.LT_CodArt')
             
                 ->select( DB::raw(" SUM(LigneTicket.LT_Qte) AS Qte_Vendu,LT_CodArt AS Code_Art,article.ART_Designation,
                                                       ( SELECT  SUM(SART_Qte) AS Qte_Stock 
                                                          FROM dbo.StationArticle
                                                          WHERE (SART_CodeArt = dbo.LigneTicket.LT_CodArt AND SART_CodeSatation = $station) )as Qte_Stock "))                                                                                            
                ->whereBetween('Ticket.TIK_DateHeureTicket', array($date1, $date2))
                ->where('SART_CodeSatation','LIKE','%'.$station.'%')
                               ->groupBy(DB::raw("LigneTicket.LT_CodArt,article.ART_Designation"))
                               ->orderBy('Qte_Stock', 'desc')
                               ->limit(100)
                               ->get();
                 
     $total_row = $results->count();
     ($total_row);
      if($total_row > 0){
         foreach($results as $article){
          $QteReell=$article->Qte_Stock-(+$article->Qte_Vendu);
          $out.= '<tr>
                    
                     <td>'.$article->Code_Art.'</td>
                     <td>'.$article->ART_Designation.'</td>
                     <td bgcolor="#0EB204">'.$article->Qte_Vendu.'</td>#FF0000
                     <td bgcolor="red"><font color="#FFFFFF">'.$article->Qte_Stock.'</font></td>
                     <td>'. $QteReell.'</td>
                   
                   </tr>';
              } 
      }
      else{ 
             $out .='<tr>
                         <td align="center" colspan="6">No Data Found</td>
                     </tr>';
        } 
   }
   /* $data = array(
    'table_data'  => $out); */
  return response($out);
  }
public function inventaireChart(Request $request){
  $station=$request->station;
  $date1=$request->date1;
  $date2=$request->date2;
  if($date2==null){
    $date2=date("m-d-Y H:i");
     }
  
  if($date1==null){
      $date1=date("01-01-2000 12:00");
       }
 
    if($station=="Tout"){
        $results = DB::table('LigneTicket')
        ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
        ->join('Ticket', function($join){ $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
                                          $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
                                          $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');})
        ->join('SessionCaisse', 'Ticket.TIK_IdSCaisse', '=', 'SessionCaisse.SC_IdSCaisse ')
        ->join('Caisse', 'SessionCaisse.SC_Caisse', '=', 'Caisse.CAI_IdCaisse')
        ->join('StationArticle', 'StationArticle.SART_CodeArt', '=', 'LigneTicket.LT_CodArt')
    
        ->select( DB::raw(" SUM(LigneTicket.LT_Qte) AS Qte_Vendu,LT_CodArt AS Code_Art,article.ART_Designation,
                                              ( SELECT  SUM(SART_Qte) AS Qte_Stock 
                                                 FROM dbo.StationArticle
                                                 WHERE (SART_CodeArt = dbo.LigneTicket.LT_CodArt)  ) as Qte_Stock"))                                                                                            
       ->whereBetween('Ticket.TIK_DateHeureTicket', array($date1, $date2))
                      ->groupBy(DB::raw("LigneTicket.LT_CodArt,article.ART_Designation"))
                      ->orderBy('Qte_Stock', 'desc')
                      ->limit(10)
                      ->get();
      return response()->json($results);           
        }
    else{
         
               $results = DB::table('LigneTicket')
                        ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
                        ->join('Ticket', function($join){ $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
                                                          $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
                                                          $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');})
                        ->join('SessionCaisse', 'Ticket.TIK_IdSCaisse', '=', 'SessionCaisse.SC_IdSCaisse ')
                        ->join('Caisse', 'SessionCaisse.SC_Caisse', '=', 'Caisse.CAI_IdCaisse')
                        ->join('StationArticle', 'StationArticle.SART_CodeArt', '=', 'LigneTicket.LT_CodArt')
                    
                        ->select( DB::raw(" SUM(LigneTicket.LT_Qte) AS Qte_Vendu,LT_CodArt AS Code_Art,article.ART_Designation,
                                                              ( SELECT  SUM(SART_Qte) AS Qte_Stock 
                                                                 FROM dbo.StationArticle
                                                                 WHERE (SART_CodeArt = dbo.LigneTicket.LT_CodArt AND SART_CodeSatation = $station) )as Qte_Stock "))                                                                                            
                       ->whereBetween('Ticket.TIK_DateHeureTicket', array($date1, $date2))
                       ->where('SART_CodeSatation','LIKE','%'.$station.'%')
                                      ->groupBy(DB::raw("LigneTicket.LT_CodArt,article.ART_Designation"))
                                      ->orderBy('Qte_Stock', 'desc')
                                      ->limit(10)
                                      ->get();
           return response()->json($results);               
         }

   }
   public function inventaireChart2(Request $request){
    $station=$request->station;
    $date1=$request->date1;
    $date2=$request->date2;
    if($date2==null){
      $date2=date("m-d-Y H:i");
       }
    
    if($date1==null){
        $date1=date("01-01-2000 12:00");
         }
   
      if($station=="Tout"){
          $results = DB::table('LigneTicket')
          ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
          ->join('Ticket', function($join){ $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
                                            $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
                                            $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');})
          ->join('SessionCaisse', 'Ticket.TIK_IdSCaisse', '=', 'SessionCaisse.SC_IdSCaisse ')
          ->join('Caisse', 'SessionCaisse.SC_Caisse', '=', 'Caisse.CAI_IdCaisse')
          ->join('StationArticle', 'StationArticle.SART_CodeArt', '=', 'LigneTicket.LT_CodArt')
      
          ->select( DB::raw(" SUM(LigneTicket.LT_Qte) AS Qte_Vendu,LT_CodArt AS Code_Art,article.ART_Designation,
                                                ( SELECT  SUM(SART_Qte) AS Qte_Stock 
                                                   FROM dbo.StationArticle
                                                   WHERE (SART_CodeArt = dbo.LigneTicket.LT_CodArt)  ) as Qte_Stock"))                                                                                            
         ->whereBetween('Ticket.TIK_DateHeureTicket', array($date1, $date2))
                        ->groupBy(DB::raw("LigneTicket.LT_CodArt,article.ART_Designation"))
                        ->orderBy('Qte_Vendu', 'desc')
                        ->limit(10)
                        ->get();
        return response()->json($results);           
          }
      else{
           
                 $results = DB::table('LigneTicket')
                          ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
                          ->join('Ticket', function($join){ $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
                                                            $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
                                                            $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');})
                          ->join('SessionCaisse', 'Ticket.TIK_IdSCaisse', '=', 'SessionCaisse.SC_IdSCaisse ')
                          ->join('Caisse', 'SessionCaisse.SC_Caisse', '=', 'Caisse.CAI_IdCaisse')
                          ->join('StationArticle', 'StationArticle.SART_CodeArt', '=', 'LigneTicket.LT_CodArt')
                      
                          ->select( DB::raw(" SUM(LigneTicket.LT_Qte) AS Qte_Vendu,LT_CodArt AS Code_Art,article.ART_Designation,
                                                                ( SELECT  SUM(SART_Qte) AS Qte_Stock 
                                                                   FROM dbo.StationArticle
                                                                   WHERE (SART_CodeArt = dbo.LigneTicket.LT_CodArt AND SART_CodeSatation = $station) )as Qte_Stock "))                                                                                            
                         ->whereBetween('Ticket.TIK_DateHeureTicket', array($date1, $date2))
                         ->where('SART_CodeSatation','LIKE','%'.$station.'%')
                                        ->groupBy(DB::raw("LigneTicket.LT_CodArt,article.ART_Designation"))
                                        ->orderBy('Qte_Stock', 'desc')
                                        ->limit(10)
                                        ->get();
             return response()->json($results);               
           }
  
     }
public function inventFilter(){
    $results = DB::table('LigneTicket')
    ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
    ->join('Ticket', function($join){ $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
                                      $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
                                      $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');})
    ->join('SessionCaisse', 'Ticket.TIK_IdSCaisse', '=', 'SessionCaisse.SC_IdSCaisse ')
    ->join('Caisse', 'SessionCaisse.SC_Caisse', '=', 'Caisse.CAI_IdCaisse')
    ->join('StationArticle', 'StationArticle.SART_CodeArt', '=', 'LigneTicket.LT_CodArt')

    ->select( DB::raw(" SUM(LigneTicket.LT_Qte) AS Qte_Vendu,LT_CodArt AS Code_Art,article.ART_Designation,
                                          ( SELECT  SUM(SART_Qte) AS Qte_Stock 
                                             FROM dbo.StationArticle
                                             WHERE (SART_CodeArt = dbo.LigneTicket.LT_CodArt) )as Qte_Stock "))                                                                                            
  
                  ->groupBy(DB::raw("LigneTicket.LT_CodArt,article.ART_Designation"))
                  ->orderBy('Qte_Stock', 'desc')
                  ->limit(100)
                  ->get();
                   /* return   Datatables::of($results)
                  ->make(true); */
                  $total_row = $results->count();
                  ($total_row);
                     if($total_row > 0){
                         
                      foreach($results as $article){
                       
                         $article->Qte_Reel=$article->Qte_Stock-(+$article->Qte_Vendu);}}
                 return response()->json($results);
   }
public function stockIndex(){
  if(Auth::check()){
  $todayDate = date("Y-m-d");
  $stations =     DB::table('station')
                     ->select('STAT_Desg','STAT_Code')
                     ->distinct()
                     ->get();
   return view('stock.stock',compact('stations','todayDate'),['title'=>"Valeur Stock"]);
 
  }
  else {  return Redirect::to('login'); }
  }
public function stockFilter(Request $request){
  $station=$request->station;
  $date1=$request->date1;
  $date2=$request->date2;
 
       $results = DB::table('LigneTicket')
       ->join('article', 'LigneTicket.LT_CodArt', '=', 'article.ART_Code')
       ->join('Ticket', function($join){ $join->on('LigneTicket.LT_NumTicket', '=', 'Ticket.TIK_NumTicket ');
                                         $join->on('LigneTicket.LT_Exerc', '=', 'Ticket .TIK_Exerc');
                                         $join->on('LigneTicket.LT_IdCarnet', '=', 'Ticket .TIK_IdCarnet');})
       ->join('SessionCaisse', 'Ticket.TIK_IdSCaisse', '=', 'SessionCaisse.SC_IdSCaisse ')
       ->join('Caisse', 'SessionCaisse.SC_Caisse', '=', 'Caisse.CAI_IdCaisse')
       ->join('StationArticle', 'StationArticle.SART_CodeArt', '=', 'LigneTicket.LT_CodArt')
   
       ->select( DB::raw(" SUM(LigneTicket.LT_Qte) AS Qte_Vendu,LT_CodArt AS Code_Art,article.ART_Designation,
                                             ( SELECT  SUM(SART_Qte) AS Qte_Stock 
                                                FROM dbo.StationArticle
                                                WHERE (SART_CodeArt = dbo.LigneTicket.LT_CodArt AND SART_CodeSatation = $station) )as Qte_Stock "))                                                                                            
      ->whereBetween('Ticket.TIK_DateHeureTicket', array($date1, $date2))
      ->where('SART_CodeSatation','LIKE','%'.$station.'%')
                     ->groupBy(DB::raw("LigneTicket.LT_CodArt,article.ART_Designation"))
                     ->orderBy('Qte_Stock', 'desc')
                     ->limit(20)
                     ->get();
                 /*  return   Datatables::of($results)
                  ->make(true); */
     //return response($results);
    return response()->json($results);
 }


public function logout(){
  Auth::logout(); // logging out user
  return Redirect::to('login');
      }
public function dataTable(){
  if(Auth::check()){
    $stations =     DB::table('station')->get();
    $familles=DB::table('famille')->get();
    $marques=DB::table('marque')->get();
    $fournisseurs=DB::table('fournisseur')->get();  
return view('test',['title'=>"DATA TABLE"]);
}
else {  return Redirect::to('login'); }
}
}