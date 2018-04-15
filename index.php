<!DOCTYPE html>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <title>To do list</title>
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="Stylesheet" type="text/css" href="css/style.css" />
   <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed:300,400,500,700" rel="stylesheet">
   <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
</head>
<body>
   <div class="wrapper">
      <nav>
         <ul>
            <li>ALL</li>
            <li>ON HOLD</li>
            <li>IN PROGRESS</li>
            <li>NEEDS REVIEW</li>
            <li>FINISHED</li>
            <li>SAVE</li>
         </ul>
      </nav>
      <div id="container">
         <?php
            $c = mysqli_connect('localhost', 'root', '', 'to_do_list');
            $c->set_charset("utf8");

            /*********************************************/
            /********** ADD/REMOVE/CHANGE NOTE **********/
            /*******************************************/

            if(isset($_GET['remove'])) {
               $id = $_GET['remove'];
               mysqli_query($c, "DELETE FROM `to_do_list` WHERE id='$id'");
            }
            else if(isset($_GET['change_status'])) {
               $id = $_GET['change_status'];
               $status = $_GET['status'];
               $array_status = array("ON HOLD", "IN PROGRESS", "NEEDS REVIEW", "FINISHED");
               mysqli_query($c, "UPDATE `to_do_list` SET Status='$array_status[$status]' WHERE id='$id'");
            } else if(isset($_POST['new_note'])) {
               $new_note_title = $_POST['new_note_title'];
               $new_note_text = $_POST['new_note_text'];
               $new_note_status = "ON HOLD";

               $c = mysqli_connect('localhost', 'root', '', 'to_do_list');
               mysqli_query($c, "INSERT INTO `to_do_list` SET Title='$new_note_title', Text='$new_note_text', Status='$new_note_status'");
            }
         
         
            if(empty($_GET["name"]) || $_GET["name"]=="all") {$q = mysqli_query($c, "SELECT * FROM `to_do_list` ");}
            else if($_GET["name"]=="on hold") {$q = mysqli_query($c, "SELECT * FROM `to_do_list` WHERE status='ON HOLD'");}
            else if($_GET["name"]=="in progress") {$q = mysqli_query($c, "SELECT * FROM `to_do_list` WHERE status='IN PROGRESS'");}
            else if($_GET["name"]=="needs review") {$q = mysqli_query($c, "SELECT * FROM `to_do_list` WHERE status='NEEDS REVIEW'");}
            else if($_GET["name"]=="finished") {$q = mysqli_query($c, "SELECT * FROM `to_do_list` WHERE status='FINISHED'");}
            else {header("Location:index.php");}
            while($r = mysqli_fetch_assoc($q)) {
               echo "<div class='note'><div class='btn_remove'><p><a href='index.php?remove=".$r['ID']."'>X</a></p></div><textarea id='title".$r['ID']."' onclick='udpate_note(".$r['ID'].")' onchange='udpate_note(".$r['ID'].")' class='title'>".$r['Title']."</textarea><textarea id='text".$r['ID']."' onclick='udpate_note(".$r['ID'].")' onchange='udpate_note(".$r['ID'].")' class='text'>".$r['Text']."</textarea><div class='status'><ul><li><a class='s_status' href='#'>".$r['Status']."</a><ul><a href='index.php?change_status=".$r['ID']."&status=0'><li>ON HOLD</li></a><a href='index.php?change_status=".$r['ID']."&status=1'><li>IN PROGRESS</li></a><a href='index.php?change_status=".$r['ID']."&status=2'><li>NEEDS REVIEW</li></a><a href='index.php?change_status=".$r['ID']."&status=3'><li>FINISHED</li></a></ul></li></ul></div></div>";
            }
            mysqli_close($c); 
         ?>
      </div>
      <div id="add_note"><p>+</p></div>
      <div id="new_note">
         <form action="index.php" method="post" class="new_note_container animate">
            <textarea class="new_note_title" name="new_note_title" placeholder="Title"></textarea>
            <textarea class="new_note_text" name="new_note_text" placeholder="Note"></textarea>
            <input type="submit" name="new_note" class="btn_new_note" value="Save">
         </form>
      </div>
   </div>
   
   <?php
      /*******************************/
      /********** UPDATE ************/
      /*****************************/
   
      if(isset($_GET["name"])) {
         $name = $_GET["name"];
         if($name == "save") {
            $save = $name;
            $ID = $_GET["ID"];
            $Title = $_GET["Title"];
            $Text = $_GET["Text"];
            echo $save;
            echo $ID;
            echo $Title;
            echo $Text;

            $c = mysqli_connect('localhost', 'root', '', 'to_do_list');
            $c->set_charset("utf8");
            mysqli_query($c, "UPDATE `to_do_list` SET `Title`='$Title',`Text`='$Text' WHERE ID='$ID'") or die ("Nie udało się zmodyfikowć rekordu");
            $myfile = fopen("id.txt", "w");
            fwrite($myfile, $ID);
            fclose($myfile);
            mysqli_close($c);
         }
      }
   
      $set_cursor_id = file_get_contents("id.txt");
      ?>
   
<script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
   //autosize(document.getElementsByClassName("title"));
   autosize(document.querySelector(".title"));
   autosize(document.querySelector(".text"));
   autosize(document.querySelector(".new_note_title"));
   autosize(document.querySelector(".new_note_text"));
   
   document.querySelector("#add_note").addEventListener("click", function() {
      document.querySelector("#new_note").style="display:block";
   });

   // new note
   let new_note = document.querySelector('#new_note');
   window.onclick = function(event) {
      if (event.target == new_note) {
         new_note.style="display:none";
      }
   }

   // set a cursor at the end of line, where user has ended modify
   textarea = $("#text"+<?php echo $set_cursor_id; ?>),
   val = textarea.val();
   textarea
    .focus()
    .val("")
    .val(val);


//change status on hover
$(".status > ul li").children("a").hover(function(){
   $(this).parent("li").children("ul").css("display","block")
}, function(){
   $(this).parent("li").children("ul").css("display","none")
});   
$(".status > ul li").children("ul").hover(function(){
   $(this).css("display","block")
}, function(){
   $(this).css("display","none")
});

   var global_textarea;
   var note_array = [];
   function udpate_note(a) {
      let id = a;
      let new_title = document.getElementById('title'+a).value;
      let new_text = document.getElementById('text'+a).value;

      note_array[0] = id;
      note_array[1] = new_title;
      note_array[2] = new_text;

      /**********************/
      /***** AUTO SAVE *****/
      /********************/

      //setup before functions
      let typing_timer;                //timer identifier
      let done_typing_interval = 2000;  //time in ms
      let $input = $('textarea');

      //on keyup, start the countdown
      $input.on('keyup', function () {
        clearTimeout(typing_timer);
        typing_timer = setTimeout(doneTyping, done_typing_interval);
      });

      //on keydown, clear the countdown 
      $input.on('keydown', function () {
        clearTimeout(typing_timer);
      });

      //"finished typing"
      function doneTyping () {
         udpate_note(a);
         global_textarea = $("#text"+note_array[0]);
         window.location.href = "index.php?name=save&ID="+note_array[0]+"&Title="+note_array[1]+"&Text="+note_array[2];
      }

      // save (ctrl+s/enter/button)
      $(window).bind('keydown', function(event) {
         if (event.keyCode === 13) {
            udpate_note(a);
            global_textarea = $("#text"+note_array[0]);
            window.location.href = "index.php?name=save&ID="+note_array[0]+"&Title="+note_array[1]+"&Text="+note_array[2];
          }
          else if (event.ctrlKey || event.metaKey) {
              switch (String.fromCharCode(event.which).toLowerCase()) {
              case 's':
                  event.preventDefault();
                  udpate_note(a);
                  global_textarea = $("#text"+note_array[0]);
                  window.location.href = "index.php?name=save&ID="+note_array[0]+"&Title="+note_array[1]+"&Text="+note_array[2];
                  break;
              }
          }
      });
   }
   document.querySelector("nav > ul > li:last-child").addEventListener("click", function() {
      if(note_array[0] != undefined) {
         window.location.href = "index.php?name=save&ID="+note_array[0]+"&Title="+note_array[1]+"&Text="+note_array[2];
      }
   });
      
   for(let i=1;i<document.querySelectorAll("nav > ul > li").length;i++) {
      document.querySelector("nav > ul > li:nth-child("+i+")").addEventListener("click", function() {
         if(i == 1) {window.location.href = "index.php?name=all";}
         else if(i == 2) {window.location.href = "index.php?name=on hold";}
         else if(i == 3) {window.location.href = "index.php?name=in progress";}
         else if(i == 4) {window.location.href = "index.php?name=needs review";}
         else if(i == 5) {window.location.href = "index.php?name=finished";}
      });
   }
</script>
</body>
</html>