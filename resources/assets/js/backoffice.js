$(document).ready(function () {

    var region = $('#hotel_region');
    var department = $("#hotel_department");
    var city = $("#hotel_city");
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

        if (!region.val()) {
            $('#departmentDiv').hide();
            $('#cityDiv').hide();
        } else {
            $('#departmentDiv').show();
        }

        if (!department.val() )
        {
            $('#cityDiv').hide();
        } else {
            $('#cityDiv').show();
        }
    }

});
