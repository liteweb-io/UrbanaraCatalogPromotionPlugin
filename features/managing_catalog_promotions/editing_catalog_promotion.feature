@managing_catalog_promotions
Feature: Editing a catalog promotion
    In order to change the catalog promotion details
    As a Store Owner
    I want to be able to edit a catalog promotion

    Background:
        Given the store operates on a single channel in "United States"
        And there is a "Christmas sale" catalog promotion
        And I am logged in as an administrator

    @ui
    Scenario: Seeing disabled code field when editing a catalog promotion
        When I modify this catalog promotion
        Then the code field should be disabled

    @ui
    Scenario: Editing a catalog promotion's exclusiveness
        When I modify this catalog promotion
        And I make it exclusive
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the "Christmas sale" catalog promotion should be exclusive

    @ui
    Scenario: Editing a catalog promotion's channels
        When I modify this catalog promotion
        And I make it applicable for the "United States" channel
        And I add the fixed value discount with amount of "$10" for "United States" channel
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the "Christmas sale" catalog promotion should be applicable for the "United States" channel

    @ui
    Scenario: Changing the promotion start and end dates
        When I modify this catalog promotion
        And I make it available from "12.12.2017" to "24.12.2017"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the "Christmas sale" catalog promotion should be available from "12.12.2017" to "24.12.2017"
