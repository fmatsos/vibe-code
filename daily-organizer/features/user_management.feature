Feature: User account management
  In order to access my personal organizer
  As a visitor
  I want to manage my account and sessions

  Scenario: Register with valid data
    Given I am on the registration page
    When I register with email "john@example.com" and password "secret"
    Then my account should be created

  Scenario: Login with valid credentials
    Given a user exists with email "john@example.com" and password "secret"
    When I log in with email "john@example.com" and password "secret"
    Then I should be authenticated

  Scenario: Logout from the application
    Given I am logged in as "john@example.com"
    When I log out
    Then I should be logged out

  Scenario: Request a password reset
    Given a user exists with email "john@example.com"
    When I request a password reset for "john@example.com"
    Then a password reset link should be emailed to "john@example.com"

  Scenario: Users cannot access each other's data
    Given a user "alice@example.com" has a task "Buy milk"
    And I am logged in as "bob@example.com"
    When I try to view the task "Buy milk" from "alice@example.com"
    Then I should not be allowed to see it

