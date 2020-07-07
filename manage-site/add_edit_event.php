<?php
/*
 * @author Shahrukh Khan
 * @website http://www.thesoftwareguy.in
 * @facebook https://www.facebook.com/Thesoftwareguy7
 * @twitter https://twitter.com/thesoftwareguy7
 * @googleplus https://plus.google.com/+thesoftwareguyIn
 */

session_start();
	
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: home.php");
    exit;
}

require("../libs/config.php");

$msg = '';

include("header.php");

?>

<link rel="stylesheet" type="text/css" href="CLEditor/jquery.cleditor.css" />
<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="CLEditor/jquery.cleditor.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  
<?php echo $msg; ?>
<div class="formField">      
    <form method="post" action=" " name="events">
      
        <table id="tableForm">
            <tr>
                <td class="formLeft"><span class="required">*</span>Event Title: </td>
                <td><input type="text" name="event_title" id="event_title" class="textboxes" autocomplete="off"  /> </td>
            </tr>
            <tr>
                <td class="formLeft"><span class="required">*</span>Description: </td>
                <td>
                    <textarea name="event_desc" id="event_desc"></textarea>
                </td>
            </tr>
            <tr>
                <td class="formLeft">Format: </td>
                <td>
                    <textarea name="event_format" id="event_format"></textarea>
                </td>
            </tr>
            <tr>
                <td class="formLeft">Meta Keywords: </td>
                <td><input type="text"  name="meta_keywords" id="event_keywords" class="textboxes" /> </td>
            </tr>

            <tr>
                <td class="formLeft"><span class="required">*</span>Contact Email: </td>
                <td><input type="email" name="event_email" id="event_email" class="textboxes"  autocomplete="off"  /> </td>
            </tr>

            <tr>
                <td class="formLeft">Contact Phone: </td>
                <td><input type="number" name="event_phone" id="event_phone" class="textboxes"  /> </td>
            </tr>

            <tr>
                <td class="formLeft">Date: </td>
                <td><input type="date" name="event_date" id="event_date" class="textboxes"/> </td>
            </tr>

            <tr>
                <td class="formLeft">Registration Link: </td>
                <td><input type="text" name="event_reglink" id="event_reglink"  class="textboxes" /> </td>
            </tr>
            <tr>
                <td class="formLeft">Additional Details: </td>
                <td><input type="text" name="event_addDetails" id="event_addDetails" placeholder ="link for more rules" class="textboxes" /> </td>
            </tr>
            
         
            <tr>
                <td class="formLeft"><span class="required">*</span>Status : </td>
                <td>     
                    <?php if (isset($_REQUEST["edit"]) && $_REQUEST["edit"] != "") { ?>
                        <label><input type="radio" name="status" id="active_status" value="A" <?php echo ($details[0]["status"] == 'A') ? 'checked' : ''; ?>  />Active</label> &nbsp; 
                        <label><input type="radio" name="status" id="status" value="I" <?php echo ($details[0]["status"] == 'I') ? 'checked' : ''; ?>  />Inactive</label>
                    <?php } else { ?>
                        <label><input type="radio" name="status" id="active_status" value="A" checked  />Active</label> &nbsp; <label><input type="radio" name="status" value="I"  />Inactive</label>
                    <?php } ?>



                </td>
            </tr>
            <tr>
                <td></td>
                <td> <input type="button" onclick="put_data()" name="sub" value="Save" /> &nbsp;  <input type="button" name="" onclick="javascript:window.location = 'manage_events.php';" value="back to lists" /> </td>
            </tr>       
        </table>
    </form>
</div>

    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript">     
         var org_id = '<?php echo $_SESSION['org_id']; ?>';
         var page = 'events';
         var event_id = '<?php echo $_GET['edit']; ?>';

       $(document).ready(function(){
           if ( event_id != '' ){
            $.ajax({
            method: "get", 
            url: "get_data.php",
            data: {org_id: org_id,
            page:page,
            event_id : event_id
            }
            }).done(function(data){
                var result= $.parseJSON(data); 
                $.each( result, function( key, value ) {
                $("#event_title").val(value['event_title']);
                $("#event_desc").val(value['event_desc']);
                $("#event_addDetails").val(value['event_addDetails']);
                $("#event_date").val(value['event_date']);
                $("#event_email").val(value['event_email']);
                $("#event_format").val(value['event_format']);
                $("#event_phone").val(value['event_phone']);
                $("#event_reglink").val(value['event_reglink']);
                $("#meta_keywords").val(value['meta_keywords']);
                $("#status").val(value['meta_keywords']);
                 });
                });
        }

         });

    </script>

    <script type="text/javascript"> 
        function put_data(){
            // include id
         var org_id = '<?php echo $_SESSION['org_id']; ?>';
         var page = 'events';
          var event_id = '<?php echo $_GET['edit']; ?>';

        var event_title = document.getElementById("event_title").value;
        var event_desc = document.getElementById("event_desc").value;
        var event_addDetails = document.getElementById("event_addDetails").value;
        var event_date = document.getElementById("event_date").value;
        var event_email = document.getElementById("event_email").value;
        var event_format = document.getElementById("event_format").value;
        var event_phone = document.getElementById("event_phone").value;
        var event_reglink = document.getElementById("event_reglink").value;
        var event_keywords = document.getElementById("event_keywords").value;

        if (document.getElementById("active_status").checked){
                 var event_status = 'A';
             }else{
                 var event_status = 'I';
             }
       

        if (event_title == '' || event_desc == '') {
        alert("Please Fill All Fields");
        } else {
        // AJAX code to submit form.
        $.ajax({
        type: "POST",
        url: "put_data.php",
        data: {
            page : page,
            org_id : org_id,
            event_id : event_id,
            event_title : event_title,
            event_desc : event_desc,
            event_addDetails : event_addDetails,
            event_date : event_date,
            event_email : event_email,
            event_format : event_format,
            event_phone : event_phone,
            event_reglink : event_reglink,
            meta_keywords : event_keywords,
            status : event_status
        },
        cache: false,
        success: function(html) {
        alert(html);
        }
        });
        }
        return false;
        }
    
    </script>


<?php
include("footer.php");
?>