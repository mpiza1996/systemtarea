<div id="header">
  <div class="container">
    <div class="row">
      <div class="col-md-12"  style="margin-left: 50px;margin-right: 50px;">
          <table class="responsive" style="font-size:11px; ">
            <tr>
              <th colspan="4" style="font-size:16px; font-family: serif;"><em>DETALLE DE CUMPLIMIENTO</em></th>
            </tr>
            <tr>
              <td style="width:30%; text-align: left;"><b>Fecha Inicio:</b></td>
              <td style="width:20%;text-align: left;">
                @if(!isset($fi))
                  {{date('d/m/Y', strtotime('-2 months'))}}
                @else
                  {{$fi}}
                @endif 
              </td>
              <td style="width:30%;text-align: left";><b>Fecha Fin:</b></td>
              <td style="width:20%;text-align: left;"> 
                @if(!isset($ff))
                  {{date('d/m/Y')}}
                @else
                  {{$ff}}
                @endif 
              </td>
            </tr>
            <tr>
              <td style="width:30%;text-align: left";><b>Usuario:</b></td>
              <td colspan="3" style="width:70%">  {{ Auth::user()->person->last_name }} {{ Auth::user()->person->name }}</td>
            </tr>
          </table>
      </div>
    </div>
  </div>
</div>


