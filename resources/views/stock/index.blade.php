@extends('back.layout')

@section('main')
<table class="table table-bordered table-hover" >
    
    <thead>
      <tr>
       <th>Code_FR</th>
        <th>Nom_FR</th>
        <th>Telephone_FR</th>
        <th>Solde_FR</th>
      </tr>
    </thead>
    <tbody >
      
   @foreach($articlesStation as $article)
      
     <tr>
        <td>{{$article['ART_CodeBar']}}</td>
        <td>{{$article['ART_Designation']}}</td>
        <td>{{$article['FAM_Lib']}}</td>
        <td>{{$fourn['MAR_Designation']}}</td>
      </tr> 
    @endforeach 
    </tbody>
</table>
@endsection