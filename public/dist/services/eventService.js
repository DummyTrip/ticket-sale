/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';
app.factory('EventService', ['$http', '$q', 'api_url', function($http, $q, api_url){
    return{
        fetchAllEvents:function(){
            return $http.get(api_url + '/events')
                .then(
                    function (response) {
                        return response.data;
                    },
                    function (errResponse) {
                        console.log('Error while fetching all events');
                        return $q.reject(errResponse);
                    }
                )
        },
        createEvent:function(event){
            return $http.post(api_url + '/events/create',event)
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while creating a event');
                        return $q.reject(errResponse);
                    }
                )
        },
        showEvents:function(event){
            return $http.get(api_url + '/events/'+event)
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while showing selected event');
                        return $q.reject(errResponse);
                    }
                )
        },
        getAllCards:function(event){
            return $http.get(api_url + '/events/'+event.id+"/tickets")
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while getting all cards');
                        return $q.reject(errResponse);
                    }
                )
        },
        buyCards:function(event){
            return $http.post(api_url + '/events/'+event.id+'/tickets/'+event.cards.id+'/buy',event)
                .then(
                    function (response) {
                        console.log(response.data);
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while buying card')
                    }
                )
        },
        editOrUpdateEvent:function(events){
            return $http.patch(api_url + '/events/'+events.id,events)
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while editing or updating the event');
                        return $q.reject(errResponse);
                    }
                )
        },
        getBlockaAndRow: function(event){
            return $http.get(api_url + '/events/'+event.id+'/blocktickets/',event.id)
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errRespose){
                        console.log('Error while getting blocks and rows');
                    }
                )
        }

    }
}

]);