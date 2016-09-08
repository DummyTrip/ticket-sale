1/**
 * Created by Muttley on 8/7/2016.
 */
'use strict';
app.factory('TicketService', ['$http', '$q', 'api_url', function($http, $q, api_url){
    return{
        fetchAllTicket:function(Event){
            return $http.get(api_url + '/events/'+Event+'/tickets')
                .then(
                    function (response) {
                        return response.data;
                    },
                    function (errResponse) {
                        console.log('Error while fetching all ticket for event');
                        return $q.reject(errResponse);
                    }
                )
        },
        reserveTicket:function (Event,ticket) {
            return $http.post(api_url + '/events/'+Event+'/tickets/'+ticket+'/buy')
                .then(
                    function (response) {
                        return response.data;
                    },
                    function (errResponse) {
                        console.log('Error while buying tickets')
                        return $q.reject(errResponse);
                    }
                )

        }

    }
}]);