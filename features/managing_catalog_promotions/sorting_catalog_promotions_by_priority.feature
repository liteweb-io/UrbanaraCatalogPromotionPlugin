@managing_catalog_promotions
Feature: Sorting listed catalog promotions by priority
    the order in which the catalog promotions are used
    As an Store Owner
    I want to sort catalog promotions by their priority

    Background:
        Given the store operates on a single channel in "United States"
        And there is a "Pugs For Everyone" catalog promotion with priority 0
        And there is a "Honour Harambe" catalog promotion with priority 2
        And there is a "Gimme An Owl" catalog promotion with priority 1
        And I am logged in as an administrator

    @ui
    Scenario: Catalog promotions are sorted by priority in descending order by default
        When I browse catalog promotions
        Then I should see 3 catalog promotions on the list
        And the first catalog promotion on the list should have name "Honour Harambe"
        And the last catalog promotion on the list should have name "Pugs For Everyone"

    @ui
    Scenario: Catalog promotion's default priority is 0 which puts it at the bottom of the list
        Given there is a "Flying Pigs" catalog promotion
        When I browse catalog promotions
        Then I should see 4 catalog promotions on the list
        And the last catalog promotion on the list should have name "Flying Pigs"

    @ui
    Scenario: Promotion added with priority -1 is set at the top of the list
        Given there is a "Flying Pigs" catalog promotion with priority -1
        When I browse catalog promotions
        Then I should see 4 catalog promotions on the list
        And the first catalog promotion on the list should have name "Flying Pigs"
