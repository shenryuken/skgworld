var morrisCharts = function() {

    // Morris.Line({
    //   element: 'morris-line-example',
    //   data: [
    //     { y: '2006', a: 100, b: 90 },
    //     { y: '2007', a: 75,  b: 65 },
    //     { y: '2008', a: 50,  b: 40 },
    //     { y: '2009', a: 75,  b: 65 },
    //     { y: '2010', a: 50,  b: 40 },
    //     { y: '2011', a: 75,  b: 65 },
    //     { y: '2012', a: 100, b: 90 }
    //   ],
    //   xkey: 'y',
    //   ykeys: ['a', 'b'],
    //   labels: ['Series A', 'Series B'],
    //   resize: true,
    //   lineColors: ['#33414E', '#95B75D']
    // });


    // Morris.Area({
    //     element: 'morris-area-example',
    //     data: [
    //         { y: '2006', a: 100, b: 90 },
    //         { y: '2007', a: 75,  b: 65 },
    //         { y: '2008', a: 50,  b: 40 },
    //         { y: '2009', a: 75,  b: 65 },
    //         { y: '2010', a: 50,  b: 40 },
    //         { y: '2011', a: 75,  b: 65 },
    //         { y: '2012', a: 100, b: 90 }
    //     ],
    //     xkey: 'y',
    //     ykeys: ['a', 'b'],
    //     labels: ['Series A', 'Series B'],
    //     resize: true,
    //     lineColors: ['#1caf9a', '#FEA223']
    // });


    Morris.Bar({
        element: 'morris-bar-example',
        data: [
            { y: '2006', a: 100, b: 90, c:23 },
            { y: '2007', a: 75,  b: 65, c:10 },
            { y: '2008', a: 50,  b: 40, c:13 },
            { y: '2009', a: 75,  b: 65, c:8  },
            { y: '2010', a: 50,  b: 40, c:25 },
            { y: '2011', a: 75,  b: 65, c:8 },
            { y: '2012', a: 100, b: 90, c:30 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['Series A', 'Series B', 'Series C'],
        barColors: ['#B64645', '#33414E', '#987cde']
    });


    // Morris.Donut({
    //     element: 'morris-donut-example',
    //     data: [
    //         {label: "Download Sales", value: 12},
    //         {label: "In-Store Sales", value: 30},
    //         {label: "Mail-Order Sales", value: 20}
    //     ],
    //     colors: ['#95B75D', '#1caf9a', '#FEA223']
    // });

}();