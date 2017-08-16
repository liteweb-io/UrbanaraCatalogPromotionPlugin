@managing_catalog_promotions
Feature: Adding a new catalog promotion with a decoration
    In order to inform customer about discounted prices
    As a Store Owner
    I want to add a new catalog promotion with a decoration to the registry

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui @javascript
    Scenario: Adding a new catalog promotion with strikehtrough decoration
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I add strikethrough decoration available on all pages
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should be decorated with strikethrough on all pages

    @ui @javascript
    Scenario: Adding a new catalog promotion with message decoration
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I add "Friday!" message decoration in "English (United States)" locale available on all pages
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should be decorated with message "Friday!" on all pages

    @ui @javascript
    Scenario: Adding a new catalog promotion with banner decoration
        When I create a new catalog promotion
        And I specify its code as "WEEKEND_SALE_PROMOTION"
        And I name it "Weekend sale!"
        And I add top-right "//localhost/lol.png" banner decoration available on all pages
        And I add it
        Then I should be notified that it has been successfully created
        And the "Weekend sale!" catalog promotion should be decorated with top-right "//localhost/lol.png" banner on all pages
