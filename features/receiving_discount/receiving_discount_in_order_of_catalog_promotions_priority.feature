@receiving_catalog_promotion_discount
Feature: Receiving discount in the order defined by the catalog promotions' priorities
    In order to pay proper amount while buying discounted goods
    As a Customer
    I want to have discounts applied in the correct order

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "The Pug Mug" priced at "$100.00"

    @todo
    Scenario: Receiving fixed discount first when priority is greater
        Given there is a catalog promotion "Cebula Deal" with priority 1
        And it gives "$10.00" discount on every product
        And there is a catalog promotion "Santa's SALE" with priority 4
        And it gives "20%" discount on every product
        When I add product "The Pug Mug" to the cart
        Then the "The Pug Mug" item should cost "$70.00"

    @todo
    Scenario: Receiving percentage discount first when priority is greater
        Given there is a catalog promotion "Cebula Deal" with priority 5
        And it gives "$10.00" discount on every product
        And there is a catalog promotion "Santa's SALE" with priority 2
        And it gives "20%" discount on every product
        When I add product "The Pug Mug" to the cart
        Then the "The Pug Mug" item should cost "$72.00"

    @todo
    Scenario: Receiving discount from exclusive promotion even if its priority is lower than others
        Given there is a catalog promotion "Cebula Deal" with priority 5
        And it gives "$10.00" discount on every product
        And there is an exclusive catalog promotion "Golden Pug Market" with priority 1
        And it gives "20%" discount on every product
        When I add product "The Pug Mug" to the cart
        Then the "The Pug Mug" item should cost "$80.00"

    @todo
    Scenario: Receiving discount from an exclusive promotion with higher priority
        Given there is an exclusive catalog promotion "Golden Pug Market" with priority 1
        And it gives "20%" discount on every product
        And there is an exclusive catalog promotion "Sloth's Agility" with priority 5
        And it gives "$10.00" discount on every product
        When I add product "The Pug Mug" to the cart
        Then the "The Pug Mug" item should cost "$90.00"
