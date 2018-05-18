/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 2.1.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v2.1/admin/html/
*/

var handleDataTableScroller = function() {
	"use strict";
    alert('oi');
    
    if ($('#data-table').length !== 0) {
        $('#data-table').DataTable({
            ajax:           "assets/plugins/DataTables/json/scroller-demo.json",
            deferRender:    true,
            scrollY:        300,
            scrollCollapse: true,
            scroller:       true,
            responsive: true,
            pageLength: 25
        });
    }
};

var TableManageScroller = function () {
	"use strict";
    return {
        //main function
        init: function () {
            //handleDataTableScroller();
        }
    };
}();