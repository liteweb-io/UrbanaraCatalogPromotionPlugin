@receiving_catalog_promotion_discount
Feature: Applying only one exclusive catalog promotion
    In order to be able to buy products with discounted prices
    As a Customer
    I want to have only one exclusive catalog promotion applied to my products

    Background:
        Given the store operates on a single channel in the "United States" named "Web"
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And there is an exclusive "Holiday SALE" catalog promotion
        And it gives "$20.00" discount on every product
        And there is a "Summer SALE" catalog promotion
        And it gives "$10.00" discount on every product

    @ui
    Scenario: Receiving only the exclusive catalog promotion even if product fulfils another promotion
        When I add product "PHP T-Shirt" to the cart
        Then I should see "PHP T-Shirt" with unit price "$80.00" in my cart

    @todo
    Scenario: Receiving only first exclusive catalog promotion even if other exclusive promotion exists
        Given the "Weekend SALE" catalog promotion has been made exclusive
        When I add product "PHP T-Shirt" to the cart
        Then the "PHP T-Shirt" item should cost "$80.00"
