# Blood-Bank-System

Design a simple ‘Blood Bank System’ web application:

The application contain 2 types of users: Hospitals and Receivers

Pages developed-

‘Registration’ pages - Different registration pages for hospitals & receivers. Captured receiver’s blood group during registration.

‘Login’ pages - Single login pages for hospitals & receivers.

‘Add blood info’ page - A hospital, once logged in, is able to add details of available blood samples (along with type) to their bank.
Access to this page is restricted only to hospitals. 

‘Available blood samples’ page - There is a page that displays all the available blood samples along with which hospital has them and a ‘Request Sample’ button.
This page is accessible to everyone, irrespective of whether the user is logged in or not.
Only receivers is able to request for blood samples by clicking the ‘Request Sample’ button.

‘View requests’ page - Hospitals is able to see the list of all the receivers who have requested for particular blood group from its blood bank.

If the user is not logged in, then he/she is redirected to the login page.
If a user is logged in as a hospital, then the user is not allowed to request for a blood sample.

