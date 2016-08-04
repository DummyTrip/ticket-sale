/**
 * Created by Muttley on 8/4/2016.
 */
'use strict';

app.controller('UserController',['$scope', 'UserService' , function($scope, UserService){
    var self = this;
    self.user = { name:'', email:'', password:''};
    self.users = [];

    self.fetchAllUsers = function(){
        UserService.fetchAllUsers()
            .then(
                function(d){
                    self.users = d;
                },
                function (errResponse){
                    console.log('Error while fetching all users in UserController');
                }
            );
    };
    self.fetchAllUsers();
}]);