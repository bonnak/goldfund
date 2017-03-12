angular.module('MetronicApp').controller('DashboardController', [
    '$scope',
    '$location',
    'Restful',
    function($scope, $location, Restful) {
        var vm = this;
        vm.model = {};
        vm.link = $location.protocol() + "://" + $location.host() + ":" + 
                ($location.port() !== 80 ? $location.port() : '') + '/register?ref=' + $scope.userProfile.username;


        vm.fetchData = function()
        {
        	Restful.get('/api/earning/data').success(function(data){
                vm.model = data;
          });
        }  

        vm.getData = function() {
            // var url = 'http://query.yahooapis.com/v1/public/yql';
            // var symbol = $("#symbol").val();
            // var data = encodeURIComponent("select * from yahoo.finance.quotes where symbol in ('" + symbol + "')");

            // $.getJSON(url, 'q=' + data + "&format=json&diagnostics=true&env=http://datatables.org/alltables.env")
            //     .done(function (data) {
            //         //$('#result').text("Price: " + data.query.results.quote.LastTradePriceOnly);
            //         console.log(data);
            //     })
            //     .fail(function (jqxhr, textStatus, error) {
            //         var err = textStatus + ", " + error;
            //         console.log('Request failed: ' + err);
            //     });
            
            // $.ajax({
            //     type: "GET",
            //     url: "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDEUR%22,%20%22USDJPY%22,%20%22USDBGN%22,%20%22USDCZK%22,%20%22USDDKK%22,%20%22USDGBP%22,%20%22USDHUF%22,%20%22USDLTL%22,%20%22USDLVL%22,%20%22USDPLN%22,%20%22USDRON%22,%20%22USDSEK%22,%20%22USDCHF%22,%20%22USDNOK%22,%20%22USDHRK%22,%20%22USDRUB%22,%20%22USDTRY%22,%20%22USDAUD%22,%20%22USDBRL%22,%20%22USDCAD%22,%20%22USDCNY%22,%20%22USDHKD%22,%20%22USDIDR%22,%20%22USDILS%22,%20%22USDINR%22,%20%22USDKRW%22,%20%22USDMXN%22,%20%22USDMYR%22,%20%22USDNZD%22,%20%22USDPHP%22,%20%22USDSGD%22,%20%22USDTHB%22,%20%22USDZAR%22,%20%22USDISK%22)&env=store://datatables.org/alltableswithkeys",
            //     // data: "s=GAIL.NS+BPCL.NS+%5ENSEI&f=snl1hgp",
            //     // dataType: "text/csv",
            //     success: function(data) {
            //         console.log(data);
            //     }
            // });
            
            var Symbol = "", CompName = "", Price = "", ChnageInPrice = "", PercentChnageInPrice = ""; 
            var CNames = "^FTSE,HSBA.L,SL.L,BATS.L,BLND.L,FLG.L,RBS.L,RMG.L,VOD.L";
            var flickerAPI = "http://query.yahooapis.com/v1/public/yql?format=json&q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDEUR%22,%20%22USDJPY%22,%20%22USDBGN%22,%20%22USDCZK%22,%20%22USDDKK%22,%20%22USDGBP%22,%20%22USDHUF%22,%20%22USDLTL%22,%20%22USDLVL%22,%20%22USDPLN%22,%20%22USDRON%22,%20%22USDSEK%22,%20%22USDCHF%22,%20%22USDNOK%22,%20%22USDHRK%22,%20%22USDRUB%22,%20%22USDTRY%22,%20%22USDAUD%22,%20%22USDBRL%22,%20%22USDCAD%22,%20%22USDCNY%22,%20%22USDHKD%22,%20%22USDIDR%22,%20%22USDILS%22,%20%22USDINR%22,%20%22USDKRW%22,%20%22USDMXN%22,%20%22USDMYR%22,%20%22USDNZD%22,%20%22USDPHP%22,%20%22USDSGD%22,%20%22USDTHB%22,%20%22USDZAR%22,%20%22USDISK%22)&env=store://datatables.org/alltableswithkeys";
            var StockTickerHTML = "";
            
            var StockTickerXML = $.get(flickerAPI, function(xml) {
                    console.log(xml);
            });
        }

        vm.fetchData(); 
        vm.getData();   
    }
]);