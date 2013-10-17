var to_ns = {};
to_ns.num_rows = null; // set by page
to_ns.deleted_rows = [];

$(function() {
  $("form").bind("submit", function() {
    $(".string_value").removeAttr("readonly");
  });
});


to_ns.display_string = function(placeholder, row) {
  $("#string_" + row).val($("#string__" + placeholder).html())
}


/**
 * Deletes a row.
 */
to_ns.delete_row = function(row) {
  $("#row_" + row).hide("blind");
  to_ns.deleted_rows.push(row);
  $("#deleted_rows").val(to_ns.deleted_rows.join(","));
}


/**
 * Adds a new blank row.
 */
to_ns.add_row = function() {
  var curr_row = ++to_ns.num_rows;

  // get the template row
  var row_html = $("#row_template").html();
  row_html = row_html.replace(/%%ROW%%/g, curr_row);

  // wrap the new line in a DIV, to allow easy removal if needed
  var wrapper_div = document.createElement("div");
  wrapper_div.setAttribute("id", "row_" + curr_row);
  wrapper_div.innerHTML = row_html;

  // now append the new row to the main rows element
  $("#rows").append(wrapper_div);

  // store the total number of rows
  $("#num_rows").val(curr_row);
}
