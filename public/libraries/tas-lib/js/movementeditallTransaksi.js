function bindkeyMovementEditAllTransaksi(elementTable,page,modal) {
    let table = $('#' + elementTable);
    let selectedRowIndex = 1; // Default selected row
    let selectedColIndex = 1; // Default selected column

    // if (page > 1 || firstPage) {
        var targetCell = $("#" + elementTable + " tbody tr:first td:eq(1)"); 
        var focusedElementFirst = $(
            "#" + elementTable + " tbody tr:first td:eq(1) input.form-control"
        );
      
        targetCell.addClass("selected-cell");

        focusedElementFirst.focus();

        firstPage = true;

        
    // }

   

    selectCellEditAllTransaksi(table, selectedRowIndex, selectedColIndex);

    table.on("click", "td", function (e) {
        var cell = $(this);
        var rowIndex = cell.parent().index();
        var colIndex = cell.index();

        clearCellSelectionsEditAllTransaksi(table);

        selectCellEditAllTransaksi(table, rowIndex, colIndex);

        selectedRowIndex = rowIndex;
        selectedColIndex = colIndex;
    });

    modal.on("keydown", function (e) {
        // Handle arrow key presses
        switch (e.key) {
            case "ArrowUp":
                selectedRowIndex = Math.max(1, selectedRowIndex - 1);
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

       
        clearCellSelectionsEditAllTransaksi(table);

        selectCellEditAllTransaksi(table, selectedRowIndex, selectedColIndex);

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

    function clearCellSelectionsEditAllTransaksi(table) {
        var cells = table.find(".selected-cell");
        cells.removeClass("selected-cell");
    }

    function selectCellEditAllTransaksi(table, rowIndex, colIndex) {
        if (colIndex !== 0) {
            var cell = table.find(
                "tr:eq(" + rowIndex + ") td:eq(" + colIndex + ")"
            );

            cell.addClass("selected-cell");
        }
    }
}


// var firstRow = $('#editAll tbody tr:first');
// // firstRow.addClass('selected');
// firstRow.click()

// $('#editAll tbody tr').click(function() {

//     $('#editAll tbody tr').removeClass('selected');

//     $(this).addClass('selected');
//     selectedRowEditAll = $(this);

// });