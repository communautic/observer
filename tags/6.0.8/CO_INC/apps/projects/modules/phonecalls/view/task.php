<div class="phonecallouter">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="25" style="padding-top: 4px;"><input name="task[]" type="checkbox" value="<?php echo $value->id;?>" class="cbx jNiceHidden" <?php echo $checked ;?> /></td>
      <td class="text11" style="padding-top: 0px;"><input type="text" name="task_text[]" class="bg" value="<?php echo $value->text;?>" /><input name="task_id[]" type="hidden" value="<?php echo $value->id;?>"></td>
    </tr>
  </table>
  <br>
</div>