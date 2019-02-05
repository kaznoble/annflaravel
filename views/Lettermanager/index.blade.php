{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
  <div class="page-content">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
    </div>

    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('') }}">{{ Lang::get('core.home') }}</a></li>
        <li class="active">{{ $pageTitle }}</li>
      </ul>
	   <div class="visible-xs breadcrumb-toggle"><a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a></div>
	  <ul class="breadcrumb-buttons collapse">
			@if($access['is_excel'] ==1)
			<li><a href="{{ URL::to('Lettermanager/download') }}" class="tips" title="{{ Lang::get('core.btn_download') }}">
			<i class="icon-folder-download2"></i>&nbsp; </a></li>	
			@endif		
		 	@if(Session::get('gid') ==1)
			<li><a href="{{ URL::to('module/config/Lettermanager') }}" class="tips"  title="{{ Lang::get('core.btn_config') }}">
			<i class="icon-cog"></i>&nbsp; </a></li>	
			@endif  
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Lettermanager/add') }}" class="tips"  title="{{ Lang::get('core.btn_create') }}">
			<i class="icon-plus-circle2"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();" class="tips" title="{{ Lang::get('core.btn_remove') }}">
			<i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 		
	  </ul>
	</div>  	
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
	{{ $details }}     
        
        <div class="div_round" >
            <select name='round_option' rows='5' id='round_option' code='' class='select2 form-control'    ></select>
            <button type="button" class="btn btn-primary butt_round" >GO</button>
        </div>
        
        <div class="table-responsive" >
            <ul class="nav nav-tabs" id="myTab" role="tablist" >
                @foreach($lettertemplate As $key=>$letter)
                    <li class="nav-item" style="background-color:{{$tab_color[$key]}}" ><a class="nav-link {{ ($letter == reset($lettertemplate) ? 'active' : '') }}"  id="{{ $letter->temp_id }}-tab" data-toggle="tab" href="#tab{{ $letter->temp_id }}" role="tab" aria-controls="tab{{ $letter->temp_id }}" aria-selected="true">{{ $letter->temp_title }}</a></li>
                @endforeach
            </ul>
            
            <div class="tab-content" id="myTabContent" >
                @foreach($lettertemplate As $letter)
                    <div class="tab-pane {{ ($letter == reset($lettertemplate) ? '' : 'fade') }} active" id="tab{{ $letter->temp_id }}" role="tabpanel" aria-labelledby="{{ $letter->temp_id }}-tab" >
                        <div class="div-toggle" >
                            <h3>{{ $letter->temp_title }}</h3>
                            <div class="table-responsive">
                            {{ Form::open(array('url'=>'Lettermanager/destroy/', 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) }}
                        <table class="table table-hover">
                            <thead>
                                            <tr>
                                                    <th> No </th>
                                                    <th> <input type="checkbox" class="checkall" /></th>
                                                    @if(FALSE) <th class="master-expand"> <i class="icon-plus"></i> </th> @endif
                                                    @foreach ($tableGrid as $t)
                                                            @if($t['view'] =='1')
                                                                    <th>{{ $t['label'] }}</th>
                                                            @endif
                                                    @endforeach
                                                    <td>Fullname</td>
                                                    <td>Address</td>
                                                    <!--<td>Letter Date</td>-->
                                                    <td>Letter Sent Date</td>
                                                    <th>{{ Lang::get('core.btn_action') }}</th>
                                              </tr>
                           
                                            <tr id="sximo-quick-search" class="table-secondary" >
                                                    <td> # </td>
                                                    @if(FALSE)<td> </td>@endif
                                                    <td> </td>
                                                    @foreach ($tableGrid as $t)
                                                            @if($t['view'] =='1')
                                                            <td>						
                                                                    {{ SiteHelpers::transForm($t['field'] , $tableForm) }}								
                                                            </td>
                                                            @endif
                                                    @endforeach
                                                    <td></td>
                                                    <td></td>
                                                    <!--<td></td>-->
                                                    <td></td>
                                                    <td style="width:100px;">
                                                    <input type="hidden"  value="Search">
                                                    <button type="button"  class=" do-quick-search btn btn-sx btn-info"> GO</button></td>
                                              </tr>
                                </thead>              
                                <tbody>
                                {{--*/ $arrearaccounts = SiteHelpers::accounttemplate($letter->al_id, $round) /*--}}
                                @foreach ($arrearaccounts as $row)
                                    {{--*/ $lettersentstatus = SiteHelpers::lettersent($row->account_no, $row->arrears_letter) /*--}}
                                    <tr class="tr_account{{ $row->account_no }} {{ ($lettersentstatus == 'yes' ? 'letter_sent_success' : '')  }}" >
                                                            <td width="50"> {{ ++$i }} </td>
                                                            <td width="50"><input type="checkbox" class="ids" name="id[]" value="{{ $row->account_id }}" />  </td>	
                                                            @if(FALSE) <td >
                                                                    <a href="javascript:void(0)" class="expand-row" id="{{ SiteHelpers::encryptID($row->account_id) }}">
                                                                    <i class="icon-plus"></i></a>
                                                            </td>	 
                                                            @endif								
                                                     @foreach ($tableGrid as $field)
                                                             @if($field['view'] =='1')
                                                             <td>					 
                                                                    @if($field['attribute']['image']['active'] =='1')
                                                                            <img src="{{ asset($field['attribute']['image']['path'].'/'.$row->$field['field'])}}" width="50" />
                                                                    @else	
                                                                            {{--*/ $conn = (isset($field['conn']) ? $field['conn'] : array() ) /*--}}
                                                                            {{ SiteHelpers::gridDisplay($row->$field['field'],$field['field'],$conn) }}	
                                                                    @endif						 
                                                             </td>
                                                             @endif					 
                                                     @endforeach
                                                     <td>					 
                                                            {{ $row->forename }}&nbsp;{{ $row->surname }}
                                                     </td>
                                                     <td>					 
                                                            {{ $row->address_1 }},&nbsp;{{ $row->address_2 }}{{ (!empty($row->address_3) ? ',&nbsp;' . $row->address_3 : '') }},&nbsp;{{ $row->address_4 }},&nbsp;{{ $row->postcode }}				 
                                                     </td>
                                                     <!--<td>
                                                            {{ $lettersentstatus }}
                                                     </td>-->
                                                     <td class="td_letter_date{{$row->account_no}}" >
                                                         Sent Letter?
                                                            <select name="sel_letter_sent" id="sel_letter_sent" class="sel_letter_sent form-control" data-id="{{ $row->account_no }}" data-cust="{{ $row->customer_no }}" data-step="{{ $row->arrears_letter }}" >
                                                                <option value="No" {{ ( ($lettersentstatus == 'no') ? 'SELECTED' : '') }} >No</option>
                                                                <option value="Yes" {{ ( ($lettersentstatus == 'yes') ? 'SELECTED' : '') }} >Yes</option>
                                                            </select> on 
                                                            {{--*/ $letter_sent = SiteHelpers::getlettersentdate($row->account_no, $row->arrears_letter) /*--}}
                                                            <span class="span_date font-weight-bold" ><strong>{{ (!empty($letter_sent) ? date('d/m/Y', strtotime($letter_sent)) : '') }}</strong></span>
                                                     </td>
                                                     <td>
                                                        <div class="btn-group">	
                                                            {{--*/ $id = SiteHelpers::encryptID($letter->temp_id) /*--}}
                                                            <a  href="{{ URL::to('lettertemplate/pdfpreview/'.$id.'?c='.$row->customer_no.'&a='.$row->account_no.'&s='.$letter->temp_id)}}"  class="printpdf tips btn btn-xs btn-success" id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Generating ..." title="{{ Lang::get('core.btn_edit') }}">Print PDF</a>
                                                        </div>
                                                    </td>				 
                                    </tr>
                                                    @include('Lettermanager.inlineview')
                                @endforeach

                            </tbody>

                        </table>
                            {{ Form::close() }}
                            </div>
                        </div>
                    </div>                    
                @endforeach             
                
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">LOADING ...</h5>
                  </div>
                  <div class="modal-body" style="text-align:center;" >
                    Please wait to update the sent letter status ... <br /><br />
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw margin-bottom" style="font-size:40px;" ></i>
<span class="sr-only">Loading...</span>
                  </div>
                </div>
              </div>
            </div>

            </div>
            
        </div>
        
        <!--	@include('footer')-->
	
	</div>	  
	
<script>
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("Lettermanager/multisearch")}}');
		$('#SximoTable').submit();
	});
        
        $("#round_option").jCombo("{{ URL::to('Lettermanager/comboselect?filter=round_config:round_number:round_name') }}",
		{  selected_value : '{{ $round }}' });
	
});	

$('.butt_round').on('click', function() {
    var round = $('#round_option option:selected').val();
    if(round !== '')
    {    
        window.location.href = '/Lettermanager?round=' + round;
    }
});

$(function() {
    $(document).on('change', '.sel_letter_sent', function() {
        // modal
        $('#exampleModal').modal();
        var account_no = $(this).attr('data-id');
        var customer_no = $(this).attr('data-cust');
        var letter_step = $(this).attr('data-step');
        var letter_sent_option = $(this).val();
        $.ajax({
            url: './ajax/letter_manager.php',
            type: 'POST',
            data: 'account_no='+account_no+'&customer_no='+customer_no+'&letter_step='+letter_step+'&lettersent='+letter_sent_option,
            success: function(data){
                // success update
                setTimeout(function() {
                    if(letter_sent_option === 'No')
                    {
                        $('.tr_account'+account_no).removeClass('letter_sent_success');
                        $('.td_letter_date'+account_no+ ' > .span_date').html('');
                    }
                    if(letter_sent_option === 'Yes')
                    {
                        $('.tr_account'+account_no).addClass('letter_sent_success');
                        $('.td_letter_date'+account_no+ ' > .span_date').html('<strong>' + data + '</strong>');
                    }                    
                    $('#exampleModal').modal('hide');
                }, 3000);
                
            }
        });
    });
});  

$('.printpdf').on('click', function() {
    var $this = $(this);
  $this.button('loading');
    setTimeout(function() {
       $this.button('reset');
   }, 8000);
});

</script>		