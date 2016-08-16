/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';
app.factory('EventService', ['$http', '$q', function($http, $q){
    return{
        fetchAllEvents:function(){
            return $http.get('http://timska.dev/events')
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
            return $http.post('http://timska.dev/event/create',event)
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
            return $http.get('http://timska.dev/events/'+event)
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
            return $http.get('http://timska.dev/events/'+events+'/edit')
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