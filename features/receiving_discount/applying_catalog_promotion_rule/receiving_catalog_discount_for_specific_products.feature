@receiving_catalog_promotion_discount
Feature: Receiving a catalog discount for specific products
    In order to pay less while buying promoted goods
    As a Customer
    I want to have reduced price for these goods

    Background:
        Given the store operates on a single channel in "United States"
        And the store classifies its products as "T-Shirts" and "Mugs"
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And it belongs to "T-Shirts"
        And the store has a product "PHP Mug" priced at "$20.00"
        And it belongs to "Mugs"
        And there is a catalog promotion "T-Shirts promotion"
        And the promotion gives "$20.00" off for products classified as "T-Shirts"

    @todo
    Scenario: Receiving discount when buying a product from a promoted taxon
        When I add product "PHP T-Shirt" to the cart
        Then the "PHP T-Shirt" item should cost "$80.00"

    @todo
    Scenario: Receiving no discount for products from taxons other than the promoted one
        When I add product "PHP Mug" to the cart
        Then the "PHP Mug" item should cost "$20.00"
