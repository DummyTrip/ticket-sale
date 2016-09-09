/**
 * Created by Muttley on 8/4/2016.
 */
'use strict';
app.factory('UserService', ['$http', '$q' , 'api_url', function($http, $q, api_url){
    return{
        fetchAllUsers: function () {
            return $http.get(api_url + '/users')
                .then(
                    function (response) {
                        return response.data;
                    },
                    function (errResponse) {
                        console.log('Error while fetching all users');
                        return $q.reject(errResponse);
                    }
                )
        },
        History: function () {
            return $http.get(api_url+'/users/history')
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while fetching users');
                        return $q.reject(errResponse);
                    }
                )
        },
        fetchUserByName: function(user){
            return $http.get(api_url + '/users/'+user)
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while fetching users');
                        return $q.reject(errResponse);
                    }
                )
        },
        editUser:function(user){ // same function for update
            return $http.post(api_url + '/profile',user)
                .then(
                    function(response){
                        console.log(response.data);
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while editing User');
                        return $q.reject(errResponse);
                    }
                )
        },
        createUser:function(user){
            return $http.post(api_url + '/singUp',user)
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while creating user');
                        return $q.reject(errResponse);
                    }
                )
        },
        checkLogIn: function (user) {
            return $http.post(api_url + '/logIn',user)
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while logging user ');
                        return $q.reject(errResponse);
                    }
            )

        },
        authUser: function () {
            return $http.get(api_url + '/auth')
                .then(
                    function(response){
                        return response.data;
                    },
                    function(errResponse){
                        console.log('Error while logging user ');
                        return $q.reject(errResponse);
                    }
            )
        }

    };
}]);