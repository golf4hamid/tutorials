
/////////////////////////
function get_types(t){
	_i("category-btn").innerText = t;
	_i("type-btn").removeAttribute("disabled");
	xhr = new XMLHttpRequest();
	var query = "?cat="+t;
	var url = "include/db/fetch_db.php"+query;
	xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.onreadystatechange = function(){
			if (xhr.readyState == 4 && xhr.status == 200){
					var response = xhr.responseText;
					_i("type_list").innerHTML = response;;
			}
	};
	xhr.send();
}
/////////////////////////

function save_act(i, a){
	xhr = new XMLHttpRequest();
	var query = "?action="+a+"&id="+i;
	var url = "include/db/users.php"+query;
	xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200){
			console.log(xhr.responseText);
		}
	};
	xhr.send();
}

//////////////////g//////

/////////////////////////
var typ ;
function selected_type(t){
	window.typ= t;
	_i("type-btn").innerText = typ;
	return typ;
}
////////////////////////

// function saveTut(){
// 		var query = "?title="+$('#title').val()+"&link1="+$('#link1').val()+"&type="+typ+"&img="+$('#img').val()+"&desc="+$('#desc').val()+"&req_id="+$('#req_id').text();
//     var url = "include/db/save_tut.php"+query;
// 		$.post(url, function(d, s){
// 			alert(d);
// 		});
// }
