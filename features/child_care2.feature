Feature: Child Care

In order to efficiently manage old patient into a child care data
As a chits user

Scenario: Old Patient
Given I am logged in as "user" with password "user"
And I click "TODAY'S PATIENTS"
And I should see "CONSULTS TODAY"
When I fill in "first" with "Allan"
When I fill in "last" with "Mendoza"
And I press "Search"
And I should see "SEARCH RESULTS"
And I choose "consult_patient_id"
And I press "Select Patient"
Then I should see "VISIT DETAILS"
@reset_consult
Scenario: Consult
Given I am logged in as "user" with password "user"
And I click "TODAY'S PATIENTS"
And I should see "CONSULTS TODAY"
When I fill in "first" with "Allan"
When I fill in "last" with "Mendoza"
And I press "Search"
And I should see "SEARCH RESULTS"
And I choose "consult_patient_id" 
And I press "Select Patient"
And I should see "VISIT DETAILS"
And I check "ptgroup[]"
And I press "Save Details"
Then I should see "CHILD"

@reset_consult
Scenario:Visit Child Care
When I create a sample patient
#And I am logged in as "user" with password "user"
And I click "TODAY'S PATIENTS"
And I should see "CONSULTS TODAY"
When I fill in "first" with "Allan"
When I fill in "last" with "Mendoza"
And I press "Search"
And I should see "SEARCH RESULTS"
And I choose "consult_patient_id" 
And I press "Select Patient"
And I should see "VISIT DETAILS"
And I check by value "FP"
And I press "Save Details"
And I should see "CHILD"
And I click "CHILD"
And I should see "services"
And I check "services[]"
And I check "vaccine[]"
When I press "Update Record"
And I should see "services[]"
And I should see "vaccine[]"
And I click "SIBLINGS"
And I should see "OTHER FAMILY MEMBERS"
And I check "patients[]"
And I press "Add Sibling"
And I should see "FIRST VISIT DATA"
And I click "BREASTFEEDING"
And I should see "FTITLE_CCDEV_BREASTFEED"
And I check "bfed_month[]"
And I fill in "date_bfed_six" with "03/02/2010"
And I press "Save Breastfeeding Status"
And I should see "bfed_month"
And I click "CONSULT"
And I should see "form_consult"
And I press "End Consult"
And I should see "confirm_end"
When I press "Yes"
Then I should see "CONSULTS TODAY"


