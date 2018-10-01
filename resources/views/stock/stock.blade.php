@extends('back.layout')

@section('main')
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
<script src="https://cdn.datatables.net/dataTabletools/3.1.5/css/dataTables.dataTabletools.css"></script>
<script src="https://cdn.datatables.net/dataTabletools/3.1.5/js/dataTables.dataTabletools.min.js"></script>
<script>
$(document).ready(function() {
   var table = $('#articles').DataTable( );
   var tabletools=new $.fn.dataTable.TableTools(table);
   $(tabletools.fnContainer().insertBefor('content container-fluid'))
} );
</script>
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
       <button class="btn btn-primary btn-submit"  id="ajaxLoad">Visualiser</button>
       
  </div>
 
</div>

<div class="row">
  <div class='col-md-6'>
    <table id="articles" class="display nowrap" style="width:100%" data-order='[[ 1, "desc" ]]' data-page-length='10'>
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
            
                            <tbody  class="panel panel-default">
                       
       
        
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
    var table = $(".display tbody");
    $.ajax({
        url: 'http://127.0.0.1:8000/stockFilter/'+station+'/'+date1+'/'+date2,
        method: "GET",
        xhrFields: {
            withCredentials: true
        },
        success: function (data) {
          //alert(data);
            table.empty();
            table.append({
              "searching": true,
              "lengthChange": false,
              "bPaginate": true,
              "bInfo": false,});
            $.each(data, function (a, b) {
                table.append("<tr><td>"+b.Qte_Vendu+"</td>"+
                    "<td>" + b.Code_Art + "</td>" +
                    "<td>" + b.ART_Designation + "</td>" +
                    "<td>" + b.Qte_Stock + "</td></tr>");
            });
 
            $(".display").DataTable();
        }
    });


  
  var chart = c3.generate({
    
    data: {
    url: 'http://127.0.0.1:8000/stockFilter/'+station+'/'+date1+'/'+date2,
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
});
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



<!-- <script >
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
     

</script> --> 
<script >
var date1=new Date();
var date2=new Date();
var station="001";

     $.fn.dataTable.ext.errMode = 'throw';
      $('#articles').DataTable( {
        "searching": false,
        "lengthChange": false,
        "bPaginate": true,
        "bInfo": false,
        "language": {
          "loadingRecords": "No records available...",
          "infoEmpty": "No records available"
        },
         "ajax": {
             "url":'http://127.0.0.1:8000/stockFilter/'+station+'/'+date1+'/'+date2,
             "dataSrc": ""
         },

        "columns": [
           { data: 'Qte_Vendu', name: 'Qte_Vendu'},
            { data: 'Code_Art', name: 'Code_Art' },
            { data: 'ART_Designation', name: 'ART_Designation' },
            { data: 'Qte_Stock', name: 'Qte_Stock' }
        ]
    } );
   

</script>
@endsection
