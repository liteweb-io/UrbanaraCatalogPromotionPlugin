@managing_catalog_promotions
Feature: Browsing catalog promotions
    In order to see all catalog promotions
    As a Store Owner
    I want to browse existing promotions

    Background:
        Given the store operates on a single channel in "United States"
        And there is a "Basic promotion" catalog promotion
        And I am logged in as an administrator

    @todo
    Scenario: Browsing catalog promotions
        When I browse catalog promotions
        Then there should be a single catalog promotion
        And the "Basic promotion" catalog promotion should exist in the registry
