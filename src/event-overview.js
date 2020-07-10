$(function() {
    source: "searchevents.php",
    select: function(event, ui) {
        event.preventDefault();
        $("#search-input").val(ui.item.id);
    }
    $("#")
});