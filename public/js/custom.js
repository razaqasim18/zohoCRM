/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(".numbers").keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g, "");
});

$("#customer_id")
    .select2()
    .on("select2:open", () => {
        $(".select2-results:not(:has(a))").append(
            '<a href="#" id="loadcustomermodal" style="padding: 6px;height: 20px;display: inline-table; width: 100%;"><i class="fas fa-plus-circle"></i> Create new customer</a>'
        );
    });

$("#sales_person_id")
    .select2()
    .on("select2:open", () => {
        $(".select2-results:not(:has(a))").append(
            '<a href="#" id="loadsalepersonmodal" style="padding: 6px;height: 20px;display: inline-table; width: 100%;"><i class="fas fa-plus-circle"></i> Create new sales person</a>'
        );
    });

$(".item_id")
    .select2()
    .on("select2:open", () => {
        $(".select2-results:not(:has(a))").append(
            '<a href="#" id="loaditemmodal" style="padding: 6px;height: 20px;display: inline-table; width: 100%;"><i class="fas fa-plus-circle"></i> Create new item</a>'
        );
    });

$(".tax")
    .select2()
    .on("select2:open", () => {
        $(".select2-results:not(:has(a))").append(
            '<a href="#" id="loadtaxmodal" style="padding: 6px;height: 20px;display: inline-table; width: 100%;"><i class="fas fa-plus-circle"></i> Create new tax</a>'
        );
    });

$(".createdtax")
    .select2()
    .on("select2:open", () => {
        $(".select2-results:not(:has(a))").append(
            '<a href="#" id="loadtaxmodal" style="padding: 6px;height: 20px;display: inline-table; width: 100%;"><i class="fas fa-plus-circle"></i> Create new tax</a>'
        );
    });

$(document).on("click", "a#loadcustomermodal", function () {
    $("#customer_id").select2("close");
    $("#customerModel").modal("show");
});

$(document).on("click", "a#loadsalepersonmodal", function () {
    $("#sales_person_id").select2("close");
    $("#salepersonModel").modal("show");
});

$(document).on("click", "a#loaditemmodal", function () {
    $(".item_id").select2("close");
    $("#itemModel").modal("show");
});

$(document).on("click", "a#loadtaxmodal", function () {
    $(".item_id").select2("close");
    $("#taxModel").modal("show");
});

$(document).on("change", "input#quote_date", function () {
    $("input#expiry_date").attr("min", $(this).val());
});

$(document).on("focusout", "input.quantity", function () {
    var result =
        Number($(this).val()) *
        Number($(this).closest("tr").find("input.rate").val());
    $(this).closest("tr").find("input.inputamount").val(result);
    let rowid = $(this).closest("tr").find("input.taxid").val();
    let taxvalue = $(this).closest("tr").find("input.taxvalue").val();

    if ($("#taxrow" + rowid).length) {
        $("#taxrow" + rowid)
            .closest("div")
            .find("input.calculatedtax")
            .val((result * (taxvalue / 100)).toFixed(2));
        $("#taxrow" + rowid)
            .closest("div")
            .find("h4")
            .html((result * (taxvalue / 100)).toFixed(2));
    }

    if ($("#tax" + rowid).length) {
        $("#tax" + rowid)
            .closest("div")
            .find("input.calculatedtax")
            .val((result * (taxvalue / 100)).toFixed(2));
        $("#tax" + rowid)
            .closest("div")
            .find("h4")
            .html((result * (taxvalue / 100)).toFixed(2));
    }
    calculateSubTotal();
    calculateTotal();
});

$(document).on("focusout", "input.rate", function () {
    var result =
        Number($(this).val()) *
        Number($(this).closest("tr").find("input.quantity").val());
    $(this).closest("tr").find("input.inputamount").val(result);

    let rowid = $(this).closest("tr").find("input.taxid").val();
    let taxvalue = $(this).closest("tr").find("input.taxvalue").val();
    if ($("#taxrow" + rowid).length) {
        $("#taxrow" + rowid)
            .closest("div")
            .find("input.calculatedtax")
            .val((result * (taxvalue / 100)).toFixed(2));
        $("#taxrow" + rowid)
            .closest("div")
            .find("h4")
            .html((result * (taxvalue / 100)).toFixed(2));
    }

    if ($("#tax" + rowid).length) {
        $("#tax" + rowid)
            .closest("div")
            .find("input.calculatedtax")
            .val((result * (taxvalue / 100)).toFixed(2));
        $("#tax" + rowid)
            .closest("div")
            .find("h4")
            .html((result * (taxvalue / 100)).toFixed(2));
    }

    calculateSubTotal();
    calculateTotal();
});

$(document).on("click", "button#addnewitem", function () {
    newItemCreate();
});

$(document).on("focusout", "input.addinput", function () {
    calculateTotal();
});

$(document).on("focusout", "input.ddiscount", function () {
    calculateDiscount();
});

$(document).on("change", "select#discountopt", function () {
    calculateDiscount();
});

$(document).on("change", "select#tax_id", function () {
    calculateTotal();
});

$(document).on("click", "button#removenewitem", function () {
    $(this).parent().parent().remove();
    let taxid = $(this).closest("tr").find("input.taxid").val();
    $("#taxrow" + taxid).remove();
    countRowTr();
    calculateSubTotal();
});

function calculateDiscount() {
    let value = Number($("input#ddiscount").val());
    let option = $("select#discountopt option:selected").val();
    let result = 0;
    if (option == "0" || option == 0) {
        result = value.toFixed(2);
    } else {
        let total = 0;
        $("input.addinput").each(function () {
            total = Number(total) + Number($(this).val());
        });
        result = (total * (value / 100)).toFixed(2);
        console.log(result);
    }
    $("#label_discount_amount").text(result);
    $("input#discount").val(result);
    calculateTotal();
}

function calculateSubTotal() {
    let total = 0;
    $("input.inputamount").each(function () {
        total = (Number(total) + Number($(this).val())).toFixed(2);
    });
    $("input#sub_total").val(total);
    $("#label_sub_total_amount").html(total);
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    $("input.addinput").each(function () {
        total = Number(total) + Number($(this).val());
    });

    let totaltax = 0;
    $("input.calculatedtax").each(function () {
        totaltax = Number(totaltax) + Number($(this).val());
    });

    let discount = $("input#discount").val();
    let result = (Number(total) + Number(totaltax) - Number(discount)).toFixed(
        2
    );
    $("input#total_amount").val(result);
    $("h5#label_total_amount").text(result);
}

function countRowTr() {
    var count = $("#div_body tr").length;
    if (count == 0) {
        newItemnodelete();
    }
}
