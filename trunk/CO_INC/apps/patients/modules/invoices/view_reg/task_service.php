<div style="border-bottom: 1px solid #ccc;">
	<table width="530" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="width: 100px; padding: 6px 0;">
            <span class="bold" style="margin-left: 7px;"><?php echo $value->number;?>. Inhalt</span><span class="text11"></span></td>
        <td class="text11" style="width: 280px; padding: 7px 0 4px 0;">
           <?php echo $value->menge;?>x  &nbsp; &nbsp; <?php echo $value->title;?>
           </td>
             <td class="text11" style="padding: 7px 0 4px 0;">
             à <?php echo CO_DEFAULT_CURRENCY . ' ' . $value->preis;?>
            </td>
            <td class="text11" style="width: 88px; text-align: right; border-left: 1px solid #ccc; padding: 7px 0 4px 0;">
            
            <?php  echo '<span>' . CO_DEFAULT_CURRENCY . ' ' . $value->taskcosts . ' &nbsp; &nbsp; </span>'; ?>
            
            </td>
      </tr>
    </table>
</div>