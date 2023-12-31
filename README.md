 * Script_name: test3.php
 * Code: http://www.thainame.net/quiz/test3.php
 * Version: 2.0.4
 * Date: 2566-06-15
 * Developer: @thaiall
 *
 * Objectives:
 * 1. เพื่อเป็นแบบทดสอบออนไลน์สำหรับผู้ทดสอบด้วยตนเอง (Online Testing) ที่บริการข้อสอบออนไลน์ แบบปรนัย 4 - 7 ตัวเลือก
 * มีฟังก์ชันการแสดงคำถามและตัวเลือกเป็นภาพขนาด 640px * 480px แบบ Lightbox
 * 2. เพื่อสนับสนุนให้คุณครูได้เปิดคำถามเป็นภาพ แล้วฉายขึ้น Projector และทำกิจกรรมในชั้นเรียน
 * โดยแยกตามสาระการเรียนรู้ที่น่าสนใจ เช่น ความรู้พื้นฐานด้านภาษาอังกฤษ คณิตศาสตร์ ภาษาไทย คอมพิวเตอร์
 *
 * Description:
 * - 660615: ปรับเพิ่มหมายเหตุ เพื่ออธิายการใช้คำสั่งใน Initial Process Section
 * ปรับค่าของตัวแปรใน Template Variables ใ้ห้เหลือบรรทัดเดียวทั้งหมด
 * เพิ่มปุ่มกลับไปทำข้อสอบใหม่ กรณีกรอกข้อมูลไม่ครบตามเงื่อนไข
 * เปลี่ยนจาก exit; เป็น function exit();
 * - 660612: เริ่มนำ code ขึ้น github.com โดย clear ค่าในตัวแปร $header_ads, $footer_ads, และ $footer_tracker
 * มีที่อยู่โค้ด คือ https://github.com/thaiall/code/blob/main/test3.php
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
