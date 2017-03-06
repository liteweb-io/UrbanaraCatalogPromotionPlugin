@managing_catalog_promotions
Feature: Catalog promotion validation
    In order to avoid making mistakes when managing catalog promotions
    As a Store Owner
    I want to be prevented from adding them without specifying the required fields

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @todo
    Scenario: Trying to add a new catalog promotion without specifying its code
        When I create a new catalog promotion
        And I name it "No-VAT promotion"
        And I do not specify its code
        And I try to add it
        Then I should be notified that a code is required
        And the catalog promotion with name "No-VAT promotion" should not be added

    @todo
    Scenario: Trying to add a new catalog promotion without specifying its name
        When I create a new catalog promotion
        And I specify its code as "no_vat_promotion"
        But I do not name it
        And I try to add it
        Then I should be notified that a name is required
        And the catalog promotion with code "no_vat_promotion" should not be added

    @todo
    Scenario: Adding a catalog promotion with start date set up after end date
        When I create a new catalog promotion
        And I specify its code as "FULL_METAL_PROMOTION"
        And I name it "Full metal promotion"
        And I make it available from "24.12.2017" to "12.12.2017"
        And I try to add it
        Then I should be notified that a catalog promotion cannot end before it starts

    @todo
    Scenario: Adding a catalog promotion with fixed discount without the price for enabled channel
        When I create a new catalog promotion
        And I specify its code as "FULL_METAL_PROMOTION"
        And I name it "Full metal promotion"
        And I make it applicable for the "United States" channel
        But I don't add the price for fixed value discount
        And I try to add it
        Then I should be notified that a catalog promotion cannot be created without price

    @todo
    Scenario: Trying to remove name from an existing catalog promotion
        Given there is a "Christmas sale" catalog promotion
        And I want to modify this promotion
        When I remove its name
        And I try to save my changes
        Then I should be notified that a name is required
        And this catalog promotion should still be named "Christmas sale"

    @todo
    Scenario: Trying to add start date later than end date for an existing catalog promotion
        Given there is a "Christmas sale" catalog promotion
        And I want to modify this promotion
        And I make it available from "24.12.2017" to "12.12.2017"
        And I try to save my changes
        Then I should be notified that a catalog promotion cannot end before it starts
