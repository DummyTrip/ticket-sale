/**
 * Created by Muttley on 8/4/2016.
 */
'use strict';

app.controller('UserController',['$http', '$rootScope', '$scope', '$location', '$localStorage', 'UserService' , function($http, $rootScope, $scope, $location, $localStorage, UserService){
    var self = this;
    self.user = { id:'', name:'', email:'', password:''};
    self.user.roles=[{id:'', role:''}];
    self.user.roles.pivot = [{id:'', role_id:''}];
    self.users = [];
    self.tempUsr={id:'', name:'',email:'',password:''};

    // go zapishuva tokenot vo localStorage.
    // povekje za ova:
    // https://developer.mozilla.org/en-US/docs/Web/API/Web_Storage_API
    function successAuth(res) {
        $localStorage.token = res.token;
        window.location = "/";
    }

    self.fetchAllUsers = function(){
        console.log('Fetching all users');
        UserService.fetchAllUsers()
            .then(
                function(d){
                    console.log($localStorage.token);
                    console.log(d);
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
                        location.href="http://timska.dev/admin";
                    else
                        location.href="http://timska.dev/";
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
                  // Prakja post do api.timska.dev
                  // api.timska.dev vrakja token i successAuth (gore e definirano) go zapishuva tokenot vo localStorage
                  $http.post('http://api.timska.dev/logIn', self.user).success(successAuth).error(function () {
                      $rootScope.error = 'Invalid credentials.';
                  });

                  // primer za logout. Treba samo da se izbrishe tokenot.
                  // ovde e napishano zatoa shto testirav dali kje go izbrishe tokenot
                  // delete $localStorage.token;

                  // go iskomentirav ovoj del.
                  // ova e stariot kod. go ostaviv za sekoj sluchaj
                  // console.log(self.user.roles[0].role+" Ova e ulogata");
                  // if(self.user.roles[0].role==="admin")
                  //     location.href="http://timska.dev/admin";
                  // else
                  //     location.href="http://timska.dev/";
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