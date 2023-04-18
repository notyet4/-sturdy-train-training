define(['uiComponent','jquery'], function (Component, $){
    return Component.extend({
        defaults: {
            searchText: '',
            searchResult: [],
            availableSku: [],
            minChars: 3
        },
        initObservable: function() {
            this._super();
            this.observe(['searchText', 'searchResult']);
            return this;
        },
        initialize: function () {
            this._super();
            this.searchText.subscribe(this.handleAutocomplete.bind(this));
        },
        handleAutocomplete: function (searchValue) {
            if(searchValue.length >=  this.minChars) {
                $.ajax({
                    url: 'USERNAME/Index/getSku',
                    type: 'POST',
                    dataType: 'json',
                    data: {value: searchValue},
                    complete: function (answer) {
                        this.searchResult(answer.responseJSON);
                    }.bind(this)

                })
            }else {
                this.searchResult([]);
            }
        }
    });
})