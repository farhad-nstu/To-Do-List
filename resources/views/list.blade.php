<!DOCTYPE html>
<html>
<head>
	<title>Ajax To Do List</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha256-rByPlHULObEjJ6XQxW/flG2r+22R5dKiAoef+aXWfik=" crossorigin="anonymous" />
</head>
<body>
<br>
  <div class="container" style="margin-left: 500px;">
    <div class="row">
      <div class="col-lg-offset-3 col-lg-4">
        <div class="panel panel-default" style="">
          <div class="panel-heading"><h3>Ajax to do list <a href="" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a></h3></div>
          <div class="panel-body" id="items">
            <ul class="list-group">
              @foreach($items as $item)	
              <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{ $item->item}}
                  <input type="hidden" id="itemId" value="{{ $item->id }}">
              </li>
              @endforeach
            </ul>
            </div>
        </div>
        </div>
            
            <div class="col-lg-2">
            	<input type="text" name="searchItem" id="searchItem" placeholder="Search" class="form-control">
            </div>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                  	<h4 class="modal-title" id="title">Add Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    
                  </div>

                  <div class="modal-body">
                  	<input type="hidden" id="id">
                    <p><input type="text" id="addItem" placeholder="Write item here" class="form-control"></p>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal">Delete</button>
                    <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal">Save changes</button>
                    <button type="button" class="btn btn-primary" id="addButton" data-dismiss="modal" display>Add</button> <!-- data-dismiss="modal" close kore dei -->
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

          </div>
    </div>
  </div>

@csrf

<script   
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>


<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '.ourItem', function(event) {
				var text = $(this).text();
				var id = $(this).find('#itemId').val();
				
				$('#title').text('Edit Item');
        var text = $.trim(text);
        $('#addItem').val(text);
        $('#delete').show('400');
        $('#saveChanges').show('400');
        $('#addButton').hide('400');
        $('#id').val(id);   
        console.log(text);
			});

        
      $(document).on('click', '#addNew', function(event) {
			$('#addItem').val('');
      $('#title').text('Add Item')
      $('#delete').hide('400')
      $('#saveChanges').hide('400')
      $('#addButton').show('400')
      });


    // add item
		$('#addButton').click( function(event) {
            var text = $('#addItem').val();
            if(text == ""){
              alert("Please type something");
            } else{
              $.post('list', {'text': text, '_token':$('input[name=_token]').val()}, function(data) {
                  console.log(data);
                  $('#items').load(location.href + ' #items');
              });
            }
            
		});




		$('#delete').click(function(event) {
			var id = $('#id').val();
			$.post('delete', {'id': id, '_token':$('input[name=_token]').val()}, function(data) {
				$('#items').load(location.href + ' #items');
				console.log(data);
			});
			
		});




    $('#saveChanges').click(function(event) {
      var id = $('#id').val();
      var value = $.trim($('#addItem').val());
      $.post('update', {'id': id, 'value': value, '_token':$('input[name=_token]').val()}, function(data) {
        $('#items').load(location.href + ' #items');
        console.log(data);
      });
      
    });




    $( function() {
    
    $( "#searchItem" ).autocomplete({
      source: 'http://127.0.0.1:8000/search'
    });
  } );


				
	});


</script>
</body>
</html>