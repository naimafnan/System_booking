Dear {{$userBooking['name']}},
<p>Thank you for booking your appointment with FOMEMA</p>
Doctor :{{ $userBooking['providerName'] }}<br>
Time :{{$userBooking['time']}}<br>
Date :{{$userBooking['date']}}<br>
Location : {{ $userBooking['Add1'] }},{{ $userBooking['Add2'] }},{{ $userBooking['Add3'] }},{{ $userBooking['Add4'] }},{{ $userBooking['Postcode'] }},{{ $userBooking['State'] }}<br>
Clinic's Name :{{ $userBooking['company_name'] }}