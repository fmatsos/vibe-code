Feature: Shopping list management
  In order to remember what to buy
  As an authenticated user
  I want to manage my shopping lists

  Scenario: Create a shopping list
    Given I am authenticated
    When I create a shopping list named "Supermarket"
    Then a shopping list "Supermarket" should exist

  Scenario: Add an item to a list
    Given a shopping list "Supermarket" exists
    When I add "Milk" to the "Supermarket" list
    Then the "Supermarket" list should contain "Milk"

  Scenario: Remove an item from a list
    Given a shopping list "Supermarket" exists with an item "Milk"
    When I remove "Milk" from the "Supermarket" list
    Then the "Supermarket" list should not contain "Milk"

  Scenario: Mark an item as purchased
    Given a shopping list "Supermarket" exists with an item "Milk"
    When I mark "Milk" as purchased in the "Supermarket" list
    Then the item "Milk" should be marked as purchased

