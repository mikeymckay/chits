Feature: Upload Modules
  In order to manage modules and plug-ins
  As a chits administrator
  I want to be able to add module

  Scenario: Visit admin page
    Given I am logged in as "admin" with password "admin"
    When I click "CREDITS"
    Then I should see "CHITS DEVELOPMENT"

