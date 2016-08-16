/**
 * Created by Muttley on 8/4/2016.
 */
'use strict';

app.controller('UserController',['$scope', 'UserService' , function($scope, UserService){
    var self = this;
    self.user = { id:'', name:'', email:'', password:''};
    self.user.roles=[{id:'', role:''}];
    self.user.roles.pivot = [{id:'', role_id:''}];
    self.users = [];
    self.tempUsr={id:'', name:'',email:'',password:''};

    self.fetchAllUsers = function(){
        console.log('Fetching all users');
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
    self.fetcUserByName = function(user){
        UserService.fetchUserByName(user)
            .then(
                function(d){
                    self.user = d;
                },
                function(errResponse){
                    console.log('Error while fetching the userByName in controller');
                }
            )
    };
    self.editUser = function(){
        UserService.editUser()
            .then(
                function(d){
                    self.user = d;
                },
                function(errResponse){
                    console.log('Error while editing user in controller');
                }
            )
    };
    self.createUserSubmit = function(){
        console.log(self.user.name+' '+self.user.email+' '+self.user.password);
        self.createUser(self.user);
    };
    self.createUser = function(user){
        console.log('Ova e userot '+user.name+' '+user.password+' '+user.email);
        var tmp = [user.name,user.email,user.password];
        console.log('Ove e tmp '+tmp);
        UserService.createUser(user)
            .then(
                function(d){
                    self.user=d;
                    console.log(self.user.roles.role+" ova e ulogata");
                    if(self.user.roles[0].role==="admin")
                        location.href="http://localhost:63342/ticket-sale/public/dist/index.html#/admin";
                    else
                        location.href="http://localhost:63342/ticket-sale/public/dist/index.html#/";
                },
                function(errResponse){
                    console.log('Error while creating user in controller');
                }
            )
    };

    self.logIn = function(user){
      UserService.checkLogIn(user)
          .then(
              function(){
                  console.log(self.user.roles[0].role+" Ova e ulogata");
                  if(self.user.roles[0].role==="admin")
                      location.href="http://localhost:63342/ticket-sale/public/dist/index.html#/admin";
                  else
                      location.href="http://localhost:63342/ticket-sale/public/dist/index.html#/";
                  console.log('Uspeshno!!! '+ self.user.name+" "+self.user.email);
              },
              function (errResponse) {
                  console.log('Error while logging user in controller');
              }
          )
    };
    self.submitLogIn= function(){
        self.logIn(self.user)
    };
    self.fetchAllUsers();
}]);