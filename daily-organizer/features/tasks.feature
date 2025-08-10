Feature: Task management
  In order to track my work
  As an authenticated user
  I want to manage my tasks

  Scenario: Create a task
    Given I am authenticated
    When I create a task titled "Buy milk" with due date "2025-01-10"
    Then the task "Buy milk" should exist with status "to do"

  Scenario: Update a task status
    Given a task "Buy milk" exists with status "to do"
    When I change the status of "Buy milk" to "in progress"
    Then the task "Buy milk" should have status "in progress"

  Scenario: Delete a task
    Given a task "Buy milk" exists
    When I delete the task "Buy milk"
    Then the task "Buy milk" should not exist

  Scenario: Filter tasks by status
    Given a task "Buy milk" exists with status "to do"
    And a task "Pay bills" exists with status "done"
    When I filter tasks by status "done"
    Then I should see the task "Pay bills"
    And I should not see the task "Buy milk"

  Scenario: Filter tasks by date
    Given a task "Buy milk" exists with due date "2025-01-10"
    And a task "Pay bills" exists with due date "2025-02-10"
    When I filter tasks by due date "2025-01-10"
    Then I should see the task "Buy milk"
    And I should not see the task "Pay bills"

