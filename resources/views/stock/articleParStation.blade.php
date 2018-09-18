@extends('back.layout')

@section('main')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<body>

 <div class="form-group">

 <div class="row">
    <div class='col-md-4'>
      <label for="Select1">Station</label>
      <select class="form-control" id="Select1"name="Select1">
        <option>Tout </option>
        @foreach($stations as $station)
        <option>{{$station->STAT_Desg}}</option>
        @endforeach 
      </select>
    </div>
    <div class='col-md-4'>
       <label for="Select2">Famille</label>
       <select class="form-control" id="Select2"name="Select2">
          <option >Tout </option>
          @foreach($familles as $article)
            <option>{{$article->FAM_Lib}}</option>
          @endforeach 
       </select>
    </div>
    <div class='col-md-4'> 
       <label for="Select3">Marque</label>
       <select class="form-control" id="Select3"name="Select3">
         <option >Tout </option>
         @foreach($marques as $article)
            <option>{{$article->MAR_Designation}}</option>
          @endforeach
      
       </select>
    </div>
 </div>
 <div class="row">
    <div class='col-md-4'>
      <label for="Select4">Fournisseur</label>
      <select class="form-control" id="Select4"name="Select4">
        <option >Tout </option>
        @foreach($fournisseurs as $article)
            <option>{{$article->FRS_Nomf}}</option>
          @endforeach
      </select>
    </div>
    
    <div class='col-md-4'>
      <label for="Select5">Qtes Afficher</label>
      <select class="form-control" id="Select5"name="Select5">
        <option value=2>Tout </option>
        <option value=0>Inférieur a 0</option>
        <option value=1>Supérieur a 0</option>
      </select>
    </div>
    <div class='col-md-4'>
       
       <label for="submit">Visualiser</label><br>
        <button class="btn btn-primary btn-submit">Visualiser</button>
       
    </div>
 
</div>

 <table class="table table-bordered table-hover" >
    
    <thead>
      <tr>
       <th>Code</th>
        <th>Désignation</th>
        <th>Famille</th>
        <th>Marque</th>
        <th>Qté</th>
      </tr>
    </thead>
    <tbody>
      
  
    </tbody>
 </table>

 </div>
  

</body>
<script type="text/javascript">
 $.ajaxSetup({
   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }});
   $(".btn-submit").click(function(e){
       e.preventDefault();
  
       var station = $("select[name=Select1]").val();
       var famille = $("select[name=Select2]").val();
       var marque = $("select[name=Select3]").val();
       var fournisseur = $("select[name=Select4]").val();  
       var QteAfficher = $("select[name=Select5]").val();    
       //alert(QteAfficher);  
       $.ajax({
         type:'get',
         url:'/articleStation',
         data:{station:station, famille:famille, marque:marque, QteAfficher:QteAfficher, fournisseur:fournisseur},
        success:function(data){  
         // alert('test');
          alert(data);
          $('tbody').html(data);  
        }

        });



	});

</script>

@endsection
