$(function(){

        console.log("WOLOLO WOLOLO WOLOLO WOLOLO");
        min=20;
        max=519;
        med=max/2;
        $.ajax({
            type: 'GET',
            //url: 'areas.json',
            url: "http://localhost/ademe/tinawebJS/php/mapael.php",
            contentType: "application/json",
            //dataType: 'jsonp',
            success : function(data){ 
                console.log(data);
                    $(".maparea6").mapael({
                            map : {
                                    name : "world_countries",
                                    defaultArea: {
                                            attrs : {
                                                    stroke : "#fff", 
                                                    "stroke-width" : 1
                                            }
                                    }
                            },
                            legend : {
                                    area : {
                                            display : true,
                                            title :"Population by country", 
                                            slices : [
                                                    {
                                                            max :min, 
                                                            attrs : {
                                                                    fill : "#6aafe1"
                                                            },
                                                            label :"Less than de "+min+" humans"
                                                    },
                                                    {
                                                            min :min, 
                                                            max :med, 
                                                            attrs : {
                                                                    fill : "#459bd9"
                                                            },
                                                            label :"Between "+min+" and "+med+" humans"
                                                    },
                                                    {
                                                            min :med, 
                                                            max :max, 
                                                            attrs : {
                                                                    fill : "#2579b5"
                                                            },
                                                            label :"Between "+med+" and "+max+" humans"
                                                    },
                                                    {
                                                            min :max, 
                                                            attrs : {
                                                                    fill : "#1a527b"
                                                            },
                                                            label :"More than "+max+" humans"
                                                    }
                                            ]
                                    }/*,
                                    plot :{
                                            display : true,
                                            title: "Some cities ..."
                                            , slices : [
                                                    {
                                                            max :500000, 
                                                            attrs : {
                                                                    fill : "#f99200"
                                                            },
                                                            attrsHover :{
                                                                    transform : "s1.5",
                                                                    "stroke-width" : 1
                                                            }, 
                                                            label :"less than 500 000 inhabitants", 
                                                            size : 10
                                                    },
                                                    {
                                                            min :500000, 
                                                            max :1000000, 
                                                            attrs : {
                                                                    fill : "#f99200"
                                                            },
                                                            attrsHover :{
                                                                    transform : "s1.5",
                                                                    "stroke-width" : 1
                                                            }, 
                                                            label :"Between 500 000 and 1 000 000 inhabitants", 
                                                            size : 20
                                                    },
                                                    {
                                                            min :1000000, 
                                                            attrs : {
                                                                    fill : "#f99200"
                                                            },
                                                            attrsHover :{
                                                                    transform : "s1.5",
                                                                    "stroke-width" : 1
                                                            }, 
                                                            label :"More than 1 million inhabitants", 
                                                            size : 30
                                                    }
                                            ]
                                    }*/
                            },/*
                            plots : {
                                    'paris' : {
                                            latitude :48.86, 
                                            longitude :2.3444, 
                                            value : 500000000, 
                                            tooltip: {content : "Paris<br />Population: 500000000"}
                                    },
                                    'newyork' : {
                                            latitude :40.667, 
                                            longitude :-73.833, 
                                            value : 200001, 
                                            tooltip: {content : "New york<br />Population: 200001"}
                                    },
                                    'sydney' : {
                                            latitude :-33.917, 
                                            longitude :151.167, 
                                            value : 600000, 
                                            tooltip: {content : "Sydney<br />Population: 600000"}
                                    },
                                    'brasilia' : {
                                            latitude :-15.781682, 
                                            longitude :-47.924195, 
                                            value : 200000001, 
                                            tooltip: {content : "Brasilia<br />Population: 200000001"}
                                    },
                                    'tokyo': {
                                            latitude :35.687418, 
                                            longitude :139.692306, 
                                            value : 200001, 
                                            tooltip: {content : "Tokyo<br />Population: 200001"}
                                    }
                            },*/
                            areas: data
                    });
            },
            error: function(){ 
                console.log("Page Not found.");
            }
        });
	
	// Example #6
	
	
});