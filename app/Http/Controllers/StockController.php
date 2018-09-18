<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class StockController extends Controller
{
public function index(){
        $stations =     DB::table('station')->get();
        $familles=DB::table('famille')->get();
        $marques=DB::table('marque')->get();
        $fournisseurs=DB::table('fournisseur')->get();  
  return view('stock.articleParStation',compact('stations','familles','marques','fournisseurs'),['title'=>"Article Par Station"]);
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
    $stations =     DB::table('station')->get();
    $familles=DB::table('famille')->get();
    $marques=DB::table('marque')->get();
    $fournisseurs=DB::table('fournisseur')->get();

              return view('stock.valeurStock',compact('stations','familles','marques','fournisseurs'),['title'=>"Liste des stocks articles / station"]);
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
        $puhttotal+=$article->ART_PrixUnitaireHT;
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
        $out.= '<tr>
            <div class=col-md-1><td colspan=5><center><b>Toutal</b></center></td></div>
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
  $famille=$request->get('famille');
  $marque=$request->get('marque');
 
  
  if($famille == "Tout" and $marque== "Tout" ){
    $articles =     DB::table('article_marque_famille')
                        ->orderBy('ART_QteStock', 'asc')
                        ->limit(10)
                        ->get();
      return response()->json($articles);   
    }
  elseif($famille !='Tout' and $marque=='Tout'){
      $articles =     DB::table('article_marque_famille')
                        ->where('FAM_Lib',$famille)
                        ->orderBy('ART_QteStock', 'asc')
                        ->limit(10)
                        ->get();
       return response()->json($articles);
    }
  elseif($famille =='Tout' and $marque!='Tout'){
      $articles =     DB::table('article_marque_famille')
                         ->where('MAR_Designation',$marque)
                         ->orderBy('ART_QteStock', 'asc')
                         ->limit(10)
                         ->get();
      return response()->json($articles);

    }
  else{
      $articles =     DB::table('article_marque_famille')
      ->where('MAR_Designation',$marque)
      ->where('FAM_Lib',$famille)
      ->orderBy('ART_QteStock', 'asc')
      ->limit(10)
      ->get();
  
      return response()->json($articles);
    }
    return response()->json($articles);
}
public function inventaireIndex(){
               $todayDate = date("Y-m-d");
               $stations =     DB::table('station')
                                  ->select('STAT_Desg')
                                  ->distinct()
                                  ->get();
   return view('stock.inventairjournalier',compact('stations','todayDate'),['title'=>"Inventaire Journalier"]);
 }
public function inventaireFilter(Request $request){
  $date1=$request->get('date1');
  $date2=$request->get('date2');
  $station=$request->get('station');
  $out='<thead>
                 <tr>
                 <th>INV_Date</th>
                 <th>INV_Etat</th>
                 <th>Designation</th>
                 <th>INV_Station</th>
                 <th>STAT_Etat</th>
                 </tr>
       </thead>';
  if($station=="Tout"){
     $results=DB::table('View_InventaireSation')
                  ->get();
                $total_row = $results->count();
            ($total_row);
               if($total_row > 0){
                   
                foreach($results as $article){
           
                  $out.= '<tr>
                             <td>'.$article->INV_Date.'</td>
                             <td>'.$article->INV_Etat.'</td>
                             <td>'.$article->INV_Station.'</td>
                             <td>'.$article->STAT_Desg.'</td>
                             <td>'.$article->STAT_Etat.'</td>
                           </tr>';
                 } }
               else{ 
                  $out .='<tr>
                        <td align="center" colspan="6">No Data Found</td>
                      </tr>';
              } 

                
   }
  else{
    $results=DB::table('View_InventaireSation')
                 ->where('STAT_Desg','LIKE','%'.$station.'%')
                 ->get();
                 
     $total_row = $results->count();
     ($total_row);
      if($total_row > 0){
         foreach($results as $article){
             $out.= '<tr>
                              <td>'.$article->INV_Date.'</td>
                              <td>'.$article->INV_Etat.'</td>
                              <td>'.$article->INV_Station.'</td>
                              <td>'.$article->STAT_Desg.'</td>
                              <td>'.$article->STAT_Etat.'</td>
                            </tr>';} 
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
public function stockIndex(){
  $todayDate = date("Y-m-d");
  $stations =     DB::table('station')
                     ->select('STAT_Desg')
                     ->distinct()
                     ->get();
return view('stock.stock',compact('stations','todayDate'),['title'=>"Valeur Stock"]);
}
public function stockFilter(Request $request){
  $date1=$request->get('date1');
  $date2=$request->get('date2');
  $station=$request->get('station');
  $out='<thead>
                 <tr>
                 <th>INV_Date</th>
                 <th>INV_Etat</th>
                 <th>Designation</th>
                 <th>INV_Station</th>
                 <th>STAT_Etat</th>
                 </tr>
       </thead>';
  if($station=="Tout"){
     $results=DB::table('View_InventaireSation')
                  ->get();
                $total_row = $results->count();
            ($total_row);
               if($total_row > 0){
                   
                foreach($results as $article){
           
                  $out.= '<tr>
                             <td>'.$article->INV_Date.'</td>
                             <td>'.$article->INV_Etat.'</td>
                             <td>'.$article->INV_Station.'</td>
                             <td>'.$article->STAT_Desg.'</td>
                             <td>'.$article->STAT_Etat.'</td>
                           </tr>';
                 } }
               else{ 
                  $out .='<tr>
                        <td align="center" colspan="6">No Data Found</td>
                      </tr>';
              } 

                
   }
  else{
    $results=DB::table('View_InventaireSation')
                 ->where('STAT_Desg','LIKE','%'.$station.'%')
                 ->get();
                 
     $total_row = $results->count();
     ($total_row);
      if($total_row > 0){
         foreach($results as $article){
             $out.= '<tr>
                              <td>'.$article->INV_Date.'</td>
                              <td>'.$article->INV_Etat.'</td>
                              <td>'.$article->INV_Station.'</td>
                              <td>'.$article->STAT_Desg.'</td>
                              <td>'.$article->STAT_Etat.'</td>
                            </tr>';} 
      }
       else{ 
             $out .='<tr>
                         <td align="center" colspan="6">No Data Found</td>
                     </tr>';
        } 
   }
   
return response($out);
}
}