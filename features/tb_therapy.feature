Feature: TB Therapy
In order to efficiently manage patient into a TB Therapy data
As a chits user

@reset_consult
Scenario:CONSULT
Given I am logged in as "user" with password "user"
And I click "TODAY'S PATIENTS"
And I should see "CONSULTS TODAY"
When I fill in "last" with "garcia"
And I press "Search"
And I should see "SEARCH RESULTS"
And I choose "consult_patient_id" 
And I press "Select Patient"
And I should see "VISIT DETAILS"
And I check by value "NTP"
And I press "Save Details"
Then I should see "TB Therapy"

@reset_consult
Scenario:First Visit TB Therapy Consult
Given I am logged in as "user" with password "user"
And I click "TODAY'S PATIENTS"
And I should see "CONSULTS TODAY"
When I fill in "last" with "garcia"
And I fill in "first" with "andres" 
And I press "Search"
And I should see "SEARCH RESULTS"
And I choose "consult_patient_id" 
And I press "Select Patient"
And I should see "VISIT DETAILS"
And I check by value "NTP"
And I press "Save Details"
And I should see "TB Therapy"
And I click "TB Therapy" 
And I should see "form_ntp_visit1"
And I select "Accountant" from "occupation"
And I select "1" from "hh_contacts"
And I select "Yes" from "bcg_scar"
And I select "Pulmonary" from "tb_class"
And I select "Bicol" from "region"
And I fill in "contact_person" with "09088656911"
And I select "New Patient" from "patient_type"
And I select "Regimen 1" from "treatment_category"
And I select "Pulmonary" from "tb_class"
And I select "Barangay Health Worker" from "treatment_partner"
And I select "Cured" from "treatment_outcome"
And I press "Save NTP Data"
And I click "CONSULT"
And I should see "form_consult"
And I press "End Consult"
And I should see "Are you sure you want to end this consult?"
When I press "Yes"
Then I should see "CONSULTS TODAY"


