Feature: Login feature
  Scenario: What I can see
    Given I visit the login page
    Then I should see the text "Accesso"
    And I should see the button "Acceder"

  Scenario: Correct credentials
    Given I visit the login page
    Then I put "sistemas@zegucom.com.mx" on the "email" input
    And I put "test123" on the "password" input
    And I click the "Acceder" button
    Then I should see the text "Empleados"
