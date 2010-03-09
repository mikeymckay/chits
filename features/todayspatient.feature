Feature: Manage Patients
	In order to maximize the time for health care delivery
	As a chits user
	I want to be able to manage patients by searching,creating,updating and deleting patient information

      Scenario: Add Consult Record
        Given I am logged in as "user" with password "user"
        And I  click "TODAY's PATIENT"
	When I fill in "first" with "Jose"	
        And I fill in "last" with "Rizal"
        And I press "Search"  
	And I should see "Found"
        And I choose "consult_patient_id"
        And I press "Select Patient"
        Then I should see "VISIT DETAILS"

