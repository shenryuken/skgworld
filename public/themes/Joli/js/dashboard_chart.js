$(function(){        
   
    
    /* Rickshaw dashboard chart */
    // var seriesData = [ [], [] ];
    // var random = new Rickshaw.Fixtures.RandomData(1000);

    // for(var i = 0; i < 100; i++) {
        // random.addData(seriesData);
    // }

    // var rdc = new Rickshaw.Graph( {
            // element: document.getElementById("dashboard-chart"),
            // renderer: 'area',
            // width: $("#dashboard-chart").width(),
            // height: 250,
            // series: [{color: "#33414E",data: seriesData[0],name: 'New'}, 
                     // {color: "#1caf9a",data: seriesData[1],name: 'Returned'}]
    // } );

    // rdc.render();

    // var legend = new Rickshaw.Graph.Legend({graph: rdc, element: document.getElementById('dashboard-legend')});
    // var shelving = new Rickshaw.Graph.Behavior.Series.Toggle({graph: rdc,legend: legend});
    // var order = new Rickshaw.Graph.Behavior.Series.Order({graph: rdc,legend: legend});
    // var highlight = new Rickshaw.Graph.Behavior.Series.Highlight( {graph: rdc,legend: legend} );        

    // var rdc_resize = function() {                
            // rdc.configure({
                    // width: $("#dashboard-area-1").width(),
                    // height: $("#dashboard-area-1").height()
            // });
            // rdc.render();
    // }

    // var hoverDetail = new Rickshaw.Graph.HoverDetail({graph: rdc});

    // window.addEventListener('resize', rdc_resize);        

    // rdc_resize();
    /* END Rickshaw dashboard chart */
    
   
	
	
    /* Bar dashboard chart */
    // Morris.Bar({
    //     element: 'dashboard-bar-1',
    //     data: [
    //         { y: '1', a: 75000, b: 35000, c:23 },
    //         { y: '2', a: 64000, b: 26000, c:10 },
    //         { y: '3', a: 78000, b: 39000, c:13 },
    //         { y: '4', a: 82000, b: 34000, c:8 },
    //         { y: '5', a: 86000, b: 39000, c:25 },
    //         { y: '6', a: 94000, b: 40000, c:8 },
    //         { y: '7', a: 96000, b: 41000, c:30 },
    //         { y: '8', a: 78000, b: 39000, c:17 },
    //         { y: '9', a: 82000, b: 34000, c:21 },
    //         { y: '10', a: 86000, b: 39000, c:120 },
    //         { y: '11', a: 150000, b: 85000, c:129 },
    //         { y: '12', a: 200000, b: 120000, c:200}
    //     ],
    //     xkey: 'y',
    //     ykeys: ['a', 'b', 'c'],
    //     labels: ['Sales', 'Stock', 'Returned'],
    //     barColors: ['#33414E', '#1caf9a', '#987cde'],
    //     gridTextSize: '10px',
    //     hideHover: true,
    //     resize: true,
    //     gridLineColor: '#E5E5E5'
    // });
    /* END Bar dashboard chart */
    
   
    
    
});

