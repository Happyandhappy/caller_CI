/*

Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7

Version: 2.1.0

Author: Sean Ngu

Website: http://www.seantheme.com/color-admin-v2.1/admin/html/

*/



var getMonthName = function(number) {

    var month = [];

    month[0] = "January";

    month[1] = "February";

    month[2] = "March";

    month[3] = "April";

    month[4] = "May";

    month[5] = "Jun";

    month[6] = "July";

    month[7] = "August";

    month[8] = "September";

    month[9] = "October";

    month[10] = "November";

    month[11] = "December";

    

    return month[number];

};



var getDate = function(date) {

    var currentDate = new Date(date);

    var dd = currentDate.getDate();

    var mm = currentDate.getMonth() + 1;

    var yyyy = currentDate.getFullYear();

    

    if (dd < 10) {

        dd = '0' + dd;

    }

    if (mm < 10) {

        mm = '0' + mm;

    }

    currentDate = yyyy+'-'+mm+'-'+dd;

    

    return currentDate;

};

/*var handleVisitorsLineChart = function() {

    var green = '#0D888B';

    var greenLight = '#00ACAC';

    var blue = '#3273B1';

    var blueLight = '#348FE2';

    var blackTransparent = 'rgba(0,0,0,0.6)';

    var whiteTransparent = 'rgba(255,255,255,0.4)';

	$.ajax({

		url : "graph",

		type : "GET",

		success : function(data){

			//console.log(data);

			//alert(data);

	   var json = $.parseJSON(data);

	  // alert(json.length);

	   			var amt_date ='';

				var amount ;

				var str ='';

				

				for(var i=0; i< json.length; i++) {

				//amt_date.push(data[i].payment_date);

				//amount.push(data[i].payment_gross_amount);

				//alert('date: '+ json[i].payment_date);

				//alert('amt:' + json[i].payment_gross_amount);

				//str = str + "{"+"x:'"+json[i].payment_date+"',"+"y:'"+json[i].payment_gross_amount+"'},";

				//str = str + "{"+"x:'"+json[i].payment_date+"',"+"y:'"+json[i].payment_gross_amount+"'},";

				           

				         amt_date= json[i].payment_date;

						 //alert(amt_date);

						 amount = json[i].payment_gross_amount;

var currentDate = new Date(amt_date);

				currentDate=getDate(currentDate);

	//			alert(currentDate);

				 str = str +"{x:'"+currentDate+"',y:"+amount+"},";

				

			}

			//alert(str);

			    

			Morris.Line({

				element: 'visitors-line-chart',

				data: [str],

				xkey: 'x',

				ykeys: ['y'],

				xLabelFormat: function(x) {

					x = getMonthName(x.getMonth());

					return x.toString();

				},

				labels: ['Subscription Amount'],

				lineColors: [green, blue],

				pointFillColors: [greenLight, blueLight],

				lineWidth: '2px',

				pointStrokeColors: [blackTransparent, blackTransparent],

				resize: true,

				gridTextFamily: 'Open Sans',

				gridTextColor: whiteTransparent,

				gridTextWeight: 'normal',

				gridTextSize: '11px',

				gridLineColor: 'rgba(0,0,0,0.5)',

				hideHover: 'auto',

			});

		},

		error : function(data) {



		}

	});

};
*/
/*var handleVisitorsLineChart = function() {

    var green = '#0D888B';

    var greenLight = '#00ACAC';

    var blue = '#3273B1';

    var blueLight = '#348FE2';

    var blackTransparent = 'rgba(0,0,0,0.6)';

    var whiteTransparent = 'rgba(255,255,255,0.4)';

$.ajax({

			url:'graph',

			success: function(data){

				var data = data;

				console.log(data);

				var date1 = [];

				var amount = [];

				for(var i in data) {

				date1.push(data[i].payment_date);

				amount.push(data[i].payment_gross_amount);

			};

			},

		  });

    Morris.Line({

        element: 'visitors-line-chart',

        data: [

            {x: data.payment_date , y: 50}

        ],

        xkey: 'x',

        ykeys: ['y'],

        xLabelFormat: function(x) {

            x = getMonthName(x.getMonth());

            return x.toString();

        },

        labels: ['Subscription Amount'],

        lineColors: [green, blue],

        pointFillColors: [greenLight, blueLight],

        lineWidth: '2px',

        pointStrokeColors: [blackTransparent, blackTransparent],

        resize: true,

        gridTextFamily: 'Open Sans',

        gridTextColor: whiteTransparent,

        gridTextWeight: 'normal',

        gridTextSize: '11px',

        gridLineColor: 'rgba(0,0,0,0.5)',

        hideHover: 'auto',

    });

};*/



/*var handleVisitorsDonutChart = function() {

    var green = '#00acac';

    var blue = '#348fe2';
	
	var json1;
	
		$.ajax({

		url : "client_count",

		type : "GET",

		success : function(data){
	   var json1 = $.parseJSON(data);
	   //alert(json1);
		}
		});

    Morris.Donut({

        element: 'visitors-donut-chart',

        data: [

            {label: "Client Users", value: json1}

        ],

        colors: [green, blue],

        labelFamily: 'Open Sans',

        labelColor: 'rgba(255,255,255,0.4)',

        labelTextSize: '12px',

        backgroundColor: '#242a30'

    });

};*/



var handleVisitorsVectorMap = function() {

    if ($('#visitors-map').length !== 0) {

        $('#visitors-map').vectorMap({

            map: 'world_merc_en',

            scaleColors: ['#e74c3c', '#0071a4'],

            container: $('#visitors-map'),

            normalizeFunction: 'linear',

            hoverOpacity: 0.5,

            hoverColor: false,

            markerStyle: {

                initial: {

                    fill: '#4cabc7',

                    stroke: 'transparent',

                    r: 3

                }

            },

            regions: [{

                attribute: 'fill'

            }],

            regionStyle: {

                initial: {

                    fill: 'rgb(97,109,125)',

                    "fill-opacity": 1,

                    stroke: 'none',

                    "stroke-width": 0.4,

                    "stroke-opacity": 1

                },

                hover: {

                    "fill-opacity": 0.8

                },

                selected: {

                    fill: 'yellow'

                },

                selectedHover: {

                }

            },

            series: {

                regions: [{

                values: {

                    IN:'#00acac',

                    US:'#00acac',

                    KR:'#00acac'

                }

                }]

            },

            focusOn: {

                x: 0.5,

                y: 0.5,

                scale: 2

            },

            backgroundColor: '#2d353c'

        });

    }

};



var handleScheduleCalendar = function() {

    var monthNames = ["January", "February", "March", "April", "May", "June",  "July", "August", "September", "October", "November", "December"];

    var dayNames = ["S", "M", "T", "W", "T", "F", "S"];



    var now = new Date(),

        month = now.getMonth() + 1,

        year = now.getFullYear();



    var events = [

        [

            '2/' + month + '/' + year,

            'Popover Title',

            '#',

            '#00acac',

            'Some contents here'

        ],

        [

            '5/' + month + '/' + year,

            'Tooltip with link',

            'http://www.seantheme.com/color-admin-v1.3',

            '#2d353c'

        ],

        [

            '18/' + month + '/' + year,

            'Popover with HTML Content',

            '#',

            '#2d353c',

            'Some contents here <div class="text-right"><a href="http://www.google.com">view more >>></a></div>'

        ],

        [

            '28/' + month + '/' + year,

            'Color Admin V1.3 Launched',

            'http://www.seantheme.com/color-admin-v1.3',

            '#2d353c',

        ]

    ];

    var calendarTarget = $('#schedule-calendar');

    $(calendarTarget).calendar({

        months: monthNames,

        days: dayNames,

        events: events,

        popover_options:{

            placement: 'top',

            html: true

        }

    });

    $(calendarTarget).find('td.event').each(function() {

        var backgroundColor = $(this).css('background-color');

        $(this).removeAttr('style');

        $(this).find('a').css('background-color', backgroundColor);

    });

    $(calendarTarget).find('.icon-arrow-left, .icon-arrow-right').parent().on('click', function() {

        $(calendarTarget).find('td.event').each(function() {

            var backgroundColor = $(this).css('background-color');

            $(this).removeAttr('style');

            $(this).find('a').css('background-color', backgroundColor);

        });

    });

};



var handleDashboardGritterNotification = function() {

    $(window).load(function() {

        setTimeout(function() {

            $.gritter.add({

                title: 'Welcome back, Admin!',

                text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus lacus ut lectus rutrum placerat.',

                image: 'assets/img/user-14.jpg',

                sticky: true,

                time: '',

                class_name: 'my-sticky-class'

            });

        }, 1000);

    });

};



var DashboardV2 = function () {

	"use strict";

    return {

        //main function

        init: function () {

            //handleVisitorsLineChart();

            //handleVisitorsDonutChart();

            handleVisitorsVectorMap();

            handleScheduleCalendar();

            handleDashboardGritterNotification();

        }

    };

}();// JavaScript Document