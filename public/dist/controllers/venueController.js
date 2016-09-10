/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';

app.controller('venueController',['$scope', 'VenueServices', 'UploadService', 'api_url', 'url', function($scope, VenueServices, UploadService, api_url, url) {
    var self = this;
    self.venue = { id:'', name:'', city:'', manager_id:'', country:'', image:'', description:'', address:'',blocks:[], block:[
        {
            name: '',
            rows: '',
            columns: ''
        }
        ]};
    self.number = Number(0);
    self.tmp =[{name:'',row:'',columns:''}];
    self.venues = [];
    self.img = null;

    $scope.UploadPicture = function(data){
        console.log(data);
        VenueServices.uploadPicture(data)
            .then(
                function (d) {
                    console.log("Success");
                    console.log(d);
                    self.uploaded = true;
                    self.venue.image = d;
                },
                function (errResponse) {
                    console.log("Fail to upload!");
                }
            );
    };


    self.doThisFirst = function () {
        var tmp = sessionStorage.getItem('sala');
        var temp = $.parseJSON(tmp);
        console.log("Da tukaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
        if( temp != null){
            console.log(temp);
            self.venue = temp;
        }
    };

    self.doThisFirst();


    self.testFn = function (e) {
        console.log(self.img);
        console.log('test: ', e);
    };

    self.set = function(venue){
        self.venue = venue;
        sessionStorage.setItem('sala',JSON.stringify(self.venue));
        self.showVenue(venue);
    };
    self.addNewBlock = function () { // za vo create
        self.venue.block.push({
            name: '',
            rows: '',
            columns: ''
        });
    };
    self.addNewBlock1 = function () { // za vo edit
        self.venue.blockInfo.push({
            block_name: '',
            rows: '',
            columns: ''
        });
    };
    self.removeBlock = function(){
        self.venue.blockInfo.splice(self.venue.blockInfo.length-1,1);
    };
    self.fetchAllVenues = function(){
        VenueServices.fetchAllVenues()
            .then(
                function(d){
                    self.venues = d;
                },
                function (errResponse){
                    console.log('Error while fetching all venues in VenueController');
                }
            );
    };
    self.createVenue = function(){
        var p = 0;
        for(var i = 0; i < self.venue.block.length; i++){
            self.venue.blocks[p++] = self.venue.block[i].name;
            self.venue.blocks[p++] = self.venue.block[i].rows;
            self.venue.blocks[p++] = self.venue.block[i].columns;
        }
        console.log('Venue: ', self.venue);
        console.log("Ova e vo controlerot: "+self.venue.blocks+" "+self.venue.name+" "+self.venue.city+" "+self.venue.country+" "+self.venue.address);
        VenueServices.createVenue(self.venue)
            .then(
                function(){
                    console.log('Kreirana '+self.venue.name);
                    location.href=url + "/#/";
                    window.location.reload(false);
                },
                function(errResponse){
                    console.log('Error while creating venue in VenueController')
                }
            )
    };
    self.showVenue = function(venue){
        VenueServices.showVenue(venue.id)
            .then(
                function(d){
                    self.venue = d;
                },
                function(errResponse){
                    console.log('Error while showing venue in VenueController')
                }
            )
    };
    self.editOrUpdate = function(){

        console.log(self.venue);
        self.venue.blocks = [];
        for(var i = 0; i < self.venue.blockInfo.length; i++){
            self.venue.blocks.push(self.venue.blockInfo[i].block_name);
            self.venue.blocks.push(self.venue.blockInfo[i].rows);
            self.venue.blocks.push(self.venue.blockInfo[i].columns);
        }
        VenueServices.editOrUpdate(self.venue)
            .then(
                function(d){
                    self.venue = d;
                    location.href=url + "/#/";
                    window.location.reload(false);
                },
                function(errResponse){
                    console.log('Error while editing or updating venue in VenueController');
                }
            )

    };
    self.fetchAllVenues();
}]);