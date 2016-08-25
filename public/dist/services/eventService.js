/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';
app.factory('EventService', ['$http', '$q', function($http, $q){
    return{
        fetchAllEvents:function(){
            return $http.get('http://api.timska.dev/events')
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
            return $http.post('http://api.timska.dev/events/create',event)
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
            return $http.get('http://api.timska.dev/events/'+event)
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
        editOrUpdateEvent:function(events){
            return $http.patch('http://api.timska.dev/events/'+events.id,events)
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while editing or updating the event');
                        return $q.reject(errResponse);
                    }
                )
        }

    }
}

]);