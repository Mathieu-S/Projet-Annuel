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

    jQuery('.add-another-collection-widget').click(function (e) {
        e.preventDefault();
        var list = jQuery(jQuery(this).attr('data-list'));
        // Try to find the counter of the list
        var counter = list.data('widget-counter') | list.children().length;
        // If the counter does not exist, use the length of the list
        if (!counter) { counter = list.children().length; }

        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data(' widget-counter', counter);

        // create a new list element and add it to the list
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });

});
