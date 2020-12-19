
<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


						<!--##############################################################################################################################--->


<script type="text/javascript">
  $(document).ready(function () {
    $('#userq').submit(function (e) {
      e.preventDefault();
      var userquestion = $('#userquest').val();
	  var userquestions = document.getElementById('#userquestions');
      var queryString = window.location.search;
	var urlParams = new URLSearchParams(queryString);
	var pid = urlParams.get('pid');
	var auctionid = urlParams.get('auctionid');
      $.ajax
        ({
          type: "POST",
          url: "questions.php",
          data: { "userquestion": userquestion, "pid": pid, "auctionid": auctionid},
          success: function (data) {
            $('#userq')[0].reset();
             $('#askModal').modal('hide');
             $('#userquestions').html(data);

          }
        });
    });
  });

</script>


<script type="text/javascript">
  $(document).ready(function () {
    $(function () {
                $(".replybtn").click(function () { 
                    var a = $(this).parents("tr").find(".quesid").text();

                    var c =$(this).parents("tr").find(".question").text(); 
                    var d =$(this).parents("tr").find(".asker").text(); 
                    var e =$(this).parents("tr").find(".questiondate").text(); 
                    var p = ""; 
                    p +="<input type='hidden' id='q' name='qid' value='"+a+"'>";
                    p +="<h3 id='c' name='question'>"+ c + "</h3>"; 
                    p +="<h3 id='d' name='asker' >"+ d + " </h3>"; 
                    p +="<h3 id='e' name='questiondate' >"+ e + " </h3>"; 
                    $("#divQuestions").empty(); 
                    $("#divQuestions").append(p); 
                    $('#ReplyModal').modal('show');
                });
                });
  });
      $(function () {
        $("#ownerform").submit(function () {
            // $('#ownerform')[0].reset();
            $("#ReplyModal").modal("hide");

        });
    });
</script>


<!----------------------------------js to check user input--------------------------------------->

 <script type="text/javascript">
 	    
function checkANS(ownerreply){
	inputflag=false;
    var textAreaExp=/^(.|\s)*[a-zA-Z]{3,500}(.|\s)*$/;
    
    if(ownerreply.length==0){
    m="";
    inputflag=false;
    document.getElementById('inputMessage').innerHTML=m;
    }
    if(ownerreply.length<3&&ownerreply.length>0){
    m="Enter at least 3 characters.";
    c="red";
    inputflag=false;
    document.getElementById('inputMessage').style.color=c;
    document.getElementById('inputMessage').innerHTML=m;
    }
    if(ownerreply.length>=3&&ownerreply.length<500){
    m="Post your answer when you are done!";
    inputflag=true;
    c="green"
    document.getElementById('inputMessage').style.color=c;
    document.getElementById('inputMessage').innerHTML=m;
    }
    if(ownerreply.length>500){
    m="Enter Less than 500 characters.";
    c="red";
    inputflag=false;
    document.getElementById('inputMessage').style.color=c;
    document.getElementById('inputMessage').innerHTML=m;
    }

     if (!textAreaExp.test(ownerreply)){
      m="Invalid text";
      c="red";
      inputflag=false;
      document.getElementById('inputMessage').style.color=c;
      document.getElementById('inputMessage').innerHTML=m;
      }

	}


function checkQUES(userquestion){
	inputflag=false;
    var quespattern=/^(.|\s)*[a-zA-Z]{3,300}(.|\s)*$/;
    if(userquestion.length==0){
    m="";
    inputflag=false;
    document.getElementById('inputMessage').innerHTML=m;
    }
    if(userquestion.length>0&&userquestion.length<3){
    m="Enter at least 3 characters.";
    c="red";
    inputflag=false;
    document.getElementById('inputMessage').style.color=c;
    document.getElementById('inputMessage').innerHTML=m;
    document.getElementById('inputMessage').innerHTML=m;
    }
    if(userquestion.length>=3&&userquestion.length<300){
    m="Post your question when you are ready!";
    c="green";
    inputflag=true;
    document.getElementById('inputMessage').style.color=c;
    document.getElementById('inputMessage').innerHTML=m;
    document.getElementById('inputMessage').innerHTML=m;
    }
    if(userquestion.length>300){
    m="Enter Less than 300 characters.";
    c="red";
    inputflag=false;
    document.getElementById('inputMessage').style.color=c;
    document.getElementById('inputMessage').innerHTML=m;
    }

     if (!quespattern.test(userquestion)){
      m="Invalid question";
      c="red";
      inputflag=false;
      document.getElementById('inputMessage').style.color=c;
      document.getElementById('inputMessage').innerHTML=m;
      }

	}

        function checkProductInquiry(){
        	    if(inputflag==false)
        	    {console.log(inputflag);
        	    window.alert("Your input was not valid.\nPlease try again!");
        	    }
          return (inputflag);
        }

  </script>




</head>
<body>
	

   <?php
	
	echo"<h3>Questions:</h3>";
	$username=$_SESSION['username']; 

 	$sql = $db->prepare("SELECT * FROM auctions WHERE product=:product");
  	$sql->bindparam(':product',$pid);
  	if($sql->execute()){
		$sql=$sql->fetch(PDO::FETCH_ASSOC);
		$owner=$sql['owner'];
		$status=$sql['status'];
	}

if($owner!=$_SESSION['username']&&isset($_SESSION['username'])) {
	if($status=="active"){?>
<!-- Modal -->
<div class="modal fade" id="askModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Submit Your Question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      	<form method="post" id='userq' onsubmit="return checkProductInquiry();">
      		<div class="modal-body">
      		 <div class="form-group">
      			<label>Your Question:</label>
      			       <span id='inputMessage'></span>
                   <input type="text" name="userquestion" onkeyup="checkQUES(this.value)" id="userquest" class="form-control"  placeholder="Enter your question here">
      		</div>
       		<?php echo "<input type='hidden' name='pid' value='".$pid."'>";?>
      		<?php echo "<input type='hidden' name='auctionid' value='".$auctionid."'>";?>
      		</div>      	
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        <button type="submit" id='qsubmit' class="btn btn-primary" name="submitquestion">Post Question</button>
	      </div>
 		</form>
    </div>
  </div>
</div>


	<div class="container">
		<div class="jumbotron">
			<div class="card">
				<div class="card-body">
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#askModal">Ask a question</button>
				</div>
			</div>
		</div>
	</div>
<?php
}//active auction
	try{ 	

		 echo "<div id='userquestions'></div>";
		echo "<h3>My Questions:</h3>";
		   $sql = $db->prepare("SELECT * FROM questions WHERE product=:product AND asker=:user ORDER BY questiondate DESC");
		  $sql->bindparam(':product',$pid);
		  $sql->bindparam(':user',$username);
		  if($sql->execute()){
		  	echo "<table>";
		  while($allquestions = $sql->fetch(PDO::FETCH_ASSOC))
		    { echo "<tr>";
		      echo "Question: <strong>".$allquestions['question']."</strong>";
		      echo "<br/>";
		      echo "Posted on: ".$allquestions['questiondate'];
		      echo "<br/>";
		      if ($allquestions['answer']==NULL) {
		      	echo "Not yet answered <br/>";
		      }
		      elseif($allquestions['answer']!=NULL){
		      echo "Owner's Reply: ".$allquestions['answer'];
		      echo "<br/>";
		      echo "answered on: ".$allquestions['answerdate'];
		      echo "<br/>";
				}
				echo "</tr>";
		    }
		    echo "</table>";
		  }

		  echo "<div id='allquestions'>"; 
		 echo "<h3>Recent Questions:</h3>"; 
		  $sql = $db->prepare("SELECT * FROM questions WHERE product=:product AND answer IS NOT NULL AND asker!=:asker ORDER BY questiondate ASC");
		  $sql->bindparam(':product',$pid);
		  $sql->bindparam(':asker',$username);
		  if($sql->execute()){
		  while($allquestions = $sql->fetch(PDO::FETCH_ASSOC))
		    {echo "<tr>";
		      echo "Question: ".$allquestions['question'];
		      echo "<br/>";
		      echo "Posted on: ".$allquestions['questiondate'];
		      echo "<br/>";
		      echo "Posted by: ".$allquestions['asker'];
		      echo "<br/>";
		      echo "Owner's Reply: ".$allquestions['answer'];
		      echo "<br/>";
		      echo "answered on: ".$allquestions['answerdate'];
		      echo "<br/>";
			echo "</tr>";
		    }
		  }
		  echo "</div>";
		$db=null;
	}

catch(PDOException $ex) {
  die("Error Message ".$ex->getMessage());
}


}//if owner isnt the active user 





########################################################################################################################################




if($owner==$_SESSION['username']){
 	echo "<h3>Pending Questions:</h3>"; 
 	try{
 		require('connection.php');
		$sql = $db->prepare("SELECT * FROM questions WHERE product=:product AND owner=:owner AND answer IS NULL ORDER BY questiondate DESC");
		  $sql->bindparam(':product',$pid);
		   $sql->bindparam(':owner',$owner);
		  $sql->execute();
		  if($sql->rowCount()!=0){

		  	echo "<table>";
		  while($pendingquestions = $sql->fetch(PDO::FETCH_ASSOC))
		    { 
		    //DO NOT CHANGE THE TEXT OF QID ROW OR ORDER OF THE TABLE
		echo "<tr><td class='quesid'>".$pendingquestions['id']."</td>";
		echo "<td class='question'>Question: <strong>".$pendingquestions['question']."</strong></td>";
		echo "<td class='asker'>Asked by: <strong>".$pendingquestions['asker']."</strong></td>";
		echo "<td class='questiondate'>Posted on: <strong>".$pendingquestions['questiondate']."</strong></td>";
		echo "<td><button type='submit' class='btn btn-primary replybtn'data-bs-toggle='modal' data-bs-target='#ReplyModal'>Reply</button></td></tr>";
		    }
		    echo "</table>";
		  }
 	}//try
 	catch(PDOException $ex) {
		  die("Error Message ".$ex->getMessage());
		}

echo "<h3>Recently Answered:</h3>"; 
	try{
		$sql = $db->prepare("SELECT * FROM questions WHERE product=:product AND answer IS NOT NULL ORDER BY answerdate DESC");
		$sql->bindparam(':product',$pid);
		if($sql->execute()){
		 while($allquestions = $sql->fetch(PDO::FETCH_ASSOC))
		 {echo "<tr>";
		  echo "Question: ".$allquestions['question'];
		  echo "<br/>";
		  echo "Posted on: ".$allquestions['questiondate'];
		  echo "<br/>";
		  echo "Posted by: ".$allquestions['asker'];
		  echo "<br/>";
		  echo "Owner's Reply: ".$allquestions['answer'];
		  echo "<br/>";
		  echo "answered on: ".$allquestions['answerdate'];
		  echo "<br/>";
		  echo "</tr>";
		  }
		 }
	echo "</div>";
	$db=null;
	}

catch(PDOException $ex) {
  die("Error Message ".$ex->getMessage());
}

?>





<!-- Modal -->
<div class="modal fade" id="ReplyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product Inquiry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      	<form method="post" action="questions.php" id="ownerform" onsubmit="return checkProductInquiry();" >
      		<div class="modal-body">
<div class="Questionsclass" id="divQuestions"></div>
      		 <div class="form-group">
      			<label>Your Reply:</label>
      			<span id='inputMessage'></span>
      			<input type="textarea" onkeyup="checkANS(this.value)" name="ownerreply" id="ownerreply" class="form-control" placeholder="Enter your reply here">
      		<?php echo "<input type='hidden' id='prodid' name='pid' value='".$pid."'>";?>
      		<?php echo "<input type='hidden' id='auctid' name='auctionid' value='".$auctionid."'>";?>
      		</div>
      		  
      		</div>      	

	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" name="saveanswer" class='asubmit'value="save">Save Answer</button>
	      </div>
 		</form>
    </div>
  </div>
</div>

<?php
}//IF OWNER IS USER

?>

</body>

</html>