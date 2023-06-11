<?php
/**
 * Script_name: test3.php
 * Code: http://www.thainame.net/quiz/test3.php
 * Version: 2.0.2
 * Date: 2566-06-12
 * Developer: @thaiall
 *
 * Objectives:
 * 1. เพื่อเป็นแบบทดสอบออนไลน์สำหรับผู้ทดสอบด้วยตนเอง (Online Testing) ที่บริการข้อสอบออนไลน์ แบบปรนัย 4 - 7 ตัวเลือก
 * มีฟังก์ชันการแสดงคำถามและตัวเลือกเป็นภาพขนาด 640px * 480px แบบ Lightbox
 * 2. เพื่อสนับสนุนให้คุณครูได้เปิดคำถามเป็นภาพ แล้วฉายขึ้น Projector และทำกิจกรรมในชั้นเรียน
 * โดยแยกตามสาระการเรียนรู้ที่น่าสนใจ เช่น ความรู้พื้นฐานด้านภาษาอังกฤษ คณิตศาสตร์ ภาษาไทย คอมพิวเตอร์
 *
 * Description:
 * - 660612: เริ่มนำ code ขึ้น github.com โดย clear ค่าในตัวแปร $header_ads, $footer_ads, และ $footer_tracker
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
 * Program_Design:
 * - Initial Process Section
 * - Variables Section
 *   + Global Variables
 *   + Prepare Session and Request Variables
 *   + Array Variables
 *   + Template Variables
 * - Main Process Section
 * - Function Section
 *   + Action Report Function
 *   + Read Quiz File and Make Randomization Function
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
date_default_timezone_set("Asia/Bangkok");
session_start();

/* --- Variables Section --- */
/* Global Variables */
$version = "2.660612";
$program_name = "test3.php";
$data_name = "computer1";
$score_name = "test3score.txt";
$current_time = date("j M Y g:i:sa");
$user_limited = 100;   // เก็บข้อมูลสมาชิกเพียง 100 ระเบียนเท่านั้น
$this_server = "http://www.thainame.net";
$og_image = $this_server . "/quiz/g1816.jpg";
$this_url =  $this_server . "/quiz/test3.php";

/* Prepare Session and Request Variables */
if (!isset($_SESSION['subj'])) $_SESSION['subj'] = "";
if (isset($_GET["subj"])) { $subj = "subj=".$_GET["subj"]; 	$_SESSION['subj'] = $subj; } else { $subj = $_SESSION['subj']; }
if (isset($_SESSION['name'])) $name = $_SESSION['name']; else $name = "";
if (isset($_SESSION['surname'])) $surname = $_SESSION['surname']; else $surname = "";
if (isset($_POST["name"])) { $name = $_POST["name"]; $_SESSION['name'] = $name; }
if (isset($_POST["surname"])) { $surname = $_POST["surname"]; $_SESSION['surname'] = $surname; }
if (isset($_REQUEST["subj"])) $data_name  = $_REQUEST["subj"];
if (isset($_REQUEST["subject"])) $data_name = $_REQUEST["subject"];
if (isset($_REQUEST["subj"]) || isset($_REQUEST["subject"])) { $this_url .= "?subj=" . $data_name; }
$data_namef = "test3". $data_name . ".php";

/* Array Variables */
$dn_desc["computer1"] = "คอมพิวเตอร์เบื้องต้น ชุดที่ 1";
$dn_desc["burin_computer1"] = $dn_desc["computer1"];
$og_desc["computer1"] = "แบบฝึกหัด คอมพิวเตอร์ ชุด 1 สำหรับนักเรียน เพื่อให้ได้ฝึกสืบค้นข้อมูลหาคำตอบด้วยตนเอง หรือชวนเพื่อน แข่งกันหาคำตอบ หรือคุณครูใช้เป็นโจทย์ชวนนักเรียนพูดคุย แลกเปลี่ยนเรียนรู้กันภายในชั้นเรียน";
$og_desc["burin_computer1"] = $og_desc["computer1"];
$dn_desc["pepe_engl_001"] = "ภาษาอังกฤษ (P) ชุดที่ 1";
$og_desc["pepe_engl_001"] = "แบบฝึกหัด ภาษาอังกฤษ (P) ชุด 1 สำหรับนักเรียน เพื่อให้ได้ฝึกการใช้คำในประโยคเกี่ยวกับ verb, preposition, single noun, และ plural noun";
$og_img["pepe_engl_001"] = "pepe_engl_001.jpg";
$dn_explain["pepe_engl_001"] = "ข้อสอบชุดพี วิชาภาษาอังกฤษ ตอนที่ 1 เกี่ยวกับ คำศัพท์ คำถาม กริยา และบุพบท ได้แก่ การนับจำนวน, การใช้ s กับ es, do กับ does, of หลังกลัว, on วันที่ หรือ กำแพง, next to แปลว่าถัดไป, in เดือน และ he she it they their";
$dn_desc["maya_engl_001"] = "ภาษาอังกฤษ (M) ชุดที่ 1";
$og_desc["maya_engl_001"] = "แบบฝึกหัด ภาษาอังกฤษ (M) ชุด 1 สำหรับนักเรียน เพื่อให้ได้ฝึกการใช้คำในประโยคเกี่ยวกับ verb, question, และ vocabruary";
$og_img["maya_engl_001"] = "maya_engl_001.jpg";
$dn_explain["maya_engl_001"] = "ข้อสอบชุดเอ็ม วิชาภาษาอังกฤษ ตอนที่ 1 เกี่ยวกับ คำศัพท์ คำถาม กริยา และบุพบท (Preposition) ได้แก่ หน่วยของสบู่, of หลังกลัว, รู้ว่าใครขายอะไร, พหูพจน์และเอกพจน์, ในฟาร์มมีอะไร, ถามความบ่อย, ถามอาชีพ";
$dn_desc["fondao_engl_001"] = "ภาษาอังกฤษ (F) ชุดที่ 1";
$og_desc["fondao_engl_001"] = "แบบฝึกหัด ภาษาอังกฤษ (F) ชุด 1 สำหรับนักเรียน เพื่อให้ได้ฝึกการใช้คำในประโยคเกี่ยวกับ preposition";
$og_img["fondao_engl_001"] = "fondao_engl_001.jpg";
$dn_explain["fondao_engl_001"] = "ข้อสอบชุดเอฟ วิชาภาษาอังกฤษ ตอนที่ 1 เกี่ยวกับ บุพบท (Preposition) ได้แก่ การใช้ for ช่วงเวลาหนึ่ง หรือเป็นเวลานาน, during ช่วงเหตุการณ์, at สถานที่ หรือกี่นาฬิกา หรือมุมตึก,  on กับด้านไหน หรือวันที่ หรือวันพิเศษ, between ระหว่างสองสิ่ง, until เวลาที่กำหนด, in ส่วนไหนของเมือง หรือ ในเมืองไหน หรือในชุดสีอะไร, by พาหนะใด";
if (isset($og_desc[$data_name])) $desc = $og_desc[$data_name];
if (isset($og_img[$data_name])) $og_image = "http://www.thainame.net/quiz/" . $og_img[$data_name];
if (isset($dn_explain[$data_name])) { $explain = $dn_explain[$data_name]; $explain_html = "<br/><span style='font-weight:bold;'>คำแนะนำ</span>: <span style='font-size:16px;'>". $explain ."</span>"; }else { $explain = ""; $explain_html = ""; }
if (isset($dn_desc[$data_name])) $data_desc = $dn_desc[$data_name]; else $data_desc ="";
$desc = "แบบทดสอบออนไลน์สำหรับผู้ทดสอบด้วยตนเอง (Online Testing) - ". $data_name ." - ". $data_desc;

/* Template Variables */
$header_ads = "";
$footer_ads = "";
$footer_tracker = "";
$header = "<!DOCTYPE html><html lang='th'><head><title>แบบทดสอบเตรียมสู่อุดมศึกษา ". $data_name ." - ". $data_desc . "</title>
<meta charset='utf-8' /><meta name='viewport' content='width=device-width,initial-scale=1' /><meta property='fb:app_id' content='457891482255937' />
<meta name='keywords' content='". $data_name .",test,quiz,exam,examination' />
<meta name='description' content='". $desc . " ". $explain ."' />
<meta property='og:image' content='". $og_image ."' />
<link type='text/css' rel='stylesheet' href='rsp81.css' /><link rel='icon' type='image/x-icon' href='rsp.ico' />
<meta property='og:url' content='". $this_url ."' /><meta property='og:title' content='ข้อสอบ ". $data_name ." - ". $data_desc . "' /><meta property='og:description' content='". $desc . " ". $explain ."' /><meta property='og:type' content='article' />
</head><body id='main'><table class='m_still' style='background-color:black;color:white'><tr><td style='font-size:24px;text-align:left;'>
<img src='". $og_image ."' class='imgborder' style='float:right;' alt='cover image' />
<span style='font-weight:bold;'>แบบทดสอบเตรียมสู่อุดมศึกษา</span><br/><span style='color:yellow;font-size:16px;'>". $data_desc ."</span>". $explain_html ."</td></tr></table>";
$header_report = "<table class='m_still'>
<tr style='background-color:black;text-align:center;'><td colspan='7' style='color:white;'>สถิติผู้ทำข้อสอบ</td></tr>
<tr style='background-color:#dddddd;text-align:center;'><td>ลำดับ</td><td>ชื่อ-สกุล</td><td>รหัสวิชา</td><td>จำนวนถูก</td>
<td>จำนวนข้อ</td><td>เวลาเริ่ม</td><td>เวลาเสร็จ</td></tr>";
$footer = "<link rel='stylesheet' href='../bootstrap/bootstrap.min.css' />
<script src='../bootstrap/jquery-3.5.1.min.js'></script>
<script src='../bootstrap/bootstrap.min.js'></script>
<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css' type='text/css' media='screen' />
<script src='//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox-plus-jquery.js'></script>
<script>jQuery.noConflict();</script>
<script>$(document).ready(function(){ $('[data-toggle=\"tooltip\"]').tooltip(); });</script>
<table class='m_still'><tr><td><div style='background-color:#ddffdd;border:1px outset white;border-radius:10px;box-shadow:5px 5px 5px lightgrey;padding:5px;margin:5px;text-align:center;font-size:12px;'>
<a href='?action=report'>คลิกเปิดสถิติผู้ทำข้อสอบ 100 รายการล่าสุด</a>
<br/>แนะนำ:
<a href='/quiz/'>รวม</a> /
<a href='?'>คอมพิวเตอร์ฯ #1</a> /
<a href='?subj=pepe_engl_001'>อังกฤษ #p1</a> /
<a href='?subj=maya_engl_001'>อังกฤษ #m1</a> /
<a href='?subj=fondao_engl_001'>อังกฤษ #f1</a>
<br/><a href='?". $subj ."'>คลิกเพื่อเริ่มต้นทำชุดนี้อีกครั้ง</a> : โค้ดรุ่น $version : เวลา : $current_time
</div></td></tr></table>" . $footer_tracker;
$error_name = "<span style='color:red;font-size:20px;'>กรอกชื่อ หรือนามสกุล ไม่ครบ<br/>แสดงว่าไม่อ่านคำชี้แจง ให้เริ่มต้นทำข้อสอบทั้งหมดใหม่</span><br/><br/>";
$error_subj = "<span style='color:red;font-size:20px;'>ไม่พบแฟ้มวิชาที่ท่านต้องการสอบ<br/>ต้องกลับไปเลือกวิชาให้ถูกต้อง</span><br/><br/>";
$remark = "<tr><td colspan='2' style='color:darkblue;text-align:left;font-size:16px;'>
<span class='bigcap35' style='line-height: 0.2;'>โ</span>ปรดดำเนินการให้ครบทุกข้อ <span style='font-weight:bold;'>ก่อนคลิกปุ่มส่งคำตอบ</span> มีขั้นตอนดังนี้ 
<span style='font-weight:bold;'>1)</span> ทำข้อสอบให้ครบทุกข้อ
<span style='font-weight:bold;'>2)</span> กรอกทั้งชื่อ-สกุลของผู้ทำข้อสอบ
<span style='font-weight:bold;'>3)</span> คลิกปุ่มส่งคำตอบ แล้วผลสอบจะถูกบันทึกเพียง 100 รายการล่าสุด โดยบันทึกชื่อ สกุล คะแนน เวลาเริ่มทำ และเวลาสิ้นสุดลงในฐานข้อมูล
หากไม่ประสงค์ระบุชื่อ-สกุลจริง ให้ใส่ชื่อไอดอลที่ท่านชื่นชอบแทน เช่น Steve Jobs
</td></tr>";
$remark_send = "<span style='color:red;line-height:30px;'>ขอย้ำว่าทำให้ครบทุกข้อ และกรอกชื่อ-สกุลของผู้ทำข้อสอบ<br/>จึงจะตรวจข้อสอบ แจ้งผล บันทึกในรายงานสถิติผู้เข้าสอบ 100 คน</span>";

/* --- Main Process Section --- */
/* Main Process for function calling */
action_report($score_name);
read_quiz_file($data_namef);
action_check($score_name);
display_all_question($data_namef);
footer($footer);

/* --- Function Section --- */
/* Action Check Function */
function action_check($score_name) {
global $header,$error_name,$footer,$qok,$cnt_quiz,$qans,$program_name,$user_limited;
if (isset($_POST["action"]) && isset($_SESSION['start'])) {
  echo $header;
  if ($_POST["action"] == "check") {
    if (strlen($_POST["name"]) == 0 || strlen($_POST["surname"]) == 0 || strlen(iconv('UTF-8','TIS-620',$_POST["surname"])) > 30 || strlen(iconv('UTF-8','TIS-620',$_POST["name"])) > 30 ) {
      echo strlen(iconv('UTF-8','TIS-620',$_POST["surname"])) ."-". strlen(iconv('UTF-8','TIS-620',$_POST["name"]))."<br/>";
      echo $error_name.$footer."</body></html>";	  
      unset($_SESSION["start"]);
      exit;
    }
    $right = 0;
    $wrong = 0;
    $qok[$cnt_quiz] = $v;
    foreach ($qok as $k=>$v) {
      $q = explode("\t",$v);
      $qans[$q[0]] = $q[2];
    }
    $mycheck = "";
    foreach ($_POST as $k=>$v) {
      if ($k != "action" && $k != "name" && $k != "surname" && $k != "total" && $k != "subject") {
        if (strlen($v) > 0) {
          if ($qans[$k] == $v) { $right++; } else { $wrong++; }
            $mycheck .= "$k". $qans[$k] . "$v "; 
        }
      }
    }
    $total = $_POST["total"];
    if ($total <= ($right + $wrong)) {
      $wrong = $total - $right;
      echo "<table class='m_still'>";
      echo "<tr><td>ผลการสอบ ของ<br/>". htmlspecialchars($_POST["name"], ENT_QUOTES) . " " . htmlspecialchars($_POST["surname"], ENT_QUOTES);
      echo "<br/><span style='font-weight:bold;'>ทำถูก</span> = $right";
      echo "<br/><span style='font-weight:bold;'>ทำผิด</span> = $wrong";
      echo "<br/><span style='font-weight:bold;'>ได้ทำ</span> = ". $total;
      echo "<br/><span style='font-weight:bold;'>จำนวนข้อสอบ</span> = ". $total;
      echo "<br/><span style='font-weight:bold;'>เริ่มทำเวลา</span> = ". $_SESSION['start'];
      echo "<br/><span style='font-weight:bold;'>แล้วเสร็จเวลา</span> = ". $current_time;
      echo "</td></tr></table>";
      $data = htmlspecialchars($_POST["name"], ENT_QUOTES)."\t".htmlspecialchars($_POST["surname"], ENT_QUOTES)."\t".$_POST["subject"]."\t";
      $data = $data . $right."\t".$total."\t".$_SESSION['start']."\t".$current_time."\n";
      $fr = array();
      if (file_exists($score_name)) $fr = file($score_name);
      $limit = count($fr);
      if ($user_limited <= $limit) $limit = $user_limited - 1;
      $fw=fopen ($score_name,"w");
      fputs ($fw,$data);
      for ($i=0;$i<$limit;$i++) fputs ($fw,$fr[$i]);
      fclose ($fw);
      echo "<meta http-equiv='refresh' content='10;url=". $program_name . "?action=report&top=10'>";
      unset($_SESSION["start"]);
    } else {
      echo "<span style='color:red;font-size:20px;'>ท่านทำข้อสอบเพียง : " . ($right + $wrong) ." ข้อ<br/>";
      echo "ไม่ครบ ". $total . " ข้อ<br/>จึงไม่ตรวจให้ .. ท่านต้องกลับไปทำให้ครบ</span><br/><br/>";
    }
  }
}
}

/* Action Report Function */
function action_report($score_name) {
global $header,$header_ads,$header_report,$ar,$footer,$footer_ads;
if (isset($_GET["action"])) {
  echo $header . $header_ads . $header_report;
  if ($_GET["action"] == "report") {
    $ar = file($score_name);
    $i=0;
    $bg_color = "";
    foreach ($ar as $k=>$v) {
      $i++;
      if (!isset($_GET["top"]) || $i <= 10) {
        $ar = explode("\t",$v);
        if (strlen($bg_color) == 0) $bg_color = " bgcolor='#ddffff'"; else $bg_color = "";
        if (isset($ar[3]) && isset($ar[4]) && $ar[3] == $ar[4]) $bg_color = " bgcolor='#ffdddd'";
        if (isset($ar[0]) && isset($ar[1]) && isset($ar[2]) && isset($ar[3]) && isset($ar[4]) && isset($ar[5]) && isset($ar[6])) {
          echo "<tr $bg_color style='font-size:10px !important;'><td style='font-size:16px;text-align:center;'>$i</td><td style='font-size:16px;'>$ar[0] $ar[1]</td><td><a href=?subj=$ar[2]>$ar[2]</a></td><td align=center>$ar[3]</td><td align=center>$ar[4]</td><td>$ar[5]</td><td>$ar[6]</td></tr>";
        }
      }
    }
    echo "</table>";
  }
  echo $footer . $footer_ads . "</body></html>";
  exit;
}
}

/* Read Quiz File and Make Randomization Function */
function read_quiz_file($data_namef) {
global $qok,$rnd,$cnt_quiz,$error_subj,$footer;
$cnt_quiz = 0;
if (!file_exists($data_namef)) {
  echo "[ " . $data_namef. " ]<br/>" .$error_subj.$footer."</body></html>";
  exit;
}
$ar = file($data_namef);
foreach ($ar as $v) {
  $q = explode("\t",$v);
  if (isset($q[2]) && strlen($q[2]) > 0) { // ตรวจว่ามีเฉลยหรือไม่
    $qok[$cnt_quiz] = str_replace(array("\r\n", "\n", "\r"),"",$v);
    $rnd[$cnt_quiz] = rand();
    $cnt_quiz = $cnt_quiz + 1;
  }
}
}

/* Display Question and Choice Function */
function display_all_question($data_namef){
global $header, $header_ads, $current_time, $rnd, $qok, $remark, $remark_send, $name, $surname, $data_name;
if (isset($_POST["action"])) { exit; }
$choice_shuffling[1] = array(1,2,3,4,7,5,6);
$choice_shuffling[2] = array(5,7,2,3,4,1,6);
$choice_shuffling[3] = array(4,1,2,5,7,3,6);
$choice_shuffling[4] = array(2,3,5,4,1,6,7);
$choice_shuffling[5] = array(4,6,7,3,1,2,5);
$choice_shuffling[6] = array(7,6,5,2,4,1,3);
$choice_shuffling[7] = array(2,4,1,3,7,6,5);
echo $header . $header_ads;
$_SESSION['start'] = $current_time;
echo "<form action='test3.php' method='post'><table class='m_still'><tr><td>";
asort($rnd); // ทำให้ array จัดเรียงตามค่าสุ่ม
$total_question = 0;
echo "<table style='background-color:#f9f9f9;'>";
$bg_color = "";
foreach ($rnd as $k=>$v) {
  $total_question++;
  $q = explode("\t",$qok[$k]);
  if (strlen($bg_color) == 0) { $bg_color = " style='background-color:#ddffff'"; } else { $bg_color = ""; }
  echo "<tr $bg_color><td style='font-size:20px;'><div style='background-color:#ffffdd;border:1px outset white;border-radius:20px;box-shadow:5px 5px 5px lightgrey;padding:5px;margin:20px;'>"; 
  echo $total_question.". ".$q[1]." ";
  $img = "q=". $q[1];
  $cok = rand(1,7);
  $choice = 1;
  for($i=3;$i<10;$i++) {
    if (isset($q[$choice_shuffling[$cok][$i - 3] + 2])) {
      if (strlen($q[$choice_shuffling[$cok][$i - 3] + 2]) > 0 && $q[$choice_shuffling[$cok][$i - 3] + 2] != "\r\n"  && $q[$choice_shuffling[$cok][$i - 3] + 2] != "\n") {
        echo "<br/><input type='radio' name='$q[0]' style='margin-left:10px;margin-right:10px;height:35px;width:35px;vertical-align:middle;' value='". ($choice_shuffling[$cok][$i - 3]) ."' />". $q[$choice_shuffling[$cok][$i - 3] + 2]."";
      }
      $img .= "&c". $choice++ ."=". $q[$choice_shuffling[$cok][$i - 3] + 2];
    }
  }
  echo "<div style='width:100%;text-align:center;'>
  <a style='margin:10px;' href='image.php?". $img."' target='_blank' title='คำถาม ". $q[1] ."' rel='lightbox[ข้อสอบออนไลน์]'><span class='glyphicon glyphicon-eye-open' style='font-size:30px;color:blue;'></span></a>
  <a style='margin:10px;' data-toggle='tooltip' title='เฉลย คือ ". $q[intval($q[2]) + 2] ."'><span class='glyphicon glyphicon-comment' style='font-size:30px;color:green;'></span></a>
  </div>";
  echo "</div></td></tr>\n";
}
echo "<tr><td style='background-color:#cccccc;text-align:center;'>
<table class='m_still' style='background-color:#dddddd;width:95%;margin-left:auto;margin-right:auto;'>
<tr><td colspan='2' style='background-color:black;color:white;font-size:24px;'>คำชี้แจง</td></tr>
$remark
<tr><td style='text-align:right;'>ชื่อ :</td><td style='text-align:left;'><input name='name' size='20' value='$name' /> เช่น Steve</td></tr>
<tr><td style='text-align:right;'>สกุล :</td><td style='text-align:left;'><input name='surname' size='20' value='$surname' /> เช่น Jobs</td></tr>
</table>
$remark_send
<br/><input type='submit' value='ส่งคำตอบ' style='background-color:darkblue;color:white;font-size:20px;width:200px;height:40px;border:2px outset black;border-radius:20px;' /></td></tr></table>
<input type='hidden' value='check' name='action' />
<input type='hidden' value='$total_question' name='total' />
<input type='hidden' value='$data_name' name='subject' />
</td></tr></table></form>";
}

/* Footer Function */
function footer($footer){
  echo $footer . "</body></html>"; /* หยุดแสดง google adsense $footer_ads */
  exit; /* ออกจากโปรแกรม */
}
?>