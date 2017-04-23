
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary text-center" id="myModalLabel">Ask For a Tutorial</h4>
      </div>
      <form class="form-group row save_req" onsubmit="sendRequest(); return false;">
      	<div class="row">
              <div class="input-group col-xs-10 col-xs-offset-1">
                  <label class="input-group-addon">Full Name  </label>
      						<input type="text" class="form-control" id="f_name" placeholder="Your Name...." required/>
              </div>
              <div class="input-group col-xs-10 col-xs-offset-1">
                  <label class="input-group-addon">E-mail </label>
                  <input type="email" class="form-control" id="email" placeholder="Your Email..." required/>
              </div>

              <div class="input-group col-xs-10 col-xs-offset-1">
                  <label class="input-group-addon">Tutorial Name </label>
                  <?php
                    if(isset($_REQUEST['query'])){
                      $q = $_REQUEST['query'];
                      echo "<input type=\"text\" class=\"form-control\" value=\"$q\" id=\"tutorial\" placeholder=\"What Tutorial You Need...\" required/>";
                    } else {
                      echo "<input type=\"text\" class=\"form-control\" id=\"tutorial\" placeholder=\"What Tutorial You Need...\" required/>";
                    }
                  ?>
              </div>

              <div class="input-group col-xs-10 col-xs-offset-1">
                  <label class="input-group-addon">Details </label>
                  <input type="text" class="form-control" id="tut_detail" placeholder="More Details"/>
              </div>
          </div>
      	<div class="row">
              <input class="btn btn-success col-xs-4 col-xs-offset-4" type="submit" value="Send Request">
          </div>
      </form>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
