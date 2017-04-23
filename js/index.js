var active = "main";
function sendRequest(){ // Save Tutorial Requests
      var url = "include/page/saveAsked.php?f_name="+$("#f_name").val()+
                "&email="+$("#email").val()+"&subject="+
                $("#tutorial").val()+"&message="+$("#tut_detail").val();
      $.post(url, function(d, s){
        $(".modal-body").html("<span class='alert alert-success col-xs-12' role='alert'>Tutorial Deleted Successfully</span>");
        setTimeout(function(){
          $(".modal").hide(1000);
          $(".modal-backdrop").hide();
          $("#myModal").hide();
        }, 1500);
      });
      return false;
}
function sendMessage(){ // Save Tutorial Contact Us Messages
  var url = "include/page/saveMessage.php?f_name="+$("#f_name").val()+
            "&s_name="+$("#s_name").val()+"&email="+$("#email").val()+"&subject="+
            $("#subject").val()+"&message="+$("#message").val();
      $.post(url, function(d, s){
        $(".modal-dialog").html("<span class='alert alert-success' role='alert'>Message Was Sent Successfully</span>");
        setTimeout(function(){
          $(".modal-dialog").slideUp("fast");
          $(".modal-backdrop").hide();
          $("#myModal").hide();
        }, 1000);
      });
      return false;
}
function refer(q, g){ // Refer To Tutorial's Category OR Type.
  var url = "include/class/tutorial.php?"+g+"="+q;
  $.post(url, function(d, s){
    $('.main-container').html(d);
  });
}

function search(){
  var url = "include/page/search_result.php?"+$('.search-form').serialize();
  $.post(url, function(d, s){
      $('.main-container').html(d);
  });

}
function goto_page(page, v, q){
	var url = page;
	if(q && v){ // If The Request Have Parameters Set
		var input = document.getElementsByClassName('search_field')[0];
		url += "?"+v+"="+q;
	} else if(v){ // The Query Parameter is Set.
		var url = page+"?query="+v;
	}
  $.post(url, function(d, s){
      $('.main-container').html(d);
  });
}


function response(t, i){
  var url = "add_tut.php?query="+t+"&id="+i;
  if($("#myModal")){
    $("#myModal").remove();
  }
  $.post(url, function(d, s){
      $("body").append(d);
  });
}
function loadPage(p){
  var url = p;
  if(p == "add_tut.php"){
    if($("#myModal")){
      $("#myModal").remove();
    }
    $.post(url, function(d, s){
        $("body").append(d);
    });
  } else {
    $.post(url, function(d, s){
        $(".container-content").html(d);
    });
  }
}
function getModal(id){
  window.updateId = id;
  if($("#myModal")){
    $("#myModal").remove();
  }
  var url = "update.php?modal="+id;
  $.post(url, function(d, s){
      $("body").append(d);
  });
}
function loadModal(m, q){
  if($("#myModal")){
    $("#myModal").remove();
  }
  if(q){
    var url = m+"?query="+q;
  } else {
    var url = m;
  }
  $.post(url, function(d, s){
      $("body").append(d);
  });
}
function adminType(q){
  var url = "../db/fetch_db.php?cat="+q;
  $("#category-btn").text(q);
  $.post(url, function(d, s){
      $("#type_list").html(d);
      if($("#type-btn").attr("disabled")){
        $("#type-btn").removeAttr("disabled");
      }
      $("#type-btn").text("Type");
  });
}
function saveTut(q){
    if (!$("#type-btn").text() || $("#type-btn").text() == "Type") {
        alert("Please Select The Type Of The Tutorial");
    } else {

      if(q == "u"){
        var query = "?title="+$('#title').val()+"&link1="+$('#link1').val()+"&type="+$("#type-btn").text()+"&img="+$('#img').val()+"&desc="+$('#desc').val()+"&id="+window.updateId;
        var url = "../db/update_tut.php"+query;
        $(".modal-content").html("<span class='alert alert-success' role='alert'>Tutorial Was Saved Successfully</span>");
      } else if(q = "c"){
        var query = "?title="+$('#title').val()+"&link1="+$('#link1').val()+"&type="+typ+"&img="+$('#img').val()+"&desc="+$('#desc').val()+"&req_id="+$('#req_id').text();
        var url = "../db/save_tut.php"+query;
        var span = $("<span class='alert alert-success' role='alert'>Tutorial Was Updated Successfully</span>");
        $(span).css({
          display : "block",
          height : "100%"
        });
        $(".modal-content").html(span);
      }
      setTimeout(function(){
        $(".modal").hide(1000);
        $(".modal-backdrop").hide();
        loadPage('all_tuts.php');
      }, 1500);

      $.post(url, function(d, s){});
    }

}


function selectType(t){
  var url = "select.php?q="+t;
  $("#category-btn").text(t);
  $.post(url, function(d, s){
    $(".all-tuts").html(d);
  });
}


function loadGender(q, g){
  var url = "select.php?"+q+"="+g;
  $("#category-btn").text(g);
  $.post(url, function(d, s){
    $(".all-tuts").html(d);
  });
}


function loadDelete(i, q){
  if($("#myModal")){
    $("#myModal").remove();
  }
  if(q && q == "request"){
    var url = "deleteModal.php?delete="+i+"&query="+q;
  } else {
    var url = "deleteModal.php?delete="+i;
  }

  $.post(url, function(d, s){
    $("body").append(d);
  });
}
function deleteTut(i, q) {
  if(q && q == "request"){
    var url = "../db/delete.php?delete="+i+"&query="+q;
    var page = '../admin/requests.php';
  } else {
    var url = "../db/delete.php?delete="+i;
      var page = 'all_tuts.php';
  }
  $.post(url, function(d, s){
    if(d == "Done!"){
      $(".modal-body").html("<span class='alert alert-success col-xs-12' role='alert'>Tutorial Deleted Successfully</span>");
      setTimeout(function(){
        $(".modal").hide(1000);
        $(".modal-backdrop").hide();
        $("#myModal").hide();
        loadPage(page);
      }, 1500);
    } else {
      $(".modal-body").append("<span class='alert alert-warning' role='alert'>Tutorial Was Not Deleted. Error: "+d+"</span>");
    }

  });
}
