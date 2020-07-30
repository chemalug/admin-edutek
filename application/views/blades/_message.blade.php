@if (isset($_alertmessage))
@if(is_array($_alertmessage))
<div id="infoMessage" class="alert alert-{{ $_alertmessage['color'] }} alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="{{ $_alertmessage['icon'] }}"></i> {{ $_alertmessage['title'] }}</h4>
	{{ $_alertmessage['text'] }}
</div>
@else
  <div id="infoMessage" class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4>{{$_alertmessage}}</h4>
  </div>
@endif

@else
@if (isset($_SESSION['message']))
@if(is_array($_SESSION['message']))
<div id="infoMessage" class="alert alert-{{ $_SESSION['message']['color'] }} alert-dismissible text-muted">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="{{ $_SESSION['message']['icon'] }}"></i> {{ $_SESSION['message']['title'] }}</h4>
	{{ $_SESSION['message']['text'] }}
</div>
@else
  <div id="infoMessage" class="alert alert-danger alert-dismissible text-muted">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4 style="color:black;">{{$_SESSION['message']}}</h4>
  </div>
@endif

@endif

@endif