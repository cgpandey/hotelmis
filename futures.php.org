<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
</head>

<body>
<p align="center">HOTEL MANAGEMENT INFORMATION SYSTEMS FUTURES.</p>
<P> These are my scattered thoughts on part of the development, hopefull if i get time i will refine this to form part of the document<br>
Some of the notes appearing below have not been implemented, it's my hope that will get some people from the community out there to assist.
</p>

<P>To try out the system <h2>Username: demo, Passowrd: demo</h2><br>
You will realize that the menu behaves rather eratically appears on some pages and disappear on some pages.<br>
Until i start saving sessions in tables sorry you will have to know the page you need to visit by replacing the index.php with the relevant page.<br>
e.g <h3>guests.php, agents.php, bookings.php, billings.php, reservation.php, lookup.php, rates.php, rooms.php</h3><br>
<b>Please login to have some fun, do send me your suggestions and ways of improving it before i release it for downloads</b>
</p>

<p>Hotel details -name &ndash;get hotel details</p>
<p> -name/pin/vat/location/country</p>
<p> -facilities-room capacity/laundry/pools/bar</p>
<p> -meal types</p>
<p> -units type-cottages/rooms</p>
<p> -logo</p>
<p> -website</p>
<p>rooms -get room details-type/occupancy, upload room photo</p>
<p> -get room facilities and special rates on facilities</p>
<p> -determine room status-vacant/booked/reserved/locked</p>
<p> -print/preview rooms list</p>
<p> -staff in charge</p>
<p>countries -country details</p>
<p> -currency/trunk code/country code/time/nationality</p>
<p>online registration</p>
<ul>
  <li>Guest membership</li>
</ul>
<ul>
  <li>Get guest details</li>
  <li>Give password</li>
  <li>Send e-mail</li>
  <li>Guest can book/reserve online</li>
  <li>Guest can view room calendar</li>
  <li>Guest can amend reservation details/membership info</li>
  <li>Allow online payment credit cards/paypal</li>
  <li>Guest to view invoice/payment and print details</li>
  <li>Print/view members list</li>
</ul>
<p>From guest list :-</p>
<ul>
  <ul>
    <li>Book</li>
    <li>Reserve</li>
    <li>Post bill</li>
    <li>Check out</li>
  </ul>
</ul>
<ul>
  <li>Rates</li>
  <ul>
    <ul>
      <li>Create rates</li>
    </ul>
  </ul>
</ul>
<ul>
  <li>Direct rates &ndash;direct bookings by guests</li>
  <li>Agent rates &ndash;create rates for agents/tour operators</li>
  <li>Set rates residence &amp; non residence rates</li>
  <li>Set rates currency</li>
  <li>Determine rates/ meal plan RO/BB/HB/FB/AI</li>
  <li>Determine rates duration</li>
</ul>
<ul>
  <ul>
    <ul>
      <li>Print/view rates list</li>
    </ul>
</ul>
</ul>
<ul>
  <li>Agents membership</li>
</ul>
<ul>
  <li>Get agents details</li>
  <li>Give password &amp;send e-mail</li>
  <li>Agents can book/register their guests online</li>
  <li>Agents can view bookings/reservations online</li>
  <li>Agents to view their rates</li>
  <li>Agents to pay online for their guests</li>
  <li>Agents list (print preview)</li>
</ul>
<p>(Tour operators) Require a/c activation</p>
<ul>
  <li>Admin/Users</li>
</ul>
<ul>
  <li>Create user accounts</li>
  <li>Determine user levels (employee/guest/agents)</li>
  <li>Set user access rights (admin/guest/agents) </li>
  <li>Set what page users can view.</li>
  <li>Users to reset their passwords.</li>
</ul>
<ul>
  <li>Booking can only be done by registered guests or through agents.</li>
</ul>
<p>-Staff can also book guest. Guest can only be booked after their guest details have been entered</p>
<ul>
  <li>Get guest details.</li>
  <li>Get looking details-meal plan, no .of occupancy, payment mode</li>
  <li>Determine if it&rsquo;s a direct booking or through an agent </li>
  <li>Book and print registration card, create bill, meal room as booked</li>
  <li>Get rates</li>
  <li>Could either directly, through agents or from reservations list.</li>
  <li>Produce booking list </li>
  <li>Automatically create bill for reservations with deposits only.</li>
  <li>Reservation</li>
  <li>Create bill for reservations with deposits only</li>
</ul>
<ul>
  <li>Reservation: Reservations can be done directly, through agents, or staff. A reservation must be done from registered guest.</li>
</ul>
<p> NB. A possibility of having booking &amp; reservation in one table with a tag for booking/reservation.</p>
<p>Get guest details</p>
<p>Get reservation details </p>
<ul>
  <li>Reserved arrival, departure dates (get night automatically)</li>
  <li>Get occupancy, meal plan</li>
  <li>Indicates if it&rsquo;s a direct or agent/tour operators reservation </li>
  <li>Person taking the reservation to be confirmed by a 2 nd party</li>
  <li>Get country of residence</li>
</ul>
<p>NB.</p>
<p>Give 5 day alert reservation notice and send mail to guest for confirmation. (either by sending mail </p>
<p>notification)</p>
<p>print preview reservation list (book guest)</p>
<p>once guest is booked remove from reservation list</p>
<p>if deposit has been paid create bill &amp; mark room as reserved</p>
<p>print reservation form, reserve room, create bill if deposit has been paid.</p>
<p>Room can be reserved as many times as long as not on the same date</p>
<p>- Booked room can be reserved for future date</p>
<p>- Booking can be done on current date</p>
<ul>
  <li>Guest Bills</li>
</ul>
<p>Bills are automatically created on booking of guest or reservations whose deposit has been paid</p>
<p>A bills list is provided to select pending bills and get bills details</p>
<p>Post bills, chits, receipts on booked guests against the bill</p>
<ul>
  <li>Lookup</li>
</ul>
<p>Setup items/parameters used by the system.</p>
<ul>
  <li>Transaction items</li>
  <li>Transaction types</li>
  <li>Document types</li>
  <li>Room types</li>
  <li>Countries</li>
  <li>Payment modes &ndash; cash, cheque, company&rsquo;s cheque, credit cards</li>
</ul>
<p>Other checks to be done:</p>
<p>Booking/reservation &ndash; check if guests already booked reserved before checking them in</p>
<p>Validate for emails</p>
<p>Booking calendar</p>
<p>Guest lists &ndash; remove some actions:</p>
<ul>
  <li>If booked remove booked link</li>
  <li>If reserved remove reserve link</li>
</ul>
<p>Reservation bills not being displayed</p>
<p>Validate for dates in booking and reservations.</p>

</body>
</html>