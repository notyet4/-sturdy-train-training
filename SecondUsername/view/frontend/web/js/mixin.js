define(['uiComponent','jquery'], function (Component, $){
    return function (Component){
        return Component.extend({
            defaults: {
                minChars: 5
            }
        });
    }  
});