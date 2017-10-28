
//Define calendar(s): addCalendar ("Unique Calendar Name", "Window title", "Form element's name", Form name")
addCalendar("Calendar1", "Select Date", "checkindate", "reservation");
addCalendar("Calendar2", "Select Date", "checkoutdate", "reservation");

addCalendar("Calendar3", "Select Date", "arrivaldate", "bookings");
addCalendar("Calendar4", "Select Date", "departuredate", "bookings");

addCalendar("Calendar5", "Select Date", "date_started", "rates");
addCalendar("Calendar6", "Select Date", "date_stopped", "rates");

addCalendar("Calendar7", "Select Date", "doc_date", "billing");

addCalendar("Calendar8", "Select Date", "date", "report");

// default settings for English
// Uncomment desired lines and modify its values
// setFont("verdana", 9);
 setWidth(90, 1, 15, 1);
// setColor("#cccccc", "#cccccc", "#ffffff", "#ffffff", "#333333", "#cccccc", "#333333");
// setFontColor("#333333", "#333333", "#333333", "#ffffff", "#333333");
setFormat("yyyy-mm-dd");
// setSize(200, 200, -200, 16);

// setWeekDay(0);
// setMonthNames("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
// setDayNames("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
// setLinkNames("[Close]", "[Clear]");
