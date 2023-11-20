     <aside id="slide-out" class="side-nav white fixed">
         <div class="side-nav-wrapper">
             <div class="sidebar-profile">
                 <div class="sidebar-profile-image">
                     <img src="../assets/images/profile-image.png" class="circle" alt="">
                 </div>
                 <div class="sidebar-profile-info">

                     <p>Admin</p>


                 </div>
             </div>

             <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
                 <li class="no-padding"><a class="waves-effect waves-grey" href="dashboard.php"><i class="material-icons">settings_input_svideo</i>แดชบอร์ด</a></li>

                 <li class="no-padding">
                     <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">desktop_windows</i>ประวัติการลาใบลา<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                     <div class="collapsible-body">
                         <ul>
                             <li><a href="leaves.php">การลาของพนักงานทั้งหมด</a></li>
                             <!-- <li><a href="pending-leavehistory.php">Pending Leaves </a></li>
                             <li><a href="approvedleave-history.php">Approved Leaves</a></li>
                             <li><a href="notapproved-leaves.php">Not Approved Leaves</a></li> -->

                         </ul>
                     </div>
                 </li>

                 <li class="no-padding">
                     <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">apps</i>ตำแหน่งเจ้าหน้าที่<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                     <div class="collapsible-body">
                         <ul>
                             <li><a href="adddepartment.php">เพิ่มตำแหน่งเจ้าหน้าที่</a></li>
                             <li><a href="managedepartments.php">แก้ไขตำแหน่งเจ้าหน้าที่</a></li>
                         </ul>
                     </div>
                 </li>
                 <li class="no-padding">
                     <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">code</i>ประเภทการลา<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                     <div class="collapsible-body">
                         <ul>
                             <li><a href="addleavetype.php">เพิ่มประเภทการลา</a></li>
                             <li><a href="manageleavetype.php">แก้ไขประเภทการลา</a></li>
                         </ul>
                     </div>
                 </li>
                 <li class="no-padding">
                     <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">account_box</i>พนักงาน<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                     <div class="collapsible-body">
                         <ul>
                             <li><a href="addemployee.php">เพิ่มพนักงาน</a></li>
                             <li><a href="manageemployee.php">แก้ไขพนักงาน</a></li>

                         </ul>
                     </div>
                 </li>




                 <li class="no-padding"><a class="waves-effect waves-grey" href="changepassword.php"><i class="material-icons">settings_input_svideo</i>เปลี่ยนรหัสผ่าน</a></li>

                 <li class="no-padding">
                     <a class="waves-effect waves-grey" href="#" onclick="confirmLogout();">
                         <i class="material-icons">exit_to_app</i>ออกจากระบบ
                     </a>
                 </li>
                 <script>
                     function confirmLogout() {
                         var confirmLogout = confirm("คุณต้องการออกจากระบบหรือไม่?");
                         if (confirmLogout) {
                             window.location.href = "logout.php";
                         }
                     }
                 </script>



             </ul>
             <div class="footer">
                 <p class="copyright">Sense ©</p>

             </div>
         </div>
     </aside>