<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Dear {{ $forename }} {{ $surname }}, </h2>
		<p> Welcome to ANNFinance! </p>
		<p>
			Your Customer No : {{ $customer_no }} <br />
			Your Email username : {{ $customer_email }} <br />
			Your Password: {{ $password	}}
		</p>
		
		<p>
			Please use the link below to activate your account
		</p>
		
		<p>
			<a href="{{ URL::to('customer_verfication?code=' . $confirmation_code) }}" >Click here to activate</a>			
		</p>
		
		<p> Thank You </p><br /><br />
		
		{{ CNF_APPNAME }} 
	</body>
</html>