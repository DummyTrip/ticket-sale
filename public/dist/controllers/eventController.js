/**
 * Created by Muttley on 8/5/2016.
 */
'use strict';

app.controller('eventController',['$scope', 'EventService', 'VenueServices', function($scope, EventService,VenueServices) {
    var self = this;
    self.event = { name:'', venue_id:'', tag_list:[], date:'',venue:'',editing:'',cards:[]};
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
    self.setEvent = function(event){
        self.event = event;
    };
    self.check= function (){
        alert('da');
        var k = 0;
        for(var p = 0; p < self.event.cards.length; p++){
            if(self.event.cards[i].block===self.event.choosenblock){
                k++;
                self.event.choosenblock_rows.push(k);
            }
        }
    };
    self.getIdVenue = function(){ // Ovaa pri create
        alert(self.event.venue.name);
        for(var i = 0; i < self.venues.length; i++){
            console.log('Venue name: '+self.venues[i].name+"so Id"+self.venues[i].id+" a jas ja odbrav "+self.tmpevent.venue);
            if(self.tmpevent.venue===self.venues[i].name){
                console.log('Entered '+self.venues[i].id);
                self.event.venue_id=self.venues[i].id;
                self.venue1 = self.venues[i];
                self.venue1.block = [];
                var tmp = self.venue1.block_names.length;
                console.log('Ova e vrednosta na tmp: '+tmp);
                for(var p = 0; p < tmp; p++){
                    self.venue1.block.push({name:'',price:''});
                }
                console.log(self.venue1.block);
                for(var k = 0; k < tmp;k++){
                    console.log(self.venue1.block_names[k]);
                    self.venue1.block[k].name = self.venue1.block_names[k];
                    self.venue1.block[k].price = '';
                }
                console.log(self.venue1);

                break;
            }
        }
    };
    self.promeni = function(event){
        console.log(event);
        self.event = event;
        self.editUpdate();
    };
    self.getIdVenues = function(){  //// Ovaa e pri update
        alert(self.event.venue);
        for(var i = 0; i < self.venues.length; i++){
            console.log('Venue name: '+self.venues[i].name);
            if(self.event.venue===self.venues[i].name){
                console.log('Entered '+self.venues[i].id);
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
        alert('Yes');
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
    self.fetchAllEvents = function(){
        console.log("Yes");
        EventService.fetchAllEvents()
            .then(
                function(d){
                    self.events = d;
                    for(var i = 0; i < self.events.length; i++){
                        self.event = self.events[i];
                        self.getAllCards();
                        self.getVenueByID();
                        //console.log(JSON.stringify(self.event.tag_list)+" pri fetching");
                    }

                },
                function (errResponse){
                    console.log('Error while fetching all events in EventController');
                }
            );
    };
    self.createEvent = function(id){
        console.log(id);
        var tmp = ['da', 'ne'];
        self.event.blocks = [];

        console.log(self.venue1.block);

        for(var q = 0; q < self.venue1.block.length; q++){
            console.log('Yes');
            console.log(JSON.stringify(self.venue1.block[q].name)+" "+JSON.stringify(self.venue1.block[q].price));
            self.event.blocks.push(self.venue1.block[q].name);
            self.event.blocks.push(self.venue1.block[q].price);
        }

        self.getIdVenue(self.event);
        self.venue_id = self.event.id;
        console.log(self.event.venue_id +" "+self.event.id);
        console.log(self.event);
        EventService.createEvent(self.event)
            .then(
                function(d){
                    self.venue = d;
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
                    console.log(d+" da ide");
                    self.event.block1=d;
                },
                function(errResponse){
                    console.log('Error while getting blocks and rows in EventController')
                }
            )
    };
    self.getAllCards = function(){
        EventService.getAllCards(self.event)
            .then(
                function(d){
                    //console.log(d);
                    self.event.cards = d;
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
                    console.log(d);
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
    self.editUpdate = function(){
        self.findId();

        EventService.editOrUpdateEvent(self.event)
            .then(
                function(d){
                    self.event = d;
                },
                function(errResponse){
                    console.log('Error while editing or updating event in EventController');
                }
            )

    };
    self.fetchAllEvents();


    self.fetchAllVenues();



}]);