@managing_catalog_promotions
Feature: Adding a new catalog promotion with a rule
    In order to discount the prices for the all products within the specific criteria
    As a Store Owner
    I want to add a new catalog promotion with a rule to the registry

    Background:
        Given the store operates on a single channel in "United States"
        And the store classifies its products as "T-Shirts" and "Mugs"
        And I am logged in as an administrator

    @todo
    Scenario: Adding a new catalog promotion with taxon rule
        When I create a new catalog promotion
        And I specify its code as "HOLIDAY_SALE"
        And I name it "Holiday sale"
        And I make this promotion applicable for products from "T-Shirts" and "Mugs" taxons
        And I add it
        Then I should be notified that it has been successfully created
        And the "Holiday sale" catalog promotion should appear in the registry
        And this catalog promotion should be applicable for products from "T-Shirts" and "Mugs" taxons

    @todo
    Scenario: Adding a new catalog promotion with contains product rule
        Given the store has a product "PHP T-Shirt" priced at "$100.00"
        When I create a new catalog promotion
        And I specify its code as "PHP_TSHIRT_PROMOTION"
        And I name it "PHP T-Shirt promotion"
        And I make this promotion applicable for "PHP T-Shirt" product only
        And I add it
        Then I should be notified that it has been successfully created
        And the "PHP T-Shirt promotion" catalog promotion should appear in the registry
        And this catalog promotion should be applicable for "PHP T-Shirt" product only
