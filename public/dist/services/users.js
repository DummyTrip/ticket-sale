/**
 * Created by Muttley on 8/4/2016.
 */
'use strict';
app.factory('UserService', ['$http', '$q', function($http, $q){
    return{
        fetchAllUsers: function () {
            return $http.get('http://timska.dev/users')
                .then(
                    function (response) {
                        return response.data;
                    },
                    function (errResponse) {
                        console.log('Error while fetching all users');
                        return $q.reject(errResponse);
                    }
                )
        }
    };
}]);