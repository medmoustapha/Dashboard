@extends('back.layout')

@section('main')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<body>

 <div class="form-group">

<div class="row">
  <div class='col-md-6 panel panel-default'>
   
    <fieldset>
       <legend>Periode </legend>
   
         <!--   <input name="active" id="idactive" onclick="disableInput('date1', this.checked);" type="checkbox" />
           De: 
          <input name="date1" id="date1" type="date" data-provide="datepicker"/><br>
          <input name="active" id="idactive" onclick="disableInput('date2', this.checked);" type="checkbox" />
          Au: 
          <input name="date2" id="date2" type="date" /> -->
       <div class="container">
          <div class='col-md-3'>
            <div class="form-group">
              <div class='input-group date' id='datetimepicker1'>
                
                <input type='text' class="form-control" value={{$todayDate}} name="date1" id="date1"/>
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
           <div class="form-group">
             <div class='input-group date' id='datetimepicker2' >
                <input type='text' class="form-control"  value='{{$todayDate}}' name="date2" id="date2"required/>
                <span class="add-on"><i class="icon-remove"></i></span>
                <span class="input-group-addon">
                       
                        <span class="glyphicon glyphicon-calendar"></span>
                </span>
             </div>
           </div>
          </div>
      </div>
    </fieldset> 
  </div>   
    <div class='col-md-2'>
       <label for="Select5">Station </label>
       <select class="form-control" id="Select1"name="Select1" id="Select1">
          <option value="Tout">Tout </option>
           @foreach($stations as $station)
          <option value={{$station->STAT_Code}}>{{$station->STAT_Desg}}</option>
           @endforeach
       </select>
    </div>
    <div class='col-md-2'>
       
       <label for="submit">Visualiser</label><br>
        <button class="btn btn-primary btn-submit" onclick="changeFunc()">Visualiser</button>
       
    </div>
 
</div>

<div class="row">
  <div class='col-md-6'>
 
   <table class="table table-bordered table-hover" >
      
    </table>

   </div>
   <div class="col-md-6">
         <!--  <span>Qté Stock</span> -->
           <div id="chart" class="se-pre-con">
          
              <div class="margin-0-auto text-center"><img src="../adminlte/img/user2-160x160.png" style="margin-bottom: 15px  height: auto;width: auto; max-width: 50px;max-height: 50px;" alt="">
                  <div translate="NO_DATA_TO_DISPLAY" class="text-center"></div>
              </div>   
           </div>
           <!-- <span>Qté Vendu</span> -->
           <div id="chart1" class="se-pre-con">
           
              <div class="margin-0-auto text-center"><img src="../adminlte/img/user2-160x160.png" style="margin-bottom: 15px  height: auto;width: auto; max-width: 50px;max-height: 50px;" alt="">
                  <div translate="NO_DATA_TO_DISPLAY" class="text-center"></div>
              </div>   
           </div>
   </div>
</div>
</div>
  

</body>
<script type="text/javascript">
 $.ajaxSetup({
   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }});
   $(".btn-submit").click(function(e){
       e.preventDefault();
  
      
       var date1 = $("input[name=date1]").val();
       var date2 = $("input[name=date2]").val();
       var station = $("select[name=Select1]").val();
          
      // alert(date1);
      /*  alert(date2);  */
       //alert(station);   
       $.ajax({
         type:'get',
         url:'/inventaireFilter',
         data:{station:station, date1:date1, date2:date2},
        success:function(data){  
         // alert('test');
       // alert(data);
          $('table').html(data);  
        }

        });


	});

</script>
<script type='text/javascript'>
 
 function disableInput(idInput, valeur)
 {
 var input = document.getElementById(idInput);

 input.disabled = valeur;

 if (valeur) {
 input.style.color.background = "#CCC";
 //BSajoute(idInput);
 } else {
    document.getElementById("idInput").value="Tout";
 input.style.background = "#FFF";
 //BSsuppr(idInput);
 }
 }
  
 function enableInput(idInput, valeur)
 {
 var input = document.getElementById(idInput);
 input.enable = valeur;

 if (valeur) {
 input.style.background = "#FFF";
 document.getElementById("idInput").value="Tout";
    
 //BSsuppr(idInput);
 } else {
 input.style.background = "#CCC";
 //BSajoute(idInput);
 }
 }
 </script>
<script >
    $(document).ready(function() {
     /*  format:'DD-MM-YYYY HH:mm:ss',todayBtn: true,autoclose: true */
  $(function() {
    $('#datetimepicker1').datetimepicker({format:'YYYY-MM-DD HH:mm:ss'});
    $('#datetimepicker2').datetimepicker({
     
      format:'YYYY-MM-DD HH:mm:ss',
      useCurrent: false //Important! See issue #1075
    });
    $("#datetimepicker1").on("dp.change", function(e) {
      $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker2").on("dp.change", function(e) {
      $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });
  });
});
</script>
<script type="text/javascript" >
function changeFunc() {
  /* alert(document.getElementById('Select1').value
        +'/'+document.getElementById('date1').value+'/'+document.getElementById('date2').value); */
  var chart = c3.generate({
    
    data: {
    url: 'http://127.0.0.1:8000/inventaireChart/'+document.getElementById('Select1').value
        +'/'+document.getElementById('date1').value+'/'+document.getElementById('date2').value,
   mimeType: 'json',
       keys: {
          x: 'ART_Designation',
           value: ['Qte_Stock'],
       },type:'bar'
},
axis: {
   y: {
   label: { // ADD
       text: 'Qté Stock',
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
var chart = c3.generate({
    
    data: {
    url: 'http://127.0.0.1:8000/inventaireChart/'+document.getElementById('Select1').value
        +'/'+document.getElementById('date1').value+'/'+document.getElementById('date2').value,
   mimeType: 'json',
       keys: {
          x: 'ART_Designation',
           value: ['Qte_Vendu'],
       },type:'line'
},
axis: {
   y: {
   label: { // ADD
       text: 'Qté Vendu',
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
   },bindto: '#chart1'
}); 
}
</script>
@endsection
