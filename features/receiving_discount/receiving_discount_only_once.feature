@receiving_catalog_promotion_discount
Feature: Receiving discount only once
    In order to pay proper amount while buying catalog promoted goods
    As a Customer
    I want to have my product affected by promotion only once

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And the store has a product "PHP Mug" priced at "$6.00"
        And there is a "Holiday SALE" catalog promotion
        And it gives "$10.00" discount on every product

    @ui
    Scenario: Receiving fixed discount for my product
        When I add product "PHP T-Shirt" to the cart
        And I update my cart
        Then I should see "PHP T-Shirt" with unit price "$90.00" in my cart
