@managing_catalog_promotions
Feature: Prevent deletion of the catalog promotions already applied to order item
    In order to maintain proper order history
    As a Store Owner
    I want to be prevented from deleting a catalog promotion which has been applied to the order item

    Background:
        Given the store operates on a single channel in "United States"
        And the store ships everywhere for free
        And the store allows paying with "Cash on Delivery"
        And the store has a product "PHP Mug" priced at "$12.00"
        And there is a "Christmas sale" catalog promotion
        And it discounts every product by "$3.00"
        And there is a customer "john.doe@gmail.com" that placed an order "#00000022"
        And the customer bought a single "PHP Mug"
        And the customer chose "Free" shipping method to "United States" with "Cash on Delivery" payment
        And I am logged in as an administrator

    @todo
    Scenario: Being unable to delete a catalog promotion that was applied to an order itemg
        When I try to delete a "Christmas sale" catalog promotion
        Then I should be notified that it is in use and cannot be deleted
        And catalog promotion "Christmas sale" should still exist in the registry
