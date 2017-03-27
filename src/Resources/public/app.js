(function($) {
    $(document).ready(function() {
        $('#urbanara_catalog_promotion_discountType').handlePrototypes({
            'prototypePrefix': 'urbanara_catalog_promotion_discountType',
            'containerSelector': '.configuration'
        });

        $('#catalog_rules a[data-form-collection="add"]').on('click', function () {
            setTimeout(function(){
                $('select[name^="urbanara_catalog_promotion[rules]"][name$="[type]"]').last().change();
            }, 50);
        });
    });
})(jQuery);
