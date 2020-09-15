define(['uiElement','ko'], function(Element, ko){
    viewModelConstructor = Element.extend({
        defaults: {
            template: 'Hainan_Sea/simple_valid_template'
        }
    });

    return viewModelConstructor;
});
