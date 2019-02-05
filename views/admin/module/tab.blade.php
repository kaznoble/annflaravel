<ul class="nav nav-tabs" style="margin-bottom:10px;">
  <li @if(Session::get('gid') != 1) class="display_none {{($active == 'config' ? 'active' : '')}}" @endif><a href="{{ URL::to($module.'/config/'.$module_name)}}">Info</a></li>
  <li @if(Session::get('gid') != 1) class="display_none {{($active == 'sql' ? 'active' : '')}}" @endif>
  <a href="{{ URL::to($module.'/sql/'.$module_name)}}">SQL</a></li>
  <li @if(Session::get('gid') != 1) class="display_none {{($active == 'table' ? 'active' : '')}}" @endif>
  <a href="{{ URL::to($module.'/table/'.$module_name)}}">Table</a></li>
  <li @if(Session::get('gid') != 1) class="display_none {{($active == 'form' ? 'active' : '')}}" @endif>
  <a href="{{ URL::to($module.'/form/'.$module_name)}}">Form</a></li>
  <li @if(Session::get('gid') != 1) class="display_none {{($active == 'sub' ? 'active' : '')}}" @endif>
  <a href="{{ URL::to($module.'/sub/'.$module_name)}}">Master Detail</a></li>  
  <li @if(Session::get('gid') != 1) class="display_none {{($active == 'permission' ? 'active' : '')}}" @endif>
  <a href="{{ URL::to($module.'/permission/'.$module_name)}}">Permission</a></li>
  <li @if(Session::get('gid') != 1) class="display_none {{($active == 'rebuild' ? 'active' : '')}}" @endif>
   <a href="javascript://ajax" onclick="SximoModal('{{ URL::to($module.'/build/'.$module_name)}}','Rebuild Module {{$module_name}}')">Rebuild</a></li>
</ul>