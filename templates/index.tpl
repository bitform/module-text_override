{include file='modules_header.tpl'}

  <table cellpadding="0" cellspacing="0">
  <tr>
    <td width="45"><a href="index.php"><img src="images/icon_text_override.gif" border="0" width="34" height="34" /></a></td>
    <td class="title">
      <a href="../../admin/modules">{$LANG.word_modules}</a>
      <span class="joiner">&raquo;</span>
      {$L.module_name}
    </td>
  </tr>
  </table>

  {include file='messages.tpl'}

  <div>
    {$L.text_module_summary}
  </div>

  <form method="post" action="{$same_page}">
    <input type="hidden" name="num_rows" id="num_rows" value="{$overridden_strings|@count}" />
    <input type="hidden" name="deleted_rows" id="deleted_rows" value="" />

    <div id="rows">

      {foreach from=$overridden_strings item=info name=row}
        {assign var='index' value=$smarty.foreach.row.index}
        {assign var='count' value=$smarty.foreach.row.iteration}

        <div id="row_{$count}">
          <table cellspacing="1" cellpadding="0" class="list_table margin_top_large">
          <tr>
            <td width="140" class="pad_left_small">{$L.word_placeholder}</td>
            <td>
              {assign var="original_string" value=""}
              <select name="placeholder_{$count}" onchange="to_ns.display_string(this.value, {$count})">
                <option value="">{$LANG.phrase_please_select}</option>
                {foreach from=$LANG key=k item=v}
                  <option value="{$k}"
                    {if $k == $info.lang_placeholder}
                      selected
                    {/if}>{$k}</option>
                {/foreach}
              </select>
            </td>
            <th rowspan="3" width="60" class="del"><a href="#" onclick="to_ns.delete_row({$count})">{$LANG.word_delete|upper}</a></th>
          </tr>
          <tr>
            <td class="pad_left_small">{$LANG.word_string}</td>
            <td><input type="text" name="string_{$count}" class="string_value" id="string_{$count}" value="{$info.original_string|escape}" readonly style="width:99%" /></td>
          </tr>
          <tr>
            <td class="pad_left_small">{$L.phrase_overridden_string}</td>
            <td><input type="text" name="overridden_string_{$count}" id="overridden_string_{$count}" value="{$info.overridden_string|escape}" style="width:99%" /></td>
          </tr>
          </table>
        </div>

      {/foreach}

    </div>

    <p>
      <input type="button" value="Add Row &raquo;" onclick="to_ns.add_row()" />
    </p>

    <p>
      <input type="submit" name="update" value="Update" />
    </p>

  </form>

  <script>
  {if $overridden_strings|@count == 0}
    to_ns.num_rows = 0;
    {literal}$(function() { to_ns.add_row(); });{/literal}
  {else}
    to_ns.num_rows = {$overridden_strings|@count};
  {/if}
  </script>

  <div style="display:none">

    <div id="row_template">
      <table cellspacing="1" cellpadding="0" class="list_table margin_top_large">
      <tr>
        <td width="140" class="pad_left_small">{$L.word_placeholder}</td>
        <td>
          <select name="placeholder_%%ROW%%" onchange="to_ns.display_string(this.value, %%ROW%%)">
            <option value="">{$LANG.phrase_please_select}</option>
            {foreach from=$LANG key=k item=v}
              <option value="{$k}">{$k}</option>
            {/foreach}
          </select>
        </td>
        <th rowspan="3" width="60" class="del"><a href="#" onclick="to_ns.delete_row(%%ROW%%)">{$LANG.word_delete|upper}</a></th>
      </tr>
      <tr>
        <td class="pad_left_small">{$LANG.word_string}</td>
        <td><input type="text" name="string_%%ROW%%" class="string_value" id="string_%%ROW%%" style="width:99%" readonly /></td>
      </tr>
      <tr>
        <td class="pad_left_small">{$L.phrase_overridden_string}</td>
        <td><input type="text" name="overridden_string_%%ROW%%" id="overridden_string_%%ROW%%" style="width:99%" /></td>
      </tr>
      </table>
    </div>

    {foreach from=$LANG key=k item=v}
      <div id="string__{$k}">{$v}</div>
    {/foreach}
  </div>

{include file='modules_footer.tpl'}
