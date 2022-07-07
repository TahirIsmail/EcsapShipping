

// Dashboard 1 Morris-chart

 // Morris donut chart
        
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Orders",
            value: 8500,

        }, {
            label: "Panding",
            value: 3630,
        }, {
            label: "Delivered",
            value: 4870
        }],
        resize: true,
        colors:['#fb9678', '#01c0c8', '#4F5467']
    });


