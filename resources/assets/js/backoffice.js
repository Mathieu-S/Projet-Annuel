$(document).ready(function () {

    var region = $('#hotel_region');
    var department = $("#hotel_department");
    var city = $("#hotel_city");
    var departmentDiv = $("#departmentDiv");
    var cityDiv = $('#cityDiv');
    var postalCode = $("#hotel_postalCode");
    var postalCodeDiv = $("#postalCodeDiv");

    if ($("input[name='hotel[name]']").val() === "") {
        region.prepend($('<option>', {value: ""}).text("Région")).val("");
        department.prepend($('<option>', {value: ""}).text("Département")).val("");
        city.prepend($('<option>', {value: ""}).text("Ville")).val("");
        postalCode.prepend($('<option>', {value: ""}).text("Code postal")).val("");
        handleSelectDisplay();
    }

    region.change(function() {

        department.empty().append($('<option>', {value: ""}).text("Département"));
        city.empty().append($('<option>', {value: ""}).text("Ville"));

        handleSelectDisplay();
        loadDatasFromZone(region, department);

    });

    department.change(function() {

        city.empty().append($('<option>', {value: ""}).text("Ville"));

        handleSelectDisplay();
        loadDatasFromZone(department, city);

    });

    city.change(function() {

       postalCode.empty().append($('<option>', {value: ""}).text("Code Postal"));

       handleSelectDisplay();
       loadDatasFromZone(city, postalCode);

    });

    function handleSelectDisplay() {

        !region.val() ? departmentDiv.hide() : departmentDiv.show();
        !department.val() ? cityDiv.hide() : cityDiv.show();
        !city.val() ? postalCodeDiv.hide() : postalCodeDiv.show();
    }

    function loadDatasFromZone (dataSource, selectToFill) {
        $.get(dataSource.data("autocomplete-url") + "/" + dataSource.val(), function (data) {
            $.each(data, function (key, value) {
                selectToFill.append($('<option>', {value: value}).text(key));
            });
        });
    }

    function addImage(container, imgButton) {
        container.on('click', imgButton, function(e) {
           e.preventDefault();

            var prototype = container.data('prototype');
            var index = container.data('index');
            var newForm = prototype.replace(/__name__/g, index);
            container.data('index', index + 1);
            $(this).before(newForm);

        });
    }

    var hotelWrapper = $('.hotel-images-wrapper');
    var bedRoomWrapper = $('.bedroom-images-wrapper');
    var hotelBtn = $('.js-hotel-image-add');
    var bedRoomBtn = $('.js-bedroom-image-add');

    addImage(hotelWrapper, hotelBtn);
    addImage(bedRoomWrapper, bedRoomBtn);

});
