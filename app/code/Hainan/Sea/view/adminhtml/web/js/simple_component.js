define(['uiElement','ko'], function(Element,ko){
    viewModelConstructor = Element.extend({
        defaults: {
            template: 'Hainan_Sea/simple_template'
        },
        message: ko.observable("Hello Knockout.js!")
    });

    return viewModelConstructor;
});
