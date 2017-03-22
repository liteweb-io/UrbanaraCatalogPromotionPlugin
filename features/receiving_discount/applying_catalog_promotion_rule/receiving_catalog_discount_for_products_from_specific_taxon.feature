@receiving_catalog_promotion_discount
Feature: Receiving a catalog discount for products from specific taxon
    In order to pay less while buying goods from promoted taxon
    As a Customer
    I want to have reduced price for these goods

    Background:
        Given the store operates on a single channel in "United States"
        And the store classifies its products as "T-Shirts" and "Mugs"
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And it belongs to "T-Shirts"
        And the store has a product "PHP Mug" priced at "$20.00"
        And it belongs to "Mugs"
        And there is a "T-Shirts promotion" catalog promotion
        And it gives "$20.00" off
        And it is applicable for products classified as "T-Shirts"

    @ui
    Scenario: Receiving discount when buying a product from a promoted taxon
        When I add product "PHP T-Shirt" to the cart
        Then I should see "PHP T-Shirt" with unit price "$80.00" in my cart

    @ui
    Scenario: Receiving no discount for products from taxons other than the promoted one
        When I add product "PHP Mug" to the cart
        Then I should see "PHP Mug" with unit price "$20.00" in my cart
