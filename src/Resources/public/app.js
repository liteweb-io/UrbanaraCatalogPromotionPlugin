(function($) {
    $(document).ready(function() {
        $('#acme_sylius_catalog_promotion_discountType').handlePrototypes({
            'prototypePrefix': 'acme_sylius_catalog_promotion_discountType',
            'containerSelector': '.configuration'
        });

        $('#catalog_rules a[data-form-collection="add"]').on('click', function () {
            setTimeout(function(){
                $('select[name^="acme_sylius_catalog_promotion[rules]"][name$="[type]"]').last().change();
            }, 50);
        });
    });
})(jQuery);
