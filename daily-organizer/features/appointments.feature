Feature: Appointment management
  In order to organize my schedule
  As an authenticated user
  I want to manage my appointments

  Scenario: Create an appointment
    Given I am authenticated
    When I create an appointment "Dentist" at "Clinic" from "2025-01-10 14:00" to "2025-01-10 15:00"
    Then the appointment "Dentist" should be scheduled for "2025-01-10 14:00"

  Scenario: Update an appointment
    Given an appointment "Dentist" exists at "Clinic" on "2025-01-10 14:00"
    When I change the location of "Dentist" to "New Clinic"
    Then the appointment "Dentist" should have location "New Clinic"

  Scenario: Delete an appointment
    Given an appointment "Dentist" exists
    When I delete the appointment "Dentist"
    Then the appointment "Dentist" should not exist

  Scenario: View appointments in a calendar
    Given an appointment "Dentist" exists on "2025-01-10"
    When I view the calendar for "2025-01-10"
    Then I should see the appointment "Dentist"

