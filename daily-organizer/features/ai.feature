Feature: AI assisted productivity
  In order to work smarter
  As an authenticated user
  I want the assistant to help me manage my day

  Scenario: Create entry from natural language
    When I enter "Call the dentist tomorrow at 2pm"
    Then an appointment "Call the dentist" should be scheduled for tomorrow at 2pm

  Scenario: Suggest items for a shopping list
    Given I often buy "Milk"
    When I create a shopping list "Supermarket"
    Then I should be suggested to add "Milk"

  Scenario: Automatically categorize tasks
    When I create a task "Project meeting"
    Then the task should be categorized as "Work"

  Scenario: Prioritize important tasks
    Given a task "Pay bills" exists with due date tomorrow
    And a task "Clean house" exists with due date next week
    When I view the focus for today
    Then "Pay bills" should be suggested as a priority task

