var to_ns = {};
to_ns.num_rows = null; // set by page
to_ns.deleted_rows = [];


to_ns.display_string = function(placeholder, row)
{
  $("string_" + row).value = $("string__" + placeholder).innerHTML;  
}


/**
 * Deletes a row.
 */
to_ns.delete_row = function(row)
{
  Effect.Fade($("row_" + row), { duration: 0.8 });
  Effect.BlindUp($("row_" + row), { duration: 0.8 });

  to_ns.deleted_rows.push(row);
  $("deleted_rows").value = to_ns.deleted_rows.join(",");
}


/**
 * Adds a new blank row.
 */
to_ns.add_row = function()
{
  var curr_row = ++to_ns.num_rows;

  // get the template row
  var row_html = $("row_template").innerHTML;
  row_html = row_html.replace(/%%ROW%%/g, curr_row);

  // wrap the new line in a DIV, to allow easy removal if needed
  var wrapper_div = document.createElement("div");
  wrapper_div.setAttribute("id", "row_" + curr_row);
  wrapper_div.innerHTML = row_html;
  
  // now append the new row to the main rows element
  $("rows").insert(wrapper_div);
  
  // store the total number of rows
  $("num_rows").value = curr_row;
}
