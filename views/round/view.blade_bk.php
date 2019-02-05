<link rel="stylesheet" type="text/css" href="/sximo/css/colorbox.css">
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="/sximo/js/jquery.colorbox.js"></script>

<div class="page-content">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small>
                <a href="/adminround" class="btn btn-xs btn-danger pull-right" title="Back To regulatory Home Page">Back</a>
            </h3>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('') }}">{{ Lang::get('core.home') }}</a></li>
            <li><a href="{{ URL::to('add_delete_round') }}">{{ $pageTitle }}</a></li>
            <li class="active">{{ Lang::get('core.view_edit_round') }} </li>
        </ul>
        <div class="visible-xs breadcrumb-toggle"><a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a></div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="Tran Ref" class=" control-label col-md-4 text-left"> Select Round </label>
                <div class="col-md-8">
                    <select name="round" id="round_no" class="form-control" onchange="Find_round(this.value);">
                        <option value="0">Select Round</option>
                        @foreach($Round as $round)
                            <option value="{{ $round->round_number }}" @if(isset($RoundData[0]->round_number)) @if($RoundData[0]->round_number == $round->round_number) selected @endif @endif>{{ $round->round_name }} - {{ $round->staff_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <br>

    @if(isset($RoundData) && !empty($RoundData))
    <div class="row">
        <br/>
       <div class="col-sm-12">
        <div class="panel panel-default">

         <div class="panel-heading">Edit View Round</div>
            <div class="panel-body">
               <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-2">
                        <label class="control-label">{{ $RoundData[0]->round_name }}</label>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label">{{ $RoundData[0]->staff_name }}</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="hidden" id="customer_no_selected" value="{{ $RoundData[0]->round_number }}">
                        <a class="btn btn-default btn-sm" onclick="add_customer();">Add Customer</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-default btn-sm" onclick="remove_customer();">Remove Customer</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-default btn-sm" onclick="open_model();">Assign to Call back list</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-default btn-sm remove_callback_btn" style="display:none;" onclick="remove_callback();">Remove From Call back list</a>
                    </div>
                </div>
               </div>
                <div class="clearfix"></div>
                <br><br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-2">
                            <label class="control-label">{{ $RoundData[0]->round_number }}</label>
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label">{{ $RoundData[0]->staff_number }}</label>
                        </div>
                        <div class="col-sm-6">
                            <a class="btn btn-default btn-sm" onclick="go_selected_customer();">Go to Selected customer accounts</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-default btn-sm remove_callback_btn" style="display:none;" onclick="open_model_reassign();">Reassign Call back day</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br><br>
                <div class="row">
                    <fieldset class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                           <input type="text" id="customer_no" placeholder="Customer Number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" id="first_name" placeholder="First Name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" id="last_name" placeholder="Last Name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <a class="btn btn-default btn-sm" onclick="search_customer();">Customer Search</a>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <div class="table-responsive htmldivshow" style="display: none;max-height: 500px;overflow: auto;">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Customer no</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Prefer time to call</th>
                                        </tr>
                                        </thead>
                                        <tbody class="tbody">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel with-nav-tabs panel-default">
                            <div class="panel-heading">
                                <ul class="nav nav-tabs" id="myTab">
                                    @if(!in_array('Monday',$staff_days))
                                        <li class="disabled" style="background-color: lightgray"><a href="javascript:void(0)">Monday</a></li>
                                    @else
                                        <li class="active" style="background-color: lightgray"><a href="#monday" data-toggle="tab">Monday</a></li>
                                    @endif

                                    @if(!in_array('Tuesday',$staff_days))
                                            <li class="disabled"><a href="javascript:void(0)">Tuesday</a></li>
                                    @else
                                            <li class="bg-info"><a href="#tuesday" data-toggle="tab">Tuesday</a></li>
                                    @endif

                                    @if(!in_array('Wednesday',$staff_days))
                                            <li class="disabled"><a href="javascript:void(0)">Wednesday</a></li>
                                    @else
                                            <li class="bg-success"><a href="#wednesday" data-toggle="tab">Wednesday</a></li>
                                    @endif

                                    @if(!in_array('Thursday',$staff_days))
                                            <li class="disabled"><a href="javascript:void(0)">Thursday</a></li>
                                    @else
                                            <li class="bg-warning"><a href="#thrusday" data-toggle="tab">Thursday</a></li>
                                    @endif

                                    @if(!in_array('Friday',$staff_days))
                                            <li class="disabled"><a href="javascript:void(0)">Friday</a></li>
                                    @else
                                            <li class="bg-danger"><a href="#friday" data-toggle="tab">Friday</a></li>
                                    @endif

                                    @if(!in_array('Saturday',$staff_days))
                                            <li class="disabled"><a href="javascript:void(0)">Saturday</a></li>
                                    @else
                                            <li class="bg-info"><a href="#saturday" data-toggle="tab">Saturday</a></li>
                                    @endif

                                    @if(!in_array('Sunday',$staff_days))
                                            <li class="disabled"><a href="javascript:void(0)">Sunday</a></li>
                                    @else
                                            <li class="bg-warning"><a href="#sunday" data-toggle="tab">Sunday</a></li>
                                    @endif
                                    <li style="background-color: green;"><a href="#callback" data-toggle="tab">Call back List</a></li>
									<li style="background-color: #edd490;"><a href="#autopayments" data-toggle="tab">Auto Payments</a></li>
									<li style="background-color: #dbefb1;"><a href="#daily_payment_log" data-toggle="tab">Daily Payment Log</a></li>									
									<li style="background-color: #c4acc6;"><a href="#week_end" data-toggle="tab">Week End</a></li>									
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content" style="border:none;" >
                                    <div class="tab-pane fade in active" id="monday">
										<?php $totalPaid = 0; ?>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Preferred Call Time</th>
                                                <th>Customer Number</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
												<th>Amount Paid<br />(&nbsp;<a href="#" class="clear_all" data-target="monday" >Clear All?</a>&nbsp;)</th>
												<th>Note</th>	
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php $setFreq = 0; $custNoListMon = ''; ?>
                                            @if(!empty($MondayCustomer))
                                            @foreach($MondayCustomer as $data)
											@if( $data->preferred_frequency != $setFreq )	
											<tr style="background-color:#f2f7ff;text-align:center;font-weight:bold;" ><td colspan="8" >			
														@if($data->preferred_frequency == 1) Weekly @endif
														@if($data->preferred_frequency == 2) Monthly @endif
														@if($data->preferred_frequency == 3) Two week @endif
														@if($data->preferred_frequency == 4) Four week @endif
													</td></tr>
											<?php if($data->preferred_frequency != $setFreq) $setFreq = $data->preferred_frequency; ?> 
											@endif
											{{ Form::open(array('url' => '/ViewEdit/' . $selectround,'method' => 'post' )) }}
                                                <tr @if($data->callback_day !='') class="bg-danger" @endif>
                                                    <td><input type="checkbox" name="insertedcustomers" value="{{$data->relation_id}}"></td>
                                                    <td>
														{{ Form::text('preferred_time',$data->preferred_time_to_call,array('class' => 'form-control')) }}
														<br />
														{{ Form::submit('UPDATE', array('class' => 'btn')) }}
													</td>
                                                    <td>{{ $data->customer_no }}</td>
                                                    <td>{{ $data->forename }}</td>
                                                    <td>{{ $data->surname }}</td>
                                                    <td><a class="googleMapPopUp" rel="nofollow" href="https://maps.google.com.au/maps?q={{$data->postcode}}" target="_blank">{{ $data->address_1.' '.$data->address_2.' '.$data->address_3.' '.$data->address_4.','.$data->postcode }}</a></td>
													<td>£{{ form::text('amount_paid',$data->amountPaid, array('class' => 'form-control monday_amount', 'data-day' => 'monday', 'data-id' => 'amount-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}</td>
													<td>{{ form::textarea('short_note',$data->shortNote, array('class' => 'form-control', 'data-day' => 'monday', 'data-note' => 'note-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}
														{{ form::token() }}
														{{ form::hidden('type', 'auth_payments') }}
														{{ form::hidden('customer_no', $data->customer_no) }}													
													</td>
                                                </tr>
											{{ Form::close() }}
												<?php $totalPaid = $totalPaid + $data->amountPaid; ?>										
                                            @endforeach
                                            @endif
												<tr><td colspan="6" style="text-align:right;" >Total:</td><td class="total_monday" >£{{ SiteHelpers::decimalpoundpence($totalPaid) }}</td><td colspan="1" ></td></tr>				
												{{ Form::hidden('custNo_monday',$custNoListMon); }}
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="tab-pane fade" id="tuesday">
										<?php $totalPaid = 0; ?>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Preferred Call Time</th>
                                                <th>Customer Number</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
												<th>Amount Paid<br />(&nbsp;<a href="#" class="clear_all" data-target="tuesday" >Clear All?</a>&nbsp;)</th>
												<th>Note</th>
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php $setFreq = 0; $custNoListTues = ''; ?>											
                                            @if(!empty($TuesdayCustomer))
                                            @foreach($TuesdayCustomer as $data)
											<?php
												$custNoListTues = $custNoListTues . $data->customer_no . ',';
											?> 										
											@if( $data->preferred_frequency != $setFreq )	
											<tr style="background-color:#f2f7ff;text-align:center;font-weight:bold;" ><td colspan="8" >
														@if($data->preferred_frequency == 1) Weekly @endif
														@if($data->preferred_frequency == 2) Monthly @endif
														@if($data->preferred_frequency == 3) Two week @endif
														@if($data->preferred_frequency == 4) Four week @endif
													</td></tr>
											<?php if($data->preferred_frequency != $setFreq) $setFreq = $data->preferred_frequency; ?> 
											@endif
											{{ Form::open(array('url' => '/ViewEdit/' . $selectround,'method' => 'post' )) }}
                                                <tr @if($data->callback_day !='') class="bg-danger" @endif>
                                                    <td><input type="checkbox" name="insertedcustomers" value="{{$data->relation_id}}"></td>
                                                    <td>
														{{ Form::text('preferred_time',$data->preferred_time_to_call,array('class' => 'form-control')) }}
														<br />
														{{ Form::submit('UPDATE', array('class' => 'btn')) }}
													</td>
                                                    <td>{{ $data->customer_no }}</td>
                                                    <td>{{ $data->forename }}</td>
                                                    <td>{{ $data->surname }}</td>
                                                    <td><a class="googleMapPopUp" rel="nofollow" href="https://maps.google.com.au/maps?q={{$data->postcode}}" target="_blank">{{ $data->address_1.' '.$data->address_2.' '.$data->address_3.' '.$data->address_4.','.$data->postcode }}</a></td>
													<td>£{{ form::text('amount_paid',$data->amountPaid, array('class' => 'form-control tuesday_amount', 'data-day' => 'tuesday', 'data-id' => 'amount-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}</td>
													<td>{{ form::textarea('short_note',$data->shortNote, array('class' => 'form-control', 'data-day' => 'tuesday', 'data-note' => 'note-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}
														{{ form::token() }}
														{{ form::hidden('type', 'auth_payments') }}
														{{ form::hidden('customer_no', $data->customer_no) }}
													</td>
                                                </tr>
												{{ Form::close() }}
												<?php $totalPaid = $totalPaid + $data->amountPaid; ?>
                                            @endforeach
                                            @endif
												<tr><td colspan="6" style="text-align:right;" >Total:</td><td class="total_tuesday" >£{{ SiteHelpers::decimalpoundpence($totalPaid) }}</td><td colspan="1" ></td></tr>
												{{ Form::hidden('custNo_tuesday',$custNoListTues); }}												
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="wednesday">
										<?php $totalPaid = 0; ?>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Preferred Call Time</th>
                                                <th>Customer Number</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
												<th>Amount Paid<br />(&nbsp;<a href="#" class="clear_all" data-target="wednesday" >Clear All?</a>&nbsp;)</th>
												<th>Note</th>
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php $setFreq = 0; $custNoListWed = ''; ?>											
                                            @if(!empty($WednesdayCustomer))
                                            @foreach($WednesdayCustomer as $data)
											<?php
												$custNoListWed = $custNoListWed . $data->customer_no . ',';
											?> 																		
											@if( $data->preferred_frequency != $setFreq )												
											<tr style="background-color:#f2f7ff;text-align:center;font-weight:bold;" ><td colspan="8" >
														@if($data->preferred_frequency == 1) Weekly @endif
														@if($data->preferred_frequency == 2) Monthly @endif
														@if($data->preferred_frequency == 3) Two week @endif
														@if($data->preferred_frequency == 4) Four week @endif
													</td></tr>
											<?php if($data->preferred_frequency != $setFreq) $setFreq = $data->preferred_frequency; ?> 
											@endif													
											{{ Form::open(array('url' => '/ViewEdit/' . $selectround,'method' => 'post' )) }}										
                                                <tr @if($data->callback_day !='') class="bg-danger" @endif>
                                                    <td><input type="checkbox" name="insertedcustomers" value="{{$data->relation_id}}"></td>
                                                    <td>
														{{ Form::text('preferred_time',$data->preferred_time_to_call,array('class' => 'form-control')) }}
														<br />
														{{ Form::submit('UPDATE', array('class' => 'btn')) }}														
													</td>
                                                    <td>{{ $data->customer_no }}</td>
                                                    <td>{{ $data->forename }}</td>
                                                    <td>{{ $data->surname }}</td>
                                                    <td><a class="googleMapPopUp" rel="nofollow" href="https://maps.google.com.au/maps?q={{$data->postcode}}" target="_blank">{{ $data->address_1.' '.$data->address_2.' '.$data->address_3.' '.$data->address_4.','.$data->postcode }}</a></td>
													<td>£{{ form::text('amount_paid',$data->amountPaid, array('class' => 'form-control wednesday_amount', 'data-day' => 'wednesday', 'data-id' => 'amount-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}</td>
													<td>{{ form::textarea('short_note',$data->shortNote, array('class' => 'form-control', 'data-day' => 'wednesday', 'data-note' => 'note-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}
														{{ form::token() }}
														{{ form::hidden('type', 'auth_payments') }}
														{{ form::hidden('customer_no', $data->customer_no) }}
													</td>
                                                </tr>
											{{ Form::close() }}
												<?php $totalPaid = $totalPaid + $data->amountPaid; ?>										
                                            @endforeach
                                            @endif
												<tr><td colspan="6" style="text-align:right;" >Total:</td><td class="total_wednesday" >£{{ SiteHelpers::decimalpoundpence($totalPaid) }}</td><td colspan="1" ></td></tr>
												{{ Form::hidden('custNo_wednesday',$custNoListWed); }}
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="thrusday">
										<?php $totalPaid = 0; ?>									
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Preferred Call Time</th>
                                                <th>Customer Number</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
												<th>Amount Paid<br />(&nbsp;<a href="#" class="clear_all" data-target="thursday" >Clear All?</a>&nbsp;)</th>
												<th>Note</th>	
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php $setFreq = 0; $custNoListThurs = ''; ?>											
                                            @if(!empty($ThrusdayCustomer))
                                            @foreach($ThrusdayCustomer as $data)
											<?php
												$custNoListThurs = $custNoListThurs . $data->customer_no . ',';
											?> 																			
											@if( $data->preferred_frequency != $setFreq )											
											<tr style="background-color:#f2f7ff;text-align:center;font-weight:bold;" ><td colspan="8" >
														@if($data->preferred_frequency == 1) Weekly @endif
														@if($data->preferred_frequency == 2) Monthly @endif
														@if($data->preferred_frequency == 3) Two week @endif
														@if($data->preferred_frequency == 4) Four week @endif
													</td></tr>
											<?php if($data->preferred_frequency != $setFreq) $setFreq = $data->preferred_frequency; ?> 
											@endif														
											{{ Form::open(array('url' => '/ViewEdit/' . $selectround,'method' => 'post' )) }}
                                                <tr @if($data->callback_day !='') class="bg-danger" @endif>
                                                    <td><input type="checkbox" name="insertedcustomers" value="{{$data->relation_id}}"></td>
                                                    <td>
														{{ Form::text('preferred_time',$data->preferred_time_to_call,array('class' => 'form-control')) }}
														<br />
														{{ Form::submit('UPDATE', array('class' => 'btn')) }}														
														</td>
                                                    <td>{{ $data->customer_no }}</td>
                                                    <td>{{ $data->forename }}</td>
                                                    <td>{{ $data->surname }}</td>
                                                    <td><a class="googleMapPopUp" rel="nofollow" href="https://maps.google.com.au/maps?q={{$data->postcode}}" target="_blank">{{ $data->address_1.' '.$data->address_2.' '.$data->address_3.' '.$data->address_4.','.$data->postcode }}</a></td>
													<td>£{{ form::text('amount_paid',$data->amountPaid, array('class' => 'form-control thursday_amount', 'data-day' => 'thursday', 'data-id' => 'amount-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}</td>
													<td>{{ form::textarea('short_note',$data->shortNote, array('class' => 'form-control', 'data-day' => 'thursday', 'data-note' => 'note-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}
														{{ form::token() }}
														{{ form::hidden('type', 'auth_payments') }}
														{{ form::hidden('customer_no', $data->customer_no) }}													
													</td>
                                                </tr>
											{{ Form::close() }}
												<?php $totalPaid = $totalPaid + $data->amountPaid; ?>										
                                            @endforeach
                                            @endif
												<tr><td colspan="6" style="text-align:right;" >Total:</td><td class="total_thursday" >£{{ SiteHelpers::decimalpoundpence($totalPaid) }}</td><td colspan="1" ></td></tr>
												{{ Form::hidden('custNo_thursday',$custNoListThurs); }}											
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="friday">
										<?php $totalPaid = 0; ?>									
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Preferred Call Time</th>
                                                <th>Customer Number</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
												<th>Amount Paid<br />(&nbsp;<a href="#" class="clear_all" data-target="friday" >Clear All?</a>&nbsp;)</th>
												<th>Note</th>	
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php $setFreq = 0; $custNoListFri = ''; ?>											
                                            @if(!empty($FridayCustomer))
                                            @foreach($FridayCustomer as $data)
											<?php
												$custNoListFri = $custNoListFri . $data->customer_no . ',';
											?> 																		
											@if( $data->preferred_frequency != $setFreq )											
											<tr style="background-color:#f2f7ff;text-align:center;font-weight:bold;" ><td colspan="8" >
														@if($data->preferred_frequency == 1) Weekly @endif
														@if($data->preferred_frequency == 2) Monthly @endif
														@if($data->preferred_frequency == 3) Two week @endif
														@if($data->preferred_frequency == 4) Four week @endif
													</td></tr>
											<?php if($data->preferred_frequency != $setFreq) $setFreq = $data->preferred_frequency; ?> 
											@endif														
											{{ Form::open(array('url' => '/ViewEdit/' . $selectround,'method' => 'post' )) }}
                                                <tr @if($data->callback_day !='') class="bg-danger" @endif>
                                                    <td><input type="checkbox" name="insertedcustomers" value="{{$data->relation_id}}"></td>
                                                    <td>
														{{ Form::text('preferred_time',$data->preferred_time_to_call,array('class' => 'form-control')) }}
														<br />
														{{ Form::submit('UPDATE', array('class' => 'btn')) }}														
														</td>
                                                    <td>{{ $data->customer_no }}</td>
                                                    <td>{{ $data->forename }}</td>
                                                    <td>{{ $data->surname }}</td>
                                                    <td><a class="googleMapPopUp" rel="nofollow" href="https://maps.google.com.au/maps?q={{$data->postcode}}" target="_blank">{{ $data->address_1.' '.$data->address_2.' '.$data->address_3.' '.$data->address_4.','.$data->postcode }}</a></td>
													<td>£{{ form::text('amount_paid',$data->amountPaid, array('class' => 'form-control friday_amount', 'data-day' => 'friday', 'data-id' => 'amount-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}</td>
													<td>{{ form::textarea('short_note',$data->shortNote, array('class' => 'form-control', 'data-day' => 'friday', 'data-note' => 'note-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}
														{{ form::token() }}
														{{ form::hidden('type', 'auth_payments') }}
														{{ form::hidden('customer_no', $data->customer_no) }}													
													</td>
                                                </tr>
											{{ Form::close() }}
												<?php $totalPaid = $totalPaid + $data->amountPaid; ?>										
                                            @endforeach
                                            @endif
												<tr><td colspan="6" style="text-align:right;" >Total:</td><td class="total_friday" >£{{ SiteHelpers::decimalpoundpence($totalPaid) }}</td><td colspan="1" ></td></tr>
												{{ Form::hidden('custNo_friday',$custNoListFri); }}												
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="saturday">
										<?php $totalPaid = 0; ?>									
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Preferred Call Time</th>
                                                <th>Customer Number</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
												<th>Amount Paid<br />(&nbsp;<a href="#" class="clear_all" data-target="saturday" >Clear All?</a>&nbsp;)</th>
												<th>Note</th>		
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php $setFreq = 0; $custNoListSat = ''; ?>											
                                            @if(!empty($SaturdayCustomer))
                                            @foreach($SaturdayCustomer as $data)
											<?php
												$custNoListSat = $custNoListSat . $data->customer_no . ',';
											?> 																		
											@if( $data->preferred_frequency != $setFreq )											
											<tr style="background-color:#f2f7ff;text-align:center;font-weight:bold;" ><td colspan="8" >
														@if($data->preferred_frequency == 1) Weekly @endif
														@if($data->preferred_frequency == 2) Monthly @endif
														@if($data->preferred_frequency == 3) Two week @endif
														@if($data->preferred_frequency == 4) Four week @endif
													</td></tr>
											<?php if($data->preferred_frequency != $setFreq) $setFreq = $data->preferred_frequency; ?> 
											@endif														
											{{ Form::open(array('url' => '/ViewEdit/' . $selectround,'method' => 'post' )) }}
                                                <tr @if($data->callback_day !='') class="bg-danger" @endif>
                                                    <td><input type="checkbox" name="insertedcustomers" value="{{$data->relation_id}}"></td>
                                                    <td>
														{{ Form::text('preferred_time',$data->preferred_time_to_call,array('class' => 'form-control')) }}
														<br />
														{{ Form::submit('UPDATE', array('class' => 'btn')) }}																
													</td>
                                                    <td>{{ $data->customer_no }}</td>
                                                    <td>{{ $data->forename }}</td>
                                                    <td>{{ $data->surname }}</td>
                                                    <td><a class="googleMapPopUp" rel="nofollow" href="https://maps.google.com.au/maps?q={{$data->postcode}}" target="_blank">{{ $data->address_1.' '.$data->address_2.' '.$data->address_3.' '.$data->address_4.','.$data->postcode }}</a></td>
													<td>£{{ form::text('amount_paid',$data->amountPaid, array('class' => 'form-control saturday_amount', 'data-day' => 'saturday', 'data-id' => 'amount-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}</td>
													<td>{{ form::textarea('short_note',$data->shortNote, array('class' => 'form-control', 'data-day' => 'saturday', 'data-note' => 'note-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}
														{{ form::token() }}
														{{ form::hidden('type', 'auth_payments') }}
														{{ form::hidden('customer_no', $data->customer_no) }}													
													</td>
                                                </tr>
											{{ Form::close() }}
												<?php $totalPaid = $totalPaid + $data->amountPaid; ?>										
                                            @endforeach
                                            @endif
												<tr><td colspan="6" style="text-align:right;" >Total:</td><td class="total_saturday" >£{{ SiteHelpers::decimalpoundpence($totalPaid) }}</td><td colspan="1" ></td></tr>
												{{ Form::hidden('custNo_saturday',$custNoListSat); }}												
											</tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="sunday">
										<?php $totalPaid = 0; ?>									
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Preferred Call Time</th>
                                                <th>Customer Number</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
												<th>Amount Paid<br />(&nbsp;<a href="#" class="clear_all" data-target="sunday" >Clear All?</a>&nbsp;)</th>
												<th>Note</th>		
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php $setFreq = 0; $custNoListSun = ''; ?>											
                                            @if(!empty($SundayCustomer))
                                            @foreach($SundayCustomer as $data)
											<?php
												$custNoListSun = $custNoListSun . $data->customer_no . ',';
											?> 										
											@if( $data->preferred_frequency != $setFreq )											
											<tr style="background-color:#f2f7ff;text-align:center;font-weight:bold;" ><td colspan="8" >
														@if($data->preferred_frequency == 1) Weekly @endif
														@if($data->preferred_frequency == 2) Monthly @endif
														@if($data->preferred_frequency == 3) Two week @endif
														@if($data->preferred_frequency == 4) Four week @endif
													</td></tr>
											<?php if($data->preferred_frequency != $setFreq) $setFreq = $data->preferred_frequency; ?> 													
											@endif														
											{{ Form::open(array('url' => '/ViewEdit/' . $selectround,'method' => 'post' )) }}
                                                <tr @if($data->callback_day !='') class="bg-danger" @endif>
                                                    <td><input type="checkbox" name="insertedcustomers" value="{{$data->relation_id}}"></td>
                                                    <td>
														{{ Form::text('preferred_time',$data->preferred_time_to_call,array('class' => 'form-control')) }}
														<br />
														{{ Form::submit('UPDATE', array('class' => 'btn')) }}														
													</td>
                                                    <td>{{ $data->customer_no }}</td>
                                                    <td>{{ $data->forename }}</td>
                                                    <td>{{ $data->surname }}</td>
                                                    <td><a class="googleMapPopUp" rel="nofollow" href="https://maps.google.com.au/maps?q={{$data->postcode}}" target="_blank">{{ $data->address_1.' '.$data->address_2.' '.$data->address_3.' '.$data->address_4.','.$data->postcode }}</a></td>
													<td>£{{ form::text('amount_paid',$data->amountPaid, array('class' => 'form-control sunday_amount', 'data-day' => 'sunday', 'data-id' => 'amount-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}</td>
													<td>{{ form::textarea('short_note',$data->shortNote, array('class' => 'form-control', 'data-day' => 'sunday', 'data-note' => 'note-' . $data->customer_no, 'data-custno' => $data->customer_no)) }}
														{{ form::token() }}
														{{ form::hidden('type', 'auth_payments') }}
														{{ form::hidden('customer_no', $data->customer_no) }}													
													</td>
                                                </tr>
											{{ Form::close() }}
												<?php $totalPaid = $totalPaid + $data->amountPaid; ?>										
                                            @endforeach
                                            @endif
												<tr><td colspan="6" style="text-align:right;" >Total:</td><td class="total_sunday" >£{{ SiteHelpers::decimalpoundpence($totalPaid) }}</td><td colspan="1" ></td></tr>
												{{ Form::hidden('custNo_sunday',$custNoListSun); }}												
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="callback">
										<?php $totalPaid = 0; ?>									
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Preferred Call Time</th>
                                                <th>Customer Number</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Callback day</th>
                                                <th>Address</th>
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php $setFreq = 0; $custNoListCall = ''; ?>											
                                            @if(!empty($CallBackCustomer))
                                            @foreach($CallBackCustomer as $data)
											<?php
												$custNoListCall = $custNoListCall . $data->customer_no . ',';
											?> 										
											@if( $data->preferred_frequency != $setFreq )												
											<tr style="background-color:#f2f7ff;text-align:center;font-weight:bold;" ><td colspan="8" >
														@if($data->preferred_frequency == 1) Weekly @endif
														@if($data->preferred_frequency == 2) Monthly @endif
														@if($data->preferred_frequency == 3) Two week @endif
														@if($data->preferred_frequency == 4) Four week @endif
													</td></tr>
											<?php if($data->preferred_frequency != $setFreq) $setFreq = $data->preferred_frequency; ?> 
											@endif															
											{{ Form::open(array('url' => '/ViewEdit/' . $selectround,'method' => 'post' )) }}
                                                <tr>
                                                    <td><input type="checkbox" name="selectcallbacklist" value="{{$data->relation_id}}"></td>
                                                    <td>
														{{ Form::text('preferred_time',$data->preferred_time_to_call,array('class' => 'form-control')) }}
														<br />
														{{ Form::submit('UPDATE', array('class' => 'btn')) }}
														</td>
                                                    <td>{{ $data->customer_no }}</td>
                                                    <td>{{ $data->forename }}</td>
                                                    <td>{{ $data->surname }}</td>
                                                    <td><font color="red">{{ $data->callback_day }}</font></td>
                                                    <td><a class="googleMapPopUp" rel="nofollow" href="https://maps.google.com.au/maps?q={{$data->postcode}}" target="_blank">{{ $data->address_1.' '.$data->address_2.' '.$data->address_3.' '.$data->address_4.','.$data->postcode }}</a></td>
                                                </tr>
											{{ Form::close() }}
												<?php $totalPaid = $totalPaid + $data->amountPaid; ?>										
                                            @endforeach
                                            @endif
												{{ Form::hidden('custNo_callback',$custNoListCall); }}												
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="autopayments">
										<?php $totalPaid = 0; ?>									
                                        <table class="table table-bordered">
                                            <tr >
												<th>Select</td>
                                                <th>Preferred Call Time</th>											
                                                <th>Customer No</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
                                            </tr>
                                            <tbody>
											<?php $setFreq = 0; $custNoListAuto = ''; ?>											
                                            @if(!empty($authpaydata))
                                            @foreach($authpaydata as $data)
											<?php
												$custNoListAuto = $custNoListAuto . $data->customer_no . ',';
											?> 										
											@if( $data->preferred_frequency != $setFreq )												
											<tr style="background-color:#f2f7ff;text-align:center;font-weight:bold;" ><td colspan="8" >
														@if($data->preferred_frequency == 1) Weekly @endif
														@if($data->preferred_frequency == 2) Monthly @endif
														@if($data->preferred_frequency == 3) Two week @endif
														@if($data->preferred_frequency == 4) Four week @endif
													</td></tr>
											<?php if($data->preferred_frequency != $setFreq) $setFreq = $data->preferred_frequency; ?> 
											@endif															
												{{ form::open(array('url' => '/ViewEdit/' . $selectround,'method' => 'post' )) }}
                                                <tr>										
													<td><input type="checkbox" name="insertedcustomers" value="{{$data->relation_id}}"></td>
                                                    <td>
														{{ form::text('preferred_time_' . $data->customer_no, $data->preferred_time_to_call, array('class'=>'form-control')) }}
													</td>		
                                                    <td><a href="/Customeraccounts?search=customer_no:{{ $data->customer_no }}"><strong>{{ $data->customer_no }}</strong></a></td>
                                                    <td>{{ $data->forename }}</td>
                                                    <td>{{ $data->surname }}</td>
                                                    <td><a class="googleMapPopUp" rel="nofollow" href="https://maps.google.com.au/maps?q={{$data->postcode}}" target="_blank">{{ $data->address_1.' '.$data->address_2.' '.$data->address_3.' '.$data->address_4.','.$data->postcode }}</a></td>
                                                </tr>
												{{ form::close() }}
												<?php $totalPaid = $totalPaid + $data->amountPaid; ?>										
                                            @endforeach
                                            @endif
												{{ Form::hidden('custNo_autopay',$custNoListAuto); }}												
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="daily_payment_log" style="border:none;">
										<div class="daily_payment_log_style" style="margin-bottom:15px;" >
											{{ Form::open(array('url' => '/ViewEdit/' . $selectround . '?search=date_type:', 'method' => 'get')) }}
												{{ Form::select('daterange', array('' => 'Today','1' => 'Last 7 Days','2' => 'Last 30 Days','3' => 'This Month','4' => 'Last Month','5' => 'Custom Range'), $selectDateType, array('id' => 'select_date_right', 'class' => 'form-control')) }}
												{{ Form::submit('SUBMIT', ['class' => 'do-quick-search btn btn-sx btn-warning']); }}	
												<div style="{{ (($selectDateType == '5') ? 'display:block' : 'display:none') }}" class="div_custom_date" >
													{{ Form::text('start_date', $start_date, array('class' => 'form-control input-sm date', 'placeholder' => 'start date')) }}  -  {{ Form::text('end_date', $end_date, array('class' => 'form-control input-sm date', 'placeholder' => 'end date')) }}												
												</div>
											{{ Form::close() }}
										</div>
										<?php $prev_ptl_date = ''; ?>
                                        <table class="table table-bordered">
										{{ Form::open(array('url'=>'/ViewEdit/' . $selectround, 'class'=>'form-horizontal' ,'id' =>'SximoTable', 'method' => 'get' )) }}
                                            <tr>
                                                <td>{{ Form::text('search_forename', $search_forename, array('class' => 'form-control')) }}</td>											
                                                <td>{{ Form::text('search_surname', $search_surname, array('class' => 'form-control')) }}</td>
                                                <td><!--{{ Form::text('search_date', $search_date, array('class' => 'form-control')) }}--></td>
                                                <td>{{ Form::text('search_customer_no', $search_customer_no, array('class' => 'form-control')) }}</td>
                                                <td>{{ Form::text('search_account_no', $search_account_no, array('class' => 'form-control')) }}</td>
                                                <td><select name='search_type_of_payment' rows='5' id='search_type_of_payment' class='search_type_of_payment form-control' ></select></td>
												<td><select name='search_pay_success' rows='5' id='search_pay_success' class='search_pay_success form-control' >			<option value=''> -- All  -- </option>
															<option value='1' {{ (($search_pay_success == '1') ? 'selected' : '') }}>Success</option>
															<option value='0' {{ (($search_pay_success == '0') ? 'selected' : '') }}>Fail</option></select></td>
												<td>{{ Form::submit('GO', ['class' => ' do-quick-search btn btn-sx btn-info']) }}</td>												
                                            </tr>
											{{ Form::close() }}
                                            <tr style="background-color: #f2f7ff" >
                                                <th>Forename</th>											
                                                <th>Surname</th>
                                                <th>Date</th>
                                                <th>Customer No</th>
                                                <th>Account No</th>
                                                <th>Type of Payment</th>
												<th>Pay Success</th>
												<th>Action</th>												
                                            </tr>
                                            <tbody>
                                            @if(!empty($dailypaymentlogdata))
                                            @foreach($dailypaymentlogdata as $data)										
											<?php
												$date_tab = false;
												$ptl_date = date('Y-m-d',strtotime($data->date));
												if( $prev_ptl_date != $ptl_date)
													$date_tab = true; $prev_ptl_date = date('Y-m-d',strtotime($data->date));
												//echo $ptl_date;
												if( $date_tab ) {
											?>
											<tr style="height:10px;" >
												<td colspan="15" ></td>
											</tr>
											<tr>
												<td colspan="15" style="background-color: #bbcbf4;font-weight:bold;" >{{ date('D, d F Y', strtotime($ptl_date)) }}</td>
											</tr>
											<?php } ?>										
                                                <tr>
                                                    <td>{{ $data->forename }}</td>												
                                                    <td>{{ $data->surname }}</td>
                                                    <td>{{ $data->date }}</td>
                                                    <td>{{ $data->customer_no }}</td>
                                                    <td>{{ $data->account_no }}</td>
                                                    <td>{{ SiteHelpers::get_payment_type($data->type_of_payment) }}</td>
													<td>
														@if($data->pay_success == 1)
															<span style="font-weight:bold;color:#3fc04b;" >SUCCESS</span>
														@else
															<span style="font-weight:bold;color:red;" >FAIL</span>
														@endif
													</td>
													<td></td>
                                                </tr>
                                            @endforeach
                                            @endif
                                            </tbody>
                                        </table>										
                                    </div>										
                                    <div class="tab-pane fade" id="week_end" style="border:none;">
										<div style="width:30%;border:none;margin-bottom: 15px;float:left;" >
											<div>Get Weekly Totals (<strong>Week runs from Monday to Sunday</strong>)
											{{ Form::open(array('url' => 'ViewEdit/' . $RoundData[0]->round_number, 'method' => 'get')) }}
												{{ Form::text('weekend_start_date', $startEndWeek, array('placeholder' => 'Start Date', 'class' => 'form-control input-sm date', 'style' => 'width:20%;')); }} - {{ Form::text('weekend_end_date', $endEndWeek,  array('placeholder' => 'End Date', 'class' => 'form-control input-sm date', 'style' => 'width:20%;margin-top:0px;')) }}&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::submit(' GO ', array('class' => 'btn')); }}
											{{ Form::close() }}</div>
											<div class="div_daily_totals_date" >Get Daily Totals
											{{ Form::open(array('url' => 'ViewEdit/' . $RoundData[0]->round_number, 'method' => 'get')) }}
												{{ Form::text('weekend_start_date', $startDailyEndWeek, array('placeholder' => 'Start Date', 'class' => 'form-control input-sm date', 'style' => 'width:20%;')); }}&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::submit(' GO ', array('class' => 'btn')); }}{{Form::hidden('formtype','daily_totals')}}
											{{ Form::close() }}</div>
											
										</div>
										<div style="float:right;text-align:right;" >
											<a href="/ViewEdit/{{ $RoundData[0]->round_number }}?type=search_history" >VIEW SEARCH HISTORY</a>									
										</div>
										<div class="clr" ></div>
										@if($searchHistory == false)
										<!-- Weekly history -->
										@if( !empty($startEndWeek) && !empty($endEndWeek) )
											{{ Form::open(array('url' => '/SaveWeekEndData', 'id' => 'search_history_form', 'method' => 'post')) }}
												{{ Form::button('SAVE THIS WEEKLY TOTALS?', array('class' => 'btn save_weekly')) }}
													{{ Form::hidden('weekend_start_date', $startEndWeek) }}
													{{ Form::hidden('weekend_end_date', $endEndWeek) }}
													{{ Form::hidden('round_no', $RoundData[0]->round_number) }}														
											{{ Form::close() }}	
										<div class="clr" style="height:15px;" ></div>
										@if($searchView)
											<a href='#' onclick="window.history.go(-1); return false;" >< Return to search history</a>
										@endif											
										<div class="clr"  ></div>
										<strong>Week End from {{ date('d/m/Y', strtotime($startEndWeek)) }} to {{ date('d/m/Y', strtotime($endEndWeek)) }}</strong>
										@endif
										
										<!-- Daily history -->
										@if( !empty($startDailyEndWeek) && $daily_save )
											{{ Form::open(array('url' => '/SaveWeekEndData', 'id' => 'search_history_form', 'method' => 'post')) }}
												{{ Form::button('SAVE THIS DAILY TOTALS?', array('class' => 'btn save_weekly')) }}
													{{ Form::hidden('weekend_start_date', $startDailyEndWeek) }}
													{{ Form::hidden('daily_save', 'daily_save') }}
													{{ Form::hidden('formtype', 'daily_totals') }}													
													{{ Form::hidden('round_no', $RoundData[0]->round_number) }}														
											{{ Form::close() }}	
										<div class="clr" style="height:15px;" ></div>
										@if($searchView)
											<a href='#' onclick="window.history.go(-1); return false;" >< Return to search history</a>
										@endif											
										<div class="clr"  ></div>
										@if(empty($startDailyEndWeek))
											<strong>Week End from {{ date('d/m/Y', strtotime($startEndWeek)) }} to {{ date('d/m/Y', strtotime($endEndWeek)) }}</strong>
										@else
											<strong>Day on {{ date('d/m/Y', strtotime($startDailyEndWeek)) }}</strong>
										@endif
										@endif										
										
										<div style="height:20px;" ></div>
										
										<!-- Auto payment totals -->
										<h4>Auto Payments</h4>										
										<table class="table table-bordered">
                                            <thead>
                                            <tr style="background-color: #f2f7ff" >
                                                <th>Loan Period {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }}</th>											
                                                <th>Total loans for {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }} without interest</th>
                                                <th>Total interest for the {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }}</th>
                                                <th>Total rebate for {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }}</th>
                                                <th>Total collect {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }}</th>
                                                <th>Total arrears {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }}</th>												
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($weekenddata))
											<?php 
												$totalLoanWithout = 0;
												$totalLoanWith = 0;
												$totalRebate = 0;
												$totalCollect = 0;
												$totalArrear = 0;
											?>
                                            @foreach($weekenddata as $key => $data)
												<?php
													$totalLoanWithout = $totalLoanWithout + $data['withinterest'];
													$totalLoanWith = $totalLoanWith + $data['withnointerest'];
													$totalRebate = $totalRebate + $data['totalrebate'];
													$totalCollect = $totalCollect + $data['totalpaid'];
													$totalArrear = $totalArrear + $data['totalarrears']
												?>
                                                <tr>
                                                    <td>{{ $key }}</td>												
                                                    <td>£{{ SiteHelpers::decimalpoundpence($data['withinterest']) }}</td>
                                                    <td>£{{ SiteHelpers::decimalpoundpence($data['withnointerest']) }}</td>
                                                    <td>£{{ SiteHelpers::decimalpoundpence($data['totalrebate']) }}</td>
                                                    <td>£{{ SiteHelpers::decimalpoundpence($data['totalpaid']) }}</td>
													<td>£{{ SiteHelpers::decimalpoundpence($data['totalarrears']) }}</td>
                                                </tr>
                                            @endforeach
												<tr style="font-weight:bold;" >
													<td>TOTALS</td>
													<td>{{ SiteHelpers::decimalpoundpence($totalLoanWithout) }}</td>
													<td>{{ SiteHelpers::decimalpoundpence($totalLoanWith) }}</td>
													<td>{{ SiteHelpers::decimalpoundpence($totalRebate) }}</td>
													<td>{{ SiteHelpers::decimalpoundpence($totalCollect) }}</td>
													<td>{{ SiteHelpers::decimalpoundpence($totalArrear) }}</td>													
												</tr>
                                            @endif
                                            </tbody>										
                                        </table>
										<!-- End - Auto payment totals -->
										<div class="clr-15" ></div>
										<!-- Cash payment totals -->
										<h4>Cash Payments</h4>
										<table class="table table-bordered">
                                            <thead>
                                            <tr style="background-color: #f2f7ff" >
                                                <th>Loan Period {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }}</th>											
                                                <th>Total loans for {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }} without interest</th>
                                                <th>Total interest for the {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }}</th>
                                                <th>Total rebate for {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }}</th>
                                                <th>Total collect {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }}</th>
                                                <th>Total arrears {{ (!empty($startDailyEndWeek) ? 'Day' : 'Week') }}</th>												
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($weekenddatacash))
											<?php 
												$totalLoanWithout = 0;
												$totalLoanWith = 0;
												$totalRebate = 0;
												$totalCollect = 0;
												$totalArrear = 0;
											?>
                                            @foreach($weekenddatacash as $key => $data)
												<?php
													$totalLoanWithout = $totalLoanWithout + $data['withinterest'];
													$totalLoanWith = $totalLoanWith + $data['withnointerest'];
													$totalRebate = $totalRebate + $data['totalrebate'];
													$totalCollect = $totalCollect + $data['totalpaid'];
													$totalArrear = $totalArrear + $data['totalarrears']
												?>
                                                <tr>
                                                    <td>{{ $key }}</td>												
                                                    <td>£{{ SiteHelpers::decimalpoundpence($data['withinterest']) }}</td>
                                                    <td>£{{ SiteHelpers::decimalpoundpence($data['withnointerest']) }}</td>
                                                    <td>£{{ SiteHelpers::decimalpoundpence($data['totalrebate']) }}</td>
                                                    <td>£{{ SiteHelpers::decimalpoundpence($data['totalpaid']) }}</td>
													<td>£{{ SiteHelpers::decimalpoundpence($data['totalarrears']) }}</td>
                                                </tr>
                                            @endforeach
												<tr style="font-weight:bold;" >
													<td>TOTALS</td>
													<td>{{ SiteHelpers::decimalpoundpence($totalLoanWithout) }}</td>
													<td>{{ SiteHelpers::decimalpoundpence($totalLoanWith) }}</td>
													<td>{{ SiteHelpers::decimalpoundpence($totalRebate) }}</td>
													<td>{{ SiteHelpers::decimalpoundpence($totalCollect) }}</td>
													<td>{{ SiteHelpers::decimalpoundpence($totalArrear) }}</td>													
												</tr>
                                            @endif
                                            </tbody>										
                                        </table>
										<!-- End - Cash payment totals -->
										@endif
										<!-- Table for search history -->
										@if($searchHistory)
										<a href="#" onclick="window.history.go(-1); return false;" >< Return to main Week End</a>
										<!-- Weekly history -->
										<table class="table table-bordered">
                                            <thead>
                                            <tr style="background-color: #f2f7ff" >
                                                <th style="width:5%;" ></th>											
                                                <th style="width:70%;text-weight:bold;">Week End History</th>
                                                <th></th>											
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($getweekendhistory))
                                            @foreach($getweekendhistory as $data)
                                                <tr>
                                                    <td>{{ Form::checkbox('select_history') }}</td>												
                                                    <td>Week of {{ SiteHelpers::get_past_seven_days_date($data->week_end_date) }} - {{ SiteHelpers::get_uk_date_format($data->week_end_date) }}</td>
                                                    <td>{{ Form::button('VIEW',['class' => 'search_view', 'data-enddate' => $data->week_end_date, 'data-roundid' => $RoundData[0]->round_number]) }} | {{ Form::button('DELETE', ['class' => 'search_delete', 'data-weekid' => $data->weeklyTotal_id, 'data-roundid' => $RoundData[0]->round_number]) }}</td>
                                                </tr>
                                            @endforeach
                                            @endif
                                            </tbody>										
                                        </table>		
										
										<!-- Daily history -->
										<table class="table table-bordered" style="margin-top: 15px;" >
                                            <thead>
                                            <tr style="background-color: #f2f7ff" >
                                                <th style="width:5%;"></th>											
                                                <th style="width:70%;text-weight:bold;">Daily History</th>
                                                <th></th>											
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($getdailyhistory))
                                            @foreach($getdailyhistory as $data)
                                                <tr>
                                                    <td>{{ Form::checkbox('select_history') }}</td>												
                                                    <td>Daily of {{ SiteHelpers::get_uk_date_format($data->week_end_date) }}</td>
                                                    <td>{{ Form::button('VIEW',['class' => 'search_view', 'data-view' => 'daily_view', 'data-enddate' => $data->week_end_date, 'data-roundid' => $RoundData[0]->round_number]) }} | {{ Form::button('DELETE', ['class' => 'search_delete', 'data-delete' => 'delete_daily', 'data-weekid' => $data->weeklyTotal_id, 'data-roundid' => $RoundData[0]->round_number]) }}</td>
                                                </tr>
                                            @endforeach
                                            @endif
                                            </tbody>										
                                        </table>												
										@endif
										<!-- /Table for search history -->										
                                    </div>									
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    @endif

<!-- Reassign Call Back Day Model for the day selection.-->
    <div id="ReassignMyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add call back Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Call Back Day:</label><br>
                                <input type="radio" name="CallbackDay_Reassign" value="Monday">&nbsp;&nbsp;Monday<br>
                                <input type="radio" name="CallbackDay_Reassign" value="Tuesday">&nbsp;&nbsp;Tuesday<br>
                                <input type="radio" name="CallbackDay_Reassign" value="Wednesday">&nbsp;&nbsp;Wednesday<br>
                                <input type="radio" name="CallbackDay_Reassign" value="Thursday">&nbsp;&nbsp;Thursday<br>
                                <input type="radio" name="CallbackDay_Reassign" value="Friday">&nbsp;&nbsp;Friday<br>
                                <input type="radio" name="CallbackDay_Reassign" value="Saturday">&nbsp;&nbsp;Saturday<br>
                                <input type="radio" name="CallbackDay_Reassign" value="Sunday">&nbsp;&nbsp;Sunday<br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Call Back Time:</label>
                                <input type="text" id="callback_timeSelect_Reassign" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="Reassign_callback()">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Call Back Day Model for the day selection.-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add call back Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Call Back Day:</label><br>
                            <input type="radio" name="CallbackDay" value="Monday">&nbsp;&nbsp;Monday<br>
                            <input type="radio" name="CallbackDay" value="Tuesday">&nbsp;&nbsp;Tuesday<br>
                            <input type="radio" name="CallbackDay" value="Wednesday">&nbsp;&nbsp;Wednesday<br>
                            <input type="radio" name="CallbackDay" value="Thursday">&nbsp;&nbsp;Thursday<br>
                            <input type="radio" name="CallbackDay" value="Friday">&nbsp;&nbsp;Friday<br>
                            <input type="radio" name="CallbackDay" value="Saturday">&nbsp;&nbsp;Saturday<br>
                            <input type="radio" name="CallbackDay" value="Sunday">&nbsp;&nbsp;Sunday<br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Call Back Time:</label>
                                <input type="text" id="callback_timeSelect" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="assign_callback()">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Call Back Day Model for the day selection.-->
    <div id="customer_main_model" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Prefer Payment Day:</label>
                                <select id='preferred_payment_day_popup' rows='5' id='preferred_payment_day' class='form-control'>
                                    @if(count($days) > 0)
                                    @foreach($days as $day)
                                        <option value="{{ $day->day_id }}">{{ $day->day_desc }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Prefer Time to Call:</label>
                                <input type="text" id="preferred_time_to_call_popup" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="model_customer_no">
                    <button type="button" class="btn btn-success" onclick="add_preferdaytime()">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $('.search_type_of_payment').jCombo("{{ URL::to('Customeraccounts/comboselect?filter=type_of_payment:id_type:type_of_payment_short') }}",
            {  selected_value : '{{ (!empty($search_type_of_payment) ? $search_type_of_payment : '') }}' });
			
        $('.search_frequency_order').jCombo("{{ URL::to('Customeraccounts/comboselect?filter=frequency:id:freq_desc') }}",
            {  selected_value : '{{ (!empty($frequency_order) ? $frequency_order : '') }}' });			
	
        // Hide or show remove call back button.
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            if(target == '#callback'){
                $('.remove_callback_btn').css('display','block');
            }else{
                $('.remove_callback_btn').css('display','none');
            }
        });

        // Code To make Selected Tab Active after page refresh
        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
                @if(isset($RoundData[0]->round_number))
                localStorage.setItem('round_number', '{{ $RoundData[0]->round_number }}');
                @endif
            });
            var activeTab = localStorage.getItem('activeTab');
            @if(isset($RoundData[0]->round_number))
            var round_number = '{{ $RoundData[0]->round_number }}';
            @endif
            if(activeTab){
                if(localStorage.getItem('round_number') == round_number)
                {
                    $('#myTab a[href="' + activeTab + '"]').tab('show');
                }
            }
			
		
			$('#select_date_right').on('change',function() {
				var selectDateVal = $('#select_date_right :selected').val();
				if(selectDateVal === '5')
					$('.div_custom_date').show();
				else
					$('.div_custom_date').hide();
			})		
			
			$('.search_view').click(function() {
				var round_id = $(this).attr('data-roundid');
				var searchEndDate = $(this).attr('data-enddate');
				var searchStartDate = new Date($(this).attr('data-enddate'));
				var daily_view = $(this).attr('data-view');
				searchStartDate.setDate(searchStartDate.getDate()-6);
				searchStartDate = searchStartDate.getFullYear() + '-' + (searchStartDate.getMonth() + 1) + '-' + searchStartDate.getDate();
				if(daily_view == 'daily_view')
				{
					searchStartDate = $(this).attr('data-enddate');
					window.location = '/ViewEdit/' + round_id +'?weekend_start_date=' + searchStartDate + '&formtype=daily_totals';
				}
				else
				{
					window.location = '/ViewEdit/' + round_id +'?weekend_start_date=' + searchStartDate + '&weekend_end_date=' + searchEndDate + '&type=search_view';
				}
			});
			
			$('.save_weekly').click(function() {
				$('#search_history_form').submit();
			});
			
			$('.search_delete').click(function(e) {
				var week_id = $(this).attr('data-weekid');
				var round_id = $(this).attr('data-roundid');
				var data_delete = $(this).attr('data-delete');
				e.preventDefault();
				if(window.confirm("Are you sure you want to delete?"))
				{
					Delete_staff_week_end(week_id, round_id, data_delete);
				}
				else
				{
					false();
					return;
				}
			});
			
			$('.clear_all').click(function(e) {
				e.preventDefault();
				if(window.confirm("Are you sure you want to clear all?"))
				{
					var custNoVal = "custNo_" + $(this).attr('data-target');
					var round_no = $('#round_no').val();
					var custNoList = $('input[name="' + custNoVal + '"]').val();
					$.ajax({
						url: "/ajax/round_note.php",
						type:"POST",
						data:{"custNoList":custNoList, "_token": "{{csrf_token()}}"},
						success: function(result){
							window.location = '/ViewEdit/' + round_no + '/';	
						}
					});				
				}
			});
			
			// press keys save data
			var timeoutId;
			$('input[name="amount_paid"], textarea[name="short_note"]').on('input propertychange change', function() {
				console.log('Textarea Change');
				var customer_no = $(this).attr('data-custno');
				var day = $(this).attr('data-day');
				console.log(day);
				var amount_paid;
				var note;
				
				clearTimeout(timeoutId);
				timeoutId = setTimeout(function() {
					// Runs 1 second (1000 ms) after the last change
					amount_paid = $('input[data-id="amount-' + customer_no +'"]').val();
					note = $('textarea[data-note="note-' + customer_no +'"]').val();					
					saveToDB(customer_no, amount_paid, note, day);
				}, 1000);
			});			
			
        });
		
		// function save amount paid and note data
		function saveToDB(customer_no, amount_paid, note, day)
		{
			console.log(amount_paid + '/' + note);
			$.ajax({
				url: "/ajax/round_update_note.php",
				type:"POST",
				data:{"customer_no":customer_no, "amount_paid":amount_paid, "note":note, "_token": "{{csrf_token()}}"},
				success: function(result){
					var sum = 0,
					amount = document.querySelectorAll('input[data-day="' + day + '"]'), i;
					for (i = 0; i < amount.length; i++) {
						sum += parseFloat(amount[i].value || 0);
					}
					$('.total_' + day).html("£" + sum.toFixed(2));
				}
			});
		}		

        // Code for google map popup
        $('.googleMapPopUp').each(function() {
            var thisPopup = $(this);
            thisPopup.colorbox({
                iframe: true,
                innerWidth: 400,
                innerHeight: 300,
                opacity: 0.7,
                href: thisPopup.attr('href') + '&ie=UTF8&t=h&output=embed'
            });
        });

		// Delete staff week end
		function Delete_staff_week_end(week_id, round_id, data_delete)
		{
			window.location = '/ViewEdit/' + round_id + '?type=delete_week_end&week_id=' + week_id + '&data_delete=' + data_delete;									
		}
		
        // Code To get Round Selected while reload from dropdown selection.
        function Find_round(id)
        {
            if(id != '0')
            {
                window.location='/ViewEdit/'+id
            }
        }

        function search_customer()
        {
            var customer_no = $('#customer_no').val();
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            if(customer_no !='' || first_name !='' || last_name !='')
            {
                $.ajax({
                    url: "/GetSearchedCustomers",
                    type:"POST",
                    data:{"customer_no":customer_no, "forename":first_name, "surname":last_name, "_token": "{{csrf_token()}}"},
                    success: function(result){
                        var obj = JSON.parse(result);
                        $('.htmldivshow').css('display','block');
                        if(obj.ResponseCode == '1'){
                            $('.tbody').html(obj.html);
                        }else if(obj.ResponseCode == '0'){
                            if(obj.html !=''){
                                $('.tbody').html(obj.html);
                            }else{
                                $('.tbody').html('<tr><td colspan="5"><center>{{ Lang::get('core.already_allocated') }}</center></td></tr>');
                            }
                        }else{
                            $('.tbody').html('<tr><td colspan="5"><center>{{ Lang::get('core.no_records') }}</center></td></tr>');
                        }
                    }
                });
            }else{
                alert('{{ Lang::get('core.input_criteria') }}');
            }
        }


        function add_customer()
        {
            if($('input[name="search_customers"]:checked').length > 0) {
                var customer_no = [];
                $('input[name="search_customers"]:checked').each(function () {
                    customer_no.push(this.value);
                });
                var cust_no = customer_no.join(',');
                var round_number = $('#customer_no_selected').val();
                $.ajax({
                    url: "/AddCustomersToRound",
                    type: "POST",
                    data: {"customer_no": cust_no, "round_number": round_number, "_token": "{{csrf_token()}}"},
                    success: function (result) {
                        var obj = JSON.parse(result);
                        window.location = obj.url;
                    }
                });
            }else{
                alert('{{ Lang::get('core.select_search_customer') }}');
            }
        }

        function remove_customer()
        {
            if($('input[name="insertedcustomers"]:checked').length > 0) {
            var relation_id=[];
            $('input[name="insertedcustomers"]:checked').each(function() {
                relation_id.push(this.value);
            });
            var relation = relation_id.join(',');
            var round_number = $('#customer_no_selected').val();
            $.ajax({
                url: "/RemoveCustomersToRound",
                type:"POST",
                data:{"relation_id":relation, "round_number":round_number, "_token": "{{csrf_token()}}"},
                success: function(result){
                    var obj = JSON.parse(result);
                    window.location = obj.url;
                }
            });
            }else{
                alert('{{ Lang::get('core.select_customer') }}');
            }
        }

        // Open Model to Show call back days when any customer is selected to put into callback list.
        function open_model()
        {
            if($('input[name="insertedcustomers"]:checked').length > 0)
            {
                $('#myModal').modal('show');
            }else{
                alert('{{ Lang::get('core.select_customer') }}');
            }
        }


        // Open Model to Show call back days when any customer is selected to put into callback list.
        function open_model_reassign()
        {
            if($('input[name="selectcallbacklist"]:checked').length > 0)
            {
                $('#ReassignMyModal').modal('show');
            }else{
                alert('{{ Lang::get('core.select_customer') }}');
            }
        }

        function assign_callback()
        {
            if($('input[name="CallbackDay"]:checked').length > 0 && $('#callback_timeSelect').val() !='')
            {
                var customer_no=[];
                $('input[name="insertedcustomers"]:checked').each(function() {
                    customer_no.push(this.value);
                });
                var cust_no = customer_no.join(',');
                var round_number = $('#customer_no_selected').val();
                var callback_day = $('input[name="CallbackDay"]:checked').val();
                var callback_time = $('#callback_timeSelect').val();
                $.ajax({
                    url: "/AssignCallbackList",
                    type:"POST",
                    data:{"customer_no":cust_no, "round_number":round_number, "callback_day":callback_day, "callback_time":callback_time, "_token": "{{csrf_token()}}"},
                    success: function(result){
                        var obj = JSON.parse(result);
                        window.location = obj.url;
                    }
                });
            }else{
                alert('{{ Lang::get('core.select_callback_day') }}');
            }
        }

        function Reassign_callback()
        {
            if($('input[name="CallbackDay_Reassign"]:checked').length > 0 && $('#callback_timeSelect_Reassign').val() !='')
            {
                var customer_no=[];
                $('input[name="selectcallbacklist"]:checked').each(function() {
                    customer_no.push(this.value);
                });
                var cust_no = customer_no.join(',');
                var round_number = $('#customer_no_selected').val();
                var callback_day = $('input[name="CallbackDay_Reassign"]:checked').val();
                var callback_time = $('#callback_timeSelect_Reassign').val();
                $.ajax({
                    url: "/ReassignCallbackList",
                    type:"POST",
                    data:{"customer_no":cust_no, "round_number":round_number, "callback_day":callback_day, "callback_time":callback_time, "_token": "{{csrf_token()}}"},
                    success: function(result){
                        var obj = JSON.parse(result);
                        window.location = obj.url;
                    }
                });
            }else{
                alert('{{ Lang::get('core.select_callback_day') }}');
            }
        }


        function remove_callback()
        {
            if($('input[name="selectcallbacklist"]:checked').length > 0)
            {
                var customer_no=[];
                $('input[name="selectcallbacklist"]:checked').each(function() {
                    customer_no.push(this.value);
                });
                var cust_no = customer_no.join(',');
                var round_number = $('#customer_no_selected').val();
                $.ajax({
                    url: "/RemoveFromCallbackList",
                    type:"POST",
                    data:{"customer_no":cust_no, "round_number":round_number, "_token": "{{csrf_token()}}"},
                    success: function(result){
                        var obj = JSON.parse(result);
                        window.location = obj.url;
                    }
                });
            }else{
                alert('{{ Lang::get('core.select_customer') }}');
            }
        }

        function go_selected_customer()
        {
            if($('input[name="insertedcustomers"]:checked').length > 0 || $('input[name="selectcallbacklist"]:checked').length > 0)
            {
                var customer_no=[];
                if($('input[name="insertedcustomers"]:checked').length > 0)
                {
                    $('input[name="insertedcustomers"]:checked').each(function() {
                        customer_no.push(this.value);
                    });
                }else if($('input[name="selectcallbacklist"]:checked').length > 0)
                {
                    $('input[name="selectcallbacklist"]:checked').each(function() {
                        customer_no.push(this.value);
                    });
                }
                var cust_no = customer_no.join(',');
                var round_number = $('#customer_no_selected').val();
                $.ajax({
                    url: "/GetCustomerNumber",
                    type:"POST",
                    data:{"relation_id":cust_no, "_token": "{{csrf_token()}}"},
                    success: function(result){
                        var obj = JSON.parse(result);
                        window.location='/Customeraccounts?search=customer_no:'+obj.cust_no+'&flag=adminround&round_number='+round_number;
                    }
                });
            }else{
                alert('{{ Lang::get('core.select_customer') }}');
            }
        }

        function add_details_open_popup(customer_no)
        {
            $('#model_customer_no').val(customer_no);
            $('#customer_main_model').modal('show');
        }

        function add_preferdaytime()
        {
            var customer_no = $('#model_customer_no').val();
            var prefer_day = $('#preferred_payment_day_popup').val();
            var prefer_time = $('#preferred_time_to_call_popup').val();
            if(prefer_day !='' && prefer_time !='')
            {
                $.ajax({
                    url: "/SaveCustomerMainDetails",
                    type:"POST",
                    data:{"customer_no":customer_no, 'prefer_day':prefer_day, 'prefer_time':prefer_time, "_token": "{{csrf_token()}}"},
                    success: function(result){
                        var obj = JSON.parse(result);
                        $('#'+customer_no+'_select_checkbox').prop('disabled',false);
                        $('#'+customer_no+'_time').html(obj.preferred_time_to_call);
                        $('#customer_main_model').modal('hide');
                        $('#preferred_time_to_call_popup').val('');
                        $('#preferred_payment_day_popup').val($("#preferred_payment_day_popup option:first").val());
                    }
                });
            }else{
                alert('{{ Lang::get('core.enter_prefer_details') }}');
            }
        }

    </script>
