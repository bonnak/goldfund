app.service("Services", [
    'Restful',
    '$translate'
	, function(Restful, $translate) {
        var services = function(){
            var self = this;
        };

        services.prototype.dateFormat = function(date){
            var d = moment(date, 'DD-MM-YYYY');
            if(d.isValid()){
                return moment(date).format('DD-MM-YYYY');
            } else{
                return '';
            }
        };

        services.prototype.getExchangeRate = function() {
             return Restful.get('api/ExchangeRate', {get_last_record: 'get_last'});
        };

        services.prototype.alertMessage = function(title, message, type){
            $.notify({
                title: '<i class="fa fa-check-circle"></i> <b>' + title + '</b>',
                message: message
            },{
                type: type
            });
        };

        services.prototype.alertMessageSuccess = function(){
            $.notify({
                title: '<i class="fa fa-check-circle"></i>',
                message: $translate.instant('SaveSuccess')
            },{
                type: 'success'
            });
        };

        services.prototype.alertMessageError = function(text){
            $.notify({
                title: '<i class="fa fa-warning"></i> <b> ' + $translate.instant("Warning") + ': </b>',
                message: text
            },{
                type: 'warning'
            });
        };
        services.prototype.alertMessageInfo = function(){
            $.notify({
                title: '<i class="fa fa-info-circle"></i> <b>Info: </b>',
                message: $translate.instant('SaveSuccess')
            },{
                type: 'info'
            });
        };
        return services;
        
 	}
]);
/**
 * AngularJS default filter with the following expression:
 * "person in people | filter: {name: $select.search, age: $select.search}"
 * performs a AND between 'name: $select.search' and 'age: $select.search'.
 * We want to perform a OR.
 */
app.filter('propsFilter', function() {
    return function(items, props) {
        var out = [];

        if (angular.isArray(items)) {
            items.forEach(function(item) {
                var itemMatches = false;

                var keys = Object.keys(props);
                for (var i = 0; i < keys.length; i++) {
                    var prop = keys[i];
                    var text = props[prop].toLowerCase();
                    if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                        itemMatches = true;
                        break;
                    }
                }

                if (itemMatches) {
                    out.push(item);
                }
            });
        } else {
            // Let the output be the input untouched
            out = items;
        }

        return out;
    }
});