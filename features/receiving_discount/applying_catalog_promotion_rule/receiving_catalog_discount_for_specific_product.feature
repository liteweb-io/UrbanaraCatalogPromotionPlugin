@receiving_catalog_promotion_discount
Feature: Receiving a catalog discount for the specific product
    In order to pay less while buying some promoted goods
    As a Customer
    I want to pay reduced price for these goods

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And there is a "T-Shirts promotion" catalog promotion
        And it gives "$20.00" off
        And it is applicable for "PHP T-Shirt" product

    @ui
    Scenario: Receiving fixed discount for promoted product
        When I add product "PHP T-Shirt" to the cart
        Then I should see "PHP T-Shirt" with unit price "$80.00" in my cart

    @ui
    Scenario: Receiving no discount for products other than the discounted ones
        Given the store has a product "PHP Mug" priced at "$20.00"
        When I add product "PHP Mug" to the cart
        Then I should see "PHP Mug" with unit price "$20.00" in my cart
