@receiving_catalog_promotion_discount
Feature: Applying only catalog promotions available at that moment
    In order to be able to buy products with discounted prices
    As a Customer
    I want to have only available catalog promotions applied to my products

    Background:
        Given the store operates on a single channel in the "United States" named "Web"
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And there is a catalog promotion "Holiday SALE"
        And it gives "$10.00" discount on every product

    @todo
    Scenario: Receiving fixed discount for my product
        When I add product "PHP T-Shirt" to the cart
        Then the "PHP T-Shirt" item should cost "$90.00"

    @todo
    Scenario: Not receiving discount when promotion has ended
        Given the "Holiday SALE" catalog promotion has already expired
        When I add product "PHP T-Shirt" to the cart
        Then the "PHP T-Shirt" item should cost "$100.00"

    @todo
    Scenario: Not receiving discount when a promotion is not available yet
        Given the "Holiday SALE" catalog promotion has not started yet
        When I add product "PHP T-Shirt" to the cart
        Then the "PHP T-Shirt" item should cost "$100.00"
