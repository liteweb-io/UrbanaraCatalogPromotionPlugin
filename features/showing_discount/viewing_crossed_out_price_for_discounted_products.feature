@showing_catalog_discount
Feature: Viewing a crossed out price for discounted products
    In order to see current catalog promotions
    As a Visitor
    I want to see the old price crossed out and a new one next to it

    Background:
        Given the store operates on a single channel in "United States"
        And there is a "Holiday SALE" catalog promotion
        And it gives "$10.00" discount on every product
        And the store has a product "PHP T-Shirt" priced at "$100.00"

    @ui
    Scenario: Viewing a catalog promotion on the details page of a product
        When I check this product's details
        Then the old product price "$100.00" should be crossed out
        And the new product price should be "$90.00"

    @ui
    Scenario: Viewing a catalog promotions on the products list
        Given the store classifies its products as "T-Shirts"
        And this product belongs to "T-Shirts"
        When I browse products from taxon "T-Shirts"
        Then the old product price "$100.00" should be crossed out
        And the new product price should be "$90.00"

    @ui
    Scenario: Viewing a catalog promotion in the cart
        When I add product "PHP T-Shirt" to the cart
        And I see the summary of my cart
        Then the old product price "$100.00" should be crossed out
        And the new product price should be "$90.00"
