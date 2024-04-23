function bindkeyMovementEditAll(elementTable,page,modal) {
    let table = $('#' + elementTable);
    let selectedRowIndex = 1; // Default selected row
    let selectedColIndex = 1; // Default selected column

    if (page > 1 || firstPage) {
        var targetCell = $("#" + elementTable + " tbody tr:first td:eq(1)"); 
        var focusedElementFirst = $(
            "#editAll tbody tr:first td:eq(1) input.form-control.first0"
        );

        targetCell.addClass("selected-cell");

        focusedElementFirst.focus();

        firstPage = true;
    }

    selectCell(table, selectedRowIndex, selectedColIndex);

    table.on("click", "td", function (e) {
        var cell = $(this);
        var rowIndex = cell.parent().index() + 2;
        var colIndex = cell.index();

        clearCellSelections(table);

        selectCell(table, rowIndex, colIndex);

        selectedRowIndex = rowIndex;
        selectedColIndex = colIndex;
    });

    modal.on("keydown", function (e) {
        // Handle arrow key presses
        switch (e.key) {
            case "ArrowUp":
                selectedRowIndex = Math.max(2, selectedRowIndex - 1);
                break;
            case "ArrowDown":
                selectedRowIndex = Math.min(
                    table.find("tr").length - 1,
                    selectedRowIndex + 1
                );
                
                break;
            case "ArrowLeft":
                selectedColIndex = Math.max(1, selectedColIndex - 1);

                break;
            case "ArrowRight":
                selectedColIndex = Math.min(
                    table.find("tr:eq(" + selectedRowIndex + ") td").length - 1,
                    selectedColIndex + 1
                );
                break;
            default:
                return;

        
        }

       
        clearCellSelections(table);

        selectCell(table, selectedRowIndex, selectedColIndex);

        // Focus on the input element in the selected cell
        var focusedElement = table.find(
            "tr:eq(" +
                selectedRowIndex +
                ") td:eq(" +
                selectedColIndex +
                ") input"
        );

        focusedElement.focus();

        e.preventDefault();
    });

    function clearCellSelections(table) {
        var cells = table.find(".selected-cell");
        cells.removeClass("selected-cell");
    }

    function selectCell(table, rowIndex, colIndex) {
        if (colIndex !== 0) {
            var cell = table.find(
                "tr:eq(" + rowIndex + ") td:eq(" + colIndex + ")"
            );

            cell.addClass("selected-cell");
        }
    }
}


$("#editAllModal").keydown(function (e) {
    let selectedRowIndexPageUpDown = $("#editAll tbody tr").index(selectedRowEditAll);

    if (e.which === 38) {
        e.preventDefault();

        if (selectedRowIndexPageUpDown > 0) {
            $("#editAll tbody tr").removeClass("selected");

            selectedRowEditAll = $("#editAll tbody tr")
                .eq(selectedRowIndexPageUpDown - 1)
                .addClass("selected");
        }
    } else if (e.which === 40) {
        e.preventDefault();

        if (selectedRowIndexPageUpDown < $("#editAll tbody tr").length - 1) {
            $("#editAll tbody tr").removeClass("selected");

            selectedRowEditAll = $("#editAll tbody tr")
                .eq(selectedRowIndexPageUpDown + 1)
                .addClass("selected");
        }
    } else if (e.which === 33) {
        if (currentPage > 1) {
            $("#pagerInput").val(currentPage - 1);
            
            currentPage--;
        }


        viewPageEdit();
    } else if (e.which === 34) {
        if (currentPage < totalPages) {
            $("#pagerInput").val(currentPage + 1);

           

            currentPage++;
        }
        viewPageEdit();
    }

    if (event.which === 33 || event.which === 34) {
        bindKeyPage(currentPage, totalPages);
    }
});



// var firstRow = $('#editAll tbody tr:first');
// // firstRow.addClass('selected');
// firstRow.click()

// $('#editAll tbody tr').click(function() {

//     $('#editAll tbody tr').removeClass('selected');

//     $(this).addClass('selected');
//     selectedRowEditAll = $(this);

// });