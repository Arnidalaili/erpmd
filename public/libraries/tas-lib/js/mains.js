let sidebarIsOpen = false;
let formats;
let offDays;
let addedRules;
let selectedValue;
let rowCount;
let lengthValue = "";

$(document).ready(function () {
    setFormats();
    startTime();
    setSidebarBindKeys();
    openMenuParents();
    // initDatepicker();
    initSelect2();
    initAutoNumeric();
    initDisabled();

    /* Remove autocomplete */
    $("input").attr("autocomplete", "off");
    $("input, textarea").attr("spellcheck", "false");

    $(document).on("click", "#sidebar-overlay", () => {
        $(document).trigger("sidebar:toggle");

        sidebarIsOpen = false;
    });

    $(document).on("show.bs.modal", ".modal", function () {
        const zIndex = 1040 + 10 * $(".modal:visible").length;
        $(this).css("z-index", zIndex);
        setTimeout(() =>
            $(".modal-backdrop")
                .not(".modal-stack")
                .css("z-index", zIndex - 1)
                .addClass("modal-stack")
        );
    });

    $(document).on("hidden.bs.modal", ".modal", function () {
        $(".modal:visible").length && $(document.body).addClass("modal-open");
    });

    $("#loader").addClass("d-none");

    $.fn.modal.Constructor.Default.backdrop = "static";
});

window.onbeforeunload = () => {
    $("#loader").removeClass("d-none");
};

function changeJqGridRowListText() {
    $(document).find('select[id$="rowList"] option[value=0]').text("ALL");
}

function setFormats() {
    $.ajax({
        url: `${appUrl}/formats/global.json`,
        method: "GET",
        dataType: "JSON",
        async: false,
        cache: false,
        success: (response) => {
            formats = response;
        },
        error: (error) => {
            showDialog(error.statusText);
        },
    });
}

function initDisabled() {
    $(".disabled").each(function () {
        $(this).disable();
    });
}

function initAutoNumeric(elements = null, options = null) {
    let option = {
        digitGroupSeparator: formats.THOUSANDSEPARATOR,
        decimalCharacter: formats.DECIMALSEPARATOR,
        minimumValue: 0,
        modifyValueOnWheel: false,
    };
    if (elements == null) {
        new AutoNumeric.multiple(".autonumeric", option);
    } else {
        $.each(elements, (index, element) => {
            new AutoNumeric(element, option);
        });
    }
}

function initAutoNumericNoDoubleZero(elements = null, options = null) {
    let defaultOptions = {
        digitGroupSeparator: formats.THOUSANDSEPARATOR,
        decimalCharacter: formats.DECIMALSEPARATOR,
        minimumValue: 0,
        decimalPlaces: 0,
        trailingNegative: "none",
        modifyValueOnWheel: false,
    };

    // Menggabungkan opsi default dengan opsi yang diberikan (jika ada)
    let mergedOptions = Object.assign({}, defaultOptions, options);

    if (elements == null) {
        new AutoNumeric.multiple(".autonumeric-nozero", mergedOptions);
    } else {
        $.each(elements, (index, element) => {
            // Membuat objek AutoNumeric
            let autoNumericInstance = new AutoNumeric(element, mergedOptions);
            element.style.textAlign = "right";

            // Menambahkan event listener setelah format selesai
            autoNumericInstance.onFormatted = function () {
                // Membersihkan nol di belakang koma desimal
                let cleanedValue = autoNumericInstance.getFormatted();
                cleanedValue = cleanedValue.replace(/(\.[0-9]*?)0+$/, "$1");

                // Set nilai yang telah dibersihkan kembali ke AutoNumeric
                autoNumericInstance.set(cleanedValue);
            };
        });
    }
}

function initAutoNumericTransakiBelanjaArmada(elements = null, options = null) {
    let defaultOptions = {
        digitGroupSeparator: formats.THOUSANDSEPARATOR,
        decimalCharacter: formats.DECIMALSEPARATOR,
        decimalPlaces: 0,
        trailingNegative: "none",
        modifyValueOnWheel: false,
    };

    // Menggabungkan opsi default dengan opsi yang diberikan (jika ada)
    let mergedOptions = Object.assign({}, defaultOptions, options);

    if (elements == null) {
        new AutoNumeric.multiple(".autonumeric-nozero2", mergedOptions);
    } else {
        $.each(elements, (index, element) => {
            // Membuat objek AutoNumeric
            let autoNumericInstance = new AutoNumeric(element, mergedOptions);
            element.style.textAlign = "right";

            // Menambahkan event listener setelah format selesai
            autoNumericInstance.onFormatted = function () {
                // Membersihkan nol di belakang koma desimal
                let cleanedValue = autoNumericInstance.getFormatted();
                cleanedValue = cleanedValue.replace(/(\.[0-9]*?)0+$/, "$1");

                // Set nilai yang telah dibersihkan kembali ke AutoNumeric
                autoNumericInstance.set(cleanedValue);
            };
        });
    }
}

function unformatAutoNumeric(data) {
    let autoNumericElements = $(".autonumeric");

    $.each(autoNumericElements, (index, autoNumericElement) => {
        let inputs = data.filter((row) => row.name == autoNumericElement.name);

        inputs.forEach((input, index) => {
            if (input.value !== "") {
                input.value = AutoNumeric.getNumber(autoNumericElement);
            }
        });
    });

    return data;
}

function setHighlight(grid) {
    let stringFilters;
    let filters;
    let gridId;

    stringFilters = grid.getGridParam("postData").filters;

    if (stringFilters) {
        filters = JSON.parse(stringFilters);
    }

    gridId = $(grid).getGridParam().id;

    if (filters) {
        filters.rules.forEach((rule) => {
            $(grid)
                .find(`tbody tr td[aria-describedby=${gridId}_${rule.field}]`)
                .highlight(rule.data);
        });
    }
}

function currencyFormat(value,isNull=false) {
 
    let result = parseFloat(value).toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

  

    result = result.replace(/\./g, "*");
    result = result.replace(/,/g, formats.THOUSANDSEPARATOR);
    result = result.replace(/\*/g, formats.DECIMALSEPARATOR);

    return result;
}

function currencyFormatNoDoubleZero(value) {
    let result = parseFloat(value).toFixed(2); // Memastikan ada dua digit desimal

    // Menghilangkan digit desimal jika tidak dibutuhkan
    if (result.endsWith(".00")) {
        result = result.slice(0, -3);
    }
   
    // Mengganti titik dengan tanda ribuan
    result = result.replace(/\B(?=(\d{3})+(?!\d))/g, formats.THOUSANDSEPARATOR);

    // Mengganti koma dengan tanda desimal
    result = result.replace(".", formats.DECIMALSEPARATOR);

    return result;
}

function currencyFormatStok(value,isNull=false) {
 
    let result = parseFloat(value).toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    if (result == '0' || result == '0.00'  && isNull) {
        return '';
    }

    result = result.replace(/\./g, "*");
    result = result.replace(/,/g, formats.THOUSANDSEPARATOR);
    result = result.replace(/\*/g, formats.DECIMALSEPARATOR);

    return result;
}

function currencyFormatNoDoubleZeroStok(value,isNull=false) {
    let result = parseFloat(value).toFixed(2); // Memastikan ada dua digit desimal

    // Menghilangkan digit desimal jika tidak dibutuhkan
    if (result.endsWith(".00")) {
        result = result.slice(0, -3);
    }
  
    if (result == '0' || result == '0.00' && isNull) {
        return '';
    }

    // Mengganti titik dengan tanda ribuan
    result = result.replace(/\B(?=(\d{3})+(?!\d))/g, formats.THOUSANDSEPARATOR);

    // Mengganti koma dengan tanda desimal
    result = result.replace(".", formats.DECIMALSEPARATOR);

    return result;
}

function currencyUnformat(value) {
    let result = parseFloat(value.replaceAll(formats.THOUSANDSEPARATOR, ""));

    return result;
}

function dateFormat(value) {
    let date = new Date(value);

    let seconds = date.getSeconds("default");
    let minutes = date.getMinutes("default");
    let hours = date.getHours("default");
    let day = date.getDate("default");
    let month = date.getMonth("default") + 1;
    let year = date.getFullYear("default");

    return `${day.toString().padStart(2, "0")}-${month
        .toString()
        .padStart(2, "0")}-${year}`;
}

function setNumberSeparators() {
    $.ajax({
        url: `${apiUrl}parameter`,
        method: "GET",
        async: false,
        data: {
            filters: JSON.stringify({
                groupOp: "AND",
                rules: [
                    {
                        field: "grp",
                        op: "cn",
                        data: "FORMAT ANGKA",
                    },
                ],
            }),
        },
        beforeSend: (jqXHR) => {
            jqXHR.setRequestHeader("Authorization", `Bearer ${accessToken}`);
        },
        success: (response) => {
            response.data.forEach((data) => {
                if (data.subgrp == "DESIMAL") {
                    decimalSeparator = data.text;
                } else if (data.subgrp == "RIBUAN") {
                    thousandSeparator = data.text;
                }
            });
        },
    });
}

function openMenuParents() {
    let currentMenu = $("a.nav-link.active").first();
    let parents = currentMenu.parents("li.nav-item");

    parents.each((index, parent) => {
        $(parent).addClass("menu-open");
    });
}

$(document).on("sidebar:toggle", () => {
    if ($("body").hasClass("sidebar-collapse")) {
        sidebarIsOpen = false;

        $("#search").focusout();
        $("body").removeClass("no-scroll");
    } else if ($("body").hasClass("sidebar-open")) {
        sidebarIsOpen = true;

        $("body").addClass("no-scroll");

        if (detectDeviceType() == "desktop") {
            $("#search").focus();
        }
    }
});

$(document).ajaxError((event, jqXHR, ajaxSettings, thrownError) => {
    if (jqXHR.status === 401) {
        showDialog(thrownError, jqXHR.responseJSON.message);
    }
});

// $(window).on("resize", function (event) {
// 	if ($(window).width() > 990) {
// 		$("body").removeClass();
// 		setTimeout(() => {
// 			$("body").addClass("sidebar-closed sidebar-collapse");
// 		}, 0);
// 	}
// });

$(".sidebars").click(function (e) {
    $("body").addClass("sidebar-open");
    e.preventDefault();
});

$(document).mouseup(function (e) {
    var container = $(".main-sidebar");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        if ($("body").hasClass("sidebar-open")) {
            $("body").removeClass("sidebar-open");
        }
    }
});

/* Disable plugin */
$.fn.disable = function () {
    this.bind("cut copy paste change", function () {
        return false;
    });

    this.on("keydown", (e) => {
        if (!e.altKey && !e.ctrlKey && e.which !== 27) {
            e.preventDefault();
            return false;
        }
    });

    if (this.is("select")) {
        let selected = this.find("option:selected");

        this.change(() => {
            this.val(selected.val());
        });
    }
};

function setErrorMessages(form, errors) {
    $.each(errors, (index, error) => {
        let indexes = index.split(".");
        let element;

        if (indexes.length > 1) {
            element = form.find(`[name="${indexes[0]}[]"]`)[indexes[1]];
        } else {
            element = form.find(`[name="${indexes[0]}"]`)[0];
        }

        if ($(element).length > 0 && !$(element).is(":hidden")) {
            $(element).addClass("is-invalid");
            $(`
					<div class="invalid-feedback">
					${error[0].toLowerCase()}
					</div>
			`).appendTo($(element).parent());
        } else {
            return showDialog(error);
        }
    });

    $(".is-invalid").first().focus();
}

function setErrorMessagesNew(form, errors) {
    $.each(errors, (index, error) => {
        let indexes = index.split(".");
        let element;

        if (indexes.length > 1) {
            element = form.find(`[name="${indexes[1]}[]"]`)[indexes[0]];
           
        } else {
            element = form.find(`[name="${indexes[0]}"]`)[0];
        }

        if ($(element).length > 0 && !$(element).is(":hidden")) {
            $(element).addClass("is-invalid");
            $(`
          <div class="invalid-feedback">
          ${error[0].toLowerCase()}
          </div>
      `).appendTo($(element).parent());
        } else {
            return showDialog(error);
        }
    });

    $(".is-invalid").first().focus();
}

function setErrorMessagesEditAll(form, errors) {

    $.each(errors, (index, error) => {
        let indexes = index.split("."); 
        let element;

        if (indexes.length > 1) {
            element = $('#editAllFormPenjualan').find(`[name="${indexes[0]}"]`)[indexes[1]];
            
        } else {
            element = $('#editAllFormPenjualan').find(`[name="${indexes[0]}"]`)[0];
        }

        if ($(element).length > 0 && !$(element).is(":hidden")) {
            $(element).addClass("is-invalid");
            $(`
        <div class="invalid-feedback">
        ${error[0].toLowerCase()}
        </div>
    `).appendTo($(element).parent());
        } else {
            return showDialog(error);
        }
    });

    $(".is-invalid").first().focus();
}

function removeTags(str) {
    if (str === null || str === "") return false;
    else str = str.toString();
    return str.replace(/(<([^>]+)>)/gi, "");
}

/**
 * Set Home, End, PgUp, PgDn
 * to move grid page
 */
function setCustomBindKeys(grid) {
    setSidebarBindKeys();

    $(document).on("keydown", function (e) {
        if (!sidebarIsOpen && activeGrid) {
            if (
                e.keyCode == 33 ||
                e.keyCode == 34 ||
                e.keyCode == 35 ||
                e.keyCode == 36 ||
                e.keyCode == 38 ||
                e.keyCode == 40 ||
                e.keyCode == 13
            ) {
                e.preventDefault();

                var gridIds = $(activeGrid).getDataIDs();
                var selectedRow = $(activeGrid).getGridParam("selrow");
                var currentPage = $(activeGrid).getGridParam("page");
                var lastPage = $(activeGrid).getGridParam("lastpage");
                var currentIndex = 0;
                var row = $(activeGrid).jqGrid("getGridParam", "postData").rows;

                for (var i = 0; i < gridIds.length; i++) {
                    if (gridIds[i] == selectedRow) currentIndex = i;
                }

                if (triggerClick == false) {
                    if (33 === e.keyCode) {
                        if (currentPage > 1) {
                            $(activeGrid)
                                .jqGrid("setGridParam", {
                                    page: parseInt(currentPage) - 1,
                                })
                                .trigger("reloadGrid");

                            triggerClick = true;
                        }
                        $(activeGrid).triggerHandler("jqGridKeyUp"),
                            e.preventDefault();
                    }
                    if (34 === e.keyCode) {
                        if (currentPage !== lastPage) {
                            $(activeGrid)
                                .jqGrid("setGridParam", {
                                    page: parseInt(currentPage) + 1,
                                })
                                .trigger("reloadGrid");

                            triggerClick = true;
                        }
                        $(activeGrid).triggerHandler("jqGridKeyUp"),
                            e.preventDefault();
                    }
                    if (35 === e.keyCode) {
                        if (currentPage !== lastPage) {
                            $(activeGrid)
                                .jqGrid("setGridParam", {
                                    page: lastPage,
                                })
                                .trigger("reloadGrid");
                            if (e.ctrlKey) {
                                if (
                                    $(activeGrid).jqGrid(
                                        "getGridParam",
                                        "selrow"
                                    ) !==
                                    $("#customer")
                                        .find(">tbody>tr.jqgrow")
                                        .filter(":last")
                                        .attr("id")
                                ) {
                                    $(activeGrid)
                                        .jqGrid(
                                            "setSelection",
                                            $(activeGrid)
                                                .find(">tbody>tr.jqgrow")
                                                .filter(":last")
                                                .attr("id")
                                        )
                                        .trigger("reloadGrid");
                                }
                            }

                            triggerClick = true;
                        }
                        if (e.ctrlKey) {
                            if (
                                $(activeGrid).jqGrid(
                                    "getGridParam",
                                    "selrow"
                                ) !==
                                $("#customer")
                                    .find(">tbody>tr.jqgrow")
                                    .filter(":last")
                                    .attr("id")
                            ) {
                                $(activeGrid)
                                    .jqGrid(
                                        "setSelection",
                                        $(activeGrid)
                                            .find(">tbody>tr.jqgrow")
                                            .filter(":last")
                                            .attr("id")
                                    )
                                    .trigger("reloadGrid");
                            }
                        }
                        $(activeGrid).triggerHandler("jqGridKeyUp"),
                            e.preventDefault();
                    }
                    if (36 === e.keyCode) {
                        if (currentPage > 1) {
                            if (e.ctrlKey) {
                                if (
                                    $(activeGrid).jqGrid(
                                        "getGridParam",
                                        "selrow"
                                    ) !==
                                    $("#customer")
                                        .find(">tbody>tr.jqgrow")
                                        .filter(":first")
                                        .attr("id")
                                ) {
                                    $(activeGrid).jqGrid(
                                        "setSelection",
                                        $(activeGrid)
                                            .find(">tbody>tr.jqgrow")
                                            .filter(":first")
                                            .attr("id")
                                    );
                                }
                            }
                            $(activeGrid)
                                .jqGrid("setGridParam", {
                                    page: 1,
                                })
                                .trigger("reloadGrid");

                            triggerClick = true;
                        }
                        $(activeGrid).triggerHandler("jqGridKeyUp"),
                            e.preventDefault();
                    }
                    if (38 === e.keyCode) {
                        if (currentIndex - 1 >= 0) {
                            $(activeGrid)
                                .resetSelection()
                                .setSelection(gridIds[currentIndex - 1]);
                        }
                    }
                    if (40 === e.keyCode) {
                        if (currentIndex + 1 < gridIds.length) {
                            $(activeGrid)
                                .resetSelection()
                                .setSelection(gridIds[currentIndex + 1]);
                        }
                    }
                    if (13 === e.keyCode) {
                        let rowId = $(activeGrid).getGridParam("selrow");
                        let ondblClickRowHandler = $(activeGrid).jqGrid(
                            "getGridParam",
                            "ondblClickRow"
                        );

                        if (ondblClickRowHandler) {
                            ondblClickRowHandler.call($(activeGrid)[0], rowId);
                        }
                    }
                }

                $(".ui-jqgrid-bdiv").find("tbody").animate({
                    scrollTop: 200,
                });
                $(".table-success").position().top > 300;
            }
        }
    });
}

function setSidebarBindKeys() {
    $(document).on("keydown", (event) => {
        if (event.keyCode === 77 && event.altKey) {
            event.preventDefault();

            $("#sidebarButton").click();
        }

        if (sidebarIsOpen) {
            let allowedKeyCodes = [37, 38, 39, 40];

            if (allowedKeyCodes.includes(event.keyCode)) {
                event.preventDefault();

                $("#search").val("");

                if ($(".nav-link.active, .nav-link.hover").length <= 0) {
                    $(".main-sidebar nav .nav-link").first().addClass("hover");
                }

                switch (event.keyCode) {
                    case 37:
                        setUpOneLevelMenu();

                        break;
                    case 38:
                        setPreviousMenuHover();

                        break;
                    case 39:
                        setDownOneLevelMenu();

                        break;
                    case 40:
                        setNextMenuHover();

                        break;
                    default:
                        break;
                }
            } else if (event.keyCode === 13) {
                let hoveredElement = $(".nav-link.hover");

                if (hoveredElement.length > 0) {
                    if (hoveredElement.siblings("ul").length > 0) {
                        setDownOneLevelMenu();
                    } else {
                        hoveredElement[0].click();
                    }
                }
            }
        }
    });
}

function setNextMenuHover() {
    let currentElement = $(".nav-link.hover").first();

    if (currentElement.length <= 0) {
        currentElement = $(".nav-link.selected-link");
    }

    if (currentElement.length <= 0) {
        currentElement = $(".nav-link.active");
    }

    let nextElement = currentElement
        .parent(".nav-item")
        .next()
        .find(".nav-link")
        .first();

    if (nextElement.length > 0) {
        currentElement.removeClass("selected-link hover");
        nextElement.addClass("hover");
    }
}

function setPreviousMenuHover() {
    let currentElement = $(".nav-link.hover").first();

    if (currentElement.length <= 0) {
        currentElement = $(".nav-link.selected-link");
    }

    if (currentElement.length <= 0) {
        currentElement = $(".nav-link.active");
    }

    let nextElement = currentElement
        .parent(".nav-item")
        .prev()
        .find(".nav-link")
        .first();

    if (nextElement.length > 0) {
        currentElement.removeClass("selected-link hover");
        nextElement.addClass("hover");
    }
}

function setUpOneLevelMenu() {
    let currentElement = $(".nav-link.hover").first();

    if (currentElement.length <= 0) {
        currentElement = $(".nav-link.selected-link");
    }

    if (currentElement.length <= 0) {
        currentElement = $(".nav-link.active");
    }

    let upOneLevelElement = currentElement.parents().eq(2);

    if (upOneLevelElement.length > 0) {
        currentElement.removeClass("selected-link hover");
        upOneLevelElement.removeClass("menu-is-opening menu-open");
        upOneLevelElement.find(".nav-link").first().addClass("hover");
    }
}

function setDownOneLevelMenu() {
    let currentElement = $(".nav-link.hover").first();

    if (currentElement.length <= 0) {
        currentElement = $(".nav-link.selected-link");
    }

    if (currentElement.length <= 0) {
        currentElement = $(".nav-link.active");
    }

    let downOneLevelElement = currentElement
        .siblings("ul")
        .css({
            display: "",
        })
        .find(".nav-link")
        .first();

    if (downOneLevelElement.length > 0) {
        currentElement.removeClass("selected-link hover");
        currentElement.parent(".nav-item").addClass("menu-open");
        downOneLevelElement.addClass("hover");
    }
}

function fillSearchMenuInput() {
    let currentElement = $(".nav-link.hover").first();

    if (currentElement.length <= 0) {
        currentElement = $(".nav-link.selected-link");
    }

    if (currentElement.length <= 0) {
        currentElement = $(".nav-link.active");
    }

    $("#search").val(currentElement.attr("id"));
}

/**
 * Move to closest input when using press enter
 */
function setFormBindKeys(form = null) {
    let element;
    let position;
    let inputs;

    if (form !== null) {
        inputs = form.find(
            "[name]:not(:hidden, [readonly], [disabled], .disabled), button:submit"
        );
    } else {
        inputs = $(document).find(
            "[name]:not(:hidden, [readonly], [disabled], .disabled), button:submit"
        );
    }

    $($(inputs.filter(":not(button)")[0])).focus();

    if (!$("#crudForm").attr("has-binded")) {
        inputs.each(function (i, el) {
            $(el).attr("data-input-index", i);
        });

        inputs.focus(function () {
            $(this).data("input-index");
        });

        inputs.keydown(function (e) {
            let operator;
            switch (e.keyCode) {
                case 38:
                    // if ($(this).parents('table').length > 0) {
                    // 	element = $(this).parents('tr').prev('tr').find('td').eq($(this).parent().index()).find('input')
                    // } else {
                    element = $(inputs[$(this).data("input-index") - 1]);
                    // }

                    break;
                case 13:
                    if (e.shiftKey) {
                        element = $(inputs[$(this).data("input-index") - 1]);
                    } else if (e.ctrlKey) {
                        $(this).closest("form").find("button:submit").click();
                    } else {
                        element = $(inputs[$(this).data("input-index") + 1]);

                        if (e.keyCode == 13 && $(this).is("button")) {
                            $(this).click();
                        }
                    }

                    break;
                case 40:
                    element = $(inputs[$(this).data("input-index") + 1]);

                    break;
                default:
                    return;
            }

            if (element !== undefined) {
                if (
                    element.is(":not(select, button)") &&
                    element.attr("type") !== "email" &&
                    element.attr("type") !== "time"
                ) {
                    position = element.val().length;
                    element[0].setSelectionRange(position, position);
                }

                element.hasClass("hasDatePicker")
                    ? $(".ui-datepicker").show()
                    : $(".ui-datepicker").hide();
                element.focus();
            }

            e.preventDefault();
        });

        form.attr("has-binded", true);
    }
}

function initResize(grid) {
    /* Check if scrollbar appears */
    $(window).height() < $(document).height()
        ? grid.setGridWidth($(window).width() - 15)
        : "";

    /* Resize grid while resizing window */
    $(window).resize(function () {
        grid.setGridWidth($(window).width() - 15);
    });
}

var delay = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

function loadGlobalSearch(grid) {
    /* Append global search textfield */
    $("#t_" + $.jgrid.jqID(grid[0].id)).html(
        $(
            `<form class="form-inline"><div class="form-group w-100 px-2" id="titlesearch"><label for="searchText" style="font-weight: normal !important;">Search : </label><input type="text" class="form-control form-control-sm global-search" id="${$.jgrid.jqID(
                grid[0].id
            )}_searchText" placeholder="Search" autocomplete="off"></div></form>`
        )
    );

    /* Handle textfield on input */
    $(document).on(
        "input",
        `#${$.jgrid.jqID(grid[0].id)}_searchText`,
        function () {
            delay(function () {
                abortGridLastRequest(grid);
                if (grid.getGridParam().id == "jqGrid") {
                    $("#left-nav")
                        .find(`button:not(#add)`)
                        .attr("disabled", "disabled");
                }
                clearColumnSearch(grid);

                var postData = grid.jqGrid("getGridParam", "postData"),
                    colModel = grid.jqGrid("getGridParam", "colModel"),
                    rules = [],
                    searchText = $(
                        `#${$.jgrid.jqID(grid[0].id)}_searchText`
                    ).val(),
                    l = colModel.length,
                    i,
                    cm;
                if (addedRules) {
                    rules.push(addedRules);
                }
                for (i = 0; i < l; i++) {
                    cm = colModel[i];
                    if (
                        cm.search !== false &&
                        (cm.stype === undefined ||
                            cm.stype === "text" ||
                            cm.stype === "select")
                    ) {
                        rules.push({
                            field: cm.name,
                            op: "cn",
                            data: searchText.toUpperCase(),
                        });
                    }
                }
                postData.filters = JSON.stringify({
                    groupOp: "OR",
                    rules: rules,
                });

                grid.jqGrid("setGridParam", {
                    search: true,
                });
                grid.trigger("reloadGrid", [
                    {
                        page: 1,
                        current: true,
                    },
                ]);
                return false;
            }, 500);
        }
    );
}

function additionalRulesGlobalSearch(params) {
    if (JSON.parse(params).rules[0]) {
        addedRules = JSON.parse(params).rules[0];
    }
}

function clearColumnSearch(grid) {
    $(`#gview_${grid.getGridParam("id")}`)
        .find('input[id*="gs_"]')
        .val("");
    $(`#gview_${grid.getGridParam("id")}`)
        .find('select[id*="gs_"]')
        .val("")
        .trigger("change.select2");
    $(`#resetdatafilter_${grid.getGridParam("id")}`).removeClass("active");
}

function clearGlobalSearch(grid) {
    $(`#${grid.getGridParam("id")}_searchText`).val("");
}

function loadClearFilter(grid) {
    /* Append Button */
    $("#gsh_" + $.jgrid.jqID(grid[0].id) + "_rn").html(
        $(
            `<div id='resetfilter' class='reset'><span id="resetdatafilter_${grid.getGridParam(
                "id"
            )}" class='btn btn-default'> X </span></div>`
        )
    );

    /* Handle button on click */
    $(`#resetdatafilter_${grid.getGridParam("id")}`).click(function () {
        highlightSearch = "";

        clearColumnSearch(grid);
        clearGlobalSearch(grid);

        grid.jqGrid("setGridParam", {
            search: false,
            postData: {
                filters: "",
            },
        }).trigger("reloadGrid");
    });
}

function startTime() {
    setInterval(() => {
        let date = new Date();

        let day = date.toLocaleString("id", {
            dateStyle: "medium",
        });

        let time = date.toLocaleString("id", {
            timeStyle: "medium",
        });

        $(".datetime-place .date-place").html(day);
        $(".datetime-place .time-place").html(time.replaceAll(".", ":"));
    }, 1000);
}

function initDatepicker(classDatepicker = "datepicker") {
    let element = $(document).find("." + classDatepicker);
    let datepickerInserted = false;

    if (!offDays) {
        offDays = getOffDays();
    }

    if (!element.parent().hasClass("input-group")) {
        element.wrap(`
				<div class="input-group">
				</div>
			`);
    }

    element
        .datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            assumeNearbyYear: false,
            showOn: "button",
            beforeShow: function (element, instance) {
                let calendar = instance.dpDiv;
                // alert(1)

                $(element).css({
                    position: "relative",
                });

                let isInModal = $(element).closest(".modal").length > 0;
                if (isInModal) {
                    $(".ui-datepicker").insertAfter(element);
                }

                // Dirty hack, but we can't do anything without it (for now, in jQuery UI 1.8.20)
                setTimeout(function () {
                    calendar.position({
                        my: "left top",
                        at: "left bottom",
                        collision: "none",
                        of: element,
                    });
                }, 1);
            },
            beforeShowDay: function (date) {
                let y = date.getFullYear().toString(); // get full year
                let m = (date.getMonth() + 1).toString(); // get month.
                let d = date.getDate().toString(); // get Day

                if (m.length == 1) {
                    m = "0" + m;
                } // append zero(0) if single digit
                if (d.length == 1) {
                    d = "0" + d;
                } // append zero(0) if single digit
                let currDate = y + "-" + m + "-" + d;

                let offDay = offDays.find((offDay) => offDay.date == currDate);
                let isSunday = date.getDay() === 0;
                let isSat = date.getDay() === 6;

                if (offDay || isSunday || isSat) {
                    if (isSunday) {
                        desc = "sunday";
                        styleClass = "datepicker-offday";
                    } else if (isSat) {
                        desc = "Saturday";
                        styleClass = "datepicker-saturday";
                    } else {
                        desc = offDay.description;
                        styleClass = "datepicker-offday";
                    }
                    return [true, styleClass, desc];
                } else {
                    return [true];
                }
            },
        })
        .inputmask({
            inputFormat: "dd-mm-yyyy",
            alias: "datetime",
            // onKeyDown: function(e, buffer, caretPos, opts) {
            // 	 // Set current year in the date picker
            // 	 var currentDate = new Date();
            // 	 var currentYear = currentDate.getFullYear();
            // 	 $(this).val('01/01/' + currentYear);
            // }
        })

        .focusout(function (e) {
            let val = $(this).val();
            if (val.match("[a-zA-Z]") == null) {
                if (val.length == 8) {
                    $(this)
                        .inputmask({
                            inputFormat: "dd-mm-yyyy",
                        })
                        .val([val.slice(0, 6), "20", val.slice(6)].join(""));
                }
            } else {
                $(this).focus();
            }
        });

    element.on("input", function (event) {
        $(".ui-datepicker").css({
            position: "absolute",
            top: "149.141px",
            left: "246.5px",
            "z-index": "1",
        });

        element.datepicker("widget").hide();
    });

    element
        .siblings(".ui-datepicker-trigger")
        .wrap(
            `
			<div class="input-group-append">
			</div>
		`
        )
        .addClass("btn btn-easyui text-easyui-dark").html(`
			<i class="fa fa-calendar-alt"></i>
		`);

    // $(".ui-datepicker-trigger").on('click', function() {
    // 	console.log($(this).parents('input-group-append'))
    //     $('.ui-datepicker').insertAfter($(this).parents('input-group-append'));

    // });

    element.on("keydown", function (event) {
        if (event.keyCode === 115) {
            if (element.datepicker("widget").not(":visible")) {
                element.datepicker("show");
            }
        }
    });

    // $('.ui-datepicker').insertAfter(element);

    //  // Add code to handle scrolling when .ui-datepicker-trigger is clicked
    //  $(".ui-datepicker-trigger").on("click", function () {

    //     if (/Mobi/.test(navigator.userAgent)) {
    //         let offsetTop = $(window).scrollTop();
    //         $('html, body').animate({scrollTop: offsetTop + 150}, 300);
    //     }
    // });
}

function getOffDays() {
    let offDays = [];

    $.ajax({
        url: `${apiUrl}harilibur`,
        method: "GET",
        dataType: "JSON",
        headers: {
            Authorization: `Bearer ${accessToken}`,
        },
        data: {
            limit: 0,
            load: "edit",
        },
        async: false,
        cache: true,
        success: (response) => {
            let convertedResponse = [];

            response.data.forEach((row) => {
                convertedResponse.push({
                    date: row.tgl,
                    description: row.keterangan,
                });
            });

            offDays = convertedResponse;
        },
    });

    return offDays;
}

function destroyDatepicker() {
    let datepickerElements = $(document).find(".datepicker");

    $.each(datepickerElements, (index, datepickerElement) => {
        $(datepickerElement).datepicker("destroy");
    });
}

$(document).on("input", ".numbernoseparate", function () {
    this.value = this.value.replace(/\D/g, "");
});

/* Select2: Autofocus search input on open */
function initSelect2(elements = null, isInsideModal = true) {
    if (elements === null) {
        $(document)
            .find("select")
            .each((index, element) => {
                let option = {
                    width: "100%",
                    theme: "bootstrap4",
                    dropdownParent: isInsideModal
                        ? $(element).parents(".modal-content")
                        : "",
                };

                $(element)
                    .select2(option)
                    .on("select2:open", function (e) {
                        document
                            .querySelector(".select2-search__field")
                            .focus();
                    });
            });
    } else {
        $.each(elements, (index, element) => {
            let option = {
                width: "100%",
                theme: "bootstrap4",
                dropdownParent: isInsideModal
                    ? $(element).parents(".modal-content")
                    : "",
            };

            $(element)
                .select2(option)
                .on("select2:open", function (e) {
                    document.querySelector(".select2-search__field").focus();
                });
        });
    }
}

function clearButton(form, el) {
    var el = $(el);
    var clearButtonClicked = false;

    el.wrap('<div class="input-group"></div>');

    let inputGroupAppend = $(
        '<div class="input-group-append"></div>'
    ).insertAfter(el);

    $(
        '<button type="button" class="btn position-absolute button-clear text-secondary" style="right: 25px; z-index: 99;"><i class="fa fa-times"></i></button>'
    ).appendTo(inputGroupAppend);

    inputGroupAppend.find("button").click(function () {
        clearButtonClicked = true;
        el.val("").trigger("change");
    });

    el.on("select2:opening", function (e) {
        if (clearButtonClicked) {
            clearButtonClicked = false;
            setTimeout(function () {
                $(".select2-search__field").val("").trigger("input");
            }, 50);
        }
    });
}

function formatSearchResult(result) {
    if (!result.id) {
        return result.text;
    }

    var query = $(".select2-search__field").val();
    var str = result.text;

    var regex = new RegExp(query, "i");
    var indexQuery = str.toLowerCase().indexOf(query.toLowerCase());

    var highlightText = str.substring(indexQuery, indexQuery + query.length);
    var newStr = str.replace(
        regex,
        '<span style="background-color:yellow;">' + highlightText + "</span>"
    );

    return $("<span>" + newStr + "</span>");
}

function destroySelect2() {
    let select2Elements = $(document).find("select");

    $.each(select2Elements, (index, select2Element) => {
        $(select2Element).select2("destroy");
    });
}

function showSuccessDialog(statusText = "", message = "") {
    $("#dialog-success-message").find("p").remove();
    $("#dialog-success-message").append(
        `<p> ${statusText} </p><p> ${message} </p>`
    );
    $("#dialog-success-message").dialog({
        modal: true,
        buttons: [
            {
                text: "Ok",
                click: function () {
                    $(this).dialog("close");
                },
            },
        ],
    });
}

// function showDialog(statusText="", message="") {
// 	$("#dialog-message").html(`
// 		<span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
// 	`)
// 	$("#dialog-message").append(
// 		`<p class="text-dark"> ${statusText} </p> ${message}`
// 	);
// 	$("#dialog-message").dialog({
// 		modal: true,
// 		buttons: [
// 			{
// 				text: "Ok",
// 				click: function () {
// 					$(this).dialog("close");
// 				},
// 			},
// 		]
// 	});
// 	$(".ui-dialog-titlebar-close").find("p").remove();
// }

function showDialog(response) {
    $("#dialog-message").html(`
		<span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
	`);
    $("#dialog-warning-message").html(`
		<span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
	`);
    if ($.type(response) === "object") {
        if ("file" in response) {
            $("#dialog-message").append(
                // `<p class="text-dark"> ${statusText} </p> ${message}`
                `<p>file: ${response.file}</p>` +
                    `<p>line : ${response.line}</p>` +
                    `<p>message : ${response.message}</p>`
            );

            $("#dialog-message").dialog({
                modal: true,
                buttons: [
                    {
                        text: "Ok",
                        click: function () {
                            $(this).dialog("close");
                        },
                    },
                ],
            });
            $(".ui-dialog-titlebar-close").find("p").remove();
        } else {
            $(`#dialog-${response.statuspesan}-message`).append(
                `<p class="text-dark">${response.message}</p>`
            );

            $(`#dialog-${response.statuspesan}-message`).dialog({
                modal: true,
                buttons: [
                    {
                        text: "Ok",
                        click: function () {
                            $(this).dialog("close");
                            $(`#dialog-${response.statuspesan}-message`)
                                .find("p")
                                .remove();
                        },
                    },
                ],
            });

            $(".ui-dialog-titlebar-close").find("p").remove();
        }
    } else {
        $("#dialog-warning-message").append(
            `<p class="text-dark">${response}</p>`
        );

        $("#dialog-warning-message").dialog({
            modal: true,
            buttons: [
                {
                    text: "Ok",
                    click: function () {
                        $(this).dialog("close");
                        $(`#dialog-warning-message`).find("p").remove();
                    },
                },
            ],
        });
        $(".ui-dialog-titlebar-close").find("p").remove();
    }
}

function showConfirm(statusText = "", message = "", urlDestination = "") {
    $("#dialog-confirm").find("p").remove();
    $("#dialog-confirm").append(`<p> ${statusText} </p><p> ${message} </p>`);
    $("#dialog-confirm").dialog({
        modal: true,
        open: function () {
            console.log($(this));
        },
        buttons: [
            {
                text: "Ok",
                open: function () {
                    $(this).addClass("btn btn-success");
                },
                click: function () {
                    $(this).dialog("close");
                    processResult(true, urlDestination);
                },
            },
            {
                text: "Cancel",
                open: function () {
                    $(this).addClass("btn btn-danger");
                },
                click: function () {
                    $(this).dialog("close");
                    processResult(false);
                },
            },
        ],
    });
}

function showConfirmForce(message = "", Id = "") {
    // var def = $.Deferred();
    $("#dialog-confirm-force").find("p").remove();
    $("#dialog-confirm-force").append(`<p> ${message} </p>`);
    // $("#dialog-confirm-force").dialog({
    // 	modal: true,
    // 	open: function () {
    // 		// console.log($(this));
    // 	},
    // 	buttons: [
    // 		{
    // 			text: "Force Edit",
    // 			open: function () {
    // 				$(this).addClass("btn btn-success");
    // 			},
    // 			click: function () {
    // 				$(this).dialog("close");
    // 				if(urlDestination != ""){
    // 					processResult(true, urlDestination);
    // 				}
    // 				def.resolve()
    // 			},
    // 		},
    // 		{
    // 			text: "Cancel",
    // 			open: function () {
    // 				$(this).addClass("btn btn-danger");
    // 			},
    // 			click: function () {
    // 				$(this).dialog("close");
    // 				processResult(false);
    // 				def.reject()
    // 			},
    // 		},
    // 	],
    // });
    $("#dialog-confirm-force").dialog({
        modal: true,
        buttons: [
            {
                id: "Force Edit",
                text: "Force Edit",
                click: function () {
                    $(this).dialog("close");
                    console.log(Id);
                    approveKacab(Id);
                },
            },
            {
                id: "Cancel",
                text: "Cancel",
                click: function () {
                    $(this).dialog("close");
                },
            },
        ],
    });
    // return def.promise();
}

function showConfirmForceEditAll(message = "", date = "") {
    // var def = $.Deferred();
    $("#dialog-confirm-force").find("p").remove();
    $("#dialog-confirm-force").append(`<p> ${message} </p>`);

    $("#dialog-confirm-force").dialog({
        modal: true,
        buttons: [
            {
                id: "Force Edit",
                text: "Force Edit",
                click: function () {
                    $(this).dialog("close");
                    console.log(date);
                    approveKacabEditAll(date);
                },
            },
            {
                id: "Cancel",
                text: "Cancel",
                click: function () {
                    $(this).dialog("close");
                },
            },
        ],
    });
    // return def.promise();
}

function showDialogEditAllMessage(message = "") {
    $("#dialog-editall-message").html(`
		<span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
	`);
    $("#dialog-editall-message").append(`<p class="text-dark">${message}</p>`);

    $("#dialog-editall-message").dialog({
        modal: true,
        buttons: [
            {
                text: "Ok",
                click: function () {
                    $(this).dialog("close");
                    $(`#dialog-editall-message`).find("p").remove();
                },
            },
        ],
    });
    $(".ui-dialog-titlebar-close").find("p").remove();
    // return def.promise();
}

function showDialogForce(response) {
    $("#dialog-force-message").html(`
		<span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
	`);
    $("#dialog-force-message").append(`<p class="text-dark">${response}</p>`);

    $("#dialog-force-message").dialog({
        modal: true,
        buttons: [
            {
                text: "Ok",
                click: function () {
                    $(this).dialog("close");
                    $(`#dialog-force-message`).find("p").remove();
                },
            },
        ],
    });
    $(".ui-dialog-titlebar-close").find("p").remove();
}

function showDialogEditAll(response, label) {
    $("#dialog-editall").html(`
		<span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
       
	`);

    $("#dialog-editall").append(
        `<p class="text-dark">perubahan harga berhasil update di pesanan final tgl pengiriman : </p>
            <input type="text" name="periode" class="form-control bg-white state-delete datepickerIndex" style="font-size:1rem!important;" value="${response}" disabled>`
    );

    initDatepicker();
    $("#dialog-editall").dialog({
        modal: true,
        buttons: [
            {
                text: "Ok",
                click: function () {
                    $(this).dialog("close");
                    $(`#dialog-editall`).find("p").remove();
                },
            },
        ],
    });

    $(".ui-dialog-titlebar-close").find("p").remove();
}

$(document).ready(function () {
    $("#sidebarButton").click(function () {
        setTimeout(() => {
            $(document).trigger("sidebar:toggle");
        }, 0);

        $(".nav-treeview").each(function (i, el) {
            $(el).removeAttr("style");
        });
    });

    var url = window.location.href;

    /** add active class and stay opened when selected */
    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $("ul.sidebar-menu a")
        .filter(function () {
            return this.href == url;
        })
        .parent()
        .addClass("active");

    // for treeview
    $("ul.treeview-menu a")
        .filter(function () {
            return this.href == url;
        })
        .parentsUntil(".sidebar-menu > .treeview-menu")
        .addClass("active");
});

$("#search").keyup(function () {
    $(this).data("val", $(this).val());
});

// $("#search").on("input", function (e) {
// 	var code = $(this).val();
// 	var test = $("#" + code).attr("id");
// 	var attr = $("#" + test).attr("href");

// 	$(".sidebar .hover").removeClass("hover");

// 	if (code === "") {
// 		$(".selected").click().removeClass("selected");
// 	} else {
// 		if (
// 			$("#" + test).hasClass("selected") ||
// 			$("#" + test).hasClass("selected-link")
// 		) {
// 			var prev = $(this).data("val");
// 			$("#" + prev)
// 				.removeClass("selected")
// 				.click();
// 			$("#" + prev).removeClass("active selected-link");
// 		} else {
// 			if (attr != "javascript:void(0)") {
// 				var link = $("#" + test).addClass("selected-link");
// 				$(document).on("keypress", function (e) {
// 					if (e.keyCode == 13) {
// 						if ($(link).hasClass("selected-link")) {
// 							$(link)[0].click();
// 						} else {
// 							return false;
// 						}
// 					}
// 				});
// 			} else {
// 				if (
// 					$("#" + test)
// 						.parent(".nav-item")
// 						.hasClass("menu-is-opening menu-open") ||
// 					$("#" + test)
// 						.parent(".nav-item")
// 						.hasClass("menu-open")
// 				) {
// 					$("#" + test).addClass("selected");
// 				} else {
// 					$("#" + test)[0].click();
// 					$("#" + test).addClass("selected");
// 				}
// 			}
// 		}
// 	}
// });

/* Table bindkeys */
$(document).on("keydown", ".table-bindkeys [name]", function (event) {
    switch (event.keyCode) {
        case 13:
            event.preventDefault();
        case 38:
            incomingElement = $(this)
                .parents("tr")
                .prev("tr")
                .find("td")
                .eq($(this).parents("td").index())
                .find("[name]");

            if (incomingElement.length !== 0) {
                setPrevFocus(incomingElement);
            }
            break;
        case 40:
            incomingElement = $(this)
                .parents("tr")
                .next("tr")
                .find("td")
                .eq($(this).parents("td").index())
                .find("[name]");

            if (incomingElement.length == 0) {
                $("form button#btnSimpan").focus();
            } else {
                incomingElement.focus();
            }
            break;
        default:
            break;
    }
});

$(document)
    .on("mousedown", "#addrow", function (event) {
        activeElement = document.activeElement;
    })
    .on("mouseup", "#addrow", function (event) {
        if (
            ($(activeElement).is("input") ||
                $(activeElement).is("select") ||
                $(activeElement).is("textarea")) &&
            $(activeElement).parents(".table-bindkeys").length > 0
        ) {
            if (
                typeof $(activeElement).attr("name") !== "undefined" &&
                $(activeElement).attr("name") !== false
            ) {
                activeElement.focus();
            }
        } else {
            $(".table-bindkeys").find("[name]")[0].focus();
        }
    });

function setPrevFocus(incomingElement) {
    position = incomingElement.val().length;

    setTimeout(() => {
        incomingElement[0].setSelectionRange(position, position);
    }, 0);

    incomingElement.focus();
}

function detectDeviceType() {
    const ua = navigator.userAgent;
    if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
        return "tablet";
    } else if (
        /Mobile|Android|iP(hone|od)|IEMobile|BlackBerry|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(
            ua
        )
    ) {
        return "mobile";
    }
    return "desktop";
}

function setGridLastRequest(grid, lastRequest) {
    grid.setGridParam({
        lastRequest,
    });
}

function getGridLastRequest(grid) {
    return grid.getGridParam()?.lastRequest;
}

function abortGridLastRequest(grid) {
    // getGridLastRequest(grid)?.abort()

    var lastRequest = getGridLastRequest(grid);
    if (lastRequest) {
        lastRequest.abort();
        grid.abortComplete = false; // Set completion flag to false
        lastRequest.onreadystatechange = function () {
            if (lastRequest.readyState === 4) {
                grid.abortComplete = true; // Set completion flag to true
            }
        };
    }
}
function isAbortComplete(grid) {
    return grid.abortComplete !== false;
}
function isAbortComplete(grid) {
    return grid.abortComplete !== false;
}
function clearGridData(grid) {
    grid.jqGrid("setGridParam", {
        datatype: "local",
        data: [],
    }).trigger("reloadGrid");
}
function clearGridHeader(grid) {
    grid.jqGrid("setGridParam", {
        data: [],
    }).trigger("reloadGrid");
}

function updatePagination(currentPage, totalPages) {
    var pagesToShow = 3;
    var halfPagesToShow = Math.floor(pagesToShow / 2);

    var startPage = Math.max(1, currentPage - halfPagesToShow);
    var endPage = Math.min(totalPages, startPage + pagesToShow - 1);

    $("#previousPageButton").click(function (e) {
        getAll(currentPage - 1);
    });

    $("#nextPageButton").click(function (e) {
        getAll(currentPage + 1);
    });
    // $("#pagination").empty();

    // $("#pagination").append(
    //     '<li class="page-item ' +
    //         (currentPage === 1 ? "disabled" : "") +
    //         '"><a class="page-link" href="#" onclick="getAll(' +
    //         (currentPage - 1) +
    //         ')">Previous</a></li>'
    // );

    // if (currentPage === totalPages) {
    //     $("#pagination").append(
    //         '<li class="page-item"><a class="page-link" href="#" onclick="getAll(1)">1</a></li>'
    //     );
    // }

    // for (var i = startPage; i <= endPage; i++) {
    //     $("#pagination").append(
    //         '<li class="page-item ' +
    //             (i === currentPage ? "active" : "") +
    //             '"><a class="page-link" href="#" onclick="getAll(' +
    //             i +
    //             ')">' +
    //             i +
    //             "</a></li>"
    //     );
    // }

    // if (endPage < totalPages) {
    //     // Tambahkan tanda "..."
    //     $("#pagination").append(
    //         '<li class="page-item disabled"><span class="page-link">...</span></li>'
    //     );
    //     // Tambahkan link untuk halaman terakhir
    //     $("#pagination").append(
    //         '<li class="page-item"><a class="page-link" href="#" onclick="getAll(' +
    //             totalPages +
    //             ')">' +
    //             totalPages +
    //             "</a></li>"
    //     );
    // }

    // // Tambahkan "Next" link
    // $("#pagination").append(
    //     '<li class="page-item ' +
    //         (currentPage === totalPages ? "disabled" : "") +
    //         '"><a class="page-link" href="#" onclick="getAll(' +
    //         (currentPage + 1) +
    //         ')">Next</a></li>'
    // );

    // $("#pagination").append(
    //     '<li class="page-item next-form" style="margin-left: 10px;">' +
    //         '<div class="input-group mb-3">' +
    //         '<input type="text" class="form-control small-input" id="nomorHalamanInput" style="width: 70px;" placeholder="Hal.">' +
    //         "</div>" +
    //         "</li>"
    // );

    // $("#nomorHalamanInput").keyup(function (event) {
    //     // Ambil nilai input dan konversi ke angka
    //     var nomorHalamanManual = parseInt($("#nomorHalamanInput").val());
    //     console.log(nomorHalamanManual);

    //     if (!isNaN(nomorHalamanManual) && nomorHalamanManual > 0) {
    //         // Panggil fungsi getAll sesuai dengan nomor halaman yang dimasukkan
    //         getAll(nomorHalamanManual);
    //         $("#nomorHalamanInput").focus();
    //     }
    // });

    // // Tambahkan event listener untuk event keyup
}

function elementPager() {
    let elPager = $(`
    <div class="row d-flex align-items-center justify-content-center justify-content-lg-end pr-3">
        <div id="PagerHandler"
            class="pager-handler d-flex align-items-center justify-content-center mx-2">
            <button type="button" id="firstPageButton"
                class="btn btn-sm hover-primary mr-2 d-flex">
                <span class="fas fa-step-backward"></span>
            </button>

            <button type="button" id="previousPageButton"
                class="btn btn-sm hover-primary d-flex">
                <span class="fas fa-backward"></span>
            </button>

            <div class="d-flex align-items-center my-1  justify-content-between gap-10" id="infoPage">
                <span>Page</span>
                <input id="pagerInput" class="pager-input" value="1" autocomplete="off">
               
            </div>

            <button type="button" id="nextPageButton"
                class="btn btn-sm hover-primary d-flex">
                <span class="fas fa-forward"></span>
            </button>

            <button type="button" id="lastPageButton"
                class="btn btn-sm hover-primary ml-2 d-flex">
                <span class="fas fa-step-forward"></span>
            </button>

            <select id="rowList" class="ml-2">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="0">ALL</option>
            </select>
        </div>
        <div id="InfoHandlerEditAll" class="pager-info">
            
        </div>
    </div>

    `);

    $(".editAllPager").append(elPager);
}

let dateFilter = $("#editAllForm").find("[name=tglpengiriman]").val();
function filtersEditAll(dataColumn = []) {
    let elFilters = ` <th>
    <div id="resetfilter" class="reset"><span id="resetdatafilter"
            class="btn btn-default align-items-center"> X </span></div>
    </th>`;

    $.each(dataColumn, (index, detail) => {
        elFilters += `
       
        <th rowspan="1" colspan="1" >
            <div class="row">
                <div class="col-3 col-sm-10">
                    <input type="text" name="nama[]" class="form-control filter-input" data-field="${detail}" autocomplete="off">
                </div>
                <div class="col-2 col-sm-1 mt-2">
                    <a title="Reset Search Value" data-column="${detail}" class="clearsearchclass">x</a>
                </div>
            
            </div>

        </th>

    `;
    });

    $("table tr.filters").html($(elFilters));

    $("#resetdatafilter").on("click", function () {
        var filters = [];
        $(".filter-input").each(function () {
            var field = $(this).data("field");
        });

        filterObject = {
            groupOp: "AND",
            rules: [],
        };

        $(".filter-input").val("");
        $("#searchText").val("");

        getAll(1, $("#rowList").val(), filterObject, dateFilter);
        setTimeout(function () {
            totalInfoPage(totalPages);
            viewPageEdit(currentPage, $("#editAll tbody tr").length);
        }, 500);
    });

    $(".filter-input").on("keyup", function () {
        var filters = [];
        $(".filter-input").each(function () {
            var field = $(this).data("field");

            var data = $(this).val();
            if (data !== "") {
                filters.push({
                    field: field,
                    op: "cn",
                    data: data,
                });
            }
        });

        filterObject = {
            groupOp: "AND",
            rules: filters,
        };
        firstPage = false;
        getAll(1, $("#rowList").val(), filterObject, dateFilter);
        setTimeout(function () {
            totalInfoPage(totalPages);
            viewPageEdit(currentPage, $("#editAll tbody tr").length);
        }, 500);
    });

    $("#searchText").on("keyup", function () {
        var filters = [];
        var l = $(".filter-input").length;

        for (i = 0; i < l; i++) {
            var data = $(this).val();
            field = $(".filter-input").eq(i).data("field");

            if (data !== "") {
                filters.push({
                    field: field,
                    op: "cn",
                    data: data,
                });
            }
        }

        filterObject = {
            groupOp: "OR",
            rules: filters,
        };

        getAll(1, $("#rowList").val(), filterObject, dateFilter);
        setTimeout(function () {
            totalInfoPage(totalPages);
            viewPageEdit(currentPage, $("#editAll tbody tr").length);
        }, 500);
    });

    var filters = {};
    $(".clearsearchclass").on("click", function () {
        var column = $(this).data("column");

        if (!filters[column]) {
            filters[column] = $('.filter-input[data-field="' + column + '"]');
        }

        if (filters[column]) {
            filters[column].val("");
        }

        filterObject = {
            groupOp: "AND",
            rules: [],
        };

        $(".filter-input").each(function () {
            var field = $(this).data("field");
            var data = $(this).val();

            if (data !== "") {
                filterObject.rules.push({
                    field: field,
                    op: "cn",
                    data: data,
                });
            }
        });

        getAll(1, $("#rowList").val(), filterObject, dateFilter);

        setTimeout(function () {
            totalInfoPage(totalPages);
            viewPageEdit(currentPage, $("#editAll tbody tr").length);
        }, 500);
    });
}

function bindKeyPagerEditAll(date) {
    $("#previousPageButton").click(function (e) {
        if (currentPage > 1) {
            getAll(parseInt(currentPage) - 1, rowCount, filterObject, date);
            $("#pagerInput").val(parseInt(currentPage) - 1);
        }
        
        if (tglPengiriman) {
            setTimeout(function () {
                viewPageEdit(10, lengthValue);
            }, 500);
        }else{
            viewPageEdit();
        }
    });
    // Handle next page button click
    $("#nextPageButton").click(function (e) {
        if (currentPage < totalPages) {
            // console.log(lengthValue);

            getAll(parseInt(currentPage) + 1, rowCount, filterObject, date);

            $("#pagerInput").val(parseInt(currentPage) + 1);
            // viewPageEdit(selectedValue, rowCount,lengthValue);
        }

        if (tglPengiriman) {
            setTimeout(function () {
                viewPageEdit(10, lengthValue);
            }, 500);
        }else{
            viewPageEdit();
        }

       
    });

    $("#lastPageButton").click(function (e) {
        getAll(lastPageEditAll);
        console.log(lengthValue);
        $("#pagerInput").val(lastPageEditAll);
        viewPageEdit();
    });

    $("#firstPageButton").click(function (e) {
        getAll(1, selectedValue);

        $("#pagerInput").val(1, selectedValue);
        viewPageEdit(selectedValue, rowCount);
    });

    $("#pagerInput").on("input", function () {
        let inputValue = $(this).val();

        if (inputValue === "" || inputValue == 0) {
            inputValue = 1; // Jika kosong, paksakan nilai menjadi 1
            $(this).val(inputValue);
        }
        getAll(inputValue);

        viewPageEdit();
    });

    $("#rowList").on("change", function () {
        selectedValue = $(this).val();

        getAll($("#pagerInput").val(), selectedValue);

        setTimeout(function () {
            rowCount = $("#editAll tbody tr").length;

            totalInfoPage(totalPages);
            viewPageEdit(selectedValue, rowCount);
        }, 500);
    });
}

function viewPageEdit(perPage = 10, rowCountEdit = 10) {
    let pageEditAll = $("#pagerInput").val();
    let perPageEditAll = perPage;
    let recordCountEditAll = rowCountEdit;
    let firstRowEditAll = (pageEditAll - 1) * perPageEditAll + 1;
    let lastRowEditAll = firstRowEditAll + recordCountEditAll - 1;
    console.log(firstRowEditAll, recordCountEditAll);
    $("#InfoHandlerEditAll").html(`
        <div class="text-md-right">
            View  ${firstRowEditAll} - ${lastRowEditAll} of ${totalRowsEditAll}
        </div>
    `);
}

function totalInfoPage() {
    $("#totalPage").remove();
    $("#infoPage").append(`
    <span id="totalPage">of ${totalPages}</span>
`);
}

// // penjualan
// function elementPagerPenjualan() {
//     let elPager = $(`
//     <div class="row d-flex align-items-center justify-content-center justify-content-lg-end pr-3">
//         <div id="PagerHandler"
//             class="pager-handler d-flex align-items-center justify-content-center mx-2">
//             <button type="button" id="firstPageButtonPenjualan"
//                 class="btn btn-sm hover-primary mr-2 d-flex">
//                 <span class="fas fa-step-backward"></span>
//             </button>

//             <button type="button" id="previousPageButtonPenjualan"
//                 class="btn btn-sm hover-primary d-flex">
//                 <span class="fas fa-backward"></span>
//             </button>

//             <div class="d-flex align-items-center my-1  justify-content-between gap-10" id="infoPagePenjualan">
//                 <span>Page</span>
//                 <input id="pagerInputPenjualan" class="pager-input" value="1" autocomplete="off">

//             </div>

//             <button type="button" id="nextPageButtonPenjualan"
//                 class="btn btn-sm hover-primary d-flex">
//                 <span class="fas fa-forward"></span>
//             </button>

//             <button type="button" id="lastPageButtonPenjualan"
//                 class="btn btn-sm hover-primary ml-2 d-flex">
//                 <span class="fas fa-step-forward"></span>
//             </button>

//             <select id="rowList" class="ml-2">
//                 <option value="10">10</option>
//                 <option value="20">20</option>
//                 <option value="50">50</option>
//                 <option value="0">ALL</option>
//             </select>
//         </div>
//         <div id="InfoHandlerEditAllPenjualan" class="pager-info">

//         </div>
//     </div>

//     `);

//     $(".editAllPager").append(elPager);
// }

// function viewPageEditPenjualan(perPage = 10, rowCountEdit = 10) {
//     let pageEditAll = $("#pagerInputInfoHandlerEditAllPenjualan").val();
//     let perPageEditAll = perPage;
//     let recordCountEditAll = rowCountEdit;
//     let firstRowEditAll = (pageEditAll - 1) * perPageEditAll + 1;
//     let lastRowEditAll = firstRowEditAll + recordCountEditAll - 1;

//     $("#InfoHandlerEditAllPenjualan").html(`
//         <div class="text-md-right">
//             View  ${firstRowEditAll} - ${lastRowEditAll} of ${totalRowsEditAll}
//         </div>
//     `);
// }

// function totalInfoPagePenjualan() {
//     $("#totalPagePenjualan").remove();
//     $("#infoPagePenjualan").append(`
//     <span id="totalPagePenjualan">of ${totalPages}</span>
// `);
// }

// function bindKeyPagerEditAllPenjualan() {
//     $("#previousPageButtonPenjualan").click(function (e) {
//         if (currentPage > 1) {
//             getAll(parseInt(currentPage) - 1, rowCount);
//             $("#pagerInputPenjualan").val(parseInt(currentPage) - 1);
//         }
//         viewPageEdit(selectedValue, rowCount);
//     });
//     // Handle next page button click
//     $("#nextPageButtonPenjualan").click(function (e) {

//         if (currentPage < totalPages) {
//             getAll(parseInt(currentPage) + 1, rowCount);
//             $("#pagerInputPenjualan").val(parseInt(currentPage) + 1);
//         }

//         viewPageEdit(selectedValue, rowCount);

//     });

//     $("#lastPageButtonPenjualan").click(function (e) {
//         getAll(lastPageEditAll);
//         $("#pagerInputPenjualan").val(lastPageEditAll);
//         viewPageEdit();
//     });

//     $("#firstPageButtonPenjualan").click(function (e) {
//         getAll(1, selectedValue);

//         $("#pagerInputPenjualan").val(1, selectedValue);
//         viewPageEdit(selectedValue, rowCount);
//     });

//     $("#pagerInputPenjualan").on("input", function () {
//         let inputValue = $(this).val();

//         if (inputValue === "" || inputValue == 0) {
//             inputValue = 1; // Jika kosong, paksakan nilai menjadi 1
//             $(this).val(inputValue);
//         }
//         getAll(inputValue);

//         viewPageEdit();
//     });

//     $("#rowList").on("change", function () {
//         selectedValue = $(this).val();

//         getAll($("#pagerInputPenjualan").val(), selectedValue);

//         setTimeout(function () {
//             rowCount = $("#editAll tbody tr").length;

//             totalInfoPage(totalPages);
//             viewPageEdit(selectedValue, rowCount);
//         }, 500);
//     });
// }
