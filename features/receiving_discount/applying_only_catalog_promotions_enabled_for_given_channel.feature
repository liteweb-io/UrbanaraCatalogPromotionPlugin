@receiving_catalog_promotion_discount
Feature: Applying only catalog promotions enabled for a given channel
    In order to be able to buy products with discounted prices
    As a Customer
    I want to have only enabled catalog promotions applied to my products

    Background:
        Given the store operates on a single channel in the "United States" named "Web"
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And there is a "Holiday SALE" catalog promotion
        And it gives "$10.00" discount on every product

    @ui
    Scenario: Receiving fixed discount for my product
        When I add product "PHP T-Shirt" to the cart
        Then I should see "PHP T-Shirt" with unit price "$90.00" in my cart

    @ui
    Scenario: Not receiving discount when a promotion is disabled for the current channel
        Given the "Holiday SALE" catalog promotion has been disabled
        When I add product "PHP T-Shirt" to the cart
        Then I should see "PHP T-Shirt" with unit price "$100.00" in my cart
