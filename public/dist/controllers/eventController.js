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
            console.log('Venue name: '+self.venues[i].name+" a jas ja odbrav "+self.tmpevent.venue);
            if(self.tmpevent.venue===self.venues[i].name){
                console.log('Entered '+self.venues[i].id);
                self.event.venue_id=self.venues[i].id;
                self.venue1 = self.venues[i];
                self.venue1.block = [];
                var tmp = self.venue1.block_names.length;
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
    self.promeni = function(){
        alert('Yes');
         console.log(self.event.venue[0].block_names);
        // for(var i = 0; i < self.event.venue.block_names.length; i++){
        //     self.tmp.push({name:self.event.venue.block_names[i]});
        // }
        // console.log(self.tmp+" da ovde");
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
                self.event.venue = self.venues[i].name;
                break;
            }
        }
    };
    self.fetchAllVenues=function(){
        VenueServices.fetchAllVenues()
            .then(
                function (d) {
                    self.venues = d;
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
        EventService.fetchAllEvents()
            .then(
                function(d){
                    self.events = d;
                    for(var i = 0; i < self.events.length; i++){
                        self.event = self.events[i];
                        self.getAllCards();
                        self.getVenueByID();
                        console.log(JSON.stringify(self.event.tag_list)+" pri fetching");
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
        for(var q = 0; q < self.venue1.blocks.length; q++){
            console.log(JSON.stringify(self.venue1.block[q].name));
            self.event.blocks.push(JSON.stringify(self.venue1.blocks[q].name));
            self.event.blocks.push(JSON.stringify(self.venue1.blocks[q].price));
        }

        self.getIdVenue(self.event);
        console.log(self.event.name+" ova se prakja");
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
    self.getAllCards = function(){
        EventService.getAllCards(self.event)
            .then(
                function(d){
                    console.log(d);
                    self.event.cards = d;
                },
                function(errResponse){
                    console.log('Error while showing events in EventController')
                }
            )
    };
    self.buyCards = function(id){
        self.event.cards.id = id;
        console.log(self.event.cards);
        EventService.buyCards(self.event)
            .then(
                function(d){
                    console.log(d);
                    self.event.cards = d;
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
    self.editOrUpdate = function(event){
        self.findId();
        console.log(self.event);
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