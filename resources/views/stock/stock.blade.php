@extends('back.layout')

@section('main')


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
           <option value={{$station->STAT_Code}}>{{$station->STAT_Desg}}</option>
           @endforeach
       </select>
  </div>
  <div class='col-md-2'>
       
       <label for="submit">Visualiser</label><br>
       <button class="btn btn-primary btn-submit" onclick="changeFunc2()">Visualiser</button>
       
  </div>
 
</div>

<div class="row">
  <div class='col-md-6'>
 
  <!--  <table class="table table-bordered table-hover" >
      
   
      <tbody  class="panel panel-default">
        
       </tbody> 
    </table> -->
    <table id="articles" class="display nowrap" style="width:100%" data-order='[[ 1, "desc" ]]' data-page-length='2'>
                            <thead>
                            <tr>
                            
                            <th>Qte_Vendu
                                </th>
                                <th>Code_Art
                                </th>
                                <th>
                                ART_Designation
                                </th>
                                <th>Qte_Stock 
                                </th>
                               
                            </tr>
                            </thead>
            
                            <tbody>
                       
       
        
                            </tbody>
                         
                           
                        </table>

  </div>
  <div class="col-md-6">
         <!--  <span>Qté Stock</span> -->
           <div id="chart" class="se-pre-con">
          
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
    
      /*  $.ajax({
         type:'get',
         dataType: 'json', 
         url:'stockFilter1/'+station+'/'+date1+'/'+date2,
       // data:{station:station, date1:date1, date2:date2}, 
         success:function(msg){  
           alert(msg);
           alert(msg[0].INV_Code);
           var i=0;
          $("#articles").DataTable().rows().remove().draw();
			msg.forEach(function (m){
       
				$("#articles").DataTable().row.add([
          msg[0].INV_Code, msg[0].STAT_Desg,msg[0].STAT_user,msg[0].INV_Date,''
]).draw();
			})
          // $('table').html(data);   
          }
         }); */
    	});
</script>
<script type='text/javascript'>
 
 function disableInput(idInput, valeur){
     var input = document.getElementById(idInput);
     input.disabled = valeur;

     if (valeur) {
         input.style.color.background = "#CCC";
       //BSajoute(idInput); 
        } 
     else {
       document.getElementById("idInput").value="Tout";
       input.style.background = "#FFF";
 //BSsuppr(idInput);
     }
  }
  
 function enableInput(idInput, valeur) {
    var input = document.getElementById(idInput);
    input.enable = valeur;

    if (valeur) {
      input.style.background = "#FFF";
      document.getElementById("idInput").value="Tout";
    
       //BSsuppr(idInput);
     } 
    else {
      input.style.background = "#CCC";
      //BSajoute(idInput);
    }
  }
 </script>
<script >
    $(document).ready(function() {
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
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="http://cdn.datatables.net/responsive/1.0.0/js/dataTables.responsive.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  
  <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 
  <script type="text/javascript" src="DataTables/datatables.min.js"></script>


  <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/responsive/1.0.0/css/dataTables.responsive.css" />
 
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<!-- <script type="text/javascript" >
function changeFunc2() {

        var date1 = $("input[name=date1]").val();
        var date2 = $("input[name=date2]").val();
        var station = $("select[name=Select1]").val();
       alert(station);
 var url = 'http://127.0.0.1:8000/stockFilter1/001/2017-07-01%2000:00:00/2018-09-21%2000:00:00';

$.getJSON(url, function (data) {

  alert(data[0].INV_Code);
  $("#articles").DataTable().rows().remove().draw();
$.each(data, function (key, entry) {
 
	$("#articles").DataTable().row.add([
  entry.Qte_Vendu,entry.Code_Art,entry.ART_Designation,entry.Qte_Stock
]).draw();


})

}); 

   


}
</script> -->
<script >


  $('#articles').DataTable({
            processing: false,
            serverSide: true,
            ajax: 'http://127.0.0.1:8000/stockFilter1/001/2017-07-01%2000:00:00/2018-09-21%2000:00:00',
            columns: [
            { data: 'Qte_Vendu', name: 'Qte_Vendu' },
            { data: 'Code_Art', name: 'Code_Art' },
            { data: 'ART_Designation', name: 'ART_Designation' },
            { data: 'Qte_Stock', name: 'Qte_Stock' }
        ]
          }).draw();

</script>
@endsection
