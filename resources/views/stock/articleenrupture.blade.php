@extends('back.layout')

@section('main')

<div class="form-group"> 
<body>
<div class="row">
<div class='col-md-2'>
       <label for="Select2">Famille</label>
       <select class="form-control" id="Select2"name="Select2">
          <option >Tout </option>
          @foreach($familles as $article)
            <option>{{$article->FAM_Lib}}</option>
          @endforeach 
       </select>
    </div>
    <div class='col-md-2'> 
       <label for="Select3">Marque</label>
       <select class="form-control" id="Select3"name="Select3">
         <option >Tout </option>
         @foreach($marques as $article)
            <option>{{$article->MAR_Designation}}</option>
          @endforeach
      
       </select>
    </div>
    <div class='col-md-4 '>
       
       <label for="submit">Visualiser</label><br>

        <button class="btn btn-primary btn-submit" onclick="changeFunc()">Visualiser</button>
       
    </div>
    <div class='col-md-4 col-md-offset-0'> 
    <b>10 Premiers articles en rupture</b>
    </div>
</div>
<div class="row">
 <div class='col-md-6'>
 
   <table class="table table-bordered table-hover" >
      <thead>
        <tr>
          <th>REF.Article</th>
          <th>Code à Bar</th>
          <th>Designation</th>
          <th>Qté min</th>
          <th>Qté Stock</th>
        </tr>
      </thead>
     
      <tbody  class="panel panel-default">
         @foreach($articles as $article)
          <tr>
            <td>{{$article->ART_Code}}</td>
            <td>{{$article->ART_CodeBar}}</td>
            <td>{{$article->ART_Designation}}</td>
            <td>{{$article->ART_QTEmin}}</td>
            <td>{{$article->ART_QteStock}}</td>
          </tr> 
         @endforeach 
       </tbody>
    </table>
    
  </div>
  <div class="col-md-6">
          <!-- <div class="panel panel-default">
               <div class="panel-heading"><b>Charts</b></div>
               <div class="panel-body">
                   <canvas id="canvas" height="390" width="600"></canvas>
               </div>
           </div> -->
           <div id="chart" class="se-pre-con">
              <div class="margin-0-auto text-center"><img src="../adminlte/img/user2-160x160.png" style="margin-bottom: 15px  height: auto;width: auto; max-width: 50px;max-height: 50px;" alt="">
                  <div translate="NO_DATA_TO_DISPLAY" class="text-center">Aucune donnée à afficher</div>
              </div>   
           </div>
   </div>
</div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
<script type="text/javascript">
 $.ajaxSetup({
   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }});
   $(".btn-submit").click(function(e){
       e.preventDefault();
       var famille = $("select[name=Select2]").val();
       var marque = $("select[name=Select3]").val();
       
     
       $.ajax({
         type:'get',
         url:'/filterrupture',
         data:{famille:famille, marque:marque},
        success:function(data){  
       // alert('success');
        $('tbody').html("waiting .........."); 
        $('tbody').html(data.table_data);  
         
       }
       });
   
    
       });
  
</script>
<script>
    //var jsonData = JSON.parse(articles);
      var chart = c3.generate({
    
    data: {
        /* json: jsonData, */
        url: 'http://127.0.0.1:8000/articleEnRupturechart',
        mimeType: 'json',
            keys: {
               x: 'ART_Designation', // it's possible to specify 'x' when category axis
               value: ['ART_QteStock'],
               },
            type:'bar'
        },
    axis: {
        y: {
        label: { // ADD
            text: '',
           },
      
        tick: {
          format: d3.format(".3f") // ADD
        },
        
        padding : {
              top : 1
            }
      },
            x: {
           
               type: 'category',
               
            }
        },
    bindto: '#chart'
});
</script>

<script type="text/javascript" >
function changeFunc() {
  var chart = c3.generate({
    
    data: {
    url: 'http://127.0.0.1:8000/filterarticleEnRupturechart/'+document.getElementById('Select2').value
        +'/'+document.getElementById('Select3').value,
   mimeType: 'json',
       keys: {
          x: 'ART_Designation',
           value: ['ART_QteStock'],
       },type:'bar'
},
axis: {
   y: {
   label: { // ADD
       text: '',
   },
 
   tick: {
     format: d3.format(".2f") // ADD
   },
   
   padding : {
         top : 1
       }
 },
       x: {
      
          type: 'category',
          
       }
   },bindto: '#chart'
}); 
}
</script>
@endsection

