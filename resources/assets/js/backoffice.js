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

        // empty department and reset the default selected value to Département
        department.empty().append($('<option>', {value: ""}).text("Département"));

        // empty city and reset the default selected value to Ville
        city.empty().append($('<option>', {value: ""}).text("Ville"));

        handleSelectDisplay();

        // filling department select according to the selected region
        $.get($(this).data("autocomplete-url") + "/" + $(this).val(), function (data) {
            $.each(data, function (key, value) {
                department.append($('<option>', {value: value}).text(key));
            });
        });

    });

    department.change(function() {

        // empty city and reset the default selected value to Ville
        city.empty().append($('<option>', {value: ""}).text("Ville"));

        handleSelectDisplay();

        // filling city select according to the selected department
        $.get($(this).data("autocomplete-url") + "/" + $(this).val(), function (data) {
            $.each(data, function (key, value) {
                city.append($('<option>', {value: value}).text(key));
            });
        });
    });

    function handleSelectDisplay() {

        !region.val() ? departmentDiv.hide() : departmentDiv.show();
        !department.val() ? cityDiv.hide() : cityDiv.show();
    }

});
