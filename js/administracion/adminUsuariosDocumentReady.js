$(document).ready(function() {
    $("#tableOne").tablesorter({
        debug: false, 
        sortList: [[0, 0]], 
        widgets: ['zebra']
    })
    .tablesorterPager({
        container: $("#pagerOne"), 
        positionFixed: false
    })
    .tablesorterFilter({
        filterContainer: $("#filterBoxOne"),
        filterClearContainer: $("#filterClearOne"),
        filterColumns: [0, 1],
        filterCaseSensitive: false
    });

    $("#tableOne .header").click(function() {
        $("#tableOne tfoot .first").click();
    });                
});   
