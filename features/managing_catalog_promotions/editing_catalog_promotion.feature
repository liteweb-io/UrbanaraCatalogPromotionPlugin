@managing_catalog_promotions
Feature: Editing a catalog promotion
    In order to change the catalog promotion details
    As a Store Owner
    I want to be able to edit a catalog promotion

    Background:
        Given the store operates on a single channel in "United States"
        And there is a "Christmas sale" catalog promotion
        And I am logged in as an administrator

    @todo
    Scenario: Seeing disabled code field when editing a catalog promotion
        When I want to modify the "Christmas sale" catalog promotion
        Then the code field should be disabled

    @todo
    Scenario: Editing a catalog promotion's exclusiveness
        When I modifythe "Christmas sale" catalog promotion
        And I make it exclusive
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the "Christmas sale" catalog promotion should be exclusive

    @todo
    Scenario: Editing a catalog promotion's channels
        When I modifythe "Christmas sale" catalog promotion
        And I make it applicable for the "United States" channel
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the "Christmas sale" catalog promotion should be applicable in the "United States" channel

    @todo
    Scenario: Changing the promotion start and end dates
        When I modifythe "Christmas sale" catalog promotion
        And I make it available from "12.12.2017" to "24.12.2017"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the "Christmas sale" catalog promotion should be available from "12.12.2017" to "24.12.2017"
