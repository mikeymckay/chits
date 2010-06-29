Feature: Upload Modules
  In order to manage modules and plug-ins
  As a chits administrator
  I want to be able to see about page

  Scenario: Visit about page
    Given I am logged in as "admin" with password "admin"
    When I click "ABOUT"
    Then I should see "About CHITS"

