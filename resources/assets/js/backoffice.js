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

        // empty subzone and reset the default selected value to Département
        department.empty().append($('<option>', {value: ""}).text("Département"));
        // empty city and reset the default selected value to Ville

        city.empty().append($('<option>', {value: ""}).text("Ville"));
        handleSelectDisplay();

        // filling subzone select according to the selected zone
        $.get($(this).data("autocomplete-url") + "/" + $(this).val(), function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                department.append($('<option>', {value: value}).text(key));
            });
        });

       // handleSelectDisplay();
    });

    department.change(function() {
       handleSelectDisplay();
    });

    function handleSelectDisplay() {

        !region.val() ? departmentDiv.hide() : departmentDiv.show();
        !department.val() ? cityDiv.hide() : cityDiv.show();
    }

});
