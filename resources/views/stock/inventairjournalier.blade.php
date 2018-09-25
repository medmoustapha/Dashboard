@extends('back.layout')

@section('main')



<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
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
<script src="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"></script>

<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>

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
  <div class='col-md-8'>
 
   <table  id="articles" class="display nowrap"  data-order='[[ 1, "desc" ]]' data-page-length='10'>
   <thead  >
                            <tr>
                            <th>
                            Code_Art
                                </th>
                            <th>
                            ART_Designation
                                </th>
                            <th>Qte_Vendu
                                </th>
                               
                               
                                <th>Qte_Stock
                                </th>
                                <th>Qté  Reel
                                </th>
                            </tr>
                            </thead>
            
                            <tbody  class="panel panel-default">
                       
       
        
                            </tbody>
    </table>

   </div>
   <div class="col-md-4">
         <!--  <span>Qté Stock</span> -->
           <div id="chart" class="se-pre-con">
          
              <div class="margin-0-auto text-center">
                  <div translate="NO_DATA_TO_DISPLAY" class="text-center"></div>
              </div>   
           </div>
           <!-- <span>Qté Vendu</span> -->
           <div id="chart1" class="se-pre-con">
           
              <div class="margin-0-auto text-center">
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
        
       $.ajax({
         type:'get',
         url:'/inventaireFilter',
         data:{station:station, date1:date1, date2:date2},
        success:function(data){  
        
          $('table').html(data);  
        }

        });


	});

</script>
<script >
    $(document).ready(function() {
    
  $(function() {
    $('#datetimepicker1').datetimepicker({format:'YYYY-MM-DD HH:mm:ss'});
    $('#datetimepicker2').datetimepicker({
     
      format:'YYYY-MM-DD HH:mm:ss',
      useCurrent: false 
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
    url: 'http://127.0.0.1:8000//inventaireChart2/'+document.getElementById('Select1').value
        +'/'+document.getElementById('date1').value+'/'+document.getElementById('date2').value,
   mimeType: 'json',
       keys: {
          x: 'ART_Designation',
           value: ['Qte_Vendu'],
       },type:'bar'
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
<script >
     $.fn.dataTable.ext.errMode = 'throw';
      $('#articles').DataTable( {
       
        "lengthChange": true,
        
        "bInfo": false,
        "ajax": {
             "url":'http://127.0.0.1:8000/inventFilter',
             "dataSrc": ""
          },
        "language": {
           "loadingRecords": "Please wait - loading..."
               },
        "columns": [
            { data: 'Code_Art', name: 'Code_Art'},
            { data: 'ART_Designation', name: 'ART_Designation' },
            { data: 'Qte_Vendu', name: 'Qte_Vendu' },
            { data: 'Qte_Stock', name: 'Qte_Stock' },
            { data: 'Qte_Reel', name: 'Qte_Reel' }
        ]
    } );
   
    $(".btn-submit").click(function() {
    $('#articles').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );
</script>
@endsection
