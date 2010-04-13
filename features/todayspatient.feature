Feature: Todays Patients
	This is Ryan trying to make a test for Today's Patients
	As a chits user
	I want to be able to manage track taday's patients 

	Scenario: Patient Loaded in Family Planning Module
    Given I am logged in as "user" with password "user"
    And I click "TODAY'S PATIENTS"
		When I click "CLICK TO VIEW RECORD"
		And I check "ptgroup[]"
		And I press "Save Details"
		And I click "DETAILS"
		Then I should see "FAMILY"

	Scenario: Patient Loaded in Maternal Care Module
    Given I am logged in as "user" with password "user"
    And I click "TODAY'S PATIENTS"
		When I click "CLICK TO VIEW RECORD"
		And I check "ptgroup[]"
		And I press "Save Details"
		And I click "DETAILS"
		Then I should see "MATERNAL"


	Scenario: Patient Loaded in 
    Given I am logged in as "user" with password "user"
    And I click "TODAY'S PATIENTS"
		When I click "CLICK TO VIEW RECORD"
		And I check "ptgroup[]"
		And I press "Save Details"
		And I click "DETAILS"
		Then I should see "NTP"
