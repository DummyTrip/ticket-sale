/**
 * Created by Muttley on 8/5/2016.

'use strict';*/

app.controller('eventController',['$scope', 'EventService', 'VenueServices', 'url', function($scope, EventService,VenueServices, url) {
    var self = this;
    self.event = { name:'', organizer_id:'',image:'', venue_id:'',description:'',img:'',tag_list:[], date:'',venue:'',editing:'',cards:[]};
    self.event.choosenblock='';
    self.event.choosenblock_rows=[];
    self.event.chosencard='';
    self.tmpevent={name:'',date:'',venue:''};
    self.events = [];
    self.event.block=[];
    self.venue1 =[
    ];
    self.event.block1=[];
    self.event.prices=[];
    self.tmp_venues=[];
    self.bolock=[];
    self.pr="1";
    self.venue = { name:'', id:''};
    self.venues=[];
    self.tmp=[];
    self.venueDet = [];
    self.setEvent = function(event){
        self.event = event;
        sessionStorage.setItem('event',JSON.stringify(self.event));
    };
    self.events1 = [];
    self.filtered = function(tmp){

        var temp = self.events;
        self.events = [];
        for(var i = 0; i < temp.length; i++){
            if(temp[i].tag_list[0]===tmp){
                self.events.push(temp[i]);
            }
        }
        if(self.events.length===0){
            self.events = temp;
        }
    };
    self.check= function (){
        var k = 0;
        for(var p = 0; p < self.event.cards.length; p++){
            if(self.event.cards[i].block===self.event.choosenblock){
                k++;
                self.event.choosenblock_rows.push(k);
            }
        }
    };
    self.getVenueDetails  = function(venue){
        for(var i = 0 ;i < self.events.length; i++){
            if(self.events[i].venue.name===venue.name){
                self.venueDet = self.getBlockaAndRow();
                break;
            }
        }
    };
    self.getIdVenue = function(){ // Ovaa pri create
        for(var i = 0; i < self.venues.length; i++){
            if(self.tmpevent.venue===self.venues[i].name){
                self.event.venue_id=self.venues[i].id;
                self.venue1 = self.venues[i];
                self.venue1.block = [];
                var tmp = self.venue1.block_names.length;
                for(var p = 0; p < tmp; p++){
                    self.venue1.block.push({name:'',price:''});
                }
                for(var k = 0; k < tmp;k++){
                    console.log(self.venue1.block_names[k]);
                    self.venue1.block[k].name = self.venue1.block_names[k];
                    self.venue1.block[k].price = '';
                }

                break;
            }
        }
    };
    self.promeni = function(event){
        self.event = event;
    };
    self.getIdVenues = function(){  //// Ovaa e pri update
        for(var i = 0; i < self.venues.length; i++){
            if(self.event.venue===self.venues[i].name){
                self.event.venue_id=self.venues[i].id;
                break;
            }
        }
    };
    self.getVenueByID = function(){
        for(var i = 0; i < self.venues.length; i++){
            if(self.event.venue_id === self.venues[i].id){
                self.event.venue = self.venues[i];
                break;
            }
        }
    };
    self.fetchAllVenues=function(){
        VenueServices.fetchAllVenues()
            .then(
                function (d) {
                    self.venues = d;
                    for(var i = 0; i < self.venues.length; i++){
                        self.tmp_venues.push(self.venues[i].name);
                    }
                    //  console.log(self.tmp_venues);
                },
                function(errResponse){
                    console.log('Error while fetching all venues in eventController');
                }
            )
    };
    self.addValue = function(value){

        var flag = false;
        for(var i = 0; i < self.event.tag_list.length; i++){
            if(self.event.tag_list[i]===value){
                flag = true;
                break;
            }
        }
        if(!flag){
            console.log(value);
            self.event.tags.push(value);
        }
    };
    self.this = function(id){
        console.log(self.events);
        /*for(var i = 0; i < self.events.length; i++){
            for(var k =0; k < self.events[i].cards.length; k++){
                if(self.events[i].cards[k].user_id===id){
                    self.events1.push(self.events[i]);
                }
            }
        }
        console.log(self.events1);*/
    };
    self.fetchAllEvents = function(){
        EventService.fetchAllEvents()
            .then(
                function(d){
                    self.events = d;
                    for(var i = 0; i < self.events.length; i++){
                        self.event = self.events[i];
                        self.getVenueByID();
                        self.getBlockaAndRow();
                        self.getAllCards();
                        //console.log(JSON.stringify(self.event.tag_list)+" pri fetching");
                    }
                },
                function (errResponse){
                    console.log('Error while fetching all events in EventController');
                }
            );
    };
    self.createEvent = function(id){
        var tmp = ['da', 'ne'];
        self.event.blocks = [];


        for(var q = 0; q < self.venue1.block.length; q++){
           // console.log(JSON.stringify(self.venue1.block[q].name)+" "+JSON.stringify(self.venue1.block[q].price));
            self.event.blocks.push(self.venue1.block[q].name);
            self.event.blocks.push(self.venue1.block[q].price);
        }

        self.getIdVenue(self.event);
        self.venue_id = self.event.id;
        EventService.createEvent(self.event)
            .then(
                function(d){
                    self.venue = d;
                    location.href=url + "/#/";
                    window.location.reload(false);
                },
                function(errResponse){
                    console.log('Error while creating event in EventController')
                }
            )
    };
    self.showEvent = function(event){
        EventService.showVenue(event.id)
            .then(
                function(d){
                    self.venue = d;
                },
                function(errResponse){
                    console.log('Error while showing events in EventController')
                }
            )
    };
    self.getBlockaAndRow = function(){
        EventService.getBlockaAndRow(self.event)
            .then(
                function(d){
                    self.event.block1=d;
                },
                function(errResponse){
                    console.log('Error while getting blocks and rows in EventController')
                }
            )
    };
    self.getAllCards = function(){
        //console.log("Ovaj log******************");
        //console.log(self.event);
        EventService.getAllCards(self.event)
            .then(
                function(d){
                   // console.log(d);
                    self.event.cards = d;
          //          console.log(self.event.cards);
                },
                function(errResponse){
                    console.log('Error while showing events in EventController')
                }
            )
    };
    self.buyCards = function(id){
        self.event.cards.id = id;
        //console.log(self.event.cards);
        EventService.buyCards(self.event)
            .then(
                function(d){
            //        console.log(d);
                    window.location.reload(false);
                },
                function(errResponse){
                    console.log('Error while buying cards in EventController')
                }
            )
    };
    self.findId = function(){
      for(var i = 0; i < self.events.length; i++){
          if(self.event.name === self.events[i].name){
              self.event.id = self.events[i].id;
              self.event.tag_list = self.events[i].tag_list;
              break;
          }
      }
    };
    $scope.Upload_Picture = function(data){
        console.log(data);
        EventService.uploadPicture(data)
            .then(
                function (d) {
              //      console.log("Success");
              //      console.log(d);
                    self.uploaded = true;
                    self.event.image = d;
                },
                function (errResponse) {
                    console.log("Fail to upload!");
                }
            );
    };
    self.editUpdate = function(){
        self.findId();

        self.event.blocks = [];
        for(var i = 0; i < self.event.block1.length; i++){
            self.event.blocks.push(self.event.block1[i].block_name);
            self.event.blocks.push(self.event.block1[i].price);
        }
        EventService.editOrUpdateEvent(self.event)
            .then(
                function(d){
                    self.event = d;
                    location.href=url;
                    //window.location.reload(false);
                },
                function(errResponse){
                    console.log('Error while editing or updating event in EventController');
                }
            )

    };
    self.doThis = function(){

        if(location.href===url + '/#/'){
            sessionStorage.clear();
        }
        var tmp = sessionStorage.getItem('event');
        var temp = $.parseJSON(tmp);

        console.log(temp);
        if(temp!=null) {
            self.event = temp;
            self.getAllCards();
        }else{
            self.fetchAllEvents();
        }
    };
    self.doThis();


    self.fetchAllVenues();



}]);