@managing_catalog_promotions
Feature: Catalog promotion unique code validation
    In order to uniquely identify catalog promotions
    As a Store Owner
    I want to be prevented from adding two catalog promotions with the same code

    Background:
        Given the store operates on a single channel in "United States"
        And there is a "No-VAT promotion" catalog promotion identified by "NO_VAT" code
        And I am logged in as an administrator

    @ui
    Scenario: Trying to add a catalog promotion with an already used code
        When I create a new catalog promotion
        And I specify its code as "NO_VAT"
        And I name it "No VAT promotion"
        And I try to add it
        Then I should be notified that a catalog promotion with this code already exists
        And there should still be only one catalog promotion with code "NO_VAT"
