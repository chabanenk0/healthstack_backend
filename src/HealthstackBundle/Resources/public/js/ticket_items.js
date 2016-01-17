var $collectionHolder;

// setup an "add a tag" link
var $addItemLink = $('<a class="btn btn-primary" href="#" class="add_tag_link">Add an item</a>');
var $newLinkLi = $('<li></li>').append($addItemLink);

function addItemFormDeleteLink($itemFormLi) {
    var $removeFormA = $('<a class="btn btn-danger" href="#">delete item</a>');
    $itemFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $itemFormLi.remove();
    });
}

function addItemForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    addItemFormDeleteLink($newFormLi);
}

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('#ticket_items');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addItemLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addItemForm($collectionHolder, $newLinkLi);
    });

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.children('div').each(function() {
        addItemFormDeleteLink($(this));
    });

});
