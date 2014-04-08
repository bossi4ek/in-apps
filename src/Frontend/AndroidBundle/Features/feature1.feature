Feature: Test
  In order to
  As authorized user
  I need to be entered to admin panel

  @insulated @javascript
  Scenario: Test my feature iLoggedInAsWithPassword
    Given I logged in as "admin" with "admin" password
    When go to "/content/top"
    Then I should see "Все приложения"

  @insulated @javascript
  Scenario: Enter content view page as user which has access to it
    Given I am on homepage
    When I go to "/content"
    Then I should see "Все приложения"
    Given I logged in as "admin" with "admin" password

  @insulated @javascript
  Scenario: Checking content to broadly, the presence in the database
    Given the following content exist:
      | id | slug            |
      | 1  | badland         |
      | 2  | can_knockdown_3 |
      | 3  | 1111            |
      | 4  | gravity_maze    |