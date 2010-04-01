When /I create a sample patient/ do
	And "I am logged in as \"user\" with password \"user\""
	And "I click \"RECORDS\""
	And "I am on the patient management form"
	And "I fill in \"patient_firstname\" with \"Andres\""
	And "I fill in \"patient_middle\" with \"Cruz\""
	And "I fill in \"patient_lastname\" with \"Garcia\""
	And "I fill in \"patient_dob\" with \"02/03/1982\""
	And "I select \"Male\" from \"patient_gender\""
	And "I fill in \"patient_mother\" with \"Maria\""
	And "I fill in \"patient_cellphone\" with \"09191234567\""
	And "I press \"Add Patient\""
        And "Debug"
end
