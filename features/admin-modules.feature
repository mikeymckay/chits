Feature: Upload Modules
  In order to manage modules and plug-ins
  As a chits administrator
  I want to be able to add module

  Scenario: Visit admin-module page
    Given I am logged in as "admin" with password "admin"
    When I click "MODULES"
    Then I should see "MODULE DATABASE"

  Scenario: A Module DeActivation
    Given I am logged in as "admin" with password "admin"
    When I click "MODULES"
    And I click "Activate Modules"
    And I check "initmod[]"
    And I press "Update Activation Status"
    Then I should see "Permission denied"
     
  Scenario: A Module Activation
    Given I am logged in as "admin" with password "admin"
    When I click "MODULES"
    And I click "Activate Modules"
    And I check by value "appointment"
    And I press "Update Activation Status"
    Then I should see "Permission denied"
    
