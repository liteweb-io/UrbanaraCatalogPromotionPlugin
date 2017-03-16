@managing_catalog_promotions
Feature: Deleting a catalog promotion
    In order to remove test, obsolete or incorrect catalog promotions
    As a Store Owner
    I want to be able to delete a catalog promotion from the registry

    Background:
        Given the store operates on a single channel in "United States"
        And there is a "Christmas sale" catalog promotion
        And I am logged in as an administrator

    @ui
    Scenario: Deleted promotion should disappear from the registry
        When I delete the "Christmas sale" catalog promotion
        Then I should be notified that it has been successfully deleted
        And this catalog promotion should no longer exist in the promotion registry
