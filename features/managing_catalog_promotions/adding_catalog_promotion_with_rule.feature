@managing_catalog_promotions
Feature: Adding a new catalog promotion with a rule
    In order to discount the prices for the all products within the specific criteria
    As a Store Owner
    I want to add a new catalog promotion with a rule to the registry

    Background:
        Given the store operates on a single channel in "United States"
        And the store classifies its products as "T-Shirts" and "Mugs"
        And I am logged in as an administrator

    @todo
    Scenario: Adding a new catalog promotion with taxon rule
        When I create a new catalog promotion
        And I specify its code as "HOLIDAY_SALE"
        And I name it "Holiday sale"
        And I make this promotion applicable for products from "T-Shirts" and "Mugs" taxons
        And I add it
        Then I should be notified that it has been successfully created
        And the "Holiday sale" catalog promotion should appear in the registry
        And this catalog promotion should be applicable for products from "T-Shirts" and "Mugs" taxons

    @todo
    Scenario: Adding a new catalog promotion with contains product rule
        Given the store has a product "PHP T-Shirt" priced at "$100.00"
        When I create a new catalog promotion
        And I specify its code as "PHP_TSHIRT_PROMOTION"
        And I name it "PHP T-Shirt promotion"
        And I make this promotion applicable for "PHP T-Shirt" product only
        And I add it
        Then I should be notified that it has been successfully created
        And the "PHP T-Shirt promotion" catalog promotion should appear in the registry
        And this catalog promotion should be applicable for "PHP T-Shirt" product only

    # Last condition for this feature needs to have javascript and thus selenium-chromedriver enabled,
    # which is currently under maintenance.
    @ui
    Scenario: Adding a new catalog promotion which contains product rule for delivery time
        When I create a new catalog promotion
        And I specify its code as "DELIVERY_TIME_PROMO"
        And I name it "Delivery time promo"
#        And I set rule delivery time "more" than 2 weeks
        And I add the fixed value discount with amount of "$10.00" for "United States" channel
        And I add it
        Then I should be notified that it has been successfully created
        And the "Delivery time promo" catalog promotion should appear in the registry
        And the "Delivery time promo" catalog promotion should give "$10" discount for "United States" channel
#        And the "Delivery time promo" catalog promotion should be applicable for delivery time "more" than 2 weeks

    # Last condition for this feature needs to have javascript and thus selenium-chromedriver enabled,
    # which is currently under maintenance.
    @ui
    Scenario: Adding a new catalog promotion with contains product in sku list rule
        Given the store has a "text" product attribute "sku" with code "sku"
        And the store has a product "PHP T-Shirt" priced at "$100"
        And this product has a text attribute "sku" with value "php-t-shirt"
        And the store has a product "PHP Mug" priced at "$50"
        And this product has a text attribute "sku" with value "php-mug"
        And the store has a product "PHP Mousepad" priced at "$20"
        And this product has a text attribute "sku" with value "php-mousepad"
        And the store has a product "PHP Sticker" priced at "$10"
        And this product has a text attribute "sku" with value "php-sticker"
        When I create a new catalog promotion
        And I specify its code as "PHP_SKU_PROMOTION"
        And I name it "PHP SKU promotion"
#        And I make this catalog promotion applicable for product sku in the list "php-t-shirt, php-mug, php-mousepad" only
        And I add it
        Then I should be notified that it has been successfully created
        And the "PHP SKU promotion" catalog promotion should appear in the registry
#        And this catalog promotion should be applicable for product sku "php-t-shirt"
#        And this catalog promotion should not be applicable for product sku "php-sticker"