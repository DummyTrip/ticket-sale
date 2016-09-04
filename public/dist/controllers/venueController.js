/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';

app.controller('venueController',['$scope', 'VenueServices', function($scope, VenueServices) {
    var self = this;
    self.venue = { id:'', name:'', city:'',country:'', img:'', description:'', address:'',blocks:[], block:[
        {
            name: '',
            rows: '',
            columns: ''
        }
        ]};
    self.number = Number(0);
    self.tmp =[{name:'',row:'',columns:''}];
    self.venues = [];

    self.set = function(venue){
        sessionStorage.setItem('sala', venue);
        self.venue = venue;
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
        var f = document.getElementById('file').files[0];
        var r = new FileReader();
        var data=null;
        r.onloadend = function(e){
             data = e.target.result;
            //send your binary data via $http or $resource or do anything else with it
        };
        r.readAsBinaryString(f);
        self.venue.img = data;
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
                },
                function(errResponse){
                    console.log('Error while editing or updating venue in VenueController');
                }
            )

    };
    self.fetchAllVenues();
}]);