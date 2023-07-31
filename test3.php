<?php
/**
 * Script_name: test3.php
 * Code: http://www.thainame.net/quiz/test3.php
 * Version: 3.0.1
 * Date: 2566-07-31
 * Developer: @thaiall
 *
 * Objectives:
 * 1. เพื่อเป็นแบบทดสอบออนไลน์สำหรับผู้ทดสอบด้วยตนเอง (Online Testing) ที่บริการข้อสอบออนไลน์ แบบปรนัย 4 - 7 ตัวเลือก
 * มีฟังก์ชันการแสดงคำถามและตัวเลือกเป็นภาพขนาด 640px * 480px แบบ Lightbox
 * 2. เพื่อสนับสนุนให้คุณครูได้เปิดคำถามเป็นภาพ แล้วฉายขึ้น Projector และทำกิจกรรมในชั้นเรียน
 * โดยแยกตามสาระการเรียนรู้ที่น่าสนใจ เช่น ความรู้พื้นฐานด้านภาษาอังกฤษ คณิตศาสตร์ ภาษาไทย คอมพิวเตอร์
 *
 * Description:
 * แบบทดสอบออนไลน์สำหรับผู้ทดสอบด้วยตนเอง (Online Testing) คือ บริการข้อสอบออนไลน์ แบบปรนัย 4 - 6 ตัวเลือก 
 * มีฟังก์ชันการแสดงคำถามและตัวเลือกเป็นภาพขนาด 640px * 480px แบบ Lightbox เพื่อสนับสนุนให้คุณครูวางแผนใช้เป็นนวัตกรรมการจัดการเรียนการสอน
 * โดยเปิดคำถามเป็นภาพบนเครื่องบริการของตน แล้วฉายขึ้น Projector และทำกิจกรรมในชั้นเรียน ซึ่งสามารถแยกตามสาระการเรียนรู้ที่น่าสนใจ 
 * เช่น ความรู้พื้นฐานด้านภาษาอังกฤษ คณิตศาสตร์ ภาษาไทย คอมพิวเตอร์ 
 *
 * Updated:
 * - 660731: เพิ่ม answer=false และแยก CSS variables
 * เพื่อเพิ่มฟังก์ชันการไม่แสดงคำตอบในหน้า view โดยปรับเงื่อนไขควบคุมตัวแปร $checkradio
 * ปรับสีตัวอักษร ลดความเข้มในโหมด View
 * และปรับการประกาศตัวแปร จะใช้ ' แทน "
 * - 660726: เริ่มใช้ฟังก์ชันกลุ่ม pat_xxx ใน Pattern Function เป็นฟังก์ชันสุดท้ายของโค้ด
 * เพื่อแยกข้อมูลออกจากโค้ด ทำให้ปรับแก้โค้ดได้ง่ายขึ้น
 * และแก้ปัญหาเกี่ยวกับโค้ดที่พบใน error_log และปรับการทำงานใน main process เพื่อเรียกใช้ functions
 * - 660719: เพิ่ม view=true ให้ทำงานคู่กับ subj=[xxx]
 * เพื่อแสดงเฉพาะส่วนของแบบทดสอบออนไลน์ พร้อมเฉลย
 * โดยตัดส่วนของ คำแนะนำ, ads, footer_tracker และ footer
 * แล้วใช้ Gofullpage extension บน Chrome สำหรับจับหน้าจอไปเป็นภาพ เพื่อนำไปใช้ทำคลิปต่อ
 * - 660622: เปลี่ยนจาก table เป็น div ยกเว้นส่วนที่เป็นตารางคะแนน
 * ปรับตามคำแนะนำของ Pagespeed
 * ถ้ามีเนื้อหาใน ads และ tracker ส่วน Mobile: Performance ได้ 80 และ Desktop: Performance ได้ 89 
 * ถ้าไม่มีเนื้อหาใน ads และ tracker ส่วน Mobile: Performance ได้ 100 และ Desktop: Performance ได้ 100
 * เพิ่ม Tag: Label ให้กับ Tag: Input
 * แก้ไขสีอักษรจาก red เป็น blue ตามเกณฑ์ Contrast ใน Pagespeed
 * - 660615: ปรับเพิ่มหมายเหตุ เพื่ออธิายการใช้คำสั่งใน Initial Process Section
 * ปรับค่าของตัวแปรใน Template Variables ใ้ห้เหลือบรรทัดเดียวทั้งหมด
 * เพิ่มปุ่มกลับไปทำข้อสอบใหม่ กรณีกรอกข้อมูลไม่ครบตามเงื่อนไข
 * เปลี่ยนจาก exit; เป็น function exit();
 * - 660612: เริ่มนำ code ขึ้น github.com โดย clear ค่าในตัวแปร $header_ads, $footer_ads, และ $footer_tracker
 * มีที่อยู่โค้ดคือ https://github.com/thaiall/code/blob/main/test3.php
 * - 660506: ข้อสอบชุดนี้ (Test3 บน Thainame.net) ถูกปรับปรุงให้เป็นระบบข้อสอบชุดแรกของผู้พัฒนา
 * ที่เปิดการแสดงเฉลย ผ่าน Mouse over บน glyphicon glyphicon-eye-open
 * ซึ่งพัฒนาต่อจากการแสดงคำถามเป็น image ผ่าน Lightbox เมื่อ Mouse click บน glyphicon glyphicon-th (table header)
 * เพื่อให้คุณครูเลือกใช้เป็นอีกเครื่องมือหนึ่งในชั้นเรียน เพื่อนำไปแชร์ผ่านสื่อสังคม
 * ที่เป็นการเปิดให้มีการแลกเปลี่ยนเรียนรู้ (Learning Exchange) แทน การวัดผลสัมฤทธิ์จากการเรียนรู้ด้วยข้อสอบแบบตัวเลือก (Choice)
 * - เริ่มพัฒนา : 2549-01-21 เพื่อใช้งานบน thainame.net
 *
 * Specification:
 * - สุ่มทั้ง คำถาม และตัวเลือก
 * - จำนวนข้อสอบในแต่ละชุดอ่านมาจากแฟ้มข้อสอบทั้งหมด
 * - ตัวเลือกมีสูงสุดได้ 7 ตัวเลือก ตามที่กำหนดในตัวแปร $choice_shuffling[ ]
 * - แสดงเฉลยเป็น Tooltips และแสดงคำถามเป็นภาพผ่าน Lightbox
 * - เก็บคะแนนของผู้ทำข้อสอบจำนวน 100 คนล่าสุดเท่านั้น
 *
 * Testing:
 * - กรณีที่คุณครูนำ Script ไปใช้บนเครื่องบริการ เช่น XAMPP สามารถใช้ได้ทันทีโดยไม่ต้องแก้ไข
 * เช่น ผมนำ Script ไปทดสอบที่ https://thaiall.com/quiz/test3.php แล้วใช้งานได้ทันที
 * โดยมีเพียง 2 แฟ้ม คือ แฟ้มแรก test3.php ที่ไม่ได้แก้ไข code แต่สามารถใช้แสดงตัวเลือก และบันทึกคะแนนได้
 * แฟ้มที่ 2 คือ แฟ้มข้อสอบ test3computer1.php ที่เป็น UTF-8
 * มีตัวอย่างแฟ้มข้อสอบที่เปิดให้ view ได้ เพื่อนำไปใช้คู่กับ script ที่ http://www.thainame.net/quiz/test3computer1.txt
 *
 * Quiz_Preparation:
 * - การเตรียมแฟ้มข้อสอบนั้นมี 9 ขั้นตอนดังนี้
 * 1. นำแฟ้มข้อสอบตัวอย่าง ไปเปิดบนโปรแกรม Excel ซึ่งง่ายที่สุดสำหรับการใช้เครื่องมือพื้นฐาน
 * แล้วเลือก Get External Data: From Text และเลือกประเภทแฟ้มเป็น All Files (*.*)
 * 2. ข้อสอบ ตัวเลือก และเฉลยแต่ละข้อจะอยู่รวมกันใน 1 บรรทัด ซึ่งแยกด้วย Delimited: Tab
 * แฟ้มข้อสอบโดยปกติมีการ Encoding แบบ UTF-8 ถ้าอ่านไม่ออกให้เปลี่ยนเป็นแบบ 874 : Thai (Windows)
 * 3. ผลการใช้ Delimited จะทำให้แต่ละคอลัม แยกออกจากกันชัดเจน
 * สามารถตรวจสอบผลการแบ่งคอลัมในส่วนของ Data preview ได้
 * 4. ผลการนำเข้าแฟ้มข้อสอบตัวอย่าง ลงในโปรแกรม Excel สำเร็จด้วยดี
 * ต่อจากนี้คือการป้อนข้อสอบชุดใหม่ ทั้งคำถาม เฉลย และตัวเลือกจนแล้วเสร็จ
 * 5. บันทึกแฟ้มข้อสอบด้วย Save as และเปลี่ยนชื่อแฟ้ม และ Extension เป็น .php
 * แล้วกดปุ่ม Save ซึ่งชื่อแฟ้ม และการเปลี่ยน Extension สามารถทำได้บน Explorer
 * 6. เปิดแฟ้มข้อสอบที่บันทึกแล้ว ด้วยการกด Right click บนชื่อแฟ้มใน Explorer
 * ในเบื้องต้นสามารถเปิดด้วย Notepad เพื่อสำรวจว่ามีข้อสอบชุดที่ได้ปรับปรุงแล้ว
 * 7. ถ้าแฟ้มข้อสอบมีรหัสตัดบรรทัด คือ 13 และ 10 ก็จะเห็นข้อสอบเรียงข้ออ่านง่าย
 * แต่ถ้าแฟ้มข้อสอบมีรหัสตัดบรรทัด คือ 10 ก็จะเห็นข้อมูลทั้งหมดอยู่ในบรรทัดเดียวบน notepad
 * ซึ่งโปรแกรม test3.php สามารถนำแฟ้มข้อสอบมาใช้ได้ทั้ง 2 กรณี
 * 8. ถ้าแฟ้มข้อสอบมีรูปแบบที่ถูกต้อง มีชื่อแฟ้ม และ extension ตามที่กำหนด
 * และเมื่อทดสอบบนเครื่องบริการร่วมกับ test3.php ก็จะปรากฎตัวเลือกมาให้ฝึกทำ
 * 9. เมื่อได้ทำข้อสอบแล้วเสร็จ ระบบจะเก็บผลสอบจำนวน 100 รายการล่าสุด
 * และสามารถเปลี่ยน URL จาก top=10 เป็น top=100 เพื่อขยายรายการแสดงผลได้
 * ระบบนี้ผู้สอบทุกคนสามารถเปิดรายงานได้ ดังนั้นการนำไปใช้ในระบบปิดจะปลอดภัยกว่า
 *
 * Program_Design:
 * - Initial Process Section
 * - Variables Section
 *   + Global Variables
 *   + Prepare Session and Request Variables
 *   + Array Variables
 *   + Template Variables
 *   + Pattern Functions
 * - Main Process Section
 * - Function Section
 *   + Action Report Function
 *   + Read Quiz File and Make Randomization Function
 *   + Action Check Function
 *   + Display Question and Choice Function
 *   + Footer Function

 * Updated:
 * - อ่านเพิ่มเรื่องฟังก์ชัน session_save_path() ได้ใน Short 12 ที่ http://www.thaiall.com/php/indexo.html
 * - ได้ปรับการใช้อาร์เรย์แบบ curly braces is deprecated $x{} ไปใช้ $x[] แทน
 * - เปลี่ยนจาก split() เป็น explode()
 *
  * Good_Code:
 * 1. อ่านง่าย แก้ง่าย
 * 2. ตั้งชื่อตามหลักการ
 * 3. มีหมายเหตุช่วยให้อ่านง่าย
 * 4. เขียนแล้วเขียนอีก
 * 5. เรียนรู้จากคนอื่น
 * 6. ใช้ภาษาเพื่อสื่อสาร
 * https://thaiall.com/source
*/

/* --- Initial Process Section --- */
/* เครื่องบริการที่ใช้อยู่กำหนด Time Zone เป็น UTC
เพื่อให้นำเวลามาใช้ได้ทันทีโดยไม่ต้อง +7 ชั่วโมงเข้าไป
คือ กำหนด Time Zone เป็น Asia/Bangkok ก็จะได้เวลาของประเทศไทย */
date_default_timezone_set('Asia/Bangkok');

/* เนื่องจากมีการเก็บชื่อ นามสกุล วิชา และเวลาเริ่มต้นของผู้ทำข้อสอบ
สำหรับนำไปใช้ในหน้าต่อไป หรือข้อสอบชุดต่อไปได้
การใช้ตัวแปร SESSION เป็นวิธีหนึ่งที่ได้รับความนิยม */
session_start();

/* --- Variables Section --- */
/* Global Variables */
$program_name = 'test3.php';
$data_name = 'computer1';
$score_name = 'test3score.txt';
$current_time = date('j M Y g:i:sa');
$user_limited = 100;   /* เก็บข้อมูลสมาชิกเพียง 100 ระเบียนเท่านั้น */
$this_domain = 'thainame.net';
$og_image = 'http://www.'. $this_domain . '/quiz/g1816.jpg';
$this_url =  'http://www.'. $this_domain . '/quiz/test3.php';
$redirect_tag = '<meta http-equiv="refresh" content="10;url='. $program_name . '?action=report&top=10">';

/* Quiz ID Variables */
$dn_desc['computer1'] = 'คอมพิวเตอร์เบื้องต้น ชุดที่ 1';
$dn_desc['burin_computer1'] = $dn_desc['computer1'];
$og_desc['computer1'] = 'แบบฝึกหัด คอมพิวเตอร์ ชุด 1 สำหรับนักเรียน เพื่อให้ได้ฝึกสืบค้นข้อมูลหาคำตอบด้วยตนเอง หรือชวนเพื่อน แข่งกันหาคำตอบ หรือคุณครูใช้เป็นโจทย์ชวนนักเรียนพูดคุย แลกเปลี่ยนเรียนรู้กันภายในชั้นเรียน';
$og_desc['burin_computer1'] = $og_desc['computer1'];
$og_img['computer1'] = 'burin_comp_001.jpg';
$og_img['burin_computer1'] = $og_img['computer1'];

$dn_desc['burin_computer2'] = 'คอมพิวเตอร์เบื้องต้น ชุดที่ 2';
$og_desc['burin_computer2'] = 'แบบฝึกหัด คอมพิวเตอร์ ชุด 2 สำหรับนักเรียน เพื่อให้ได้ฝึกสืบค้นข้อมูลหาคำตอบด้วยตนเอง หรือชวนเพื่อน แข่งกันหาคำตอบ หรือคุณครูใช้เป็นโจทย์ชวนนักเรียนพูดคุย แลกเปลี่ยนเรียนรู้กันภายในชั้นเรียน';
$og_img['burin_computer2'] = 'burin_comp_002.jpg';

$dn_desc['pepe_engl_001'] = 'ภาษาอังกฤษ (P) ชุดที่ 1';
$og_desc['pepe_engl_001'] = 'แบบฝึกหัด ภาษาอังกฤษ (P) ชุด 1 สำหรับนักเรียน เพื่อให้ได้ฝึกการใช้คำในประโยคเกี่ยวกับ verb, preposition, single noun, และ plural noun';
$og_img['pepe_engl_001'] = 'pepe_engl_001.jpg';
$dn_explain['pepe_engl_001'] = 'ข้อสอบชุดพี วิชาภาษาอังกฤษ ตอนที่ 1 เกี่ยวกับ คำศัพท์ คำถาม กริยา และบุพบท ได้แก่ การนับจำนวน, การใช้ s กับ es, do กับ does, of หลังกลัว, on วันที่ หรือ กำแพง, next to แปลว่าถัดไป, in เดือน และ he she it they their';

$dn_desc['maya_engl_001'] = 'ภาษาอังกฤษ (M) ชุดที่ 1';
$og_desc['maya_engl_001'] = 'แบบฝึกหัด ภาษาอังกฤษ (M) ชุด 1 สำหรับนักเรียน เพื่อให้ได้ฝึกการใช้คำในประโยคเกี่ยวกับ verb, question, และ vocabruary';
$og_img['maya_engl_001'] = 'maya_engl_001.jpg';
$dn_explain['maya_engl_001'] = 'ข้อสอบชุดเอ็ม วิชาภาษาอังกฤษ ตอนที่ 1 เกี่ยวกับ คำศัพท์ คำถาม กริยา และบุพบท (Preposition) ได้แก่ หน่วยของสบู่, of หลังกลัว, รู้ว่าใครขายอะไร, พหูพจน์และเอกพจน์, ในฟาร์มมีอะไร, ถามความบ่อย, ถามอาชีพ';

$dn_desc['fondao_engl_001'] = 'ภาษาอังกฤษ (F) ชุดที่ 1';
$og_desc['fondao_engl_001'] = 'แบบฝึกหัด ภาษาอังกฤษ (F) ชุด 1 สำหรับนักเรียน เพื่อให้ได้ฝึกการใช้คำในประโยคเกี่ยวกับ preposition';
$og_img['fondao_engl_001'] = 'fondao_engl_001.jpg';
$dn_explain['fondao_engl_001'] = 'ข้อสอบชุดเอฟ วิชาภาษาอังกฤษ ตอนที่ 1 เกี่ยวกับ บุพบท (Preposition) ได้แก่ การใช้ for ช่วงเวลาหนึ่ง หรือเป็นเวลานาน, during ช่วงเหตุการณ์, at สถานที่ หรือกี่นาฬิกา หรือมุมตึก,  on กับด้านไหน หรือวันที่ หรือวันพิเศษ, between ระหว่างสองสิ่ง, until เวลาที่กำหนด, in ส่วนไหนของเมือง หรือ ในเมืองไหน หรือในชุดสีอะไร, by พาหนะใด';

$dn_desc['thailand_001'] = 'ประเทศไทย (T) ชุดที่ 1';
$og_desc['thailand_001'] = 'แบบฝึกหัด ประเทศไทย (T) ชุด 1 สำหรับนักเรียน เพื่อให้รู้ข้อมูลพื้นฐานของประเทศไทย';
$og_img['thailand_001'] = 'thailand_001.jpg';
$dn_explain['thailand_001'] = 'ข้อสอบชุดที วิชาประเทศไทย ชุดที่ 1 เกี่ยวกับจังหวัด อำเภอ ทิศ ภูเขา ทะเลสาบ ที่เป็นที่สุดของไทย';

/* Prepare Session and Request Variables */
if (!isset($_SESSION['subj'])) $_SESSION['subj'] = '';
if (isset($_GET['subj'])) { $subj = 'subj='.$_GET['subj'];  $_SESSION['subj'] = $subj; } else { $subj = $_SESSION['subj']; }
if (isset($_SESSION['name'])) $name = $_SESSION['name']; else $name = '';
if (isset($_SESSION['surname'])) $surname = $_SESSION['surname']; else $surname = '';
if (isset($_POST['name'])) { $name = $_POST['name']; $_SESSION['name'] = $name; }
if (isset($_POST['surname'])) { $surname = $_POST['surname']; $_SESSION['surname'] = $surname; }
if (isset($_REQUEST['subj'])) $data_name  = $_REQUEST['subj'];
if (isset($_REQUEST['subject'])) $data_name = $_REQUEST['subject'];
if (isset($_REQUEST['subj']) || isset($_REQUEST['subject'])) { $this_url .= '?subj=' . $data_name; }
$data_namef = 'test3'. $data_name . '.php';

/* Facebook Open Graph Variables */
if (isset($og_desc[$data_name])) $desc = $og_desc[$data_name];
if (isset($og_img[$data_name])) $og_image = 'http://www.' . $this_domain . '/quiz/' . $og_img[$data_name];

/* CSS Variables */
$css['header'] = 'display:table;background-color:teal;color:white;font-size:24px;text-align:center;';
$css['bg_color_default'] = 'background-color:#ddffff;';
$css['bg_color_view'] = 'background-color:green;';
$css['bg_color_good'] = 'background-color:#ffdddd;';
$css['font_size_view'] = 'font-size:30px;color:#666688;font-weight:bold;text-shadow:1px 1px #888888;';
$css['font_size_default'] = 'font-size:24px;';
$css['radio'] = 'float:left;margin-right:3px;height:25px;width:25px;vertical-align:middle;';

/* Template Variables */
if(!isset($_SERVER['HTTP_HOST']) || substr($_SERVER['HTTP_HOST'],strlen($this_domain) * -1) != $this_domain || isset($_REQUEST['view'])) {
$header_ads = $footer_ads = $footer_tracker = ''; 
} else {
$header_ads = "<div class='m_still' style='display:table;background-color:#dddddd;'><script async src='//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'></script>
<ins class='adsbygoogle' style='display:block' data-ad-client='ca-pub-3309619467978767' data-ad-slot='8000711351' data-ad-format='auto'></ins>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script><!-- 06 quiz rsp --></div>";
$footer_ads = "<!-- ถูกใช้งาน แสดงเฉพาะใน report --></table><div class='m_still' style='display:table;'>
<script async src='//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'></script>
<ins class='adsbygoogle' style='display:block' data-ad-client='ca-pub-3309619467978767' data-ad-slot='8000711351' data-ad-format='auto'></ins>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script><!-- 06 quiz rsp --></div>";
$footer_tracker = "<div class='m_still' style='display:table;text-align:center;background-color:black'><script language=javascript>page='quiz_test3_". $data_name ."'</script>
<script language='javascript1.1' src='http://hits.truehits.in.th/data/h0013970.js'></script>" . '<!-- Histats.com  (div with counter) --><div id="histats_counter"></div>
<!-- Histats.com  START  (aync)--><script type="text/javascript">var _Hasync= _Hasync|| []; _Hasync.push([\'Histats.start\', \'1,4598807,4,9,110,60,00011111\']); 
_Hasync.push([\'Histats.fasi\', \'1\']); _Hasync.push([\'Histats.track_hits\', \'\']); (function() { var hs = document.createElement(\'script\'); hs.type = \'text/javascript\'; 
hs.async = true; hs.src = (\'//s10.histats.com/js15_as.js\'); (document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0]).appendChild(hs); })();
</script><noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?4598807&101" alt="" border="0"></a></noscript><!-- Histats.com  END  --></div>';
}
if (isset($dn_explain[$data_name]) && !isset($_REQUEST['view'])) { $explain = $dn_explain[$data_name]; $explain_html = '<br/><span style="font-weight:bold;">คำแนะนำ</span>: <span style="font-size:16px;">'. $explain .'</span>'; }else { $explain = ''; $explain_html = ''; }
if (isset($dn_desc[$data_name])) $data_desc = $dn_desc[$data_name]; else $data_desc ='';
$desc = 'แบบทดสอบออนไลน์สำหรับผู้ทดสอบด้วยตนเอง (Online Testing) - '. $data_name .' - '. $data_desc;
if(isset($_REQUEST['view'])) $backgroundcolor = "style='background-color:green;'"; else $backgroundcolor ='';
$header = "<!DOCTYPE html><html lang='th'><head><title>แบบทดสอบเตรียมสู่อุดมศึกษา ". $data_name ." - ". $data_desc . "</title><meta charset='utf-8' />
<meta name='viewport' content='width=device-width,initial-scale=1' /><meta property='fb:app_id' content='457891482255937' />
<meta name='keywords' content='". $data_name .",test,quiz,exam,examination' /><meta name='description' content='". $desc . " ". $explain ."' />
<meta property='og:image' content='". $og_image ."' /><link type='text/css' rel='stylesheet' href='rsp81.css' /><link rel='icon' type='image/x-icon' href='rsp.ico' />
<meta property='og:url' content='". $this_url ."' /><meta property='og:title' content='ข้อสอบ ". $data_name ." - ". $data_desc . "' />
<meta property='og:description' content='". $desc . " ". $explain ."' /><meta property='og:type' content='article' /></head><body id='main' $backgroundcolor>
<div class='m_still' style='".$css["header"]."'>
<img src='". $og_image ."' class='imgborder' style='float:right;' alt='cover image' /><span style='font-size:32px;font-weight:bold;'>แบบทดสอบเตรียมสู่อุดมศึกษา</span>
<br/><span style='font-weight:bold;color:yellow;font-size:30px;'>". $data_desc ."</span>". $explain_html ."</div>";
$header_report = "<table class='m_still'><tr style='background-color:black;text-align:center;'><td colspan='7' style='color:white;'>สถิติผู้ทำข้อสอบ</td></tr>
<tr style='background-color:#dddddd;text-align:center;'><td>ลำดับ</td><td>ชื่อ-สกุล</td><td>รหัสวิชา</td><td>จำนวนถูก</td><td>จำนวนข้อ</td><td>เวลาเริ่ม</td><td>เวลาเสร็จ</td></tr>";
$open_form ='<form action="test3.php" method="post"><table class="m_still"><tr><td>';
$footer = "<link rel='stylesheet' href='../bootstrap/bootstrap.min.css' /><script src='../bootstrap/jquery-3.5.1.min.js'></script>
<script src='../bootstrap/bootstrap.min.js'></script><link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css' type='text/css' media='screen' /><script src='//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox-plus-jquery.js'></script><script>jQuery.noConflict();</script>
<script>$(document).ready(function(){ $('[data-toggle=\"tooltip\"]').tooltip(); });</script><div class='m_still' style='display:table;'>
<div style='background-color:white;border:1px outset white;border-radius:10px;padding:5px;margin:5px;text-align:center;font-size:12px;'>
<a href='?action=report'>คลิกเปิดสถิติผู้ทำข้อสอบ 100 รายการล่าสุด</a><br/>แนะนำ: <a href='/quiz/'>รวม</a> / <a href='?'>คอมพิวเตอร์ฯ #1</a> / 
<a href='?subj=pepe_engl_001'>อังกฤษ #p1</a> / <a href='?subj=maya_engl_001'>อังกฤษ #m1</a> / <a href='?subj=fondao_engl_001'>อังกฤษ #f1</a>
<br/><a href='?". $subj ."'>คลิกเพื่อเริ่มต้นทำชุดนี้อีกครั้ง</a> / เวลา : $current_time<br/>Open source: 
<a href='https://github.com/thaiall/code/blob/main/test3.php'>github.com</a> / <a href='?".$subj."&view=true'>view answer</a> / <a href='?".$subj."&view=true&answer=false'>view no answer</a></div></div>".$footer_tracker."</body></html>";
$error_name = '<br/><span style="color:blue;font-size:20px;">กรอกชื่อ หรือนามสกุล ไม่ครบ<br/>แสดงว่าไม่อ่านคำชี้แจง ให้เริ่มต้นทำข้อสอบทั้งหมดใหม่</span><br/><br/>';
$error_subj = '<br/><span style="color:blue;font-size:20px;">ไม่พบแฟ้มวิชาที่ท่านต้องการสอบ<br/>ต้องกลับไปเลือกวิชาให้ถูกต้อง</span><br/><br/>';
$remark = "<tr><td colspan='2' style='color:darkblue;text-align:left;font-size:16px;'><span class='bigcap35' style='line-height: 0.2;'>โ</span>ปรดดำเนินการให้ครบทุกข้อ 
<span style='font-weight:bold;'>ก่อนคลิกปุ่มส่งคำตอบ</span> มีขั้นตอนดังนี้ <span style='font-weight:bold;'>1)</span> ทำข้อสอบให้ครบทุกข้อ 
<span style='font-weight:bold;'>2)</span> กรอกทั้งชื่อ-สกุลของผู้ทำข้อสอบ <span style='font-weight:bold;'>3)</span> คลิกปุ่มส่งคำตอบ แล้วผลสอบจะถูกบันทึกเพียง 100 รายการล่าสุด
โดยบันทึกชื่อ สกุล คะแนน เวลาเริ่มทำ และเวลาสิ้นสุดลงในฐานข้อมูล หากไม่ประสงค์ระบุชื่อ-สกุลจริง ให้ใส่ชื่อไอดอลที่ท่านชื่นชอบแทน เช่น Steve Jobs </td></tr>";
$remark_send = '<span style="color:blue;line-height:30px;">ขอย้ำว่าทำให้ครบทุกข้อ และกรอกชื่อ-สกุลของผู้ทำข้อสอบ<br/>จึงจะตรวจข้อสอบ แจ้งผล บันทึกในรายงานสถิติผู้เข้าสอบ 100 คน</span>';
$open_table = '<table style="background-color:#f9f9f9;width:100%">';
$close_row = '</div></td></tr>'."\n";

/* Pattern Functions */
function pat_footer_view(){
return '</table></table><div style="width:100%;text-align:center;"><a href="test3.php">#</a></div>';
}

function pat_open_row($bg_color,$font_size){
$output = "<tr style='$bg_color $font_size'><td><div style='background-color:#ffffdd;border:1px outset white;border-radius:20px;padding:5px;margin:20px;'>"; 
echo $output;
}

function pat_radio($q,$choice,$label,$checkradio){
global $css;
$output = "<table><td><input type='radio' name='$q[0]' $checkradio style='".$css['radio']."' value='". $choice ."' /></td><td><label>". $label."</label></td></table>";
echo $output;
}

function pat_score_result($right,$wrong,$total,$current_time,$program_name){
$output = "<div class='m_still' style='display:table;'>ผลการสอบ ของ<br/>". 
htmlspecialchars($_POST["name"], ENT_QUOTES) . " ". 
htmlspecialchars($_POST["surname"], ENT_QUOTES). "<br/><span style='font-weight:bold;'>ทำถูก</span> = ".$right.
"<br/><span style='font-weight:bold;'>ทำผิด</span> = ".$wrong.
"<br/><span style='font-weight:bold;'>ได้ทำ</span> = ".$total.
"<br/><span style='font-weight:bold;'>จำนวนข้อสอบ</span> = ".$total.
"<br/><span style='font-weight:bold;'>เริ่มทำเวลา</span> = ".$_SESSION['start'].
"<br/><span style='font-weight:bold;'>แล้วเสร็จเวลา</span> = ".$current_time.
"<br/><a href='$program_name?action=report&top=10'>เปิดรายงานผลการสอบ 100 อันดับล่าสุด</a></div>";
echo $output;
}
	  
function pat_name_form($remark,$name,$surname,$remark_send,$total_question,$data_name){
$output = "<tr><td style='background-color:#cccccc;text-align:center;'>
<table class='m_still' style='background-color:#dddddd;width:95%;margin-left:auto;margin-right:auto;padding-top:5px;'>
<tr><td colspan='2' style='background-color:black;color:white;font-size:24px;'>คำชี้แจง</td></tr>".$remark.
"<tr><td style='text-align:right;'>ชื่อ</td><td style='text-align:left;'><input name='name' size='20' value='$name' /> <label>เช่น Steve</label></td></tr>
<tr><td style='text-align:right;'>สกุล</td><td style='text-align:left;'><input name='surname' size='20' value='$surname' /> <label>เช่น Jobs</label></td></tr>
</table>".$remark_send.
"<br/><input type='submit' value='ส่งคำตอบ'
style='background-color:darkblue;color:white;font-size:20px;width:200px;height:40px;border:2px outset black;border-radius:20px;' /></td></tr></table>
<input type='hidden' value='check' name='action' />
<input type='hidden' value='".$total_question."' name='total' />
<input type='hidden' value='".$data_name."' name='subject' />
</td></tr></table></form>";
echo $output;
}

function pat_view_eye_open($image_id,$txt_question,$txt_answer){
$output = "<div style='width:100%;text-align:center;'>
<a style='margin:10px;' href='image.php?". $image_id ."' target='_blank' title='คำถาม : ". $txt_question ."' rel='lightbox[ข้อสอบออนไลน์]'>
<span class='glyphicon glyphicon-eye-open' style='font-size:30px;color:blue;'></span></a>
<a style='margin:10px;' data-toggle='tooltip' title='เฉลย : ". $txt_answer ."'>
<span class='glyphicon glyphicon-comment' style='font-size:30px;color:green;'></span></a></div>";
echo $output;
}

function pat_incomplete($right,$wrong,$total){
$output = "<div class='m_still' style='color:blue;font-size:20px;'>ท่านทำข้อสอบเพียง : " .($right + $wrong).
" ข้อ<br/>ไม่ครบ ".$total." ข้อ<br/>จึงไม่ตรวจให้ .. ท่านต้องกลับไปทำให้ครบ<br/><button onclick='history.back()'>กลับไปทำใหม่</button></span></div>";
echo $output;
}

function pat_row_report($bg_color,$i,$ar){
$output = "<tr style='font-size:10px !important;$bg_color'><td style='font-size:16px;text-align:center;'>$i</td><td style='font-size:16px;'>$ar[0] $ar[1]</td>
<td><a href=?subj=$ar[2]>$ar[2]</a></td><td align=center>$ar[3]</td><td align=center>$ar[4]</td><td>$ar[5]</td><td>$ar[6]</td></tr>";
echo $output;
}

/* --- Main Process Section --- */
/* Main Process for function calling */
if (isset($_GET['action']) && $_GET['action'] == 'report') {
  action_report($score_name); 
} else {
  read_quiz_file($data_namef); /* ถูกใช้ทั้งใน action_check และ display_all_questions */
  if (isset($_POST['action']) && $_POST['action'] == 'check' && isset($_SESSION['start'])) {
    action_check($score_name);
  } elseif (!isset($_POST['action'])) {
    display_all_questions($data_namef);
  }	
  footer($footer);
}

/* --- Function Section --- */
/* Action Report Function */
function action_report($score_name) {
global $css, $header,$header_ads,$header_report,$ar,$footer,$footer_ads;
echo $header . $header_ads . $header_report;
$ar = file($score_name);
$i=0;
$bg_color = '';
foreach ($ar as $k=>$v) {
  $i++;
  if (!isset($_GET['top']) || $i <= $_GET['top']) {
    $ar = explode("\t",$v);
    if (strlen($bg_color) == 0) $bg_color = $css['bg_color_default']; else $bg_color = '';
    if (isset($ar[3]) && isset($ar[4]) && $ar[3] == $ar[4]) $bg_color = $css["bg_color_good"];
    if (isset($ar[0]) && isset($ar[1]) && isset($ar[2]) && isset($ar[3]) && isset($ar[4]) && isset($ar[5]) && isset($ar[6])) pat_row_report($bg_color,$i,$ar);
  }
} /* foreach */
exit($footer_ads.$footer);
}

/* Read Quiz File and Make Randomization Function */
function read_quiz_file($data_namef) {
global $qok,$rnd,$cnt_quiz,$error_subj,$footer;
$cnt_quiz = 0;
if (!file_exists($data_namef)) exit("[ " . $data_namef . " ]".$error_subj.$footer);
$ar = file($data_namef);
foreach ($ar as $v) {
  $q = explode("\t",$v);
  if (isset($q[2]) && strlen($q[2]) > 0) { /* ตรวจว่ามีเฉลยหรือไม่ */
    $qok[$cnt_quiz] = str_replace(array("\r\n", "\n", "\r"),"",$v);
    $rnd[$cnt_quiz] = rand();
    $cnt_quiz = $cnt_quiz + 1;
  }
}
}

/* Action Check Function */
function action_check($score_name) {
global $header,$error_name,$footer,$qok,$cnt_quiz,$qans,$program_name,$user_limited,$current_time,$redirect_tag;
echo $header;
if (strlen($_POST['name']) == 0 || strlen($_POST['surname']) == 0 || strlen(iconv('UTF-8','TIS-620',$_POST['surname'])) > 30 || strlen(iconv('UTF-8','TIS-620',$_POST['name'])) > 30 ) {
  unset($_SESSION["start"]);
  echo strlen(iconv('UTF-8','TIS-620',$_POST['surname'])) .'-'. strlen(iconv('UTF-8','TIS-620',$_POST['name']));
  exit($error_name.$footer);
}
$right = $wrong = 0;
foreach ($qok as $k=>$v) {
  $q = explode("\t",$v);
  if(isset($q[2])) $qans[$q[0]] = $q[2];
}
$mycheck = '';
foreach ($_POST as $k=>$v) {
  if ($k != 'action' && $k != 'name' && $k != 'surname' && $k != 'total' && $k != 'subject') {
    if (strlen($v) > 0) {
      if ($qans[$k] == $v) $right++; else $wrong++;
        $mycheck .= "$k". $qans[$k] . "$v "; 
    }
  }
}
$total = $_POST['total'];
if ($total <= ($right + $wrong)) {
  $wrong = $total - $right;
  echo $redirect_tag;
  pat_score_result($right,$wrong,$total,$current_time,$program_name);      
  $data = htmlspecialchars($_POST['name'], ENT_QUOTES)."\t".htmlspecialchars($_POST['surname'], ENT_QUOTES)."\t".$_POST['subject']."\t";
  $data = $data . $right."\t".$total."\t".$_SESSION['start']."\t".$current_time."\n";
  $fr = array();
  if (file_exists($score_name)) $fr = file($score_name);
  $limit = count($fr);
  if ($user_limited <= $limit) $limit = $user_limited - 1;
  $fw=fopen ($score_name,'w');
  fputs ($fw,$data);
  for ($i=0;$i<$limit;$i++) fputs ($fw,$fr[$i]);
  fclose ($fw);
  unset($_SESSION['start']);
} else {		
  pat_incomplete($right,$wrong,$total);	  
}
}

/* Display Question and Choice Function */
function display_all_questions($data_namef){
global $css, $header, $header_ads, $open_form, $open_table, $close_row, $current_time, $rnd, $qok, $remark, $remark_send, $name, $surname, $data_name;
$choice_shuffling[1] = array(1,2,3,4,7,5,6);
$choice_shuffling[2] = array(5,7,2,3,4,1,6);
$choice_shuffling[3] = array(4,1,2,5,7,3,6);
$choice_shuffling[4] = array(2,3,5,4,1,6,7);
$choice_shuffling[5] = array(4,6,7,3,1,2,5);
$choice_shuffling[6] = array(7,6,5,2,4,1,3);
$choice_shuffling[7] = array(2,4,1,3,7,6,5);
echo $header . $header_ads . $open_form . $open_table;
$_SESSION['start'] = $current_time;
asort($rnd); /* ทำให้ array จัดเรียงตามค่าสุ่ม */
$total_question = 0;
$bg_color = '';
foreach ($rnd as $k=>$v) {
  $total_question++;
  $q = explode("\t",$qok[$k]);
  if (strlen($bg_color) == 0) $bg_color = $css['bg_color_default']; else $bg_color = '';
  if(isset($_REQUEST['view'])) { $bg_color = $css['bg_color_view']; $font_size = $css['font_size_view']; } else { $font_size =$css['font_size_default']; }
  pat_open_row($bg_color,$font_size);
  echo $total_question.'. '.$q[1].' ';
  $img = 'q=' . $q[1];
  $cok = rand(1,7);
  $choice = 1;
  for($i=3;$i<10;$i++) {
    if (isset($q[$choice_shuffling[$cok][$i - 3] + 2])) {
      if (strlen($q[$choice_shuffling[$cok][$i - 3] + 2]) > 0 && $q[$choice_shuffling[$cok][$i - 3] + 2] != "\r\n"  && $q[$choice_shuffling[$cok][$i - 3] + 2] != "\n") {
        if(intval($q[2]) == $choice_shuffling[$cok][$i - 3] && isset($_REQUEST['view']) && !isset($_REQUEST['answer'])) $checkradio = 'checked'; else $checkradio = '';
        pat_radio($q,$choice_shuffling[$cok][$i - 3],$q[$choice_shuffling[$cok][$i - 3] + 2],$checkradio);
      }
      $img .= '&c'. $choice++ .'='. $q[$choice_shuffling[$cok][$i - 3] + 2];
    }
  }
  if(!isset($_REQUEST['view'])) pat_view_eye_open($img,$q[1],$q[intval($q[2]) + 2]);
  echo $close_row;
}
if(!isset($_REQUEST['view'])) pat_name_form($remark,$name,$surname,$remark_send,$total_question,$data_name);
}

/* Footer Function */
function footer($footer){
  if(isset($_REQUEST['view']))
    $footer = pat_footer_view();
  exit($footer); /* หยุดแสดง google adsense $footer_ads */
}
?>