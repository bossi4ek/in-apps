Feature: Test
  In order to
  As authorized user
  I need to be entered to admin panel

#  @insulated @javascript
#  Scenario: Enter album view page as user which has access to it
#    Given I am on homepage
#    When I go to "/content"
#    Then I should see "Все приложения"
#    When I go to "/login"
#    Then I should see "security.login.username"
#    When I fill in "username" with "admin"
#    And I fill in "password" with "admin"
#    And I press "security.login.submit"
#    Then I should see "AdminPanel"

  @insulated @javascript
  Scenario: Checking content to broadly, the presence in the database
    Given the following content exist:
      | id | slug            |
      | 1  | badland         |
      | 2  | can_knockdown_3 |
      | 3  | 1111            |
      | 4  | gravity_maze    |