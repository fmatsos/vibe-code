Feature: Notifications and reminders
  In order to stay on top of my schedule
  As an authenticated user
  I want to receive reminders for upcoming items

  Scenario: Receive a reminder for a task
    Given a task "Pay bills" exists with due date "2025-01-10"
    When the reminder time for "Pay bills" is reached
    Then I should receive a notification for "Pay bills"

  Scenario: Receive a reminder for an appointment
    Given an appointment "Dentist" is scheduled at "2025-01-10 14:00"
    When the time is "2025-01-10 13:45"
    Then I should receive a reminder for "Dentist"

