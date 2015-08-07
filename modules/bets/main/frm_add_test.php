<?php
if(isset($_GET['ans'])){
echo "<table>\n";
?>
<tr>
	<td valign=top><br>
		คำถาม : 
	</td>
	<td valign=top>
		<textarea name="question" rows="6" cols="60">คำถาม</textarea>
	</td>
    <td valign="top">
    	<br> น้ำหนักคะแนน <br>
        <input type="radio" name="score" id="score1" style="cursor:pointer" value="0.25">
        <label for="score1" style="cursor:pointer">0.25</label>
        <input type="radio" name="score" id="score2" style="cursor:pointer" value="0.50">
        <label for="score2" style="cursor:pointer">0.50</label>
        <input type="radio" name="score" id="score3" style="cursor:pointer" value="0.75">
        <label for="score3" style="cursor:pointer">0.75</label>
        <input type="radio" name="score" id="score4" style="cursor:pointer" value="1.00">
        <label for="score4" style="cursor:pointer">1.00</label>
        <br>
        <input type="radio" name="score" id="score5" style="cursor:pointer" value="99" onclick="document.getElementById('etcScore').focus();">
        <label for="score5" style="cursor:pointer">อื่น ๆ</label> <input type="text" name="etcScore" id="etcScore" size="4">
    </td>
</tr>
<?php
	for($i=1;$i<=$_GET['ans'];$i++)
	{
		?>
<tr>
	<td valign=top><br>
		<?php echo "ตัวเลือกที่ $i";?> : 
	</td>
	<td valign=top>
		<textarea name="choice[]" rows="6" cols="60"><?php echo "ตัวเลือกที่ $i";?></textarea>
	</td>
	<td valign=top><br>
		<input type="radio" name="ans_true"  value="<?php echo $i;?>"id="c<?php echo $i;?>" style="cursor:pointer"> <label for="c<?php echo $i;?>" style="cursor:pointer">เป็นคำตอบที่ถูกต้อง</label>
	</td>
</tr>
<?php
	}
echo "</table>\n";

}
?>