$(function() {
    var addButton = $('#add-time-group'),
        collectionHolder = $('#time-groups tbody');

    addButton.data('index', collectionHolder.find('tr').length);
    addButton.on('click', function(e) {
        e.preventDefault();

        var dataHolder = $(this);
            prototype = dataHolder.data('prototype'),
            index = dataHolder.data('index'),
            newForm = prototype.replace(/__name__/g, index);

        dataHolder.data('index', index + 1);

        collectionHolder.append(newForm);
    });

    $(document).on('click', '.remove-time-group', function(e) {
        e.preventDefault();

        $(this).parent().parent().remove();
    });
});
