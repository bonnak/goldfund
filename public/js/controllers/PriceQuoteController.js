angular.module('app')
.directive('onFinishRender', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit(attr.onFinishRender);
                });
            }
        }
    }
})
.controller('PriceQuoteController', [
    '$scope',
    '$http',
    '$interval',
    function ($scope, $http, $interval){
        
        // var Symbol = "", CompName = "", Price = "", ChnageInPrice = "", PercentChnageInPrice = ""; 
        // var flickerAPI = "http://query.yahooapis.com/v1/public/yql?format=json&q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDEUR%22,%20%22USDJPY%22,%20%22USDBGN%22,%20%22USDCZK%22,%20%22USDDKK%22,%20%22USDGBP%22,%20%22USDHUF%22,%20%22USDLTL%22,%20%22USDLVL%22,%20%22USDPLN%22,%20%22USDRON%22,%20%22USDSEK%22,%20%22USDCHF%22,%20%22USDNOK%22,%20%22USDHRK%22,%20%22USDRUB%22,%20%22USDTRY%22,%20%22USDAUD%22,%20%22USDBRL%22,%20%22USDCAD%22,%20%22USDCNY%22,%20%22USDHKD%22,%20%22USDIDR%22,%20%22USDILS%22,%20%22USDINR%22,%20%22USDKRW%22,%20%22USDMXN%22,%20%22USDMYR%22,%20%22USDNZD%22,%20%22USDPHP%22,%20%22USDSGD%22,%20%22USDTHB%22,%20%22USDZAR%22,%20%22USDISK%22)&env=store://datatables.org/alltableswithkeys";
        // var StockTickerHTML = "";
        
        // var StockTickerXML = $.get(flickerAPI, function(data) {
        //     console.log(data);
        // });


        var vm = this;
        vm.quotes = [];

        vm.getQuotes = function(){
            $http({
                method: 'GET',
                url: 'http://query.yahooapis.com/v1/public/yql?format=json&q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDEUR%22,%20%22USDJPY%22,%20%22USDBGN%22,%20%22USDCZK%22,%20%22USDDKK%22,%20%22USDGBP%22,%20%22USDHUF%22,%20%22USDLTL%22,%20%22USDLVL%22,%20%22USDPLN%22,%20%22USDRON%22,%20%22USDSEK%22,%20%22USDCHF%22,%20%22USDNOK%22,%20%22USDHRK%22,%20%22USDRUB%22,%20%22USDTRY%22,%20%22USDAUD%22,%20%22USDBRL%22,%20%22USDCAD%22,%20%22USDCNY%22,%20%22USDHKD%22,%20%22USDIDR%22,%20%22USDILS%22,%20%22USDINR%22,%20%22USDKRW%22,%20%22USDMXN%22,%20%22USDMYR%22,%20%22USDNZD%22,%20%22USDPHP%22,%20%22USDSGD%22,%20%22USDTHB%22,%20%22USDZAR%22,%20%22USDISK%22)&env=store://datatables.org/alltableswithkeys'
            }).success(function(data){

                data.query.results.rate.forEach(function(quote){
                    vm.quotes.push({
                        ask : quote.Ask,
                        bid : quote.Bid,
                        date : quote.Date,
                        name : quote.Name,
                        rate : quote.Rate,
                        time : quote.Time,
                        id : quote.id 
                    });
                });
                
                $scope.$on('renderBxSlider', function(ev) {
                    $('.bxslider').bxSlider({
                      minSlides: 8,
                      maxSlides: 8,
                      slideWidth: $('.quotes-string .container').width(),
                      slideMargin: 10,
                      ticker: true,
                      speed: 60000
                    });
                });
            });
        };
        vm.getQuotes();
    }
]);
