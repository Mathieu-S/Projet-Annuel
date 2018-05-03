$(document).ready(function () {

    var region = $('#hotel_region');
    var department = $("#hotel_department");
    var city = $("#hotel_city");
    var departmentDiv = $("#departmentDiv");
    var cityDiv = $('#cityDiv');

    region.prepend($('<option>', {value: ""}).text("Région")).val("");
    department.prepend($('<option>', {value: ""}).text("Département")).val("");
    city.prepend($('<option>', {value: ""}).text("Ville")).val("");

    handleSelectDisplay();

    region.change(function() {
       handleSelectDisplay();
    });

    department.change(function() {
       handleSelectDisplay();
    });

    function handleSelectDisplay() {

        !region.val() ? departmentDiv.hide() : departmentDiv.show();
        !department.val() ? cityDiv.hide() : cityDiv.show();
    }

});
