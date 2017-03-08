@managing_catalog_promotions
Feature: Adding a new catalog promotion
    In order to discount the prices for the whole product catalog
    As a Store Owner
    I want to add a new catalog promotion

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @todo
    Scenario: Adding a new catalog promotion
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should appear in the registry

    @todo
    Scenario: Adding a new exclusive catalog promotion
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I make it exclusive
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should appear in the registry
        And this catalog promotion should be exclusive

    @todo
    Scenario: Adding a new catalog promotion with start and end dates
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I make it available from "21.04.2017" to "21.05.2017"
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should appear in the registry
        And this catalog promotion should be available from "21.04.2017" to "21.05.2017"

    @todo
    Scenario: Adding a new catalog promotion with fixed discount
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I add the fixed value discount with amount of "$10" for "United States" channel
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should appear in the registry
        And this catalog promotion should give "$10" discount for "United States" channel

    @todo
    Scenario: Adding a new catalog promotion with percentage discount
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I add the percentage discount with amount of 10%
        And I add it
        Then I should be notified that it has been successfully created
        And this catalog promotion should give "10%" discount

    @todo
    Scenario: Adding a new catalog promotion for a channel
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I make it applicable for the "United States" channel
        And I add it
        Then I should be notified that it has been successfully created
        And this catalog promotion should be applicable in the "United States" channel
