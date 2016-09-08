/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';
app.factory('VenueServices', ['$http', '$q', 'api_url', function($http, $q, api_url){
    return{
        fetchAllVenues:function(){
            return $http.get(api_url + '/venues')
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
        uploadPicture:function(data) {
            var fd = new FormData();
            console.log(data);
            fd.append('file', data);
            angular.forEach(data, function (elem) {
                fd.append('file', elem);
            });
            console.log("Service log HERE");
            return $http.post(api_url + '/images/upload', fd,
                {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }
            )
                .then(
                    function (response) {
                        return response.data;
                    },
                    function (errResponse) {
                        console.error('Error while uploading');
                        return $q.reject(errResponse);
                    }
                )
        },
        createVenue:function(venue){
            console.log(venue);
            return $http.post(api_url + '/venues/create',venue)
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
            return $http.get(api_url + '/venues/'+venues)
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
            return $http.patch(api_url + '/venues/'+venues.id,venues)
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