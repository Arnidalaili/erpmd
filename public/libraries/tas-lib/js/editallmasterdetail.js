 // Create a container div for each table
 let tableContainer = $('<div class="table-container mb-3">');

 let table = $("<table>");

function createTable(data,detailHeader,subHeader) {
    $("#editAllTableBody").empty();

    $.each(data, function (index, entry) {
        // Create a container div for each table
         tableContainer = $('<div class="table-container mb-3">');

        table = $("<table>");

        // Detail Header
        const detailHeaderRow = $("<tr>");
        const detailHeaderCells = detailHeader
        detailHeaderCells.forEach((cellText) => {
            detailHeaderRow.append($("<th>").text(cellText));
        });
        table.append(detailHeaderRow);

        // Detail Row
        const detailRow = $("<tr>");
        detailRow.append($("<td>").text(index + 1));

        const detailCells = [
            createInput("nobukti", entry.nobukti),
            createInput("nobuktipesananfinal", entry.nobuktipesananfinal),
            createInput("customernama", entry.customernama),
            createInput("alamatpengiriman", entry.alamatpengiriman),
            createInput("tglpengiriman", entry.tglpengiriman),
            createInput("keterangan", entry.keterangan),
            createInput("statusnama", entry.statusnama),
        ];

        table.append(detailRow);
        detailCells.forEach((cell) => detailRow.append($("<td>").append(cell)));
        table.append(detailRow);

        // Sub Header
        const subHeaderRow = $('<tr class="sub-header-row">');
        const subHeaderCells = subHeader
        subHeaderCells.forEach((cellText) => {
            subHeaderRow.append($("<th>").text(cellText));
        });
        table.append(subHeaderRow);

        let totalPrice = 0;
        $.each(entry.details, function (index, details) {
            const productRow = $("<tr>");
            productRow.append($("<td>").text(index + 1));
            const productCells = [
                createInput("nama", details.productnama),
                createInput("satuan", details.satuannama),
                createInput("qty", details.qty),
                createInput("qtyretur", details.qtyretur),
                createInput("keterangan", details.keterangandetail),
                createInput("harga", details.harga),
                createInput("totalharga", details.totalharga),
            ];
            productCells.forEach((cell) =>
                productRow.append($("<td>").append(cell))
            );
            table.append(productRow);
    
            totalPrice += details.harga; // Accumulate the total price
        });

        // Display total price row
        const totalRow = $("<tr>");
        totalRow.append($('<td colspan="6">Total Harga:</td>'));
        totalRow.append($("<td>").text(totalPrice));
        totalRow.append($("<td>"));

        table.append(totalRow);

        // Append the table to the container
        tableContainer.append(table);

        // Append the container to the body
        $("#editAllTableBody").append(tableContainer);
    });
}

function createInput(name, value) {
    return $(
        `<input type="text" name="${name}" class="form-control lg-form filled-row" autocomplete="off" value="${value}" />`
    );
}
