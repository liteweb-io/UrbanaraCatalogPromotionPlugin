@receiving_catalog_promotion_discount
Feature: Receiving a catalog discount for the specific product
    In order to pay less while buying some promoted goods
    As a Customer
    I want to pay reduced price for these goods

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And there is a catalog promotion "T-Shirts promotion"
        And this promotion gives "$20.00" off for "PHP T-Shirt" product

    @todo
    Scenario: Receiving fixed discount for promoted product
        When I add product "PHP T-Shirt" to the cart
        Then the "PHP T-Shirt" item should cost "$80.00"

    @todo
    Scenario: Receiving no discount for products other than the discounted ones
        Given the store has a product "PHP Mug" priced at "$20.00"
        When I add product "PHP Mug" to the cart
        Then the "PHP Mug" item should cost "$20.00"
