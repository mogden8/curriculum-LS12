$(document).ready(function() {
    // Initialize Sortable for each category section.
    // Each .plo-category-section is now a direct <tbody> child of <table> (no nesting),
    // so SortableJS can find and manipulate them correctly.
    $('.plo-category-section').each(function() {
        new Sortable(this, {
            group: {
                name: 'plo-list',
                // Restrict movement between different categories
                pull: false,
                put: false
            },
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function() {
                updatePLOOrder();
            }
        });
    });

    function updatePLOOrder() {
        // Collect all PLO IDs in their current visual order across all category sections.
        const allPLOIds = [];

        $('.plo-category-section').each(function() {
            $(this).find('tr[data-plo-id]').each(function() {
                allPLOIds.push($(this).data('plo-id'));
            });
        });

        // Write the full order as a single comma-separated value into the one hidden
        // input that lives directly inside #ploReorderForm. This avoids appending
        // inputs to <tr> elements (invalid HTML) or scattering inputs across the DOM.
        $('#plos_order').val(allPLOIds.join(','));

        // Enable the save button now that an order change has been recorded.
        $('button[type="submit"]').prop('disabled', false)
            .addClass('btn-success')
            .removeClass('btn-secondary');
    }

    // Populate the hidden input with the initial page-load order so that a save
    // without any dragging still submits valid data.
    updatePLOOrder();

    // Disable save button until the user actually drags something.
    // (updatePLOOrder above has already written the initial value, so the input is
    // ready; we just keep the button visually disabled until a real change happens.)
    $('button[type="submit"]').prop('disabled', true)
        .addClass('btn-secondary')
        .removeClass('btn-success');
});