@receiving_catalog_promotion_discount
Feature: Receiving fixed discount
    In order to pay proper amount while buying catalog promoted goods
    As a Customer
    I want to buy the goods for the lower price

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And there is a catalog promotion "Holiday SALE"
        And it gives 10% discount on every product

    @todo
    Scenario: Receiving percentage discount for my product
        When I add product "PHP T-Shirt" to the cart
        Then the "PHP T-Shirt" item should cost "$90.00"

    @todo
    Scenario: Receiving percentage discount does not affect the shipping fee
        Given the store has "DHL" shipping method with "$10.00" fee
        And I am a logged in customer
        When I add product "PHP T-Shirt" to the cart
        And I proceed selecting "DHL" shipping method
        Then my cart total should be "$100.00"
        And my cart shipping total should be "$10.00"
