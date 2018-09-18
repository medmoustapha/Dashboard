@extends('back.layout')

@section('main')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<body>

 <div class="form-group">

<div class="row">
  <div class='col-md-6 panel panel-default'>
   
    <fieldset>
       <legend>Periode </legend>
   
       <div class="container">
          <div class='col-md-3'>
            <div class="form-group">
              <div class='input-group date' id='datetimepicker1'>
              
                <input type='text' class="form-control" value={{$todayDate}} name="date1" />
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
           <div class="form-group">
             <div class='input-group date' id='datetimepicker2' >
                <input type='text' class="form-control" value='{{$todayDate}}' name="date2" />
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
       <select class="form-control" id="Select1"name="Select1">
           @foreach($stations as $station)
          <option>{{$station->STAT_Desg}}</option>
           @endforeach
       </select>
    </div>
    <div class='col-md-2'>
       
       <label for="submit">Visualiser</label><br>
        <button class="btn btn-primary btn-submit">Visualiser</button>
       
    </div>
 
</div>

<div class="row">
  <div class='col-md-6'>
 
   <table class="table table-bordered table-hover" >
      
     <!-- 
      <tbody  class="panel panel-default">
        
       </tbody> -->
    </table>

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
          
       alert(date1);
      /*  alert(date2);  */
       alert(station);   
       $.ajax({
         type:'get',
         url:'stockFilter',
         data:{station:station, date1:date1, date2:date2},
        success:function(data){  
         // alert('test');
        alert(data);
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
  $(function() {
    $('#datetimepicker1').datetimepicker();
    $('#datetimepicker2').datetimepicker({
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
@endsection
