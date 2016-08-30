/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';
app.factory('VenueServices', ['$http', '$q', function($http, $q){
    return{
        fetchAllVenues:function(){
            return $http.get('http://api.timska.dev/venues')
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
        createVenue:function(venue){
            console.log(venue);
            return $http.post('http://api.timska.dev/venues/create',venue)
                .then(
                    function(response){
                        console.log(response.data);
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while creating a venue');
                        return $q.reject(errResponse);
                    }
                )
        },
        showVenue:function(venues){
            return $http.get('http://api.timska.dev/venues/'+venues)
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
            return $http.patch('http://api.timska.dev/venues/'+venues.id,venues)
                .then(
                    function(response){
                        console.log('Da ushesno e update vo venue');
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