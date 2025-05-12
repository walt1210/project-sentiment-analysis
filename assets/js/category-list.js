$(document).ready(function () {
    loadCategoryList();
});

function loadCategoryList() {
    $.ajax({
        url: "/sentiment-analysis/project-sentiment-analysis/controllers/get_categories.php", // Edit this directory
        type: "GET",
        dataType: "json",
        success: function (data) {
            $('#category-list').empty();  
            for (var i = 0; i < data.length; i++) {
                $('#category-list').append('<li class="list-group-item">' + data[i].name + '</li>');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
        }
    });
}
