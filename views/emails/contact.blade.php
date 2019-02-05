<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Dear Admin, </h2>
		<p>
			Today's Date :- {{ $created_at }} <br />
			Customer Number :- {{ $customer_no }} <br />
			Name :- {{ $forename }} {{ $surname }} <br />
			Email :- {{ $customer_email }} <br />
			Home Number :- {{ $home_telephone }} <br />
			Mobile :- {{ $mobile_number }}
		</p>
		
		{{ CNF_APPNAME }} 
	</body>
</html>