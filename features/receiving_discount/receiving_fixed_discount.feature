@receiving_catalog_promotion_discount
Feature: Receiving fixed discount
    In order to pay proper amount while buying catalog promoted goods
    As a Customer
    I want to buy goods for lower prices

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And the store has a product "PHP Mug" priced at "$6.00"
        And there is a "Holiday SALE" catalog promotion
        And it gives "$10.00" discount on every product

    @ui
    Scenario: Receiving fixed discount for my product
        When I add product "PHP T-Shirt" to the cart
        Then I should see "PHP T-Shirt" with unit price "$90.00" in my cart

    @ui
    Scenario: Receiving fixed discount equal to the item price even if the discount is bigger than that
        When I add product "PHP Mug" to the cart
        Then I should see "PHP Mug" with unit price "$0.00" in my cart

    @ui
    Scenario: Receiving fixed discount does not affect the shipping fee
        Given the store has "DHL" shipping method with "$10.00" fee
        And I am a logged in customer
        When I add product "PHP T-Shirt" to the cart
        And I proceed selecting "DHL" shipping method
        Then my cart total should be "$100.00"
        And my cart shipping total should be "$10.00"
