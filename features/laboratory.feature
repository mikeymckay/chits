Feature: Appointments
	In order to maximize the use of chits
	As a chits user
	I want to be able to access Laboratory Menu

     Scenario: Access Laboratory Menu
       Given I am logged in as "user" with password "user"
       And I click "LABORATORY"
       Then I should see "No requests available."
