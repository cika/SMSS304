<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ฟอร์มสร้างแบบทดสอบ</title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>

<body>
            <form action="#" method="post" enctype="multipart/form-data" name="form1" id="form1">
              <table width="700" border="0" align="center">
                <tr>
                  <td colspan="2" align="center" bgcolor="#FFCCCC">ฟอร์มสร้างแบบทดสอบ</td>
                </tr>
                <tr>
                  <td width="135" align="right">หลักสูตร ::</td>
                  <td width="355"><select name="curriculum" id="curriculum">
                  <option value="" selected="selected">---เลือก---</option>
                  </select></td>
                </tr>
                <tr>
                  <td align="right">กลุ่มสาระการเรียนรู้ ::</td>
                  <td><select name="matter" id="matter">
                  <option value="">---เลือก---</option>
                  </select></td>
                </tr>
                <tr>
                  <td align="right">รายวิชา ::</td>
                  <td align="left"><select name="subject" id="subject">
                  <option value="">---เลือก---</option>
                  </select></td>
                </tr>
                <tr>
                  <td align="right">มาตรฐานรายวิชา ::</td>
                  <td align="left"><select name="standart" id="standart">
                  <option value="">---เลือก---</option>
                  </select></td>
                </tr>
                <tr>
                  <td align="right">ระดับชั้น ::</td>
                  <td align="left"><select name="level" id="level">
                  <option value="">---เลือก---</option>
                  </select></td>
                </tr>
                <tr>
                  <td align="right">ตัวชี้วัด/จุดประสงค์ ::</td>
                  <td align="left"><select name="aim" id="aim">
                  <option value="">---เลือก---</option>
                  </select></td>
                </tr>
                <tr>
                  <td align="right">คำถาม ::</td>
                  <td align="left"><textarea cols="20" id="question" name="question" rows="10" >คำถาม</textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'question',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#CC3366',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
          //  '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <td align="right">ตัวเลือกที่ 1 ::</td>
                  <td align="left"><textarea cols="20" id="choice1" name="choice1" rows="10" >ตัวเลือกที่ 1</textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'choice1',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
			//  ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
       //     '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <td align="right">ตัวเลือกที่ 2 ::</td>
                  <td align="left"><textarea cols="20" id="choice2" name="choice2" rows="10" >ตัวเลือกที่ 2</textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'choice2',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
      //      '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <td align="right">ตัวเลือกที่ 3 ::</td>
                  <td align="left"><textarea cols="20" id="choice3" name="choice3" rows="10" >ตัวเลือกที่ 3</textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'choice3',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
        //    '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <td align="right">ตัวเลือกที่ 4 ::</td>
                  <td align="left"><textarea cols="20" id="choice4" name="choice4" rows="10" >ตัวเลือกที่ 4</textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'choice4',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
        //    '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <td align="right">ตัวเลือกที่ 5 ::</td>
                  <td align="left"><textarea cols="20" id="choice5" name="choice5" rows="10" >ตัวเลือกที่ 5</textarea>
    <script type="text/javascript">
  //<![CDATA[
            CKEDITOR.replace( 'choice5',{
			height   : 100,
			width    : 500,
			
			uiColor        : '#006699',
			
			    toolbar :
        [
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
       //     '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],

        ],
           
            } );
        //]]>    </script></td>
                </tr>
                <tr>
                  <td align="right">คำตอบที่ถูกต้อง ::</td>
                  <td align="left"><select name="answer" id="answer">
                  <option value="">---เลือกคำตอบ---</option>
                  <option value="1">ตัวเลือกที่ 1</option>
                  <option value="2">ตัวเลือกที่ 2</option>
                  <option value="3">ตัวเลือกที่ 3</option>
                  <option value="4">ตัวเลือกที่ 4</option>
                  <option value="5">ตัวเลือกที่ 5</option>
                  </select></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><input type="submit" name="submitTest" id="submitTest" value="บันทึก" />
                  <input type="reset" name="submitTest2" id="submitTest2" value="ยกเลิก" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
              </table>
              
</form>
</body>
</html>