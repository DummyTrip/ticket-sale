app.controller('UserController',['$http', '$rootScope', '$scope', '$location', '$localStorage', 'UserService' , function($http, $rootScope, $scope, $location, $localStorage, UserService){
    var self = this;
    self.user = { id:'', name:'', email:'', password:''};
    self.user.role_list=[];
    self.userPass ={oldPass:'',newPass:'',confirmPass:''};
    self.users = [];
    self.tempUsr={id:'', name:'',email:'',password:''};
    self.tmp ='';
    self.roles=['admin','organizator','menadzer','kupuvac'];
    // go zapishuva tokenot vo localStorage.
    // povekje za ova:
    // https://developer.mozilla.org/en-US/docs/Web/API/Web_Storage_API
    function successAuth(res) {
        $localStorage.token = res.token;
        window.location="/";
    };

    self.fetchAllUsers = function(){
        //console.log('Fetching all users');
        UserService.fetchAllUsers()
            .then(
                function(d){

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
        console.log(self.user.password);
        console.log(self.user.role_list);
        if (self.userPass.newPass === self.userPass.confirmPass) {
            self.user.password = self.userPass.confirmPass;
            console.log(JSON.stringify(self.user)+" Ova e userto vo edit");
            if(self.user.password != null){
                UserService.editUser(self.user)
                    .then(
                        function (d) {
                            self.user = d;
                        },
                        function (errResponse) {
                            console.log('Error while editing user in controller');
                        }
                    )
            }else{
                console.log('Vnesenite passwordi ne se poklopuvaat');
            }
        }

    };
    self.sumbitPrivileges = function(user){
        self.user = user;
        self.user.password="";
        self.editUserPrivileges();
    };
    self.editUserPrivileges = function(){
        if(self.user.role_names[0]==="organizator"){
            self.user.role_list[0] = 3;
        }else if(self.user.role_names[0]==="admin"){
            self.user.role_list[0] = 1;
        }else if(self.user.role_names[0]==="menadzer"){
            self.user.role_list[0] = 2;
        }
        console.log(self.user);
        UserService.editUser(self.user)
            .then(
                function (d) {
                    self.user = d;
                },
                function (errResponse) {
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
                    console.log(self.user.role_list[0]+" ova e ulogata");
                    if(self.user.role_list[0]==="admin")
                        location.href="http://timska.dev/admin";
                    else
                        location.href="http://timska.dev/";
                },
                function(errResponse){
                    console.log('Error while creating user in controller');
                }
            )
    };

    // Prati post do api.timska.dev/auth i vidi dali sum logiran.
    // Ako sum logiran togash vo ovoj kontroler vnesi gi soodvetnite polinja
    // vo self.user
    self.auth = function () {
        UserService.authUser()
            .then(
                function (response) {
                    self.user.name = response.user.name;
                    self.user.id = response.user.id;
                    self.user.email = response.user.email;
                    self.user.role = response.user.role;
                    self.user.role_list = response.user.role_list;
                    console.log(self.user);
                    sessionStorage.setItem('user',JSON.stringify(self.user));
                   // console.log(self.user.role_list+" Lista na ulogi");
                    self.tempUsr = self.user;
                   // console.log(response.user + "Ova se ulogite");
                },
                function (errResponse) {
                    console.log('Auth error. You are not logged in.');
                }
            )
    };

    // Napravi logout. Slednite chekori go pravi:
    // Izbrishi token od local storage.
    // Izbrishi user od rootscope
    // Izbrishi self.user
    // Prenasochi do index.
    self.logout = function () {
        delete $localStorage.token;
        sessionStorage.clear();
        $rootScope.user = null;
        self.user = { id:'', name:'', email:'', password:''};
        window.location = "/";
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

                       // sessionStorage.setItem('user', JSON.stringify(self.user));
                        console.log(self.user);
                        // go iskomentirav ovoj del.
                        // ova e stariot kod. go ostaviv za sekoj sluchaj
                        //console.log(self.user.roles[0].role + " Ova e ulogata");
                        /*if (self.user.roles[0].role === "admin")
                            location.href = "http://timska.dev/admin";
                        else
                            location.href = "http://timska.dev/";*/
                        console.log('Uspeshno!!! '+ self.user.name+" "+self.user.email);

                },
                function (errResponse) {
                    console.log('Error while logging user in controller');
                }
            )
    };
    self.submitLogIn= function(){
        alert('Yes');
        self.logIn(self.user)
    };
    self.check = function(){
    //    console.log(self.user);
        console.log('Yes');
        var tmp = sessionStorage.getItem('user');
        var temp = $.parseJSON(tmp);

        if(temp === null){
            self.auth();
          //  console.log(self.user + " posle auth()");
        }else{
            self.user = temp;
            self.tempUsr = self.user;
        }
        var tmp =location.href;
        console.log(tmp+" "+self.user.role_list[0]);
        console.log((tmp==="http://timska.dev/#/events" || tmp==="http://timska.dev/#/editEvent" || tmp==="http://timska.dev/#/createEvent") &&(self.user.role_list[0]!=1 ||self.user.role_list[0]!=3));

        if(tmp === "http://timska.dev/#/users" && self.user.role_list[0]!=1){
            location.href="/";
        }
        if((tmp==="http://timska.dev/#/events" || tmp==="http://timska.dev/#/addEvent" ||tmp==="http://timska.dev/#/editEvent" ) && (self.user.role_list[0]!=1 && self.user.role_list[0]!=3)){
            console.log(self.user.role_list[0]);
            console.log((tmp==="http://timska.dev/#/events" || tmp==="http://timska.dev/#/editEvent" || tmp==="http://timska.dev/#/createEvent") && self.user.role_list[0]!=1);
            location.href="/";
        }
        if((tmp==="http://timska.dev/#/venues" || tmp==="http://timska.dev/#/editVenue" || tmp==="http://timska.dev/#/createVenue") &&(self.user.role_list[0]!=1 && self.user.role_list[0]!=2)){
            location.href="/";
        }
    };
    self.checkIt=function(tmp){
        alert(tmp);
        self.user.role_list[0]  = tmp;
    };

    self.fetchAllUsers();

    // pri sekoe palenje na ovoj kontroler proveri dali user-ot e logiran.
    // Ne znam dali e ova pametno. Treba da se proveri.
    self.check();
}]);

/**
 * Created by Muttley on 8/4/2016.
 */
'use strict';
