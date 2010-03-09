Feature: Appointments
	In order to maximize the use of chits
	As a chits user
	I want to be able to access Appointments Today

     Scenario: Access Appointments Menu
       Given I am logged in as "user" with password "user"
       And I click "APPOINTMENTS"
       Then I should see "No patients scheduled today."
