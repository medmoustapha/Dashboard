@extends('back.layout')

@section('main')

<!-- You need an element with an id called "chart" to set a place where your chart will render-->
<!-- <div id="chart"></div> -->
<div class="content">
<div class="row">
<div class='col-md-4'>
<h3 class="text-primary">Total des Ventes par commercial :</h3>
</div>
<div class='col-md-4'>
      <div class="form-group">
      <label for="sel1">Choisir La Période:</label>

<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div>
      </div>
      </div>
      <div class="col-md-4">
      <div class="form-group">
      <label for="sel1">Valider:</label>
    <div class="form-group mx-sm-3 mb-2">
        <button type="button" class="btn btn-primary mb-2" onclick="changeFunc()">Valider</button>
</div>
</div>
</div>
</div>
<br>
<div class="row" id="chart" style="display: none;">
    <div   id="chart6"  >   
</div> 
<br>
<div class="row">           
                <div style="display: none;" id="z">
                <h3 class="text-primary">Total des Tickets Annulés En Dinar </h3>

                    <h2> <div class="col-sm-12" id="a">0</div></h2>
                    <div class="col-sm-12">
                         <table id="example2" class="display nowrap" style="width:100%">
                            <thead>
                            <tr>
                              <th></th>
                            <th>Nom Du Commercial
                                </th>
                                <th>Chiffre D'affaire Annulés
                                </th>
                            </tr>
                            </thead>
                            <tbody>                   
                            </tbody>       
                        </table>
                        </div>
                    </div>
                </div>  
</br>
<div class="row">
  <select id ="select2" name ="select2" class="selectpicker" data-live-search="true"> 
<option>choisir Commercial</option>
</select>
<select id ="select1" name ="select1" class="selectpicker" data-live-search="true"> 
<option>Details</option>
<option>Par Article</option>
<option>Par Client</option>

</select>
<button type="button" class="btn btn-primary mb-2" onclick="changeFunc2()">Valider</button>

  </div>
</div> 
<div class="row">

<div   id="load" style="display: none;" >
   
<i class="fa fa-spinner fa-spin" style=" position: fixed;
  z-index: 999;
  height: 4em;
  width: 4em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;">Loading</i>
              </div>                 
           </div>   
                          
<br>
  <div class="row"  style="display: none;" id="r">
  <h2>Details par article</h2>

                    <div class="col-sm-12">
  <table id="article" class="display nowrap" style="width:100%">
                            <thead>
                            <tr>
                              <th></th>
                            <th>Article
                                </th>
                                <th>Total Vente En Dinar
                                </th>
                                <th>
                                Coût d'achat en dinar
                                </th>
                                <th>Marge de Gain En Dinar 
                                </th>
                                <th>% Marge
                                </th>
                            </tr>
                            </thead>
                            <tfoot>
            <tr>
                <th colspan="2" style="text-align:right">Total En Dinar:</th>
                <th></th>
            </tr>
        </tfoot>
                            <tbody>
                            
                            </tbody>
                         
                           
                        </table>
                        </div>
                        </div>
                     
                        <br>
                      
                        <div class="row" style="display: none;" id="m">
                        <h2>Details par Client</h2>

                    <div class="col-sm-12">
  <table id="client" class="display nowrap" style="width:100%">
                            <thead>
                            <tr>
                              <th></th>
                            <th>Client
                                </th>
                                </th>
                                <th>Total Vente En Dinar
                                </th>
                                <th>Coût d'achat en dinar
                                </th>
                                <th>Marge de Gain En Dinar 
                                </th>
                                <th>% Marge
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                            <tfoot>
            <tr>
                <th ></th>
                <th></th>
                <th ></th>
                <th></th><th ></th>
                <th></th>
            </tr>
        </tfoot>
                           
                        </table>
                        </div>
                        </div>
                    
                        </div>
  </html>

<script type="text/javascript" >
function changeFunc2() {
///////////////////////////////////////////////////////////Vente PAr article////////////////////////  
    var from= $("#reportrange").data('daterangepicker').startDate.format('YYYY-MM-DD HH:mm:ss');
    var to=$("#reportrange").data('daterangepicker').endDate.format('YYYY-MM-DD HH:mm:ss');
    let dropdown = $('#select2');
    let dropdown1 = $('#select1');

if($('select[name="select1"]').val()=="Par Article"){
     $('#r').attr('style','display: block');
     $('#m').attr('style','display: none');
    var table = $('#article').DataTable( {
        
        destroy: true,
        aLengthMenu: [
        [0,25, 50, 100, 200, -1],
        [0,25, 50, 100, 200, "All"]
    ],
    dom: 'lBfrtip', select: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'asc' ],
     
    iDisplayLength: -1,
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 2 ).footer() ).html(
                pageTotal +' ( '+ total +' total)'
            );
        }
   
    } );
    

    $('#article').show();
    com=   $('select[name="select2"]').val();
const url = '/CaParCommercialByArticle/'+from+'/'+to+'/'+com;
// Populate dropdown with list of provinces
$.getJSON(url, function (data) {
    $("#article").DataTable().rows().remove().draw();
$.each(data, function (key, entry) {
    marge =numeral(( entry.TotalVente- entry.TotalAchat)).format('0,0.000');
    pour =numeral((marge/entry.TotalVente)*100).format('0,0');
    pour+="%";
	$("#article").DataTable().row.add([
   '', entry.ART_Designation,numeral( entry.TotalVente).format('0,0.000'), numeral(entry.TotalAchat).format('0,0.000'),marge,pour
]).draw();

})



});
}
////////////////////////////vente par client//////////////////////////////
else
if($('select[name="select1"]').val()=="Par Client"){
    $('#m').attr('style','display: block');
    $('#r').attr('style','display: none');

     var table = $('#client').DataTable( {
        destroy: true,
        aLengthMenu: [
        [0,25, 50, 100, 200, -1],
        [0,25, 50, 100, 200, "All"]
    ],
    dom: 'lBfrtip', select: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'asc' ],
     
    iDisplayLength: -1,
    "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
       
	    var tueTotal = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b)+'Dinar';
                }, 0 );
			
            // Update footer by showing the total with the reference of the column index 
	    $( api.column( 1 ).footer() ).html('Total');
            $( api.column( 2 ).footer() ).html(tueTotal);
        
        }
   
    } );


com=   $('select[name="select2"]').val();
const url = '/CaParCommercialByClient/'+from+'/'+to+'/'+com;

// Populate dropdown with list of provinces
$.getJSON(url, function (data) {
    $("#client").DataTable().rows().remove().draw();
$.each(data, function (key, entry) {
    marge =numeral(( entry.TotalVente- entry.TotalAchat)).format('0,0.000');
    pour =numeral((marge/entry.TotalVente)*100).format('0,0');
    pour+="%";
    
	$("#client").DataTable().row.add([
   '', entry.CLI_NomPren,numeral( entry.TotalVente).format('0,0.000'), numeral(entry.TotalAchat).format('0,0.000'),marge,pour,''
]).draw();

})



});
}
}
function changeFunc() {

    $('#load').attr('style','display: block');
    $('#chart').attr('style','display: none');
    $('#chart6').attr('style','display: none');
    $('#z').attr('style','display: none');
    $('#m').attr('style','display: none');
    $('#r').attr('style','display: none');
  //////////////////////////////////get request time/////////////////
    var from= $("#reportrange").data('daterangepicker').startDate.format('YYYY-MM-DD HH:mm:ss');
    var to=$("#reportrange").data('daterangepicker').endDate.format('YYYY-MM-DD HH:mm:ss');
    var start_time = new Date().getTime();

jQuery.get('/CaParCommercial/'+from+'/'+to,
    function(data, status, xhr) {
        var request_time = new Date().getTime() - start_time;
        
  setTimeout(function() {
    // rest of code here

    $('#load').attr('style','display: none');
    $('#z').attr('style','display: block');
    $('#chart').attr('style','display: block');
    $('#chart6').attr('style','display: block');
}, request_time); }
   
);
///////////////////////////////////////////////////////////////////////////
    var table = $('#example2').DataTable( {
        destroy: true,
        lengthChange: false,
        dom: 'Bfrtip', select: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'asc' ]
    } );
 
  var from= $("#reportrange").data('daterangepicker').startDate.format('YYYY-MM-DD HH:mm:ss');
  var to=$("#reportrange").data('daterangepicker').endDate.format('YYYY-MM-DD HH:mm:ss');
  var chart = c3.generate({
    data: {
        url: '/CaParCommercial/'+from+'/'+to,
        
        mimeType: 'json',
            keys: {
              
               x: 'TIK_DESIG_COMMERCIAL', // it's possible to specify 'x' when category axis
                value: ['TotalVente'],
            }
    }, line: {
    connectNull: false,
},
    axis: {
        y: {
        label: { // ADD
            text: 'Total des Ventes En Dinar',
        },
      
        tick: {
          format: d3.format(".3f") // ADD
        }
      },
     
            x: {
           
               type: 'category'
            }
        },bindto: '#chart6'
});

///////////////////////totale des ticket Annuler//////////////////////////////
$.getJSON('/TotalVenteAnnulerfilter/'+from+'/'+to, function(data)
  {
    var TotalVenteAnnuler=data[0].TotalVenteAnnuler;
    document.getElementById("a").innerHTML =numeral(TotalVenteAnnuler).format('0,0.000');
 

  })
/////////////////////////////////////////////remplir Commercial Tiket Annuler////////////////////////
  $.ajax({
		type: "GET", //rest Type
		dataType: 'json', //mispelled
		url: '/CaAnnulerParCommercial/'+from+'/'+to,
		async: true,

		contentType: "application/json; charset=utf-8",
		success: function (msg) {
        
         $("#example2").DataTable().rows().remove().draw();
			msg.forEach(function (m/*, index */){
                
				$("#example2").DataTable().row.add([
   '', m.TIK_DESIG_COMMERCIAL, m.TotalVente
]).draw();
			})
		}
	});
/////////////////////////Remplir Commercial list//////////////////////////
$('#select2').selectpicker('refresh');
let dropdown = $('#select2');

dropdown.empty();

dropdown.append('<option selected="true" disabled>select Commercial</option>');
dropdown.prop('selectedIndex', 0);

const url = '/CaParCommercial/'+from+'/'+to;

// Populate dropdown with list of provinces
$.getJSON(url, function (data) {

$.each(data, function (key, entry) {

dropdown.append($('<option></option>').attr('value', entry.TIK_DESIG_COMMERCIAL).text(entry.TIK_DESIG_COMMERCIAL));
})
$('#select2').selectpicker('refresh');


});


}
</script>
<script type="text/javascript">
$(function() {

var start = moment().startOf('day'); // This will return a copy of the Date that the moment uses

var end =  moment().endOf('day'); // This will return a copy of the Date that the moment uses

  

    function cb(start, end) {
        $('#reportrange span').html(start.format('YYYY-MM-DD HH:mm:ss') + ' - ' + end.format('YYYY-MM-DD  HH:mm:ss'));
            }

    $('#reportrange').daterangepicker({

        startDate: start,
        endDate: end,
        timePicker:true,
        timePicker24Hour:true,
        timePickerSeconds:true,
        showDropdowns:true,
        ranges: {
           "Aujourd'hui": [moment(), moment()],
           'Hier': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
           'Les 7 derniers jours': [moment().subtract(6, 'days'), moment()],
           'Les 30 derniers jours': [moment().subtract(29, 'days'), moment()],
           'Ce mois-ci': [moment().startOf('month'), moment().endOf('month')],
           'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           '365 derniers jours': [moment().subtract(1, 'year').startOf('days')],
           "L'année dernière": [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]

        }
    }, cb);

    cb(start, end);

});
</script>


@endsection
