<table width="100%" class="fourCols-grey">
    <tr>
        <td class="fourCols-three greybgDark"><?php echo $img;?></td>
        <td class="fourCols-four greybgDark smalltext"><?php echo $post->user;?></td>
        <td class="fourCols-four greybgDark smalltext" style="text-align: right;"><?php echo $post->datetime;?></td>
    </tr>
 </table>
<?php echo($post->text);?>