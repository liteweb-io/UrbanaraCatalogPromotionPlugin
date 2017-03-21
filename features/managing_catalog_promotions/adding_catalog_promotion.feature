@managing_catalog_promotions
Feature: Adding a new catalog promotion
    In order to discount the prices for the whole product catalog
    As a Store Owner
    I want to add a new catalog promotion

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui
    Scenario: Adding a new catalog promotion
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should appear in the registry

    @ui
    Scenario: Adding a new exclusive catalog promotion
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I make it exclusive
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should be exclusive

    @ui
    Scenario: Adding a new catalog promotion with start and end dates
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I make it available from "21.04.2017" to "21.05.2017"
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should be available from "21.04.2017" to "21.05.2017"

    #This scenario should be run as a juvascript, but there is a problem with running them so temporary can be run headless
    @ui
    Scenario: Adding a new catalog promotion with fixed discount
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I add the fixed value discount with amount of "$10" for "United States" channel
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should give "$10" discount for "United States" channel

    @ui @javascript
    Scenario: Adding a new catalog promotion with percentage discount
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I specify the percentage discount with amount of "10%"
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should give "10%" discount

    @ui
    Scenario: Adding a new catalog promotion for a channel
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I make it applicable for the "United States" channel
        And I add the fixed value discount with amount of "$10" for "United States" channel
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should be applicable for the "United States" channel

    @ui
    Scenario: Adding a new catalog promotion with priority
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I set its priority to 1
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should have priority set to 1
