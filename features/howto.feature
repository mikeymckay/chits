Feature: Upload Modules
  In order to manage modules and plug-ins
  As a chits administrator
  I want to be able to see howto page

  Scenario: Visit howto page
    Given I am logged in as "admin" with password "admin"
    When I click "HOWTO"
    Then I should see "CHITS HOWTO"

