$(document).ready(function() {
    const ploSaveButton = $('.plo-save-order');
    const categorySaveButton = $('.category-save-order');

    // Initialize Sortable for each category section
    $('.plo-category-section').each(function() {
        new Sortable(this, {
            group: {
                name: 'plo-list',
                // Restrict movement between different categories
                pull: false,
                put: false
            },
            animation: 150,
            handle: '.drag-handle', // Drag handle class
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                // Update hidden input fields for new order
                updatePLOOrder(evt.to);
                enableSaveButton(ploSaveButton);
            }
        });
    });

    // Initialize Sortable for the PLO category list
    $('.plo-category-list').each(function() {
        new Sortable(this, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updatePLOCategoryOrder(evt.to);
                enableSaveButton(categorySaveButton);
            }
        });
    });

    function updatePLOOrder(container) {
        // Get all PLO sections to update the complete order
        const allPLOSections = $('.plo-category-section');
        const allPLOIds = [];

        // Clear all existing position inputs
        $('input[name="plos_pos[]"]').remove();

        // Collect PLO IDs in their current order from all sections
        allPLOSections.each(function() {
            const rows = $(this).find('tr[data-plo-id]');
            rows.each(function() {
                const ploId = $(this).data('plo-id');
                allPLOIds.push(ploId);

                // Create a new hidden input for the PLO's position
                const input = $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'plos_pos[]')
                    .val(ploId);
                $(this).find("td:last-child").append(input);
            });
        });
    }

    function updatePLOCategoryOrder(container) {
        $('input[name="categories_pos[]"]').remove();

        $('.plo-category-list tr[data-category-id]').each(function() {
            const categoryId = $(this).data('category-id');

            const input = $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'categories_pos[]')
                .attr('form', 'savePLOCategoryOrder')
                .val(categoryId);
            $(this).find("td:last-child").append(input);
        });
    }

    function enableSaveButton(button) {
        button.prop('disabled', false)
            .addClass('btn-success')
            .removeClass('btn-secondary');
    }

    function disableSaveButton(button) {
        button.prop('disabled', true)
            .addClass('btn-secondary')
            .removeClass('btn-success');
    }

    // Initially disable order save buttons until changes are made
    disableSaveButton(ploSaveButton);
    disableSaveButton(categorySaveButton);

    // Update all sections on page load to ensure proper order
    updatePLOOrder();
    updatePLOCategoryOrder();
});