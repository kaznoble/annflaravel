<!DOCTYPE html>
<html lang="en">
 	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    	<title>{{ CNF_APPNAME }}</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">		
		{{ HTML::style('sximo/css/bootstrap.min.css')}}
		{{ HTML::style('sximo/css/sximo.css')}}
		{{ HTML::style('sximo/css/icons.min.css')}}
		
		{{ HTML::script('sximo/js/plugins/jquery.min.js') }}

	
  	</head>

<body class="full-width page-condensed bg-default">
	<div class="page-container">
		
	    	{{ $content }}
			
	</div>	  
		
</div>
	  
</html>