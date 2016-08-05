/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';
app.factory('VenueServices', ['$http', '$q', function($http, $q){
    return{
        fetchAllVenues:function(){
            return $http.get('http://timska.dev/venues')
                .then(
                    function (response) {
                        return response.data;
                    },
                    function (errResponse) {
                        console.log('Error while fetching all venues');
                        return $q.reject(errResponse);
                    }
                )
        },
        createVenue:function(){
            return $http.post('http://timska.dev/venues/create')
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while creating a venue');
                        return $q.reject(errResponse);
                    }
                )
        },
        showVenue:function(venues){
            return $http.get('http://timska.dev/venues/'+venues)
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while showing selected venue');
                        return $q.reject(errResponse);
                    }
                )
        },
        editOrUpdate:function(venues){
            return $http.get('http://timska.dev/venues/'+venues+'/edit')
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while editing or updating the venue');
                        return $q.reject(errResponse);
                    }
                )
        }
    }
}]);